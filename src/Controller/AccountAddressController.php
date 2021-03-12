<?php

namespace App\Controller;

use App\Classe\Carte;
use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAddressController extends AbstractController
{
    private $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }

    /**
     * @Route("/compte/adresses", name="account_address")
     */
    public function index()
    {
        //dd($this->getUser()->getAdresses());
        return $this->render('account/address.html.twig');
    }

    /**
     * @Route("/compte/ajouter-une-adresse", name="account_address_add")
     */
    public function add(Request $request, Carte $carte)
    {
        $adress= new Address();

        $form=$this->createForm(AddressType::class, $adress);

        $form->handleRequest( $request);
        if ($form->isSubmitted() && $form->isValid()){
            $adress->setUser($this->getUser());

            $this->entityManager->persist($adress);
            $this->entityManager->flush();
            if ($carte->get()){
                return $this->redirectToRoute('order');
            }else{
                return $this->redirectToRoute('account_adress');
            }

        }

        return $this->render('account/address_form.html.twing', [
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/compte/modifier-une-adresse/{id}", name="account_address_edit")
     */
    public function adit(Request $request, $id)
    {
        $adress= $this->entityManager->getRepository(Address::class)->findOneById($id);
        if (!$adress || $adress->getUser() != $this->getUser()){
            return $this->redirectToRoute('account_address');
        }

        $form=$this->createForm(AddressType::class, $adress);

        $form->handleRequest( $request);
        if ($form->isSubmitted() && $form->isValid()){

            $this->entityManager->flush();
            return $this->redirectToRoute('account_address');
        }

        return $this->render('account/address_form.html.twing', [
            'form'=>$form->createView()
        ]);
    }


    /**
     * @Route("/compte/supprimer-une-adresse/{id}", name="account_address_delete")
     */
    public function delete($id)
    {
        $adress= $this->entityManager->getRepository(Address::class)->findOneById($id);
        if ($adress && $adress->getUser() == $this->getUser()){
            $this->entityManager->remove($adress);
            $this->entityManager->flush();
        }
        return $this->redirectToRoute('account_address');
    }
}
