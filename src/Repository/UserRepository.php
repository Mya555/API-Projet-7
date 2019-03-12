<?php

namespace App\Repository;

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
     * @return \Pagerfanta\Pagerfanta
     */
    public function search($term, $order = 'asc', $limit = 20, $offset = 0)
    {
        $qb = $this
            ->createQueryBuilder( 'a' )
            ->select( 'a' )
            ->orderBy( 'a.firstName', $order );
        if ($term) {
            $qb
                ->where( 'a.firstName LIKE ?1' )
                ->setParameter( 1, '%' . $term . '%' );
        }
        return $this->paginate( $qb, $limit, $offset );
    }
}
