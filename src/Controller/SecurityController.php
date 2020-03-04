<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/registration", name="app_register")
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardAuthenticatorHandler, LoginAuthenticator $formAuthenticator){
        /**
         * @var $user User
         */
        $user = new User();
        $form= $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $user = $form->getData();
            $user->setPassword($passwordEncoder->encodePassword(
                $user,
                $user->getPassword()
            ));
            $user->setKarma(50);
            $user->setMoney(0);
            if(!empty($form->get('code'))){
                $code = $form->get('code')->getData();
                switch ($code){
                    case "JendaPalach2020":
                        $user->setKarma(100);
                        $user->setMoney(250);
                        break;
                    case "NekdoVic2020":
                        $user->setKarma(500);
                        $user->setMoney(1000);
                        $user->setRoles(["ROLE_ADMIN"]);
                        break;
                    case "Obergruppenfuhrer":
                        $user->setKarma(5000);
                        $user->setMoney(5000);
                        $user->setRoles(["ROLE_SUPER_ADMIN"]);
                        break;
                    default:
                        $user->setKarma(-1000);
                        $user->setMoney(0);
                }
            }
            $manager->persist($user);
            $manager->flush();
            return $guardAuthenticatorHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $formAuthenticator,
                'main'
            );
        }

        return $this->render("security/registration.html.twig",[
            "form"=>$form->createView()
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}
