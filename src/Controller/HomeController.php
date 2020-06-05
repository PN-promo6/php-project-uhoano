<?php

namespace Controller;

class HomeController
{
    public function display()
    {
        global $postRepo;
        global $userRepo;
        global $orm;

        $posts = array();

        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            if (strpos($search, "@") === 0) {
                $nickname = substr($search, 1);
                $userRepo = $orm->getRepository(User::class);
                $users = $userRepo->findBy(array("nickname" => $nickname));

                if (count($users) == 1) {
                    $user = $users[0];
                    $posts = $postRepo->findBy(array("user" => $user->id));
                }
            } else {
                $posts = $postRepo->findBy(array("nickname" => $_GET['search']));
            }
        } else {
            $posts = $postRepo->findAll();
        }
        include "../templates/display.php";
    }
}
