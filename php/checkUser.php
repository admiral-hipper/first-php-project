<?php
require_once 'functions.php';
if(isset($_POST['login'])){
$mydata=sanitizeString($_POST['login']);
if(strlen($mydata)<6)echo"&#10008;";
else{
$login=hash('ripemd128',"$hash1$mydata$hash2");
$result=queryMysql("SELECT * FROM members WHERE login='$login'");
if(!$result){echo"&#10008;";}
else echo"&#10004;";
}
}
?>