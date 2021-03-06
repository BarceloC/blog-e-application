<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Post;
use AppBundle\Services\PostService;
use AppBundle\Form\PostType;

class CrudController extends Controller
{
    /**
     * @Route("post/{url_alias}", name="post", methods={"GET","HEAD"})
     */
    public function postAction(string $url_alias, Request $request, PostService $postService)
    {
        $post = $postService->findBy(array('urlAlias' => $url_alias));
        if(count($post) > 0)
        {
            $post = $post[0];
            return $this->render("blog/post/post.html.twig", array('post' => $post));
        }
        else
        {
            throw $this->createNotFoundException("Le post $url_alias n'existe pas.");
        }
    }

    /**
     * @Route("sortedPost/", name="sortedPost", methods={"POST", "HEAD"})
     */
    public function sortedPostAction(Request $request, PostService $postService)
    {
        $selectChoice = $request->get("critere");
        if($selectChoice === "titre")
        {
            $posts = $postService->findBy(array($selectChoice => $request->get($selectChoice)));
            return $this->render("blog/post/sortedPost.html.twig", array('posts' => $posts));
        }
        else if($selectChoice === "published")
        {
            $date = new \Datetime($request->get($selectChoice));
            $posts = $postService->findBy(array($selectChoice => $date));
            return $this->render("blog/post/sortedPost.html.twig", array('posts' => $posts));
        }
        else
        {
            throw $this->createNotFoundException("Le critère recherché n'existe pas.");
        }
    }

    /**
     * @Route("post/create/", name="createPost")
     */
    public function newAction(Request $request, PostService $postService)
    {
        $post = new Post();
        $user = $this->getUser();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        //message flash
        $flashbag = $this->get('session')->getFlashBag();

        if($form->isSubmitted() && $form->isValid())
        {
            $post = $form->getData();
            //insert post
            $postService->newPost($post, $user);
            //on prévient l'utilisateur que son post à bien été créé
            $flashbag->add("success", "text.card.paragraph.post.success");
            //redirection
            return $this->redirectToRoute('homepage');
        }
    
        return $this->render("blog/post/newPost.html.twig", array("form" => $form->createView()));
    }

    /**
     * @Route("post/edit/{urlAlias}", name="editPost")
     */
    public function editAction(String $urlAlias, Request $request, PostService $postService)
    {
        $post = $postService->findBy(array('urlAlias' => $urlAlias));
        $post = $post[0];

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $post = $form->getData();
            //insert post
            $postService->editPost($post);
            //redirection
            return $this->redirectToRoute('homepage');
        }
        
        return $this->render("blog/post/editPost.html.twig", array("form" => $form->createView(), 'post' => $post));
    }

    /**
     * @Route("post/delete/{urlAlias}", name="deletePost")
     */
    public function deleteAction(String $urlAlias, Request $request, PostService $postService)
    {
        $post = $postService->findBy(array('urlAlias' => $urlAlias));
        $post = $post[0];

        $postService->deletePost($post);
        return $this->redirectToRoute('homepage');
    }
}