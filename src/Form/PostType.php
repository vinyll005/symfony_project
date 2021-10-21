<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image', FileType::class, array(
                'label' => 'Main image',
                'required' => false,
                'mapped' => false,
            ))
            ->add('category', EntityType::class, array(
                'label' => 'Category',
                'class' => Category::class,
                'choice_label' => 'title',
                'attr' => [
                    'placeholder' => 'Type text'
                ]
            ))
            ->add('title', TextType::class, array(
                'label' => 'Post title',
                'attr' => [
                    'placeholder' => 'Type title'
                ]
            ))
            ->add('content', TextType::class, array(
                'label' => 'Post Content',
                'attr' => [
                    'placeholder' => 'Type content'
                ]
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr' => [
                    'class' => 'btn btn-success float-left mr-4'
                ]
            ))
            ->add('delete', SubmitType::class, array(
                'label' => 'Delete',
                'attr' => [
                    'class' => 'btn btn-danger'
                ]
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
