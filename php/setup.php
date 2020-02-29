<?php
require_once 'functions.php';
createTable('members','
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
login VARCHAR(16),
password VARCHAR(16),
INDEX(login(16)),
INDEX(password(16))
');
createTable('friends','
idUser INT UNSIGNED,
idFriend  INT UNSIGNED,
INDEX(idUser),
INDEX(idFriend)
');
createTable('profiles','
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(16),
text VARCHAR(4096),
country VARCHAR(128),
city VARCHAR(16),
image VARCHAR(16),
INDEX(name(6)),
INDEX(id),
INDEX(city(6)),
INDEX(image(16)),
INDEX(country(6))
');
createTable('groupNames','
id VARCHAR(128),
name VARCHAR(16),
INDEX(name(6)),
FULLTEXT(id)
');
createTable('groups','
id VARCHAR(200),
message VARCHAR(4096),
auth INT UNSIGNED,
recip INT UNSIGNED,
time VARCHAR(32),
INDEX(auth),
INDEX(recip),
FULLTEXT(id)
');
createTable('publications','
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 profiD VARCHAR(16),
 text VARCHAR(2048),
 image1 VARCHAR(128),
 image2 VARCHAR(128),
 image3 VARCHAR(128),
 INDEX(profiD(16))
 ');


?>