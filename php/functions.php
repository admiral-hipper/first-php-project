<?php
$hash1="Kiev";
$hash2="rostovondon61";
$dbname="modgnik";
$dbuser="DimaPO";
$dbhost="localhost";
$dbpassword="qscvbn9";
$appname="modgnik";
$connection= new mysqli($dbhost,$dbuser,$dbpassword,$dbname);
if($connection->connect_error)die($connection->connect_error);
function createTable($name,$query){
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Таблица '$name' создана или уже существовала<br>";
}
function queryMysql($query){
global $connection;
$result=$connection->query($query);
if(!$result)die($connection->error);
return $result;
}
function destroy_session(){
$_SESSION=array();
if(session_id()!=""||isset($_COOKIE[session_name()]))
setcookie(session_name(),"",time()-2592000,"/");
session_destroy();
}
function sanitizeString($var){
global $connection;
$var=strip_tags($var);
$var=htmlentities($var);
$var=stripslashes($var);
return $connection->real_escape_string($var);
}
function showProfile($user){
if(file_exists("$user.jpg"))
echo "<img src='$user.jpg'/>";
$result=queryMysql("SELECT * FROM profiles WHERE user='$user'");
if($result->num_rows){
    $row=$result->fetch_array(MYSQLI_ASSOC);
    echo stripslashes($row['text'])."<br style='clear:left;'><br>";
}
}
 function echo_header($user_name){
     echo<<<_END
     <!DOCTYPE html>
     <html>
     <head>
         <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1">
         <title>Document</title>
         <link rel="stylesheet" href="../css/profile.css">
         <script src="https://kit.fontawasome.com/52b02e8afc.js"></script>
         <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
         <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic|Playfair+Display:400,700&subset=latin,cyrillic">
         <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.css">       
     </head>
     <body class="sait">
         <header><span class="btn-menu"><span id="butt-menu"></span></span>
          <span class="headert" ><a href=""id="logo">Kingdom</a></span>
             <section id="service">
                 <span ><a href="" class="serve" >About us</a></span>
                 <span ><a href="" class="serve">Sign up</a></span>
                 <span ><a href="login.php?destroy_s=kod" class="serve">Login/out</a></span>
                 </section>
         </header>
         <div class="menu-default">
            <div id="form1"> <form id="search" action="" method="post">
                 <input class="field1" type="search" placeholder="Поиск учасников">
                 <input class="search" id="butt-ser" type="submit" value="&#128269;">
             </form>
             </div>
             <span><a href="index.php" class="menu" id="menu0">My page <i class="fa fa-user" aria-hidden="true"></i></a></span>
             <span><a href="" class="menu" id="menu1">Friends <i class="fa fa-users" aria-hidden="true"></i></a></span>
             <span><a href="" class="menu" id="menu2">Messages <i class="fa fa-comments-o" aria-hidden="true"></i></a></span>
            <span><a href="profile.php?d=$user_name" class="menu" id="menu2">Edit Profile<i class="fa fa-pencil" aria-hidden="true"></i></a></span>
             <span><a href="" class="menu" id="menu5">Settings <i class="fa fa-cogs" aria-hidden="true"></i></a></span> 
         </div>
         <div class="article">
     _END;
 }
 function my_array_searcher($var,$array){
$num_rows=count($array);
for($i=0;$i<$num_rows;$i++){
if($var==$array[$i])
return true;
}
return false;
 }
?>