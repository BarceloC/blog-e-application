<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use AppBundle\Entity\User;
use AppBundle\Services\FileUploader;

class ImageUploadListener
{
    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    private function uploadFile($entity)
    {
        // upload only works for Product entities
        if (!$entity instanceof User) {
            return;
        }

        $file = $entity->getImageProfil();

        // only upload new files
        if ($file instanceof UploadedFile) 
        {
            $fileName = $this->uploader->upload($file);
            $entity->setImageProfil($fileName);
        } 
        elseif ($file instanceof File) 
        {
            // prevents the full file path being saved on updates
            // as the path is set on the postLoad listener
            $entity->setImageProfil($file->getFilename().$file->guessExtension());
        }
    }
}