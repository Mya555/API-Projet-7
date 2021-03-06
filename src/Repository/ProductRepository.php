<?php

namespace App\Repository;

use App\Entity\Product;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use PagerFanta\Pagerfanta;


/**
 * Class ProductRepository
 * @package App\Repository
 */
class ProductRepository extends AbstractRepository
{
    public function search($term, $order = 'asc', $limit = 20, $offset = 0)
    {
        $queryBuilder = $this
            ->createQueryBuilder( 'a' )
            ->select( 'a' )
            ->orderBy( 'a.productName', $order );
        if ($term) {
            $queryBuilder
                ->where( 'a.productName LIKE ?1' )
                ->setParameter( 1, '%' . $term . '%' );
        }
        return $this->paginate( $queryBuilder, $limit, $offset );
    }
}