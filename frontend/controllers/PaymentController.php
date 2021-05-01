<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\CompanySubscription;
use common\models\CompanySubscriptionPayment;
use common\models\UserDetails;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Stripe\Stripe;
use common\models\LeadMaster;

require_once Yii::$app->basePath . '/../vendor/stripe/stripe-php/init.php';

class PaymentController extends Controller {

    /** @inheritdoc */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex($id) {
        if (empty($id)) {
            return $this->redirect(['/browse-jobs/recruiter-lead']);
        }
        $model = LeadMaster::findOne(['id' => $id]);
        return $this->render('index', ['model' => $model]);
    }

    public function actionStripekey() {
        if (Yii::$app->params['STRIP_TEST_MODE'] == 'on') {
            echo json_encode(['publicKey' => Yii::$app->params['STRIP_TEST_PUBLISH_KEY']]);
        } else {
            echo json_encode(['publicKey' => Yii::$app->params['STRIP_LIVE_PUBLISH_KEY']]);
        }
    }

    public function actionCheckoutsession($id) {
        $lead_id = base64_decode($id);
        $payment_id = '';
        $session = Yii::$app->session;
        $model = LeadMaster::findOne(['id' => $lead_id]);

        $amount_cents = $model->price * 100;

        $subscription = new CompanySubscription();
        $subscription->company_id = \common\CommonFunction::getLoggedInUserCompanyId();
        $subscription->package_id = \common\models\PackageMaster::PAY_AS_A_GO;
        $subscription->created_at = \common\CommonFunction::currentTimestamp();
        $subscription->updated_at = \common\CommonFunction::currentTimestamp();
        if ($subscription->save()) {
            $paymentModel = new CompanySubscriptionPayment();
            $paymentModel->subscription_id = $subscription->id;
            $paymentModel->amount = $model->price;
            $paymentModel->lead_id = $lead_id;
            $paymentModel->status = CompanySubscriptionPayment::STATUS_PENDING;
            if ($paymentModel->save()) {
                $payment_id = $paymentModel->id;
            }
        }
        if ($session->isActive) {
            $session->set('payment_id', $payment_id);
        } else {
            $session->open();
            $session->set('payment_id', $payment_id);
        }
        if (Yii::$app->params['STRIP_TEST_MODE'] == 'on') {
            $secret_key = Yii::$app->params['STRIPE_TEST_SECRET_KEY'];
        } else {
            $secret_key = Yii::$app->params['STRIPE_LIVE_SECRET_KEY'];
        }

        Stripe::setApiKey($secret_key);


        $checkout_session = \Stripe\Checkout\Session::create([
                    'success_url' => Yii::$app->urlManager->createAbsoluteUrl("payment/success") . '?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => Yii::$app->urlManager->createAbsoluteUrl("payment/cancel"),
                    'payment_method_types' => ['card'],
                    'mode' => 'payment',
                    'line_items' => [[
                    'amount' => $amount_cents,
                    'currency' => 'usd',
                    'quantity' => 1,
                    'name' => Yii::$app->user->identity->details->companyNames,]]
        ]);

        echo json_encode(['checkoutSessionId' => $checkout_session['id']]);
    }

    public function actionSuccess($session_id = Null) {
        $id = $_GET["session_id"];
        if (Yii::$app->params['STRIP_TEST_MODE'] == 'on') {
            $secret_key = Yii::$app->params['STRIPE_TEST_SECRET_KEY'];
        } else {
            $secret_key = Yii::$app->params['STRIPE_LIVE_SECRET_KEY'];
        }
        \Stripe\Stripe::setApiKey($secret_key);
        $checkout_session = \Stripe\Checkout\Session::retrieve($id);
        $session = Yii::$app->session;
        $payment_id = $session->get('payment_id');
        if (empty($payment_id)) {
            return $this->redirect(['/browse-jobs/recruiter-lead']);
        } else {
            $paymentModel = CompanySubscriptionPayment::findOne(['id' => $payment_id]);
            $paymentModel->customer_transaction_id = $checkout_session->customer;
            $paymentModel->payment_response = json_encode($checkout_session);
            $paymentModel->status = CompanySubscriptionPayment::STATUS_SUCCESS;
            $paymentModel->save();
            $session->remove('payment_id');
            $session->close();
            Yii::$app->session->setFlash("success", "Your payment is recived successfully.");
            return $this->redirect(['/browse-jobs/recruiter-lead']);
        }
    }

    public function actionCancel() {
        $session = Yii::$app->session;
        $payment_id = $session->get('payment_id');
        if (empty($payment_id)) {
            return $this->redirect(['/browse-jobs/recruiter-lead']);
        }
        $paymentModel = CompanySubscriptionPayment::findOne(['id' => $payment_id]);
        $paymentModel->status = CompanySubscriptionPayment::STATUS_Fail;
        $paymentModel->save();
        $session->remove('payment_id');
        $session->close();
        return $this->redirect(['/browse-jobs/recruiter-lead']);
    }

}
