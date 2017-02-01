<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * WordRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class WordRepository extends EntityRepository
{
    public function getAllWords($currentPage = 1)
    {
        $query = $this->createQueryBuilder('p')
            ->getQuery();

        $paginator = $this->paginate($query, $currentPage);

        return $paginator;
    }

    public function paginate($dql, $page = 1, $limit = 5)
    {
        if ($page === null) {
            $page = 1;
        }
        $paginator = new Paginator($dql, $fetchJoinCollection = true);

        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);

        return $paginator;
    }
}
