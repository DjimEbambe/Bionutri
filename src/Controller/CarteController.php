<?php

namespace App\Controller;

use App\Classe\Carte;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarteController extends AbstractController
{
    private $entityManager;



    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }


    /**
     * @Route("/mon-panier", name="cart")
     */
    public function index(Carte $carte)
    {


        //dd($cartComplet);

        return $this->render('carte/index.html.twig', [
            'cart'=>$carte->getFull(),
            'stockfini'=>Carte::$stockfini,
        ]);
    }

    /**
     * @Route("/cart/add/{id}", name="add_to_cart")
     */
    public function add(Carte $carte,$id)
    {
        $carte->add($id);
        return $this->redirectToRoute('cart');

    }


    /**
     * @Route("/cart/remove", name="remove_to_cart")
     */
    public function remove(Carte $carte)
    {
        $carte->remove();
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/cart/delete/{id}", name="delete_to_cart")
     */
    public function delete(Carte $carte, $id)
    {
        $carte->delete($id);
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/decrease/{id}", name="decrease_to_cart")
     */
    public function decrease(Carte $carte, $id)
    {
        $carte->decrease($id);
        return $this->redirectToRoute('cart');
    }
}
