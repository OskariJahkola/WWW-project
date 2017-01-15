<?php

$db = new PDO('mysql:host=localhost;dbname=www;charset=utf8', 'jahkola', '');

// get the best 10 scores in from highest to lowest
$stmt = $db->prepare("SELECT username, score FROM penguin_jump ORDER BY score DESC");
$stmt->execute();

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

print(json_encode($rows));

?>