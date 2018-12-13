<?php

namespace AppBundle\Services;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class PostService
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager->getRepository('AppBundle:Post');
    }

    public function tenLastPost()
    {
        return $this->em->tenLastPost();
    }

    public function findBy(array $tab)
    {
        return $this->em->findBy($tab);
    }
}