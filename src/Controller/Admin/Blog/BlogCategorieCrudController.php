<?php

namespace App\Controller\Admin\Blog;

use App\Entity\Blog\BlogCategorie;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BlogCategorieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BlogCategorie::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            SlugField::new('slug')->setTargetFieldName('title'),
        ];
    }

}
