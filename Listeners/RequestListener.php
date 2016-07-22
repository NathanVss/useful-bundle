<?php
namespace Vss\UsefulBundle\Listeners;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Created by PhpStorm.
 * User: nathan
 * Date: 06/03/16
 * Time: 11:10
 */
class RequestListener {

    /**
     * Put in request the json content.
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event) {
        $request = $event->getRequest();
        $data = [];

        if (strstr($request->getContentType(), "form")) {
            parse_str($request->getContent(), $data);
        }
        if (strstr($request->getContentType(), "json")) {
            $data = json_decode($request->getContent(), true);
        }
        if ($data) {
            $request->request->add($data);
        }

    }

}