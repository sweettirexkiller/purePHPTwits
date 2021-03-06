<?php
    session_start();
    require_once __DIR__.'/../../php/classes/postClass.php';
    require_once __DIR__.'/../renderFunction.php';
    require_once __DIR__.'/../../php/dbConfig.php';
    $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>MyOwnSmallTweeter</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <ul class="nav nav-tabs">
                <li class="active"><a href="http://localhost/myOwnSmallTwitter/html/main%20/main.php">Home</a></li>
                <li><a href="http://localhost/myOwnSmallTwitter/html/user_site/userSiteMaker.php">Profile</a></li>
            </ul>
            <div class="well">
                <form action="" method="post">
                    <legend>Create a post</legend>
                    <div class="form-group">
                        <label for='content'>Content:</label>
                        <textarea class="form-control" name='content' id='content' rows="4" placeholder="Type your post..."></textarea>
                        <button type="submit" class="btn btn-success form-control">Add</button>
                    </div>
                </form>
            </div>
            <?php 
                //handleing the post form
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    if(isset($_POST['content']) && count($_POST['content']) > 0 && isset($_SESSION['logged_user_id'])){
                        
                        $loadPost = new post();
                        $loadPost->setContent($_POST['content']);
                        $loadPost->setDateOfCreation(date('Y-m-d G:y:s',time()));
                        $loadPost->setUser_id($_SESSION['logged_user_id']);
                       
                        try{
                          $loadPost->saveToDB($conn);
                        } catch (Exception $ex) {
                            $data = ['info'=>'There was a problem in posting. We are sorry.'];
                            echo render('wrongFormTemplate.html', $data);
                        }
                    }else{
                        $data = ['info'=>'You must be logged in to make a post.'];
                        echo render('wrongFormTemplate.html', $data);
                    }
                }
            ?>
            <div class="well">
                <div class="row">
                    <h4>POSTS:</h4>
                </div>
            </div>
            <?php 
                $allPosts = postWithEmail::loadAllPostsWithUserEmailOrderedByTime($conn);
                foreach($allPosts as $postWithEmailObject){
                    $data = [
                        'email' => $postWithEmailObject->getEmail(),
                        'content' => $postWithEmailObject->getContent(),
                        'date'    => $postWithEmailObject->getDateOfCreation(),
                        'post_id' => $postWithEmailObject->getId()
                    ];
                 echo render('postTemplate.html', $data);
                }
            ?> 
     
        </div>
    </body>
</html>



