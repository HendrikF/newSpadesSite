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
}
