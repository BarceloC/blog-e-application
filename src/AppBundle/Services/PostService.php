<?php

namespace AppBundle\Services;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use AppBundle\Services\UrlAliasService;

class PostService
{
    protected $em;
    protected $urlAliasService;
    protected $repository;

    public function __construct(EntityManagerInterface $entityManager, UrlAliasService $urlAliasService)
    {
        $this->em = $entityManager;
        $this->urlAliasService = $urlAliasService;
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

    public function newPost(Post $post, User $user)
    {
        $post->setPublished(new \Datetime());
        $post->setUrlAlias($post->getTitre());
        $post->setUser($user);
        $user->setPosts($post);
        do
        {
            $post->setUrlAlias($this->urlAliasService->create($post->getUrlAlias()));
        }while(!$this->isUrlAliasUnique($post->getUrlAlias()));
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