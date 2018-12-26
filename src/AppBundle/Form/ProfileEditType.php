<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\User;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class ProfileEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('imageProfil', FileType::class, array('data_class' => null, 'required' => false, 'label' => 'input.file.profile_image'));
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_edit';
    }
}