<?php

namespace Nearteam\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class BaseRepository extends EntityRepository {

    /**
     * Add criterias for an entity specified by $alias
     * @param QueryBuilder $qb
     * @param string $alias
     * @param array $criterias
     * @return QueryBuilder $qb
     */
    public function addCriterias($qb, $alias, $criterias) {
        foreach ($criterias as $key => $value) {
            $qb->andWhere($alias . '.' . $key . ' = :' . $key)
                    ->setParameter($key, $value);
        }

        return $qb;
    }

}

