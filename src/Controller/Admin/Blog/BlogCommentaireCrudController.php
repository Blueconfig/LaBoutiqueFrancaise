<?php

namespace App\Controller\Admin\Blog;

use App\Entity\Blog\BlogCommentaire;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BlogCommentaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BlogCommentaire::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
