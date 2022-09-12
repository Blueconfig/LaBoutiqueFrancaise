<?php

namespace App\Controller\Admin\Blog;

use App\Entity\Blog\BlogImages;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BlogImagesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BlogImages::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [

            TextField::new('title'),
            ImageField::new('file')
                ->setBasePath('articles/')
                ->setUploadDir('public/articles')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),

        ];
    }

}
