<?php
use yii\helpers\Url;
?>

<html>
    <head>
        <title>RN 500</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    </head>
    <body marginheight="0" marginwidth="0" topmargin="0" leftmargin="0" bgcolor="#f1f1f1" style="font-family:'Raleway', sans-serif; font-size:17px;">
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f1f1f1" style="padding:20px; font-family:'Raleway', sans-serif; font-size:17px;">
            <tr>
                <td valign="top" align="center">
                    <table width="600" border="0" cellspacing="0" cellpadding="0" style="marging:20px; border:1px solid #9c9c9c;">
                        <tr>
                            <td align="left" bgcolor="#eeeeee">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td style="padding:10px 20px; font-size:17px; font-family:'Raleway', sans-serif; margin-top:5px;"></td>
                                    </tr>
                                    <tr>
                                        <td style="border-top:2px solid #128A43; padding-bottom:3px; padding-top:3px; height:1px;"></td>
                                    </tr>
                                    <tr>
                                        <td style="font-size:17px; font-family:'Raleway', sans-serif; color:#333333; padding:0px 20px;">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:17px;">
                                                <tr>
                                                    <td style="font-size:17px; color:#333; font-weight:500; line-height:20px; height:30px; font-family:'Raleway', sans-serif; padding-left:2px;">Dear Admin,<br></td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#333; font-weight:500; font-size:15px; padding-bottom:10px;">A new contact request has been arrived. Please find the details as below:</td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#333; font-weight:500; font-size:15px;">
                                                        <div style="display:inline-block; padding:6px; background-color:#eee; border-radius:4px; width:97%; border:2px solid #128A43">
                                                            <b>Name :</b> <?= $user['DynamicModel']['name'] ?> <br>
                                                            <b>Email Id :</b> <a href="mailto:<?= $user['DynamicModel']['email'] ?>" style="color:#128A43; font-weight:bold; text-decoration:none"><?= $user['DynamicModel']['email'] ?></a><br>
                                                            <b>Message :</b> <?= $user['DynamicModel']['subject'] ?><br>
                                                            <b>Message :</b> <?= $user['DynamicModel']['message'] ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#333; font-weight:500; font-size:15px;">Thank you,<br>RN 500
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td style="border-top:2px solid #128A43; height:1px; color:#333;font-size:13px;"></td>
                                    </tr>                                   
                                    <tr>
                                        <td align="left" style="font-family:'Raleway', sans-serif; text-decoration:none; background-color:#eeeeee; color:#333; font-size:12px; padding:10px 20px;">&copy; <?= date('Y') ?> RN500. All Rights Reserved.</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>