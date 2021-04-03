<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

/* @var $user common\models\User */
?>

<tr>

    <td style="padding: 0px 30px 20px;font-family: 'Montserrat', sans-serif;font-size: 24px;">

        <h3 style="margin: 40px 0 0;font-weight: 600;color: #3362cc">Hi <?= Html::encode($name) ?>,</h3>

    </td>

</tr>





<tr>

    <td style="padding: 0px 30px 20px;color: #2f3241;font-weight: 500;font-family: 'Montserrat', sans-serif;text-align: justify;font-size: 16px;line-height: 30px;">

        Follow the link below to reset your password:

    </td>

</tr>





<tr>

    <td  style="padding: 0px 30px 20px;">

        <a href="<?= $resetLink ?>"  style="text-decoration: none;color: #FFF;padding: 16px 30px;background:#4485ea;

           font-weight: 500;text-align: center;cursor: pointer;display: inline-block;

           border-radius: 4px;font-family: 'Montserrat', sans-serif;margin: 10px 0px">Click Here</a>

    </td>

</tr>



<tr>

    <td style="padding: 0px 30px 20px;color: #2f3241;font-weight: 500;font-family: 'Montserrat', sans-serif;text-align: justify;font-size: 16px;line-height: 24px;">

        We hope you will have a pleasent experience with us.

    </td>

</tr>                                        





<tr>

    <td style="padding: 0px 30px 20px;color: #2f3241;font-weight: 500;font-family: 'Montserrat', sans-serif;text-align: justify;font-size: 16px;line-height: 30px;">

        Thanks,<br/>

        RN500

    </td>

</tr>