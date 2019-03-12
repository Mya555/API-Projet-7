<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * Class AbstractRepository
 * @package App\Repository
 */
abstract class AbstractRepository extends EntityRepository
{
    protected function paginate(QueryBuilder $qb, $limit = 20, $offset = 0)
    {
        if (0 >= $limit || 0 > $offset) {
            throw new \LogicException( '$limit & $offset must be greater than 0.' );
        }
        if($offset > 100 ){
            throw new \LogicException( '$offset must be smaller than 100.' );
        }

        $pager = new Pagerfanta( new DoctrineORMAdapter( $qb ) );
        $currentPage = (ceil( ($offset + 1) / $limit ));
        $pager->setCurrentPage( $currentPage );
        $pager->setMaxPerPage( (int)$limit );

        return $pager;
    }
}