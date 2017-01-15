<?php
session_start();
require_once("utils.php");

$pattern = "((?=.*[A-Z])(?=.*[a-z])(?=.*\d).{7,21})";

if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["check_pw"])) {
    if ($_POST["password"] === $_POST["check_pw"]){
        if (strlen($_POST["password"]) >= 8){
            if (preg_match($pattern, $_POST["password"])){
                    $db = new PDO('mysql:host=localhost;dbname=www;charset=utf8', 'jahkola', '');
                    $password = sha1($_POST["password"] . SALT);
                    $stmt = $db->prepare("INSERT INTO userdb(username, password) VALUES(:f1, :f2)");
                    $stmt->execute(array(":f1" => $_POST["username"], ":f2" => $password));
                    print "<p>Registration successful</p>";
                    require("game.html");
            }
            else{
                print "<p>Password must contain lower-case letters, at least 1 upper-case letter and number";
            }
        }
        else{
            print "<p>Password too short! (longer than 8 characters)</p>";
        }
        
    }
    else {
        print "<p>Passwords don't match!</p>";
    }
}
else {
print <<<REGISTERFORM
<div class="container">
      <form class="form-signin" action="index.php?p=register" method="post">
        <h2 class="form-signin-heading">Please register</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input name= "username" type="text" class="form-control" placeholder="Username" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input name= "password" type="password"class="form-control" placeholder="Password" required>
        <label for="inputPassword" class="sr-only">Password</label>
        <input name= "check_pw" type="password"class="form-control" placeholder="Re-enter password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        </div>
      </form>
REGISTERFORM;
}