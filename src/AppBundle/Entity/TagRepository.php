<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class TagRepository extends EntityRepository
{
    public function getTags()
    {
        $query = $this->getEntityManager()->createQuery(
        "SELECT t.title
        FROM AppBundle:Tag t
        ORDER BY t.title ASC
        ");
        return $query->getArrayResult();
    }
    
    public function getTagsWithPostCount()
    {
        $query = $this->getEntityManager()->createQuery(
        "SELECT t.title, COUNT(p.id) AS postCount
        FROM AppBundle:Tag t
        LEFT JOIN t.posts p
        GROUP BY t.id
        ORDER BY postCount DESC, t.title ASC
        ");
        return $query->getScalarResult();
    }

    public function getPosts($title, $page = 1, $pageSize = 10)
    {
        $query = $this->getEntityManager()->createQuery(
        "SELECT p, t, a
        FROM AppBundle:Post p
        LEFT JOIN p.tags t
        LEFT JOIN p.author a
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
        LEFT JOIN t.posts p
        WHERE t.title = :title
        ")
        ->setParameter(':title', $title);
        return $query->getSingleScalarResult();
    }
    
    public function getTag($title)
    {
        $query = $this->getEntityManager()->createQuery(
        "SELECT t
        FROM AppBundle:Tag t
        WHERE t.title = :title
        ")
        ->setParameter(':title', $title);
        return $query->getOneOrNullResult();
    }
}
