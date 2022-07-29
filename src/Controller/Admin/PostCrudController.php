<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextareaField::new('summary'),
            TextEditorField::new('body'),
            ChoiceField::new('status')
                ->setChoices(fn() => [
                    'draft' => 1,
                    'published' => 2
                ]),
            TimeField::new('created_at')->setFormat('Y-MM-dd HH:mm:ss'),
            TimeField::new('updated_at')->setFormat('Y-MM-dd HH:mm:ss'),
            ImageField::new('post_image')
                ->setBasePath('uploads/images')     // 显示时使用
                ->setUploadDir('public/uploads/images') // 上传时使用
        ];
    }
}
