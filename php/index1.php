<?php
require_once 'header.php';
$result=queryMysql("SELECT * FROM friends WHERE idUser='$user_id'");
if(!$result)die("my error");
$num=$result->num_rows;
for($j=0;$j<$num;$j++){
$result->data_seek($j);
$row=$result->fetch_array(MYSQLI_NUM);
$friend_id[]=$row[1];
}
$result=queryMysql("SELECT * FROM publications");
$num=$result->num_rows;
for($j=0;$j<$num;$j++){
$result->data_seek($j);
$row=$result->fetch_array(MYSQLI_NUM);
if(array_search($row[1],$friend_id)){
    $r=$row[1];
    $pubtext=$row[2];
    $pubimage1=$row[3];
    $pubimage2=$row[4];
    $pubimage3=$row[5];
    $authorname=queryMysql("SELECT name FROM profiles WHERE id='$r'");
    echo<<<_HTML_
    <span class="publication">
                <span class="authorname">$authorname</span>
                <span class="pubtext">$pubtext</span>
                <img class="pubimage" src="../image/$pubimage1" alt="">
                <img class="pubimage" src="../image/$pubimage2" alt="">
                <img class="pubimage" src="../image/$pubimage3" alt="">
            </span>
    _HTML_;
}
}
echo<<<_END
/div>
   
    <footer>&copy;All grants are protected</footer>
</body>
</html>
_END;

?>