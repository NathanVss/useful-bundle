<?php
/**
 * Created by PhpStorm.
 * User: nathan
 * Date: 02/06/16
 * Time: 15:34
 */

namespace Vss\UsefulBundle\Utils\Api;

use Symfony\Component\HttpFoundation\ParameterBag;
use Vss\UsefulBundle\Utils\Opts;

/**
 * Class PatchHelper
 * @package Vss\UsefulBundle\Utils\Api
 */
class PatchHelper {

    const TYPE_TIMESTAMP = 1;

    /**
     * @param ParameterBag $params
     * @param $object
     * @param $needs
     */
    public static function patch(ParameterBag $params, $object, $needs) {
        foreach ($needs as $key => $need) {
            if ($params->has($key)) {
                $setter = 'set' . ucfirst($key);

                $value = $params->get($key);
                if ($callback = Opts::is($need, 'refine')) {
                    $value = $callback($value);
                }
                if ($type = Opts::is($need, 'type')) {
                    if ($type == self::TYPE_TIMESTAMP) {
                        $value = \DateTime::createFromFormat('U', $value);
                    }
                }

                $object->$setter($value);
            }
        }
    }

}