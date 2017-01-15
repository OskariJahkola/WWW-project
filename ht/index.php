<?php
    session_start();
    require_once("utils.php");
    
    
    if($_GET["p"] === "login") {
        require("login.php");
    }
    else if ($_GET["p"] === "register"){
        require("register.php");
    }
    else if ($_GET["p"] === "logout"){
        require("logout.php");
    }
    
    // weather.php set to default
    else
    {
        //require("weather.php");
    }

?>