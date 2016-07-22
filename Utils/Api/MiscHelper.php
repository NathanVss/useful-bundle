<?php
/**
 * Created by PhpStorm.
 * User: nathan
 * Date: 30/05/16
 * Time: 23:59
 */

namespace Vss\UsefulBundle\Utils\Api;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Class MiscHelper
 * @package Vss\UsefulBundle\Utils\Api
 */
class MiscHelper {

    /**
     * @param $object
     * @param ParameterBag $bag
     * @param array $args
     */
    public static function setFromBag($object, ParameterBag $bag, array $args) {
        foreach ($args as $arg) {
            $setter = "set" . ucfirst($arg);
            $object->$setter($bag->get($arg));
        }
    }

}