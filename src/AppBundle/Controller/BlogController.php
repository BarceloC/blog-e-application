<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Post;
use AppBundle\Services\PostService;

class BlogController extends Controller
{
    /**
     * @Route("/", name="homepage", methods={"GET","HEAD"})
     */
    public function indexAction(Request $request, PostService $postService)
    {
        // replace this example code with whatever you need
        $posts = $postService->tenLastPost();
        var_dump($posts);
        return new Response('');
    }

    /**
     * @Route("/post/{url_alias}", name="post", methods={"GET","HEAD"})
     */
    public function postAction(string $url_alias, Request $request, PostService $postService)
    {
        $post = $postService->findBy(array('urlAlias' => $url_alias));
        var_dump($url_alias);
        return $this->render("blog/post/post.html.twig", array('id' => $url_alias));
    }
}
