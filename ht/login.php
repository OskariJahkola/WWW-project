<?php
session_start();
require_once("utils.php");

//if the user is already logged in don't allow them to login again
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    echo "You are already logged in " . $_SESSION['username'] . ", please logout to sign in with another account.";
    require("game.html");
    
}
else{
if(isset($_POST["username"]) && isset($_POST["password"]))
{
    $db = new PDO('mysql:host=localhost;dbname=www;charset=utf8', 'jahkola', '');
    
    $password = sha1($_POST["password"] . SALT);
    
    $stmt = $db->prepare("SELECT username FROM userdb WHERE username=:username AND password=:password");
    $stmt->execute(array(":username" => $_POST["username"], ":password" => $password));

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    //print(json_encode($rows));
    
    if(count($rows) === 1){
        $_SESSION['loggedin'] = true;
        $_SESSION["uid"] = $rows[0]["uid"];
        $_SESSION["username"] = $rows[0]["username"];
        //echo "Welcome=" . $_SESSION['username'];
        require_once("game.html");
    }
    else{
        print("Username or password incorrect");
    }
}
else {
print <<<LOGINFORM
<div class="container">
      <form class="form-signin" action="index.php?p=login" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input name= "username" type="text" class="form-control" placeholder="Username" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input name= "password" type="password"class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <div class="form-group">
          <div class="col-md-12 control">
            <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                Don't have an account? 
            <a href="index.php?p=register" onClick="$('#loginbox').hide(); $('#signupbox').show()">
                Sign Up Here
            </a>
            </div>
      </form>
LOGINFORM;
}
}
?>
