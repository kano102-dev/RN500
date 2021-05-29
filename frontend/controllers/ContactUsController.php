<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\base\DynamicModel;
use frontend\models\ContactForm;

class ContactUsController extends Controller {

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        $postData = Yii::$app->request->post();
        $model = new DynamicModel(['name', 'email', 'subject', 'message']);

        $model->addRule(['name', 'email', 'subject', 'message'], 'string')
                ->addRule(['name', 'email', 'subject', 'message'], 'required')
                ->addRule('email', 'email');
        
        if($model->load(Yii::$app->request->post())){
           if(ContactForm::sendContactUsEmail($postData)){
               Yii::$app->session->setFlash("success", "Thank you for contacting. We will right back to you soon.");
               return $this->redirect(['site/contact-us']);
           }
        }
        
        return $this->render('contact-us',['model' => $model]);
    }

}

?>