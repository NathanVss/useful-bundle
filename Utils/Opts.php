<?php
/**
 * Created by PhpStorm.
 * User: nathan
 * Date: 21/05/16
 * Time: 00:05
 */

namespace Vss\UsefulBundle\Utils;

/**
 * Class Opts
 * @package Vss\UsefulBundle\Utils
 */
class Opts {

    /**
     * @param $opts
     * @param $key
     * @return mixed|callable
     */
    public static function is($opts, $key) {
        if (!isset($opts[$key])) {
            return false;
        }
        return $opts[$key];
    }
}