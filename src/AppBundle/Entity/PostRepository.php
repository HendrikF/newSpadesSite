<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    public function getRecentPosts($page = 1, $pageSize = 10)
    {
        $query = $this->getEntityManager()->createQuery(
        "SELECT p, t, a
        FROM AppBundle:Post p
        JOIN p.tags t
        JOIN p.author a
        ORDER BY p.published DESC
        ")
        ->setFirstResult($pageSize * ($page - 1))
        ->setMaxResults($pageSize);
        return $query->getArrayResult();
    }

    public function getPostCount()
    {
        $query = $this->getEntityManager()->createQuery(
        "SELECT count(p) AS postCount
        FROM AppBundle:Post p
        ");
        return $query->getSingleScalarResult();
    }

    /*public function getUsersBugs($userId, $number = 15)
    {
        $dql = "SELECT b, e, r FROM Bug b JOIN b.engineer e JOIN b.reporter r ".
               "WHERE b.status = 'OPEN' AND e.id = ?1 OR r.id = ?1 ORDER BY b.created DESC";

        return $this->getEntityManager()->createQuery($dql)
                             ->setParameter(1, $userId)
                             ->setMaxResults($number)
                             ->getResult();
    }

    public function getOpenBugsByProduct()
    {
        $dql = "SELECT p.id, p.name, count(b.id) AS openBugs FROM Bug b ".
               "JOIN b.products p WHERE b.status = 'OPEN' GROUP BY p.id";
        return $this->getEntityManager()->createQuery($dql)->getScalarResult();
    }*/
}
