<?php

namespace Api\Core;

class Alert
{
    public static function span()
    {
        if (!empty($_SESSION['alertType']) and !empty($_SESSION['alertMessage'])) {
            Alert::alert($_SESSION['alertMessage'], $_SESSION['alertType']);
            unset($_SESSION['alertMessage']);
            unset($_SESSION['alertType']);
        }
    }
    public static function error($message)
    {
        echo "<div class='alert alert-danger text-center mx-auto'>";
        echo $message;
        echo "</div>";
    }

    public static function alert($message, $type)
    {
        echo "<div class='alert alert-{$type} text-center mx-auto container'>";
        echo $message;
        echo "</div>";
    }
}
