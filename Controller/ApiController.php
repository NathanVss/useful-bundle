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
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Vss\UsefulBundle\Controller\Exception\MissingParamsException;

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
    public static function success($datas = 'success', array $opts = array()) {
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
    public static function error($httpCode, $type, $message = "", array $opts = []) {

        $errorCode = $httpCode;
        if (isset($opts['code']) && ($code = $opts['code'])) {
            $errorCode = $code;
        }

        if ($type instanceof \Exception) {

            if (preg_match("/\\\\(\\w+)Exception$/m", get_class($type), $matches)) {
                $type = $matches[1];
            } else {
                $type = get_class($type);
            }

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
     * @param $request
     * @param $needle
     * @param array $params
     * @return JsonResponse
     */
    public function required($request, $needle, &$params) {
        try {
            $params = $this->requiredParams($request, $needle);
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
    public function requiredParams($params, $needle) {

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
            throw new BadRequestHttpException("missing these params : " . implode(', ', $missing));
        }

        return $found;
    }

    /**
     * @param array $needle
     * @param ParameterBag $haystack
     * @return ParameterBag
     */
    public function needs(array $needle, ParameterBag $haystack) {
        try {
            $this->requiredParams($haystack, $needle);
            return $haystack;
        } catch (BadRequestHttpException $e) {
            $exception = new MissingParamsException();
            $exception->setResponse(self::error(400, "MissingParams", $e->getMessage()));
            throw $exception;
        }
    }
}