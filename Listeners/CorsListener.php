<?php
/**
 * Created by PhpStorm.
 * User: nathan
 * Date: 19/02/16
 * Time: 13:13
 */

namespace Vss\UsefulBundle\Listeners;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class CorsListener
{
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $responseHeaders = $event->getResponse()->headers;

        $responseHeaders->set('Access-Control-Allow-Headers', 'origin, content-type, accept, Authorization');
        $responseHeaders->set('Access-Control-Allow-Origin', '*');
        $responseHeaders->set('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, PATCH, OPTIONS');
        $responseHeaders->set('Access-Control-Expose-Headers', 'X-Debug-Token, X-Debug-Token-Link');
    }
}