<?php
/**
 * Created by PhpStorm.
 * User: nathan
 * Date: 05/06/16
 * Time: 11:49
 */

namespace Vss\UsefulBundle\Utils;

/**
 * Class Email
 * @package Vss\UsefulBundle\Utils
 */
class Email {

    /**
     * @param $email
     * @return bool
     */
    public static function isEmailValid($email) {
        return boolval(filter_var($email, FILTER_VALIDATE_EMAIL));
    }

}