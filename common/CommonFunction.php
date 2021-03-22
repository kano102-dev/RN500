<?php

namespace common;

use Yii;

class CommonFunction {

    public static function generateOTP($digits = 6) {
//      return (string) sprintf("%06d", mt_rand(1, 999999));
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $digits; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return  $randomString;
    }
    
    public static function currentTimestamp(){
        return time();
    }

}
