<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Product;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager=$entityManager;
    }
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request,  PaginatorInterface $paginator)
    {

        $search=new search();
        $form=$this->createForm(SearchType::class, $search);


        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()){
            $products=$this->entityManager->getRepository(Product::class)->findWithSearch($search);

            $productsPination=$paginator->paginate(
                $products, /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                9 /*limit per page*/
            );;
        }

        else{
            $products = $this->entityManager->getRepository(Product::class)->FindAll();
            $productsPination=$paginator->paginate(
                $products, /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                9 /*limit per page*/
            );;
        }
        return $this->render('home/index.html.twig', [
            'products' => $productsPination,
            'form'=>$form->createView(),
            'form2'=>$form->createView(),
            'formHead'=>$form->createView()
        ]);
    }


    /**
     * @Route("/produit/{slug}", name="product")
     */
    public function show($slug)
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);
        //$bestProducts= $this->entityManager->getRepository(Product::class)->findByisBest(1);
        //$bestProducts = $this->entityManager->getRepository(Product::class)->findByIsBest(true);
        if (!$product) {
            return $this->redirectToRoute('home');
        }
        return $this->render('product/show.html.twig', [
            'product' => $product,
            //'bestProducts' => $bestProducts
        ]);
    }
}
