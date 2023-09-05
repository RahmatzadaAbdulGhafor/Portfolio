<?php
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "ecs417";

    $conn = new mysqli($servername, $username, $password, $dbname);

   

    
    session_start();
    

    //get data from form
    $blogId = $_POST['blogId'];
    $comment = $_POST['comment'];

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //add username to the begging of the comment
    if (isset($_SESSION["username"])){
        //retrieve only the beginning of the email
        
        $user = explode("@", $_SESSION["username"])[0];
        $comment = $user . ": " . $comment;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $sql = "INSERT INTO comments (id, comment) VALUES ('$blogId', '$comment')";
        if ($conn->query($sql) === TRUE) {
            //redirect back to current page to display new comment
            header("Location: {$_SERVER['HTTP_REFERER']}");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }

?>