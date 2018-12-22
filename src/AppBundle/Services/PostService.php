<?php

namespace AppBundle\Services;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Post;
use AppBundle\Services\UrlAliasService;

class PostService
{
    protected $em;
    protected $urlAlisService;
    protected $repository;

    public function __construct(EntityManagerInterface $entityManager, UrlAliasService $urlAlisService)
    {
        $this->em = $entityManager;
        $this->urlAlisService = $urlAlisService;
        $this->repository = $entityManager->getRepository('AppBundle:Post');
    }

    public function lastPost(int $page, int $limit)
    {
        return $this->repository->lastPost($page, $limit/2);
    }

    public function lastPostVisitor(int $limit)
    {
        return $this->repository->lastPostVisitor($limit);
    }

    public function findBy(array $tab)
    {
        return $this->repository->findBy($tab);
    }

    public function newPost(Post $post)
    {
        $post->setPublished(new \Datetime());
        $post->setUrlAlias($post->getTitre());
        do
        {
            $post->setUrlAlias($this->urlAlisService->create($post->getUrlAlias()));
        }while(!$this->isUrlAliasUnique($this->urlAlisService->create($post->getUrlAlias())));
        $this->em->persist($post);
        $this->em->flush();
    }

    public function editPost(Post $post)
    {
        $this->em->flush();
    }

    public function isUrlAliasUnique(string $urlAlias)
    {
        return $this->repository->isUrlAliasUnique($urlAlias);
    }

    public function deletePost(Post $post)
    {
        $this->em->remove($post);
        $this->em->flush();
    }
}