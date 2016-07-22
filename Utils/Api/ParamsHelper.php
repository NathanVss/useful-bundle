<?php
/**
 * Created by PhpStorm.
 * User: nathan
 * Date: 30/05/16
 * Time: 18:40
 */

namespace Vss\UsefulBundle\Utils\Api;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class ParamsHelper
 * @package Vss\UsefulBundle\Utils\Api
 */
class ParamsHelper {

    /**
     * @param $request
     * @param $needle
     * @param ParameterBag $params
     * @return JsonResponse
     */
    public static function required($request, $needle, &$params) {
        try {
            $params = self::requiredParams($request, $needle);
            $params = $request;
        } catch (BadRequestHttpException $e) {
            return self::error(400, "MissingParams", $e->getMessage());
        }
    }


    /**
     * Throws BadRequestHttpException if $params doesn't contains all the $needle keys
     * @param $params
     * @param $needle
     * @return \Symfony\Component\HttpFoundation\ParameterBag
     * @throws BadRequestHttpException
     */
    public static function requiredParams($params, $needle) {

        $found = [];
        $missing = [];
        foreach ($needle as $need) {
            $flag = false;
            $value = null;
            foreach ($params as $param => $_value) {
                if ($param == $need) {
                    $flag = true;
                    $value = $_value;
                }
            }
            if ($flag) {
                $found[$need] = $value;
            } else {
                $missing[] = $need;
            }
        }

        if (count($found) != count($needle)) {
            throw new BadRequestHttpException("missing parameters these params : " . implode(', ', $missing));
        }

        return $found;
    }

    public static function fetch(ParameterBag $hay, array $needle) {

    }
}