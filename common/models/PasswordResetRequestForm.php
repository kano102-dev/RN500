<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**

 * Password reset request form

 */
class PasswordResetRequestForm extends Model {

    public $email;

    /**

     * {@inheritdoc}

     */
    public function rules() {

        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

    public function attributeLabels() {

        return [
            'email' => "Email",
            'password' => "Password",
        ];
    }

    /**

     * Sends an email with a link, for resetting the password.

     *

     * @return bool whether the email was send

     */
    public function sendEmail($is_welcome_mail = 0) {
        /* @var $user User */
        $user = User::findOne([
                    'email' => $this->email,
        ]);
        if (!$user) {

            return false;
        }
        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {

            $user->generatePasswordResetToken();

            if (!$user->save()) {
                return false;
            }
        }
        $resetLink = Yii::$app->urlManagerAdmin->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);

        $name = isset($user->fullName) ? $user->fullName : "";

        Yii::$app->mailer->htmlLayout = '@common/mail/layouts/html';

        Yii::$app->mailer->textLayout = '@common/mail/layouts/text';
        $htmlLayout = '@common/mail/passwordResetToken-html';
        $textLayout = '@common/mail/passwordResetToken-text';
        $subject = 'Password reset for ' . \Yii::$app->params['senderName'];
        if ($is_welcome_mail) {
            $htmlLayout = '@common/mail/emailVerify-html';
            $textLayout = '@common/mail/emailVerify-text';
            $subject = 'Verify your Email ID';
        }
        return Yii::$app->mailer->compose(['html' => $htmlLayout, 'text' => $textLayout], ['user' => $user, 'resetLink' => $resetLink, 'name' => $name])
                        ->setFrom([Yii::$app->params['senderEmail'] => \Yii::$app->params['senderName']])
                        ->setTo($this->email)
                        ->setSubject($subject)
                        ->send();
    }

}
