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
use Symfony\Component\HttpFoundation\JsonResponse;


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

    /**
     * @Route("/listUser", name="list_msg_user")
     */
    public function getMessageUser()
    {
        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getId();
        $utilisateur = $em->getRepository(Utilisateur::class)->findOneBy(['id_user' => $userId]);
        $admin = $em->getRepository(Admin::class)->findAll();
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

    /**
     * @Route("/listAdmin", name="list_admin")
     */
    public function getAdmin()
    {
        $em = $this->getDoctrine()->getManager();
        $admin = $em->getRepository(Admin::class)->findAll();
        $userId = $this->getUser()->getId();

        return $this->render("admin/listAdmin.html.twig", [
            'admin' => $admin,
            'userId' => $userId
        ]);
    }

    /**
     * @Route("/sendMessaage", name="send_msg")
     */
    public function sendMessage(Request $request)
    {
        $userId = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $msg = $request->get("message");
        $id_conversation = $request->get("id_conversation");
        $id_admin = $request->get("id_admin");
        $admin = $em->getRepository(Admin::class)->findOneBy(['id_admin' => $id_admin]);
        $utilisateur = $em->getRepository(Utilisateur::class)->findOneBy(['id_user' => $this->getUser()]);
        // $id_user = $em->getRepository(Utilisateur::class)->findOneBy(['id_user' => $userId]);

        if($id_conversation == null){
            //ajout un nouvelle conversation dans la table conversation
            $conversation = new Conversation();
            $conversation->setIdAdmin($admin);
            $conversation->setIdUtilisateur($utilisateur);

            $em->persist($conversation);
            $em->flush();

            $last_conv = $em->getRepository(Conversation::class)->findOneBy([], ['id' => 'DESC']);

            $message = new Message();
            $message->setMessage($msg);
            $message->setIdConversation($last_conv); //on ajoute la derniere conversation qui vient d'etre ajouté
            $message->setIdUser($this->getUser());

            $em->persist($message);
            $em->flush();

        } else {
            $conversation = $em->getRepository(Conversation::class)->findOneBy(['id' => $id_conversation]);
        

            $message = new Message();
            $message->setMessage($msg);
            $message->setIdConversation($conversation);
            $message->setIdUser($this->getUser());

            $em->persist($message);
            $em->flush();

        }
        
        return new response();
    }

    /**
     * @Route("/getNewMsg", name="new_msg")
     */
    public function getNewMsg(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id_conversation = $request->get("id_conversation");
        $message = $em->getRepository(Message::class)->findAll();

        return $this->render("modal/modalDiscu.html.twig", [
            'id_conversation' => $id_conversation,
            'message'=> $message
        ]);
    }

    /**
     * @Route("/getNewMsgModal", name="new_msg_modal")
     */
    public function getNewMsgModal(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $message = $em->getRepository(Message::class)->findAll();
        dump($message);

        return new Response($message);
    }
}

?>