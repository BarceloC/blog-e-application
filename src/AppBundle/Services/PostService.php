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

    public function lastPost(int $page, int $limit)
    {
        return $this->em->lastPost($page, $limit/2);
    }

    public function lastPostVisitor(int $limit)
    {
        return $this->em->lastPostVisitor($limit);
    }

    public function findBy(array $tab)
    {
        return $this->em->findBy($tab);
    }
}