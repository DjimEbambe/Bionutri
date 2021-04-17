<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\BlogCommentaire;
use App\Entity\Comment;
use App\Entity\Product;
use App\Form\BlogCommentType;
use App\Form\CommentType;
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
    public function show($slug, Request $request)
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);
        //$bestProducts= $this->entityManager->getRepository(Product::class)->findByisBest(1);
        //$bestProducts = $this->entityManager->getRepository(Product::class)->findByIsBest(true);
        if (!$product) {
            return $this->redirectToRoute('home');
        }

        $commentaires = $this->entityManager->getRepository(Comment::class)->findBy([
            'product' => $product,
            'actif' => 0
        ],['createdAt' => 'desc']);


        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);


        if ($commentForm->isSubmitted() ){
            // On récupère le contenu du champ parenti

            //dd($commentForm->getData());
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
            $comment->setPseudo($this->getUser()->getName());
            $comment->setPhone($this->getUser()->getPhone());
            $comment->setRgpd(true);
            $comment->setProduct($product);
            $parentid = $commentForm->get("parentid")->getData();

            if($parentid != null){
                $parent = $this->entityManager->getRepository(Comment::class)->find($parentid);
            }

            // On définit le parent
            $comment->setParent($parent ?? null);
            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            //$this->addFlash('message', 'Votre commentaire a bien été envoyé');
            return $this->redirectToRoute('product', ['slug' => $product->getSlug()]);
        }


        return $this->render('product/show.html.twig', [
            'product' => $product,
            'commentForm' => $commentForm->createView(),
            'comments' => $commentaires,
            //'bestProducts' => $bestProducts
        ]);
    }
}
