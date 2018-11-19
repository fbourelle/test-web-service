<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class ApiController extends AbstractController
{
    /**
     * renvoie une liste d'utilisateurs
     * 
     * @Route("/api/v1/users", 
     *   methods={"get"},
     *   name="api-get-users")
     */
    public function getUsers()
    {
        $file = 'user.csv';
        $users = array();
        $row = 0;

        $filename = __DIR__ . "/../../public/file/" .$file;

        if (file_exists($filename)) { // si le fichier existe
            if (($handle = fopen(__DIR__ . "/../../public/file/" .$file, "r")) !== FALSE) { // on parcoure le fichier csv
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                    $num = count($data);           
                    if ($row > 0) { // si on ne lit pas la première ligne correspondant aux nom des colonnes
                        $user = new User();
                        for ($c = 0; $c < $num; $c++) {
                            $id = $data[0];
                            $name = $data[1];
                            $firstname = $data[2];
                            $phonenumber = $data[3];
                            $user->setId(trim($id));
                            $user->setName(trim($name));
                            $user->setFirstname(trim($firstname));
                            $user->setPhonenumber(trim($phonenumber));
                            $users[$row] = $user;
                        }
                    }   
                    $row++;
                }
                fclose($handle);
            }    
        } else {
            // si le fichier est introuvable
            return $this->json([
                "status" => "error",
                "message" => "Le fichier d'entrée est introuvable"
            ], 404);
        }
            // si le fichier est vide
        if (empty($users)) {
            return $this->json([
                "status" => "error",
                "message" => "Aucun adhérent n'est présent"
            ], 404);
        }            

        // on retourne un fichier correct
        return $this->json($users, 200);
    }

    /**
    * renvoie un utilisateur
    *
    * @Route(
    *     "/api/v1/users/{id}",
    *     methods={"get"},
    *     name="api_get_user_detail"
    * )
    */
    public function getUserDetail($id)
    {
        // on crée un nouvel utilisateur
        $user = new User();  
        $row = 0;
        if (($handle = fopen(__DIR__ . "/../../public/file/user.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $num = count($data);
                if ($row > 0) {
                    if ($id == $data[0]) {  // si l'id demandé correspond à l'id d'un utilisateur
                        for ($c = 0; $c < $num; $c++) {
                            $id = $data[0];
                            $name = $data[1];
                            $firstname = $data[2];
                            $phonenumber = $data[3];
                            $user->setId(trim($id));
                            $user->setName(trim($name));
                            $user->setFirstname(trim($firstname));
                            $user->setPhonenumber(trim($phonenumber));
                            return $this->json($user); // on retourne immédiatement l'utilisateur
                        }
                    }
                }
                $row++;   
            }
            fclose($handle);
        }    

        // si on n'a pas trouvé d'utilisateur correspondant à l'id demandé
        if (empty($user->id)) {
            return $this->json([
                "status" => "error",
                "message" => "Aucun adhérent ne correspond à votre demande"
            ], 404);
        }
    }
}
