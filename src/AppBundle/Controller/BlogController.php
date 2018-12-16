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
     * @Route("/{page}", name="homepage", requirements={"page"="\d+"}, methods={"GET","HEAD"})
     */
    public function indexAction(int $page = 1, Request $request, PostService $postService)
    {
        //nombre de posts à afficher
        $limit = 10;
        if($this->get('security.authorization_checker')->isGranted('ROLE_USER'))
        {
            if($page < 1)
                throw $this->createNotFoundException("La page ".$page." n'existe pas.");
            
            $posts = $postService->lastPost($page, $limit);
            $nbPages = ceil(count($posts)/($limit/2));
            
            return $this->render("blog/accueil/accueil.html.twig", array(
                'posts' => $posts,
                'nbPages' => $nbPages,
                'page' => $page
            ));
        }
        else
        {
            $posts = $postService->lastPostVisitor($limit);
            return $this->render("blog/accueil/accueil.html.twig", array('posts' => $posts));
        }
    }

    /**
     * @Route("post/{url_alias}", name="post", methods={"GET","HEAD"})
     */
    public function postAction(string $url_alias, Request $request, PostService $postService)
    {
        $post = $postService->findBy(array('urlAlias' => $url_alias));
        return $this->render("blog/post/post.html.twig", array('id' => $url_alias));
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
}
