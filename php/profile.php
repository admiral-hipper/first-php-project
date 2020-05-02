<?php
require_once 'header.php';      
$solution="";
if(!(isset($_GET['d'])||isset($_POST['d']))){
    echo<<<_script
    <script>
     document.location.href="index.php"
     </script>
    _script;
}
    else {
    if(isset($_GET['d'])){$login_profile=sanitizeString($_GET['d']);
$result=queryMysql("SELECT * FROM members WHERE login='$login_profile'");} 
if(isset($_POST['d'])){  $login_profile=sanitizeString($_POST['d']);
    $result=queryMysql("SELECT * FROM members WHERE login='$login_profile'");}
if(!$result){
    echo <<<_END
    <span class="no-publication">THIS PROFILE DOESN'T EXIST</span>
    _END;
} 
else{
    if(isset($_POST['username'])){
        $post_username=sanitizeString($_POST['username']);
        $post_gender=sanitizeString($_POST['gender']);
        $post_country=sanitizeString($_POST['country']);
        $post_city=sanitizeString($_POST['city']);
        $post_text=sanitizeString($_POST['my_text']);
         $putting=queryMysql("UPDATE profiles SET name='$post_username',text='$post_text',country='$post_country',city='$post_city',gender='$post_gender' WHERE id='$user_id'");
         if($_FILES['avatar']['name']){
            $saveto = "../image/$login_profile.jpg";
            if(file_exists($saveto))unlink("$saveto");
            move_uploaded_file($_FILES['avatar']['tmp_name'], $saveto);
            $typeok = TRUE;
            switch($_FILES['avatar']['type'])
            {
            case "image/gif": $src = imagecreatefromgif($saveto); break;
            case "image/jpeg":
            //Как обычный, так и прогрессивный JPEG-формат
            case "image/pjpeg": $src = imagecreatefromjpeg($saveto); break;
            case "image/png": $src = imagecreatefrompng($saveto); break;
            default: $typeok = FALSE; break;
            }
            if ($typeok)
            {
            list($w, $h) = getimagesize($saveto);
            $max = 150;
            $tw = $w;
            $th = $h;
            if (($w > $h)&&($max < $w || $max>$w))
            {
            $th = $max / $w * $h;
            $tw = $max;
            }
            elseif (($h > $w) && ($max < $h || $max<$h))
            {
            $tw = $max / $h * $w;
            $th = $max;
            }
            elseif ($max < $w&&$w==$h)
            {
            $tw = $th = $max;
            }

            $tmp = imagecreatetruecolor($tw, $th);
            imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
            imageconvolution($tmp, array(array(-1, -1, -1),
            array(-1, 16, -1), array(-1, -1, -1)), 8, 0);
            imagejpeg($tmp, $saveto);
            imagedestroy($tmp);
            imagedestroy($src);
            $putting=queryMysql("UPDATE profiles SET image='$saveto' WHERE id='$user_id'");
            }
        }
    }
    $id_profile=$result->fetch_assoc()['id'];
    $result=queryMysql("SELECT * FROM profiles WHERE id='$id_profile'");
    if(isset($_POST['friend'])){
        $rrr=$_POST['friend'];
        if(queryMysql("SELECT * FROM friends WHERE idUser='$user_id' AND idFriend='$id_profile'"))
        $friend=queryMysql("INSERT INTO friends VALUES('$user_id','$rrr')");
    }
    if(isset($_POST['delete-pub'])){
        $id_delete=sanitizeString($_POST['delete-pub']);
        $image_delete=queryMysql("SELECT * FROM publications WHERE id='$id_delete'")->fetch_array(MYSQLI_ASSOC);
        for($i=1;$i<4;$i++){
           if(file_exists($image_delete["image$i"]))unlink($image_delete["image$i"]);
        }
        $delete=queryMysql("DELETE FROM publications WHERE id='$id_delete'");
    }
    if(isset($_POST['pub-text'])){
        $s1=$s2=$s3="";
        $text_pub=sanitizeString($_POST['pub-text']);
        $imgPublication=queryMysql("INSERT INTO publications VALUES(NULL,'$id_profile','$text_pub','','','')");
        $imgPublication=queryMysql("SELECT * from publications WHERE profid='$id_profile' ORDER BY id DESC");
        $img_id=$imgPublication->fetch_assoc()['id'];
        if($_FILES['image1']['name']){
            $saveto1 = "../image/$img_id".$login_profile."1.jpg";
            move_uploaded_file($_FILES['image1']['tmp_name'], $saveto1); 
            $typeok1 = TRUE;
            switch($_FILES['image1']['type'])
            {
            case "image/gif": $src = imagecreatefromgif($saveto1); break;
            case "image/jpeg":
            //Как обычный, так и прогрессивный JPEG-формат
            case "image/pjpeg": $src = imagecreatefromjpeg($saveto1); break;
            case "image/png": $src = imagecreatefrompng($saveto1); break;
            default: $typeok1 = FALSE; break;
            }
            if ($typeok1)
            { 
                $s1=$saveto1; 
            }
        }
        if($_FILES['image2']['name']){
            $saveto2 = "../image/$img_id".$login_profile."2.jpg";
            move_uploaded_file($_FILES['image2']['tmp_name'], $saveto2); 
            $typeok2 = TRUE;
            switch($_FILES['image2']['type'])
            {
            case "image/gif": $src = imagecreatefromgif($saveto2); break;
            case "image/jpeg":
            //Как обычный, так и прогрессивный JPEG-формат
            case "image/pjpeg": $src = imagecreatefromjpeg($saveto2); break;
            case "image/png": $src = imagecreatefrompng($saveto2); break;
            default: $typeok2 = FALSE; break;
            }
            if ($typeok2)
            { 
                $s2=$saveto2; 
            }
        }
        if($_FILES['image3']['name']){
            $saveto3 = "../image/$img_id".$login_profile."3.jpg";
            move_uploaded_file($_FILES['image3']['tmp_name'], $saveto3);
            $typeok3 = TRUE;
            switch($_FILES['image3']['type'])
            {
            case "image/gif": $src = imagecreatefromgif($saveto3); break;
            case "image/jpeg":
            //Как обычный, так и прогрессивный JPEG-формат
            case "image/pjpeg": $src = imagecreatefromjpeg($saveto3); break;
            case "image/png": $src = imagecreatefrompng($saveto3); break;
            default: $typeok3= FALSE; break;
            }
            if ($typeok3)
            {   
                $s3=$saveto3;
            }
        }
        $add_pub=queryMysql("UPDATE publications SET image1='$s1',image2='$s2',image3='$s3' WHERE id='$img_id'");
    }
   ////////////////////////////////////////////////
    $profile_info=$result->fetch_array(MYSQLI_BOTH);
    $profile_name=$profile_info[1];
    $profile_text=$profile_info[2];
    $profile_country=$profile_info[3];
    $profile_city=$profile_info[4];
    $profile_image=$profile_info[5];
    $profile_gender=$profile_info[6];
    if($profile_gender==1){$gender="Man";
    $solution="<script>$('#man').attr({checked:\"checked\"})</script>";
    }
    else if($profile_gender==2){$gender="Woman";
        $solution="<script>$('#woman').attr({checked:\"checked\"})</script>";}
    else $gender="Didn't say";
    if($id_profile==$user_id){
        
        echo<<<_USER
            <form method='post' action='profile.php' enctype='multipart/form-data'class="info-user">
            <span id="img">
            <div>
            <span class="profile-avatar"><img src="$profile_image" alt="Your avatar"></span>
            </div>
            <input name="avatar" id="file3" type="file">
            <label for="file3" class="filelabel"><i class="fa fa-upload" aria-hidden="true"></i>  Choose a photo</label>
            </span>
            <span class="profile-info">
             <span class="type-info">Username:</span><input value="$profile_name" class="information" type="text" name="username">
             <span class="type-info">Gender:</span><span class="information"><input type="radio" value="1" id="man" class="gender" name="gender">Man <input name="gender" type="radio" id="woman" value="2">Woman</span>$solution
             <span class="type-info">Country:</span><input class="information" value="$profile_country" type="text" name="country">
             <span class="type-info">City:</span><input class="information" value="$profile_city" type="text" name="city">
                </span>
                <span class="send-form">
            <input type="submit" class="send-to-profile" value="Save changes">
            <input type="hidden" name="d" value="$login_profile">
            </span>
            <span class="about-me"><h2>ABOUT ME</h2><textarea maxlength="800" name="my_text" id="about">$profile_text</textarea></span>
            <span class="filelabel" id="add-publ">Add new publication</span>
            </form>
            <form action="" method="POST"id="new-pub" class="publication" enctype='multipart/form-data'>
                <a href="" class="authorpubl"><img class="avatar" src="$profile_image"><span class="authname">Dima</span></a>
                <textarea name="pub-text" id="text-pub" placeholder="Type here" maxlength="400"></textarea>
                <span id="img">
                    <div>
                    <img src="___profile_image" class="profile-img" alt="Your image">
                    </div>
                    <input name="image1" id="file" type="file">
                    <label for="file" class="filelabel"><i class="fa fa-upload" aria-hidden="true"></i>  Choose a photo</label>
                    </span>
                    <span id="img">
                        <div>
                        <img src="___profile_image" class="profile-img" alt="Your image">
                        </div>
                        <input name="image2" id="files" type="file" >
                        <label for="files" class="filelabel"><i class="fa fa-upload" aria-hidden="true"></i>  Choose a photo</label>
                        </span>
                        <span id="img">
                            <div>
                            <img src="___profile_image" class="profile-img" alt="Your image">
                            </div>
                            <input name="image3" id="file1" type="file" >
                            <label for="file1" class="filelabel"><i class="fa fa-upload" aria-hidden="true"></i>  Choose a photo</label>
                            </span>
                            <span id="img">
                            <div>
                            <img src="" class="profile-img" alt="" id="cleaner-add">
                            </div>
                                <input type="submit" class=""id="add-public" value="">    
                                <input type="hidden" name="d" value="$login_profile">
                                 <label id="submit-pub" class="filelabel" for="add-public">ADD ALL</label>
                                </span>
                                        </form>
                                       
        _USER;
    }
    
    else{
        $checkfriend="";
        $check=queryMysql("SELECT * FROM friends WHERE idUser='$user_id' AND idFriend='$id_profile'")->num_rows;
        if($check)
        $checkfriend="<script>$('#addtofr').css('display','none')</script>"; 
      echo<<<_PROFILE
      <span class="info-user">
       <span class="profile-avatar"><img src="$profile_image" alt=""></span>
       <span class="profile-info">
        <span class="type-info">Username:</span><span class="information">$profile_name</span>
        <span class="type-info">Gender:</span><span class="information">$gender</span>
        <span class="type-info">Country:</span><span class="information">$profile_country</span>
        <span class="type-info">City:</span><span class="information">$profile_city</span>
        </span>
        <form action="" class="send-form" method="POST">
        <a href="messages.php?message="$login_profile" class="send-to-profile">Send message</a>
        <input id="addtofr" type="submit" class="send-to-profile" value="Add to friends">$checkfriend
        <input type="hidden" value="$login_profile" name="d">
        <input type="hidden" value="$id_profile" name="friend">
        </form>
        <span class="about-me"><h2>ABOUT ME</h2><span>$profile_text</span></span>
        </span>
      _PROFILE;  
    }
    $result=queryMysql("SELECT * FROM publications WHERE profid='$id_profile' ORDER BY id DESC");
    $num_row=$result->num_rows;
    for($j=0;$j<$num_row;$j++){
    $result->data_seek($j);
    $publication=$result->fetch_array(MYSQLI_BOTH);
    $publtext=$publication['text'];
    $id_pub=$publication[0];
    $pubimage1=$publication[3];
    $pubimage2=$publication[4];
    $pubimage3=$publication[5];
    if($id_profile!=$user_id){
    echo<<<_publ
    <span class="publication">
        <a href="profile.php?d=$login_profile" class="authorpubl"><img class="avatar" src="../image/$profile_image"><span class="authname">$profile_name</span></a>
        <span class="pubtext">$publtext</span>
        <img class="pubimage" src="$pubimage1" alt="">
        <img class="pubimage" src="$pubimage2" alt="">
        <img class="pubimage" src="$pubimage3" alt="">
    </span>
    _publ;
    }
    else{
        echo<<<_publ
        <span class="publication">
        <a href="profile.php?d=$login_profile" class="authorpubl"><img class="avatar" src="$profile_image"><span class="authname">Dima</span></a>
        <form class="form-delete" action="" method="post">
            <input type="hidden" name="delete-pub" value="$id_pub">
            <input type="hidden" name="d" value="$login_profile">
            <input type="submit"id="delete">
            <label for="delete" class="delete-button"><i class="fa fa-trash-o" aria-hidden="true"></i></label>
        </form>
        <span class="pubtext">$publtext</span>
        <img class="pubimage" src="$pubimage1" alt="">
        <img class="pubimage" src="$pubimage2" alt="">
        <img class="pubimage" src="$pubimage3" alt="">
        </span>
        _publ;
    }
    }
        echo<<<_footer
        </div>
        <script src="../javascript.js"></script>
        <footer>&copy;All grants are protected</footer>
        </body>
        </html>
        _footer;
 }
}
?>
