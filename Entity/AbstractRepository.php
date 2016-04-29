<?php
/**
 * Created by PhpStorm.
 * User: nathan
 * Date: 12/03/16
 * Time: 00:04
 */

namespace Vss\UsefulBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class AbstractRepository
 * @package AppBundle\Entity
 */
abstract class AbstractRepository extends EntityRepository {

    /**
     * Count all these entities.
     * @return mixed
     */
    public function count() {

        return $this->createQueryBuilder('a')
            ->select('COUNT(a)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param $criteria
     * @return int
     */
    public function countBy($criteria) {

        return $this->getFindByQb($criteria, ['count' => true])
            ->getQuery()->getSingleScalarResult();
    }

    public function getSumQb($col, array $criteria = []) {
        $qb = $this->createQueryBuilder('a')
            ->select("SUM(a.$col)");
        $this->applyCriteria($qb, $criteria);
        return $qb;
    }

    /**
     * @param $col
     * @param array $criteria
     * @return mixed
     */
    public function sum($col, array $criteria = []) {

        return $this->getSumQb($col, $criteria)->getQuery()->getSingleScalarResult();
    }

    /**
     * @param $id
     * @param array $criterias
     * @return bool
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function existsByDifferentId($id, array $criterias = []) {

        $qb = $this->getFindByQb($criterias, ['count' => true]);

        if ($id) {
            $qb->andWhere('a.id != :id')
                ->setParameter('id', $id);
        } else {
            $qb->andWhere('a.id IS NOT NULL');
        }

        return (bool)$qb->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param array $opts
     * @return array
     */
    public function advFindBy(array $opts = []) {
        $criteria = [];
        if (isset($opts['criteria']) && $opts['criteria']) {
            $criteria = $opts['criteria'];
        }
        return $this->getFindByQb($criteria, $opts)
            ->getQuery()
            ->getResult();
    }

    /**
     * Returns a findBy query builder.
     * Options are :
     * "count" : returns a count qb.
     * "orderBy", "limit", "offset".
     *
     * @param array $criterias
     * @param array $opts
     * @return QueryBuilder
     */
    public function getFindByQb(array $criterias = array(), $opts = array()) {
        if (isset($opts['qb']) && $opts['qb']) {
            $qb = $opts['qb'];
        } else {
            if (isset($opts['count']) AND $opts['count']) {
                $qb = $this->createQueryBuilder('a');
                $qb->select('COUNT(a)');
            } else {
                $qb = $this->createQueryBuilder('a');
            }
        }

        $this->applyCriteria($qb, $criterias);
        if (isset($opts['notCriteria']) && $opts['notCriteria']) {
            $this->applyCriteria($qb, $opts['notCriteria'], ['not' => true]);
        }
        if (isset($opts['orderBy']) AND $opts['orderBy']) {
            foreach ($opts['orderBy'] as $field => $type) {
                $qb->orderBy("a.$field", $type);
            }
        }

        if (isset($opts['limit']) AND $opts['limit']) {
            $qb->setMaxResults($opts['limit']);
        }
        if (isset($opts['offset']) AND $opts['offset']) {
            $qb->setFirstResult($opts['offset']);
        }

        return $qb;
    }

    /**
     * @param $qb
     * @param array $criterias
     * @param array $opts
     */
    public function applyCriteria($qb, array $criterias = [], array $opts = []) {

        $not = isset($opts['not']) && $opts['not'];
        $count = 0;
        foreach ($criterias as $key => $criteria) {

            $operator = "=";
            if ($not) {
                $operator = "!=";
            }
            $str = "a.$key $operator :where_$key";
            if ($count == 0) {
                $qb->where($str);
            } else {
                $qb->andWhere($str);
            }

            $qb->setParameter(":where_$key", $criteria);
            $count++;
        }
    }

}