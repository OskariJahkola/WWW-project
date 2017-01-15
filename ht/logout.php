<?php

    session_start();
    if (session_destroy()){
        require("weather.php");
    }

