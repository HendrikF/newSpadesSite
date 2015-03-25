<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class TagRepository extends EntityRepository
{
    public function getTags()
    {
        $query = $this->getEntityManager()->createQuery(
        "SELECT t, COUNT(p) AS postCount
        FROM AppBundle:Tag t
        JOIN t.posts p
        GROUP BY p.id
        ");
        return $query->getScalarResult();
    }

    public function getPosts($title, $page = 1, $pageSize = 10)
    {
        $query = $this->getEntityManager()->createQuery(
        "SELECT p, t, a
        FROM AppBundle:Post p
        JOIN p.tags t
        JOIN p.author a
        WHERE t.title = :title
        ORDER BY p.published DESC
        ")
        ->setParameter(':title', $title)
        ->setFirstResult($pageSize * ($page - 1))
        ->setMaxResults($pageSize);
        return $query->getArrayResult();
    }

    public function getPostCount($title)
    {
        $query = $this->getEntityManager()->createQuery(
        "SELECT COUNT(p)
        FROM AppBundle:Tag t
        JOIN t.posts p
        WHERE t.title = :title
        ")
        ->setParameter(':title', $title);
        return $query->getSingleScalarResult();
    }
}
