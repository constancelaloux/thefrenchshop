<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;

class ProductCrudController extends AbstractCrudController
{
     public const PRODUCT_BASE_PATH = 'images/';
    public const PRODUCT_UPLOAD_DIR = 'public/images/';
    public const UPLOADED_FILE_NAME_PATTERN = '[randomhash].[extension]';
    
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

 
    public function configureFields(string $pageName): iterable
    {
        return [
                   TextField::new('name'),
                   TextField::new('subtitle'),
                   SlugField::new('slug')
                       ->setTargetFieldName('name'),
                   TextareaField::new('Description'),
                   AssociationField::new('category'),
                   ImageField::new('illustration')
                       ->setUploadDir(self::PRODUCT_UPLOAD_DIR)
                       ->setBasePath(self::PRODUCT_BASE_PATH)
                       ->setUploadedFileNamePattern(self::UPLOADED_FILE_NAME_PATTERN)
                       ->setRequired(false),
                   MoneyField::new('price')
                       ->setCurrency('EUR'),
                   /*DateTimeField::new('updatedAt')
                       ->hideOnForm(),
                   DateTimeField::new('createdAt')
                       ->hideOnForm(),*/
               ];

    }
}
