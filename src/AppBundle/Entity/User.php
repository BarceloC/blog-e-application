<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="blog_user")
 * @ORM\Entity
 */
class User extends BaseUser
{
  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Post", mappedBy="user")
   */
  protected $posts;

  /**
   * @ORM\Column(name="image_profil", type="text", nullable=true)
   * 
   * 
   * @Assert\Image(
   *    mimeTypes = {"image/jpeg", "image/png", "image/gif"}
   * )
   */
  protected $imageProfil;



  public function __construct()
  {
    parent::__construct();
    $this->posts = array();
    // your own logic
  }

  public function getImageProfil()
  {
    return $this->imageProfil;
  }

  public function setImageProfil($imageProfil)
  {
    $this->imageProfil = $imageProfil;
  }

  public function getPosts()
  {
    return $this->posts;
  }

  public function setPosts($post)
  {
    $this->posts[] = $post;
  }
}