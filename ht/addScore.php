<?php

    $db = new PDO('mysql:host=localhost;dbname=www;charset=utf8', 'jahkola', '');
    
    $stmt = $db->prepare("INSERT INTO penguin_jump(username,score) VALUES(:f1,:f2)");
	$stmt->execute(array(":f1" => $_POST["username"], ":f2" => $_POST["score"]));
    $stmt->debugDumpParams();
?>