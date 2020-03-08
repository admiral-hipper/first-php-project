<?php
require_once 'functions.php';
$error=$remove="";
session_start();
if(isset($_POST['login'])){
    $login=sanitizeString($_POST['login']);
    $login=hash('ripemd128',"$hash1$login$hash2");
    $password=sanitizeString($_POST['password']);
    $password=hash('ripemd128',"$hash1$password$hash2");
    $username=sanitizeString($_POST['username']);
    $gender=sanitizeString($_POST['gender']);
    $country=sanitizeString($_POST['country']);
    $city=sanitizeString($_POST['city']);
    $result=queryMysql("SELECT * FROM members WHERE login='$login'");
    if(!$result)
        $error="This name isn't avaible";
    elseif($login&&$password&&$username&&$gender&&$country&&$city){
        $error="one of these fields aren't filled ";
    }
    else{
        $members=queryMysql("INSERT INTO members VALUES (NULL,'$login','$password')");
        $profile=queryMysql("INSERT INTO profiles VALUES(NULL,'$username',NULL,'$country','$city',NULL,'$gender')");
        if(!$members||!$profile){die("ERROR");}
        else{
        $_SESSION['uname']=$login;
        $result=queryMysql("SELECT * FROM members WHERE login='$login'");
        if(!$result)die("ERROR");
        else{
            $row=$result->fetch_array(MYSQLI_NUM);
            $_SESSION['id']=$row[0];
            $remove=<<<_end
            <script>document.location.href="edit_profile.php"</script>
            _end;
        }
    
    }
}
}
echo<<<_END
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign up</title>
    <link rel="stylesheet" href="../css/registration.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

</head>
<body>
    <header>
        <span class="headert"><a href="" id="logo">Kingdom registration</a></span>
    </header>
    <span id="clear1"></span>
    <span id="clear2"></span>
    <div class="registration-article">
        <form action=""method="POST">
            <span class="registration-text">Login</span><input name="login" id="r-username" type="text" class="registr-input" required='required'><span id="login" class="check"></span>
            <span class="registration-text">Password</span><input name="password" id="r-password1" type="password" class="registr-input" required='required'><span id="pass1" class="check"></span>
            <span class="registration-text" id="r-text">Repeat password</span><input name="" id="r-password2" type="password" class="registr-input" required='required'><span id="pass2" class="check"></span>
            <span class="registration-text">Username</span><input name="username" id="r-username" type="text" class="registr-input"><span id="login" class="check" required='required'></span>
            <span class="registration-text" id="gender">Choose gender 
            <span class="registration-text" id="gender2">
                <span><span>Man</span><input type="radio" name="gender" value="0"></span>
                <span><span>Woman</span><input type="radio" name="gender" value="1"></span>
            </span>
        </span>
            <span class="registration-text">Country</span><input name="country" class="registr-input" type="text" required='required'><span></span>
            <span class="registration-text">City</span><input name="city" class="registr-input" type="text" required='required'><span></span>
            <span class="enter"><input  type="submit" value="Enter"></span>
            <span class="error">$error</span>
        </form>
    </div>
    $remove
    <script>
        $('#r-username').blur(function(){
            log=$('#r-username').val()
      $.post('../php/checkUser.php',{login:''+log+''},function(data){
          $('#login').html(data)
      })
        })
        $('#r-password1').blur(function(){
            value=$(this).val()
            if(value.length<8){
            $('#pass1').html("&#10008;")
            $('#pass2').html("&#10008;")
            }
            else if(/[^a-zA-Z0-9_]/.test(value)||!/[a-z]/.test(value)||!/[0-9]/.test(value))
            { $('#pass1').html("&#10008;")}
            else $('#pass1').html("&#10004;")
        })
              $('#r-password2').blur(function(){
                  if($('#r-password2').val()!=$('#r-password1').val())
                      $('#pass2').html("&#10008;")
                  else  $('#pass2').html("&#10004;")
              })
              $('r-username').blur(function(){
                if($(this).val().length>8||/[^a-zA-Z0-9_]/.test($(this).val()))
                $('#login').html("&#10008;")
                else  $('#login').html("&#10004;")
              })
    </script>
</body>
</html>
_END;
?>