<?php 

namespace Api\Controllers;

class PageController{
    public function home(){
        include dirname(__DIR__) . '/views/login.php';
    }

}