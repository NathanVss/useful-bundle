<?php
/**
 * Created by PhpStorm.
 * User: nathan
 * Date: 22/02/16
 * Time: 12:21
 */

namespace Vss\UsefulBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class ApiController
 * @package ApiBundle\Controller
 */
class ApiController extends Controller
{
    /**
     * @param $datas
     * @param array $opts
     * @return JsonResponse
     * @throws \Exception
     */
    public static function success($datas, array $opts = array()) {
        $response = new JsonResponse();
        $response->setData($datas);
        $response->setStatusCode(200);
        if ($opts) {
            if (isset($opts['encoding_options'])) {
                $response->setEncodingOptions($opts['encoding_options']);
            }
        }
        return $response;
    }

    /**
     * Facebook style error
     * @param int $httpCode
     * @param string $type
     * @param string $message
     * @param array $opts
     * @internal param int $code
     * @return JsonResponse
     */
    public static function error($httpCode, $type, $message, array $opts = []) {

        $errorCode = $httpCode;
        if (isset($opts['code']) && ($code = $opts['code'])) {
            $errorCode = $code;
        }

        $areDetails = isset($opts['details']) && $opts['details'];

        $error = [
            "message" => $message,
            "type" => $type,
            "code" => $errorCode
        ];
        if ($areDetails) {
            $error['details'] = $opts['details'];
        }

        $response = new JsonResponse();
        $response->setData([
            'error' => $error
        ]);
        $response->setStatusCode($httpCode);
        return $response;
    }


    /**
     * Throws BadRequestHttpException if $params doesn't contains all the $needle keys
     * @param $params
     * @param $needle
     * @return array
     * @throws BadRequestHttpException
     */
    public function requiredParams($params, $needle) {

        $found = [];
        foreach ($params as $param => $value) {
            $flag = false;
            foreach ($needle as $need) {
                if ($need == $param) {
                    $flag = true;
                }
            }
            if ($flag) {
                $found[$param] = $value;
            }

        }
        if (count($found) != count($needle)) {
            throw new BadRequestHttpException("missing parameters some of these params : " . implode(', ', $needle));
        }
        return $found;
    }

}