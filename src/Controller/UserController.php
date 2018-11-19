<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\Unirest;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function getUsers(Request $request)
    {
        // on appelle l'api qui retourne les utilisateurs
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/test-web-service/public/api/v1/users");
        $result = curl_exec($ch);
        curl_close($ch);
        
        // on affiche le résultat de manière brute
        print_r($result);

        // A terminer : convertir les données en tableau d'objet
        return $this->render('user/index.html.twig', [
            'data' => $result,
        ]);
    }

    /**
     * @Route("/user/{id}", name="user_detail")
     */
    public function getUserDetail($id)
    {
        // on appelle l'api qui retourne 1 utilisateur selon l'ID passé en URL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/test-web-service/public/api/v1/users/".$id);
        $result = curl_exec($ch);
        curl_close($ch);
        
        // on affiche le résultat de manière brute
        print_r($result);

        // A terminer : convertir les données en tableau d'objet
        return $this->render('user/userdetail.html.twig', [
            'data' => $result,
        ]);
    }

}
