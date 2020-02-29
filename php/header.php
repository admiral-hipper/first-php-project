<?php
require_once 'functions.php';
session_start();
if(isset($_SESSION['uname'])&&isset($_SESSION['id'])){
    $user_name=$_SESSION['uname'];
    $user_id=$_SESSION['id'];
    $loginend=TRUE;
}
else{
$loginend=FALSE;
}
if(!$loginend){
 echo<<<_END
 <!DOCTYPE html>
 <html>
 <head>
     <meta charset="UTF-8">
     <title>Document</title>
 </head>
 <body>
     <script>
     document.location.href="login.php"
     </script>
 </body>
 </html>
 _END;  
}else
echo_header();

?>
