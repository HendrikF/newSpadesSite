<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\User;

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
        
        return $this->render('AppBundle:authentication:login.html.twig', array(
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
        return $this->render('AppBundle:authentication:access-denied.html.twig', array(
            'title' => 'Access Denied',
            'navi' => ''
        ));
    }
    
    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $user->setIsActive(false);
        
        $form = $this->createForm('user', $user);
        $form->handleRequest($request);
        $user = $form->getData();
        
        $factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);
        $user->setSalt(md5(uniqid(null, true)));
        $pass = $encoder->encodePassword($user->getPassword(), $user->getSalt());
        $user->setPassword($pass);
        
        if($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            $this->addFlash(
                'info',
                "Registration of ___{$user->getUsername()}___ completed, activation by admin needed."
            );
            
            return $this->redirectToRoute('blog');
        } elseif($form->isSubmitted()) {
            $this->addFlash(
                'warning',
                "Could not register ___{$user->getUsername()}___ due to validation errors."
            );
        }
        
        return $this->render('AppBundle:authentication:register.html.twig', array(
            'title' => 'User Registration',
            'navi' => '',
            'form' => $form->createView()
        ));
    }
}
