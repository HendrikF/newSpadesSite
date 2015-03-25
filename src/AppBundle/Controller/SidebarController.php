<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SidebarController extends Controller
{
    public function recentPostsAction()
    {
        $posts = $this->getDoctrine()->getRepository('AppBundle:Post')->getRecentPosts();
        
        return $this->render('sidebar/recentPosts.html.twig', array(
            'posts' => $posts
        ));
    }
    
    public function blogTagsAction()
    {
        $tags = $this->getDoctrine()->getRepository('AppBundle:Tag')->getTags();
        
        return $this->render('sidebar/blogTags.html.twig', array(
            'tags' => $tags
        ));
    }
}
