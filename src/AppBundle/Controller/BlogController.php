<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Post;

class BlogController extends Controller
{
    /**
     * @Route("/{page}", name="blog", defaults={"page" = 1}, requirements={"page": "\d+"})
     */
    public function indexAction($page)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Post');
        
        $padding = 3;
        $pageSize = 10;
        
        $postCount = $repository->getPostCount();
        $pageCount = ceil($postCount / $pageSize);
        
        if($page > $pageCount) {
            throw $this->createNotFoundException(
                'Sorry, we do not have that many posts.'
            );
        }
        
        $posts = $repository->getRecentPosts($page, $pageSize);
        
        $prev = ($page > 1);
        $next = ($page < $pageCount);
        $pages = array();
        
        for($i = $page-$padding; $i <= $page+$padding; $i++) {
            if($i >= 1 and $i <= $pageCount) {
                $pages[] = $i;
            }
        }
        
        return $this->render('default/home.html.twig', array(
            'title' => 'Blog',
            'navi' => 'blog',
            'posts' => $posts,
            'prev' => $prev,
            'next' => $next,
            'page' => $page,
            'pages' => $pages
        ));
    }
    /**
     * @Route("/blog/edit/{slug}", name="blog-edit")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request, $slug = null)
    {
        if($slug == null) {
            $title = 'Create blog post';
            $post = new Post();
            $post->setAuthor($this->getUser());
        } else {
            $title = 'Edit blog post';
            $post = $this->getDoctrine()
                ->getRepository('AppBundle:Post')
                ->findOneBySlug($slug);
            if(!$post) {
                throw $this->createNotFoundException(
                    'Sorry, I can not find the requested post.'
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
            
            $this->addFlash(
                'success',
                "Changes to ___{$post->getTitle()}___ have been saved."
            );
            
            return $this->redirectToRoute('blog-post', array('slug' => $post->getSlug()));
        }
        
        return $this->render('default/blog-edit.html.twig', array(
            'title' => $title,
            'navi' => 'blog',
            'form' => $form->createView()
        ));
    }
    /**
     * @Route("/tag/{title}/{page}", name="tag", defaults={"page" = 1}, requirements={"page": "\d+"})
     */
    public function tagAction($title, $page)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Tag');
        
        $padding = 3;
        $pageSize = 10;
        
        $postCount = $repository->getPostCount($title);
        $pageCount = ceil($postCount / $pageSize);
        
        if($page > $pageCount) {
            throw $this->createNotFoundException(
                'Sorry, we do not have that many posts.'
            );
        }
        
        $posts = $repository->getPosts($title, $page, $pageSize);
        
        $prev = ($page > 1);
        $next = ($page < $pageCount);
        $pages = array();
        
        for($i = $page-$padding; $i <= $page+$padding; $i++) {
            if($i >= 1 and $i <= $pageCount) {
                $pages[] = $i;
            }
        }
        
        return $this->render('default/posts.html.twig', array(
            'title' => $title,
            'navi' => 'blog',
            'posts' => $posts,
            'prev' => $prev,
            'next' => $next,
            'page' => $page,
            'pages' => $pages
        ));
    }
    /**
     * @Route("/blog/{slug}", name="blog-post")
     */
    public function postAction($slug)
    {
        $post = $this->getDoctrine()->getRepository('AppBundle:Post')->getPostBySlug($slug);
        
        if(!$post) {
            throw $this->createNotFoundException(
                'Sorry, we can not find the requested post.'
            );
        }
        
        return $this->render('default/post.html.twig', array(
            'title' => $post->getTitle(),
            'navi' => 'blog',
            'post' => $post
        ));
    }
}
