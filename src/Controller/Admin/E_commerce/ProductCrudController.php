<?php

namespace App\Controller\Admin\E_commerce;

use App\Entity\Product;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Symfony\Component\HttpKernel\KernelInterface;

class ProductCrudController extends AbstractCrudController
{
    private $appKernel;

    public function __construct(KernelInterface $appKernel)
    {
        $this->appKernel = $appKernel;
    }

    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // ...
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER)
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('name'),
            SlugField::new('slug')
                ->setTargetFieldName('name')
                ->hideOnIndex(),
            ImageField::new('illustration')
                ->setBasePath('uploads/product')
                ->setUploadDir('public/uploads/product')
                ->setRequired(false),
            TextField::new('subtitle', 'Sous titre'),
            TextareaField::new('description')->hideOnIndex(),
            BooleanField::new('isBest','Meilleur'),
            MoneyField::new('price')->setCurrency('CDF'),
            IntegerField::new('stock', 'Quantité'),
            AssociationField::new('category', 'Categorie'),
            //DateField::new('createdAt'),
            DateField::new('updatedAt','Mis à jour')->hideOnForm(),
            DateField::new('createdAt','Crée le')
                ->hideOnIndex()
                ->hideOnForm(),
        ];
    }


    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        $response = $this->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $usersId=$this->getUser()->getId();

        if ($this->isGranted('ROLE_ADMIN') && '...'){
            return $response;
        }


        //instruction de la boutique
        /*
        $response->andwhere("entity.users = $usersId");
        //dd($response);
        return $response;
        */
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        //use implode() for to convert array to string
        $tmp_name_dir= implode ($_FILES['Product']['tmp_name']['illustration']);
        $name_file_tmp=implode ( $_FILES['Product']['name']['illustration'] );
        $name_file_all=pathinfo($name_file_tmp,PATHINFO_BASENAME);
        //$name_file_all =  $name_file_all.$category;
        $project_dir=$this->appKernel->getProjectDir();
        //dd($project_dir."/public/uploads/post/".$name_file_all);
        if (!($project_dir."/public/uploads/product/".$name_file_all)){
            move_uploaded_file($tmp_name_dir,$project_dir."/public/uploads/product/".$name_file_all);
            $entityInstance->setIllustration($name_file_all);
        }

        $entityInstance->setUpdatedAt(new DateTime('now'));
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
}

