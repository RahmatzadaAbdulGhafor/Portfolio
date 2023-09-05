<?php
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "ecs417";
    date_default_timezone_set('Europe/London');

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $title = $_POST["Title"];
    // $text = $_POST["textArea"];
    // so user can enter special characters
    $text = mysqli_real_escape_string($conn, $_POST["textArea"]);
    $date = date('Y-m-d');
    $time = date("H:i:s");


    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $sql = "INSERT INTO blogs (date, time, title, text) VALUES ('$date', '$time', '$title', '$text')";
        
        if ($conn->query($sql) === TRUE) {
            header('Location: viewBlog.php');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }

?>