<?php
require_once __DIR__.'/../dbConfig.php';
require_once __DIR__.'/postClass.php';
$conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);

//TESTY dla loadPostById

//$testPost = post::loadPostById($conn, 1);
//var_dump($testPost);

//TESTY dla loadAllPostsByUserId

//$allTestPostsForUserId1 = post::loadAllPostsByUserId($conn, 1);
//var_dump($allTestPostsForUserId1);