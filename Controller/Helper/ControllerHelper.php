<?php
/**
 * Created by PhpStorm.
 * User: nathan
 * Date: 30/05/16
 * Time: 19:52
 */

namespace Vss\UsefulBundle\Controller\Helper;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Vss\UsefulBundle\Controller\ApiController;

/**
 * Class ControllerHelper
 * @package Vss\UsefulBundle\Controller\Helper
 */
class ControllerHelper extends ApiController {

    /**
     * ControllerHelper constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container) {
        $this->setContainer($container);
    }

}