<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SidebarController extends Controller
{
    public function recentPostsAction()
    {
        $query = $this
            ->getDoctrine()
            ->getManager()
            ->createQuery(
                'SELECT p
                FROM AppBundle:Post p
                ORDER BY p.published DESC'
            )
            ->setFirstResult(0)
            ->setMaxResults(10);
        $posts = $query->getResult();
        
        return $this->render('sidebar/recentPosts.html.twig', array(
            'posts' => $posts
        ));
    }
    
    public function blogTagsAction()
    {
        $query = $this
            ->getDoctrine()
            ->getManager()
            ->createQuery(
                'SELECT t
                FROM AppBundle:Tag t'
            );
        $tags = $query->getResult();
        return $this->render('sidebar/blogTags.html.twig', array(
            'tags' => $tags
        ));
    }
}
