<?php
/**
 * Created by PhpStorm.
 * User: nathan
 * Date: 19/05/16
 * Time: 17:31
 */

namespace Vss\UsefulBundle\Utils;

/**
 * Class Tokenizer
 * @package Vss\UsefulBundle\Utils
 */
class Tokenizer {

    /**
     * @param $length
     * @param string $characters
     * @return string
     */
    public static function random($length, $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}