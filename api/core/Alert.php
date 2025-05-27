<?php 

namespace Api\Core;

class Alert{
    public static function error($message){
        echo "<div class='alert alert-danger text-center mx-auto'>";
        echo $message;
        echo "</div>";
    }
}