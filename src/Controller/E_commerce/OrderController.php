<?php

namespace App\Controller\E_commerce;

use App\Classe\Carte;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{

    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/commande", name="order")
     */
    public function index(Carte $cart): Response
    {
        //dd($cart->getFull());
        if (!$this->getUser()->getAddresses()->getValues()){

            return $this->redirectToRoute('account_address_add');
        }

        $form=$this->createForm(OrderType::class, null, [
            'user'=>$this->getUser()
        ]);

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart'=> $cart->getFull(),
        ]);
    }

    /**
     * @Route("/commande/recapitulatif", name="order_recap", methods={"POST"})
     */
    public function add(Carte $carte, Request $request)
    {

        $form=$this->createForm(OrderType::class, null, [
            'user'=>$this->getUser(),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $date = new \DateTime();
            $carriers=$form->get('carriers')->getData();
            $delivery=$form->get('addresses')->getData();
            $delivery_content=$delivery->getFirstname().' '.$delivery->getName();

            if ($delivery->getReference()){
                $delivery_content .= '</br>'.$delivery->getReference();
            }

            $delivery_content .= '</br>'.$delivery->getAddress();
            $delivery_content .= '</br>'.$delivery->getPhone();
            $delivery_content .= '</br>'.$delivery->getCity();

            //enregistrer ma commande order
            $dayDate = new \DateTime();
            $order = new Order();
            $order->setUser($this->getUser());
            $order->setReference(sprintf('%sH%s', $dayDate->format('dmY'), uniqid()));
            $order->setCreatedAt($date);
            $order->setCarrierName($carriers->getName());
            $order->setCarrierPrice($carriers->getPrice());
            $order->setDelivery($delivery_content);
            $order->setState(0);

            $this->entityManager->persist($order);


            //Enregistrer mes produits orderDetaills
            foreach ($carte->getFull() as $product){
                $orderdetails= new OrderDetails();
                $orderdetails->setMyOrder($order);
                $orderdetails->setProduct($product['product']->getName());
                $orderdetails->setQuantity($product['quantity']);
                $orderdetails->setPrice($product['product']->getPrice());
                $orderdetails->setTotal($product['product']->getPrice() * $product['quantity']);

                $this->entityManager->persist($orderdetails);
            }

            $this->entityManager->flush();

            return $this->render('order/add.html.twig', [
                'cart'=>$carte->getFull(),
                'carrier'=>$carriers,
                'delvery'=>$delivery_content,
                'reference'=>$order->getReference()

            ]);
        }

        return $this->redirectToRoute('cart');

    }
}
