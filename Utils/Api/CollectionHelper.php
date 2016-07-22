<?php
/**
 * Created by PhpStorm.
 * User: nathan
 * Date: 30/05/16
 * Time: 18:38
 */

namespace Vss\UsefulBundle\Utils\Api;

use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Vss\UsefulBundle\Controller\ApiController;
use Vss\UsefulBundle\Entity\AbstractRepository;

/**
 * Class CollectionHelper
 * @package Vss\UsefulBundle\Utils\Api
 */
class CollectionHelper {

    /**
     * @param Request $request
     * @param AbstractRepository $rep
     * @return JsonResponse
     */
    public static function get(Request $request, AbstractRepository $rep) {
        if ($request->query->has('count')) {
            return ApiController::success($rep->count());
        }

        if ($r = ParamsHelper::required($request->query, ['limit', 'offset'], $params)) {
            return $r;
        }

        if ($params->get('limit') > 500) {
            return ApiController::error(400, "LimitExceded", "");
        }
    }

    /**
     * @param Request $request
     * @param AbstractRepository $rep
     * @return array
     */
    public static function find(Request $request, AbstractRepository $rep) {
        return $rep->findBy([], ['id' => 'desc'], $request->query->get('limit'), $request->query->get('offset'));
    }

}