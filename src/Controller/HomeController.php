<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Message;
use App\Entity\Utilisateur;
use App\Entity\Admin;
use App\Entity\User;
use App\Entity\Conversation;
use Symfony\Component\HttpFoundation\Request;


class HomeController extends AbstractController {


    /**
     * @Route("/", name="home")
     */
    public function index():Response
    {
        $error = false;

        return $this->render("home/home.html.twig", [
            'error' => $error
        ]);
    }

    /**
     * @Route("/discuss", name="discuss")
     */
    public function getDiscuss(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $id_conversation = $request->get("id_conversation");
        $message = $em->getRepository(Message::class)->findAll();

        return $this->render("home/discuss.html.twig", [
            'id_conversation' => $id_conversation,
            'message'=> $message
        ]);
    }

    /**
     * @Route("/list", name="list_msg")
     */
    public function getMessage()
    {
        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getId();
        $admin = $em->getRepository(Admin::class)->findOneBy(['id_admin' => $userId]);
        $utilisateur = $em->getRepository(Utilisateur::class)->findAll();
        $conversation = $em->getRepository(Conversation::class)->findAll();
        $msg = $em->getRepository(Message::class)->findAll();
        // dump($conversation->getIdAdmin());
        // $msg = $em->

        return $this->render("home/historiqueMessage.html.twig", [
            'message' => $msg,
            'admin' => $admin,
            'utilisateur' => $utilisateur,
            'conversation' => $conversation,
            'userId' => $userId
        ]);
    }
}

?>