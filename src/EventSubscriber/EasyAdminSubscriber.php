<?php

namespace App\EventSubscriber;

use App\Entity\Header;
use App\Entity\Product;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use ReflectionClass;

class EasyAdminSubscriber implements EventSubscriberInterface
{

    private $appKernel;

    public function __construct(KernelInterface $appKernel)
    {
        $this->appKernel = $appKernel;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setIllustration'],
            BeforeEntityUpdatedEvent::class => ['updateIllustration']
        ];
    }

    public function uploadIllustration($event,  $entityName)
    {
        $entity = $event->getEntityInstance();
        $category= $entity->getCategory()->getName();

        //use implode() for to convert array to string
        $tmp_name_dir= implode ($_FILES[$entityName]['tmp_name']['illustration']);
        $name_file_tmp=implode ( $_FILES[$entityName]['name']['illustration'] );
        $name_file_all=pathinfo($name_file_tmp,PATHINFO_BASENAME);
        //$name_file_all =  $name_file_all.$category;
        $project_dir=$this->appKernel->getProjectDir();

       //dd($project_dir."/public/uploads/".$category."/".$name_file_all);


        if (!($project_dir."/public/uploads/".$name_file_all)){
            move_uploaded_file($tmp_name_dir,$project_dir."/public/uploads/".$name_file_all);
            $entity->setIllustration($name_file_all);
        }

    }

    public function updateIllustration(BeforeEntityUpdatedEvent $event)
    {
        //if (!($event->getEntityInstance() instanceof Product) && !($event->getEntityInstance() instanceof Header)){
        if (!($event->getEntityInstance() instanceof Product)){
            return;
        }
        $reflexion= new ReflectionClass($event->getEntityInstance());
        $entityName= $reflexion->getShortName();


        if ($_FILES[$entityName]['tmp_name']['illustration'] !=''){
            $this->uploadIllustration($event,  $entityName);
        }
    }

    public function setIllustration(BeforeEntityPersistedEvent $event)
    {
        $reflexion= new ReflectionClass($event->getEntityInstance());
        $entityName= $reflexion->getShortName();

        //if (!($event->getEntityInstance() instanceof Product) && !($event->getEntityInstance() instanceof Header)){

        if (!($event->getEntityInstance() instanceof Product)){
            return;
        }
        $this->uploadIllustration($event,  $entityName);
    }



}
