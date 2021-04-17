<?php

namespace App\Controller\Account;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AccountPasswordController extends AbstractController
{

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }
    /**
     * @Route("/compte/modifier-mon-mot-de-passe", name="account_password")
     * @Security ("is_granted ('IS_AUTHENTICATED_FULLY')")
     */

    public function index(Request $request, UserPasswordEncoderInterface  $encoder)
    {
        
        $user= $this->getUser();
        $form = $this->createForm(ChangePasswordType::class,$user);
        $form->handleRequest($request);
        $notification = null;

        if ($form->isSubmitted() && $form->isValid()){
            $old_pwd = $form->get('old_password')->getData();
            //dd($old_pwd);
            if ($encoder->isPasswordValid($user,$old_pwd)) {

                $new_pwd =$form->get('new_password')->getData();
                $password = $encoder->encodePassword($user, $new_pwd);

                //dd($password);
                $user->setPassword($password);
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $notification="Votre mot de passe a été bien mis à jour";
            }
            else {
                $notification="votre mot de passe actuel n'est pas le bon";
            }
        }
        return $this->render('account/password.html.twig',[
            'form'=>$form->createView(),
            'notification'=>$notification
        ]);
    }
}
