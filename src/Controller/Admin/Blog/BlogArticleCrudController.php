<?php

namespace App\Controller\Admin\Blog;

use App\Entity\Blog\BlogArticle;
use App\Entity\Blog\BlogCategorie;
use App\Entity\Categories;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BlogArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BlogArticle::class;
    }

    public function createEntity(string $entityFqcn): BlogArticle
    {
        $article = new BlogArticle();
        $article->setEditor($this->getUser());
        $article->setCreatedAt(new \DateTimeImmutable());
        return $article;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            SlugField::new('slug')->setTargetFieldName('title'),
            TextEditorField::new('content'),
            AssociationField::new('categories'),
            CollectionField::new('images')->useEntryCrudForm(),
            BooleanField::new('etat')->setLabel('Publier'),
        ];
    }

}
