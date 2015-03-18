<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Post;

class BlogController extends Controller
{
    /**
     * @Route("/", name="blog")
     */
    public function indexAction()
    {
        $query = $this
            ->getDoctrine()
            ->getManager()
            ->createQuery(
                'SELECT p
                FROM AppBundle:Post p
                ORDER BY p.published DESC'
            );
            #->setFirstResult(0)
            #->setMaxResults(5);
        $posts = $query->getResult();
        
        return $this->render('default/posts.html.twig', array(
            'title' => 'Blog',
            'navi' => 'blog',
            'posts' => $posts
        ));
    }
    /**
     * @Route("/blog/edit/{slug}", name="blog-edit", defaults={"slug" = "new"})
     */
    public function editAction(Request $request, $slug)
    {
        if($slug == 'new') {
            $title = 'Blogpost erstellen';
            $post = new Post();
        } else {
            $title = 'Blogpost bearbeiten';
            $post = $this->getDoctrine()
                ->getRepository('AppBundle:Post')
                ->findOneBySlug($slug);
            if(!$post) {
                throw $this->createNotFoundException(
                    'Sorry, I cannot find the requested post.'
                );
            }
        }
        
        $form = $this->createFormBuilder($post)
            ->add('slug', 'text', array('attr' => array('class' => 'form-control')))
            ->add('title', 'text', array('attr' => array('class' => 'form-control')))
            ->add('published', 'date', array('attr' => array('class' => 'form-control')))
            ->add('content', 'textarea', array('attr' => array('class' => 'form-control', 'rows' => 25)))
            ->add('save', 'submit', array('attr' => array('class' => 'btn btn-success'), 'label' => 'Save Post'))
            ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            
            return $this->redirectToRoute('blog-post', array('slug' => $post->getSlug()));
        }
        
        return $this->render('default/blog-edit.html.twig', array(
            'title' => $title,
            'navi' => 'blog',
            'form' => $form->createView(),
        ));
    }
    /**
     * @Route("/tag/{title}", name="tag")
     */
    public function tagAction($title)
    {
        $tag = $this->getDoctrine()
            ->getRepository('AppBundle:Tag')
            ->findOneByTitle($title);

        if(!$tag) {
            throw $this->createNotFoundException(
                'Sorry, I cannot find the requested tag.'
            );
        }
        
        return $this->render('default/posts.html.twig', array(
            'title' => $tag->getTitle(),
            'navi' => 'blog',
            'posts' => $tag->getPosts()
        ));
    }
    /**
     * @Route("/blog/{slug}", name="blog-post")
     */
    public function postAction($slug)
    {
        $post = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->findOneBySlug($slug);
        
        if(!$post) {
            throw $this->createNotFoundException(
                'Sorry, I cannot find the requested post.'
            );
        }
        
        return $this->render('default/post.html.twig', array(
            'title' => $post->getTitle(),
            'navi' => 'blog',
            'post' => $post
        ));
    }
}
