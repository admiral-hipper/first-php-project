<?php
require_once 'functions.php';
session_start();
$error="";
$remove="";
if(isset($_GET['destroy_s']))
destroy_session();
if(isset($_POST['username'])&&isset($_POST['password'])){
    $username=sanitizeString($_POST['username']);
    $userpass=sanitizeString($_POST['password']);
    $username=hash('ripemd128',"$hash1$username$hash2");
    $userpass=hash('ripemd128',"$hash1$userpass$hash2");
    $result=queryMysql("SELECT * FROM members WHERE login='$username' AND password='$userpass'");
    $r=$result->num_rows;
    if(!$r){
        $error="Password or login isn't truth";
    }
    else{
    $_SESSION['uname']=$username;
    $result=queryMysql("SELECT id FROM members WHERE login='$username'");
    $rows=$result->fetch_array(MYSQLI_NUM);
    $_SESSION['id']=$rows[0];
    $remove=<<<_E
    <script>document.location.href="index.php"</script>
    _E;
}
}
echo<<<_END
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>
<body>
    <header>
        <span class="headert"><a href="" id="logo">Kingdom Login</a></span>
    </header>
    <span id="clear1"></span>
    <span id="clear2"></span>
    <article class="login">
        <form class="login-form" action="login.php" method="POST">
        <span>Login</span><span><input name="username" class="login-input" type="text"></span>
        <span>Password</span> <span><input name="password" class="login-input" type="password"></span>
        <span class="login-enter"><input  type="submit" value="Enter"></span><a href="signup.php" class="registration">Registration</a>
        </form>
        <div id="info">$error</div>
    </article>
    $remove
</body>
</html>
_END;
?>