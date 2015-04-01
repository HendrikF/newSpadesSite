<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AuthenticationController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        if($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $request->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }
        $username = $request->getSession()->get(SecurityContext::LAST_USERNAME);
        
        return $this->render('authentication/login.html.twig', array(
            'title' => 'Login',
            'navi' => '',
            'username' => $username,
            'error' => $error
        ));
    }

    /**
     * @Route("/login-check", name="login-check")
     */
    public function loginCheckAction()
    {
        // The security layer will intercept this request
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        // The security layer will intercept this request
    }
    
    /**
     * @Route("/access-denied", name="access-denied")
     */
    public function accessDeniedAction()
    {
        return $this->render('authentication/access-denied.html.twig', array(
            'title' => 'Access Denied',
            'navi' => ''
        ));
    }
}
