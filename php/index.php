<?php
require_once 'header.php';
$result=queryMysql("SELECT * FROM friends WHERE idUser='$user_id'");
$num=$result->num_rows;
for($j=0;$j<$num;$j++){
$result->data_seek($j);
$row=$result->fetch_array(MYSQLI_NUM); 
$friends[]=$row[1];
}

$result=queryMysql("SELECT * FROM publications");
$num=$result->num_rows;
for($j=0;$j<$num;$j++){
$result->data_seek($j);
$row=$result->fetch_array(MYSQLI_NUM);
if(my_array_searcher($row[1],$friends)){
    $r=$row[1];
    $pubtext=$row[2];
    $pubimage1=$row[3];
    $pubimage2=$row[4];
    $pubimage3=$row[5];
    $author=queryMysql("SELECT name FROM profiles WHERE id='$r'");
    $row2=$author->fetch_array(MYSQLI_NUM);
    $authorname=$row2[0];

    echo<<<_HTML_
    <span class="publication">
                <a href="" class="authorpubl"><img class="avatar" src="../image/crown.jpg"><span class="authname">$authorname Dima</span></a>
                <span class="pubtext">$pubtext  Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati vitae a necessitatibus, ut ducimus officiis quibusdam alias autem hic temporibus, quae totam. Aperiam ea maiores id adipisci provident. Delectus ipsum commodi soluta rerum adipisci officiis expedita iusto in sed facilis? Laboriosam sit nulla magni, temporibus id nemo dolor, mollitia nobis, labore ipsam voluptatem maiores! Ab magnam ducimus minima adipisci laudantium. Fugit aut ducimus, atque, quia dolor nisi obcaecati ex amet dignissimos rerum rem asperiores laboriosam cumque fugiat sed voluptates tenetur odit autem ea. Aliquid optio excepturi unde porro aut, ut assumenda animi accusantium similique et distinctio velit nihil cupiditate sit.</span>
                <img class="pubimage" src="../image/$pubimage1" alt="">
                <img class="pubimage" src="../image/$pubimage2" alt="">
                <img class="pubimage" src="../image/$pubimage3" alt="">
            </span>
    _HTML_;
}
}
echo<<<_END
</div>
   
    <footer>&copy;All grants are protected</footer>
</body>
</html>
_END;

?>
