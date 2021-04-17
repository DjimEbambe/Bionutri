<?php

namespace App\Controller\Account;

use App\Entity\User;
use App\Form\RegisterType;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegisterController extends AbstractController
{
    private $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security){
        $this->entityManager=$entityManager;
        $this->security = $security;
    }

    /**
     * @Route("/inscription", name="register")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder, LoginFormAuthenticator $login, GuardAuthenticatorHandler $guard): Response
    {

        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $notification = null;
        $phoneExist= null;

        $form->handleRequest($request);

        if ($this->security->getUser()) {
            return $this->redirectToRoute('account');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $search_phone = $this->entityManager->getRepository(User::class)->findOneByPhone($user->getPhone());

            if ($search_phone) {
                //$phoneExist = 'Ce numéro  existe déjà !';
                $notification = 'Ce numéro  existe déjà !';

            }

            else{

                $password = $encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);

                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $notification = 'enregistrement reussi';


                //Just to be UX, I had a flash message
                $this->addFlash('success', 'The registration is successfull');


                /*
                 * Envoie Mails
                $mail = new Mail();
                $content = sprintf('Bonjour %s <br> Merci pour votre inscription ;-)', $user->getPhone());
                    $mail->send(
                        $user->getEmail(),
                        sprintf('%s %s', $user->getFirstName(), $user->getName()),
                        'Bienvenue sur le site "La boutique"',
                        $content
                    );
                 */

                return $guard->authenticateUserAndHandleSuccess($user,$request,$login,'main');
            }

        }


        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
