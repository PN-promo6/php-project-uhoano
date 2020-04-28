<?php

namespace Entity;

use Entity\User;

class Post
{
    public $id;
    public $nickname;
    public $category;
    public $description;
    public $url_img;
    public $date;
    public User $user;

    // public function __construct($id, $nickname, $category, $description, $url_img, $date)
    // {
    //     $this->id = $id;
    //     $this->nickname = $nickname;
    //     $this->description = $description;
    //     $this->url_img = $url_img;
    //     $this->date = $date;
    // }
}
