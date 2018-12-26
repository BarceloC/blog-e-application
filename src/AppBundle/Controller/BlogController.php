<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Post;
use AppBundle\Services\PostService;
use AppBundle\Entity\User;
use Doctrine\DBAL\Driver\Connection;

class BlogController extends Controller
{
    /**
     * @Route("/{page}", name="homepage", requirements={"page"="\d+"}, methods={"GET","HEAD"})
     */
    public function indexAction(int $page = 1, Request $request, PostService $postService)
    {
        //nombre de posts à afficher
        $limit = 10;
        $perPage = 5;
        if($page > $limit/$perPage)
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        
        if($this->get('security.authorization_checker')->isGranted('ROLE_USER'))
        {
            if($page < 1)
                throw $this->createNotFoundException("La page ".$page." n'existe pas.");
            
            $posts = $postService->lastPost($page, $limit);
            $nbPages = (ceil(count($posts)/$perPage) > 2) ? 2 : ceil(count($posts)/$perPage);
            
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
     * @Route("/debug", name="debug")
     */
    public function debug(PostService $postService)
    {
        dump($postService->newPost(new Post(), new User()));
        return new Response("");
    }
}
