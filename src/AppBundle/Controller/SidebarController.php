<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SidebarController extends Controller
{
    public function recentPostsAction()
    {
        $posts = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->createQueryBuilder('p')
            ->select('p')
            ->orderBy('p.published', 'DESC')
            ->setFirstResult(0)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        
        return $this->render('sidebar/recentPosts.html.twig', array(
            'posts' => $posts
        ));
    }
    
    public function blogTagsAction()
    {
        $tags = $this->getDoctrine()
            ->getRepository('AppBundle:Tag')
            ->createQueryBuilder('t')
            ->select('t, p')
            ->leftJoin('t.posts', 'p')
            ->getQuery()
            ->getResult();
        
        return $this->render('sidebar/blogTags.html.twig', array(
            'tags' => $tags
        ));
    }
}
