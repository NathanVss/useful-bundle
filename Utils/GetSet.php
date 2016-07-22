<?php
/**
 * Created by PhpStorm.
 * User: nathan
 * Date: 06/06/16
 * Time: 00:22
 */

namespace Vss\UsefulBundle\Utils;

/**
 * Class GetSet
 * @package Vss\UsefulBundle\Utils
 */
class GetSet {

    /**
     * @param $attr
     * @return string
     */
    public static function setter($attr) {
        return 'set' . ucfirst($attr);
    }

    /**
     * @param $attr
     * @return string
     */
    public static function getter($attr) {
        return 'get' . ucfirst($attr);
    }

}