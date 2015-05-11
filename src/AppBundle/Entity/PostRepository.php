<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    public function getRecentPosts($page = 1, $pageSize = 10, $showHidden = False)
    {
        if($showHidden) {
            $showHidden = '';
        } else {
            $showHidden = 'WHERE p.hidden = 0';
        }
        $query = $this->getEntityManager()->createQuery(
        "SELECT p, t, a
        FROM AppBundle:Post p
        LEFT JOIN p.tags t
        LEFT JOIN p.author a
        $showHidden
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
    
    public function getPostBySlug($slug)
    {
        $query = $this->getEntityManager()->createQuery(
        "SELECT p, t, a
        FROM AppBundle:Post p
        LEFT JOIN p.tags t
        LEFT JOIN p.author a
        WHERE p.slug = :slug
        ")
        ->setParameter('slug', $slug);
        return $query->getOneOrNullResult();
    }
}
