<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SidebarController extends Controller
{
    public function recentPostsAction()
    {
        $showHidden = $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN');
        $posts = $this->getDoctrine()->getRepository('AppBundle:Post')->getRecentPosts(1, 10, $showHidden);
        
        return $this->render('AppBundle:sidebar:recentPosts.html.twig', array(
            'posts' => $posts
        ));
    }
    
    public function blogTagsAction()
    {
        $tags = $this->getDoctrine()->getRepository('AppBundle:Tag')->getTagsWithPostCount();
        
        return $this->render('AppBundle:sidebar:blogTags.html.twig', array(
            'tags' => $tags
        ));
    }
}
