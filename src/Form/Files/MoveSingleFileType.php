<?php

namespace App\Form\Files;

use App\Controller\Files\FileUploadController;
use App\Form\Type\UploadrecursiveoptionsType;
use App\Services\FilesHandler;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MoveSingleFileType extends AbstractType
{
# TODO: change in JS
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add(FilesHandler::KEY_TARGET_UPLOAD_TYPE, ChoiceType::class, [
                'choices' => $options[FilesHandler::KEY_MODULES_NAMES],
                'attr'    => [
                    'class'                        => 'form-control listFilterer',
                    'data-dependent-list-selector' => '#move_single_file_target_subdirectory'
                ]
            ])
            ->add(FileUploadController::KEY_SUBDIRECTORY_TARGET_PATH_IN_UPLOAD_DIR, UploadrecursiveoptionsType::class, [
                'choices'   => [], //this is not used anyway but parent ChoiceType requires it
                'required'  => true,
            ])
            ->add('submit', SubmitType::class, [
            ]);

        /**
         * INFO: this is VERY IMPORTANT to use it here due to the difference between data passed as choice
         * and data rendered in field view
         */
        $builder->get(FileUploadController::KEY_SUBDIRECTORY_TARGET_PATH_IN_UPLOAD_DIR)->resetViewTransformers();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
        #Z$resolver->setRequired(FilesHandler::KEY_TARGET_SUBDIRECTORY_NAME);
        $resolver->setRequired(FilesHandler::KEY_MODULES_NAMES);
    }
}