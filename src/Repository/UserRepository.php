<?php

namespace App\Repository;

use App\Entity\Client;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends AbstractRepository
{
    /**
     * @param $term
     * @param string $order
     * @param int $limit
     * @param int $offset
     * @param Client $client
     * @return \Pagerfanta\Pagerfanta
     */
    public function search($term, $order = 'asc', $limit = 20, $offset = 0, Client $client = null)
    {
        $queryBuilder = $this
            ->createQueryBuilder( 'a' )
            ->select( 'a' )
            ->orderBy( 'a.firstName', $order );
        if ($term) {
            $queryBuilder
                ->where( 'a.firstName LIKE ?1' )
                ->setParameter( 1, '%' . $term . '%' );
        }
        if ($client != null){
            $queryBuilder->andWhere('a.client= ?2')
                ->setParameter( 2, $client);
        }
        return $this->paginate( $queryBuilder, $limit, $offset );
    }
}
