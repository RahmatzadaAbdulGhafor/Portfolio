<?php
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "ecs417";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $killer = false;
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    $wrongUsername = false;
    $wrongPassword = false;

    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            if ($row["email"]==$_POST["email"] && $row["password"]==$_POST["password"]){
                $killer = true;
                if ($row["email"] == "admin@admin") {
                    $isAdmin = true;
                }
                $username = $row["email"];
            }

            if($row["email"]==$_POST["email"]){
                $wrongUsername = true;
            }
            if($row["password"]==$_POST["password"]){
                $wrongPassword = true;
            }

        }       
        if($killer==false){    
            if($wrongUsername == false &&  $wrongPassword == false){
                $error_msg = "INVALID USERNAME & PASSWORD";
            }
            elseif ($wrongUsername == false){
                $error_msg = "INVALID USERNAME";
            }
            elseif ($wrongPassword == false){
                $error_msg = "INVALID PASSWORD";
            }
            
            header("Location: signInPage.php?error_msg=".urlencode($error_msg));
        }
        else{
            session_start();
            $_SESSION["loggedIn"] = true;
            $_SESSION["isAdmin"] = $isAdmin;
            $_SESSION["username"] = $username;
            
            header('Location: viewBlog.php');
        }
    }
?>