<?php
/**
 * Created by PhpStorm.
 * User: nathan
 * Date: 26/12/2016
 * Time: 19:05
 */

namespace Vss\UsefulBundle\Controller\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class MissingParamsException extends BadRequestHttpException {

    /**
     * @var Response
     */
    private $response;

    /**
     * @return Response
     */
    public function getResponse() {
        return $this->response;
    }

    /**
     * @param Response $response
     */
    public function setResponse($response) {
        $this->response = $response;
    }
    
}