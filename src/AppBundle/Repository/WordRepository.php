<?php

namespace AppBundle\Repository;

/**
 * WordRepository
 */
class WordRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @return \Doctrine\ORM\Query
     */
    public function findAllWords()
    {
        $query = $this->createQueryBuilder('w')
            ->orderBy('w.dateCreated', 'DESC')
        ;

        return $query;
    }

    /**
     * @param int $wishlistId
     *
     * @return \Doctrine\ORM\Query
     */
    public function findAllByWishlist($wishlistId)
    {
        $query = $this->createQueryBuilder('word')
            ->innerJoin('word.wishlists', 'w', 'WITH', 'w.id = :wishlistId')
            ->setParameter('wishlistId', $wishlistId)
            ->orderBy('word.dateCreated', 'DESC')
        ;

        return $query;
    }
}
