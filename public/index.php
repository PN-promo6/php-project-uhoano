<?php
// require("../vendor/autoload.php");

// use Entity\Post;
// use Entity\User;

// $usr1 = new User();

// $usr1->id = 1;
// $usr1->nickname = "Juan Carlos";
// $usr1->password = "azerty";
// $usr1->email = "juan.carlos@gmail.com";

// $post1 = new Post();

// $post1->id = 1;
// $post1->nickname = "toto";
// $post1->category = "Meuble";
// $post1->description = "Table epoxy";
// $post1->url_image = "https://image.made-in-china.com/202f0j10zwQtmDTKZFuZ/High-Transparency-Epoxy-Resin-for-River-Table-Casting.jpg";
// $post1->date = time();
// $post1->user = $usr1;

// $post2 = new Post();

// $post2->id = 2;
// $post2->nickname = "tata";
// $post2->category = "Sculture";
// $post2->description = "Table epoxy";
// $post2->url_image = "https://image.made-in-china.com/202f0j10zwQtmDTKZFuZ/High-Transparency-Epoxy-Resin-for-River-Table-Casting.jpg";
// $post2->date = time();
// $post2->user = $usr1;

// $post3 = new Post();

// $post3->id = 2;
// $post3->nickname = "titi";
// $post3->category = "Azerty";
// $post3->description = "Table epoxy";
// $post3->url_image = "https://image.made-in-china.com/202f0j10zwQtmDTKZFuZ/High-Transparency-Epoxy-Resin-for-River-Table-Casting.jpg";
// $post3->date = time();
// $post2->user = $usr1;

// $posts = array($post1, $post2, $post3);

require __DIR__ . '/../vendor/autoload.php';
session_start();

use Entity\Post;
use Entity\User;
use ludk\Persistence\ORM;
use Controller\AuthController;
use Controller\HomeController;

$orm = new ORM(__DIR__ . '/../Resources');
$userRepo = $orm->getRepository(User::class);
$postRepo = $orm->getRepository(Post::class);
$posts = $postRepo->findAll();
$post0 = $posts[0];
$manager = $orm->getManager();
//modifie le titre d'un recipe
// $post1 = $postRepo->find(1);
// $post1->category = "nouveau titre";
// $manager->persist($post1);
// $manager->flush();

$action = substr(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), 1);
switch ($action) {
  case 'register':
    $controller = new AuthController();
    $controller->register();
    break;

  case 'logout':
    $controller = new AuthController();
    $controller->logout();
    break;

  case 'login':
    $controller = new AuthController();
    $controller->login();
    break;

  case 'new':
    if (!isset($_SESSION['user'])) {
      header('Location:/?action=display');
    } else {
      $posts = $postRepo->findAll();
      if (
        isset($_POST['category']) && isset($_POST['description']) && isset($_POST['url_image'])
      ) {
        $errorMsg = NULL;
        if ($_POST['category'] == "0") {
          $errorMsg = "Choose a category.";
        } else if (empty($_POST['description'])) {
          $errorMsg = "Put a description.";
        } else if (empty($_POST['url_image'])) {
          $errorMsg = "Put a url image.";
        }
        if ($errorMsg) {
          include "../templates/new.php";
        } else {
          $newPost = new Post();
          $newPost->category = $_POST['category'];
          $newPost->description = $_POST['description'];
          $newPost->url_img = $_POST['url_image'];

          $newPost->user = $_SESSION['user'];
          $manager->persist($newPost);
          $manager->flush();
          header('Location:/?action=display');
        }
      } else {
        include "../templates/new.php";
      }
    }
    break;

  case 'display':
  default:
    $controller = new HomeController();
    $controller->display();
    break;
}
