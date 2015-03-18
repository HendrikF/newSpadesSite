<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StaticController extends Controller
{
    /**
     * @Route("/about", name="about")
     */
    public function aboutAction()
    {
        return $this->render('default/about.html.twig', array(
            'title' => 'About',
            'navi' => 'about'
        ));
    }
    
    /**
     * @Route("/get-it", name="get-it")
     */
    public function getItAction()
    {
        return $this->render('default/get-it.html.twig', array(
            'title' => 'Get It!',
            'navi' => 'getIt'
        ));
    }
    
    /**
     * @Route("/contribute", name="contribute")
     */
    public function contributeAction()
    {
        return $this->render('default/contribute.html.twig', array(
            'title' => 'Contribute!',
            'navi' => 'contribute'
        ));
    }
}
