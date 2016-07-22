<?php
/**
 * Created by PhpStorm.
 * User: nathan
 * Date: 06/06/16
 * Time: 00:12
 */

namespace Vss\UsefulBundle\Utils;

/**
 * Class CamlCase
 * @package Vss\UsefulBundle\Utils
 */
class CamlCase {

    /**
     * @param $string
     * @return mixed
     */
    public static function snakeToCaml($string) {
        $out = preg_replace_callback("/_(\\w{1})/m", function($match) {
            return strtoupper($match[1])    ;
        }, $string);
        return $out;
    }

}