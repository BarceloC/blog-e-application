<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    /**
     * @Route("/", name="homepage", methods={"GET","HEAD"})
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/post/{id}", name="post", requirements={"id"="\d+"}, methods={"GET","HEAD"})
     */
    public function postAction(int $id, Request $request)
    {
        $phrase = "Le post numéro est $id";
        return $this->render("blog/post/post.html.twig", array('id' => $id));
    }
}
