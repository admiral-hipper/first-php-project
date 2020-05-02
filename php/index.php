<?php
require_once 'header.php';
$result=queryMysql("SELECT * FROM friends WHERE idUser='$user_id'");
$num=$result->num_rows;
$friends=[];
for($j=0;$j<$num;$j++){
$result->data_seek($j);
$row=$result->fetch_array(MYSQLI_NUM); 
$friends[]=$row[1];
}
$count_for=0;
$result=queryMysql("SELECT * FROM publications ORDER BY id DESC");
$num=$result->num_rows;
for($j=0;$j<$num;$j++){
$result->data_seek($j);
$row=$result->fetch_array(MYSQLI_NUM);
if(my_array_searcher($row[1],$friends)){
    $count_for++;
    $r=$row[1];
    $pubtext=$row[2];
    $pubimage1=$row[3];
    $pubimage2=$row[4];
    $pubimage3=$row[5];
    $author=queryMysql("SELECT name FROM profiles WHERE id='$r'");
    $row2=$author->fetch_array(MYSQLI_NUM);
    $authorname=$row2[0];
    $avatar=$row[5];
    $login_profile=queryMysql("SELECT * FROM members WHERE id='$r'")->fetch_assoc()['login'];
    echo<<<_HTML_
    <span class="publication">
                <a href="profile.php?d=$login_profile" class="authorpubl"><img class="avatar" src="$avatar"><span class="authname">$authorname</span></a>
                <span class="pubtext">$pubtext</span>
                <img class="pubimage" src="../image/$pubimage1" alt="">
                <img class="pubimage" src="../image/$pubimage2" alt="">
                <img class="pubimage" src="../image/$pubimage3" alt="">
            </span>
    _HTML_;
}
}
if($count_for==0){
    echo<<<_end
    <span class="no-publication">$user_id YOUR FRIENDS DON'T HAVE ANY PUBLICATIONS</span>
    _end;
}
echo<<<_END
<script src="../javascript.js"></script>
</div>
    <footer>&copy;All grants are protected</footer>
</body>
</html>
_END;

?>
