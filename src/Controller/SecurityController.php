<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Utilisateur;
use App\Entity\Admin;

class SecurityController extends AbstractController 
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @Route("/login", name="user_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, Request $request)
    {
        
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render("home/home.html.twig", [
            // 'typeUser' => $userType,
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/loginAuth/{userType}", name="user_login_auth")
     */
    public function loginAuth(AuthenticationUtils $authenticationUtils, Request $request, $userType)
    {
        
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render("security/login.html.twig", [
            'typeUser' => $userType,
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/registerForm/{userType}", name="form_register")
     */
    public function registerForm(AuthenticationUtils $authenticationUtils, Request $request, $userType)
    {
        dump($userType);
        
        return $this->render("register/registerForm.html.twig", [
            'typeUser' => $userType,
        ]);
    }

    /**
     * @Route("/register", name="user_register")
     */
    public function register(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        // $role = $request->get("role");
        $username = $request->get("username");
        $password = $request->get("password");

        if($request->get("role") == "Admin"){
            $role = "ROLE_ADMIN";
        } else {
            $role = "ROLE_USER";
        }

        $user = new User();
        $user->setRoles($role);
        $user->setIdUser($username);
        $user->setPassword($this->encoder->encodePassword($user, $password));

        $entityManager->persist($user);
        $entityManager->flush();

        $last_user = $entityManager->getRepository(User::class)->findOneBy([], ['id' => 'DESC']);

        if($role == "ROLE_ADMIN"){
            $admin = new Admin;
            $admin->setIdAdmin($last_user);

            $entityManager->persist($admin);
            $entityManager->flush();   

        } else {
            $utilisateur = new Utilisateur;
            $utilisateur->setIdUser($last_user);

            $entityManager->persist($utilisateur);
            $entityManager->flush();  
        }

        return $this->redirectToRoute('home');
    }

}

?>