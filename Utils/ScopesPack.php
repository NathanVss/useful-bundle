<?php
/**
 * Created by PhpStorm.
 * User: nathan
 * Date: 15/04/16
 * Time: 11:31
 */

namespace Vss\UsefulBundle\Utils;

use Vss\UsefulBundle\Utils\Exception\ScopeDoesNotExistsException;

/**
 * Class ScopesPack
 * @package Vss\UsefulBundle\Utils
 */
class ScopesPack {

    /**
     * @var array
     */
    protected $scopes;

    /**
     * ScopesPack constructor.
     * @param array $scopes
     */
    public function __construct(array $scopes) {
        $this->scopes = $scopes;
    }

    /**
     * @return array
     * @throws ScopeDoesNotExistsException
     */
    public function serializeScopes() {
        $data = [];
        foreach ($this->scopes as $scope) {
            $scopeData = $this->getScope($scope);
            if (is_object($scopeData)) {
                $s = $scopeData->serialize();
            } else {
                $s = $scopeData;
            }
            $data[$scope] = $s;
        }
        return $data;
    }

    /**
     * @return array
     */
    public function getScopes() {
        return $this->scopes;
    }

    /**
     * @param array $scopes
     */
    public function setScopes($scopes) {
        $this->scopes = $scopes;
    }

    /**
     * @param $scope
     * @return bool
     */
    public function hasScope($scope) {
        return in_array($scope, $this->scopes);
    }

    /**
     * @param $scope
     * @return mixed
     * @throws ScopeDoesNotExistsException
     */
    public function getScope($scope) {

        if (!$this->hasScope($scope)) {

            throw new ScopeDoesNotExistsException("The scope $scope does not exists.");
        }

        return $this->$scope;
    }

}