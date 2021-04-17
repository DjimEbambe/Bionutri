<?php

namespace App\Controller\Blog;

use App\Entity\BlogArticles;
use App\Entity\BlogCommentaire;
use App\Form\BlogCommentType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//use App\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager=$entityManager;
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {

        // Méthode findBy qui permet de récupérer les données avec des critères de filtre et de tri
        $donnees = $this->entityManager->getRepository(BlogArticles::class)->findBy([],['createdAt' => 'desc']);

        $articles = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );

        return $this->render('blog/index.html.twig', [
            'article' => $articles,
        ]);
    }

    /**
     * @Route("/blog/{slug}", name="article")
     */
    //name Route: blog article
    public function article($slug, Request $request){
        $article = $this->entityManager->getRepository(BlogArticles::class)->findOneBy(['slug' => $slug]);

        $commentaires = $this->entityManager->getRepository(BlogCommentaire::class)->findBy([
            'blogArticles' => $article,
            'actif' => 0
        ],['createdAt' => 'desc']);

        if(!$article){
            // Si aucun article n'est trouvé, nous créons une exception
            return $this->redirectToRoute('blog');
        }

        $comment = new BlogCommentaire();
        $commentForm = $this->createForm(BlogCommentType::class, $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() ){   //sans && $commentForm->isValid())
            // On récupère le contenu du champ parentid
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
            $comment->setPseudo($this->getUser()->getName());
            $comment->setPhone($this->getUser()->getPhone());
            $comment->setRgpd(true);
            $comment->setBlogArticles($article);
            $parentid = $commentForm->get("parentid")->getData();

            if($parentid != null){
                $parent = $this->entityManager->getRepository(BlogCommentaire::class)->find($parentid);
            }

            // On définit le parent
            $comment->setParent($parent ?? null);

            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            //$this->addFlash('message', 'Votre commentaire a bien été envoyé');
            return $this->redirectToRoute('article', ['slug' => $article->getSlug()]);
        }

        return $this->render('blog/article.html.twig', [
            'commentForm' => $commentForm->createView(),
            'article' => $article,
            'comments' => $commentaires,
        ]);
    }
}
