<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>view Blog</title>
    <link rel="stylesheet" type="text/css" href="reset.css">
    <link rel="stylesheet"  href="reset.css">
    <link rel="stylesheet" href="styles.css" media="only screen and (min-width: 769px)">
    <link rel="stylesheet" href="mobile.css" media="only screen and (max-width: 769px)">
</head>
<body class="blogHTML">
    <header id="home">
        <nav>
            <img src="images/QM.jpg" class="logo" >
            <ul class="topLinks">
                    <li><a href="index.html#home">HOME</a></li>
                    <li><a href="index.html#profile">ABOUT</a></li>
                    <li><a href="education.html">EDUCATION</a></li>
                    <li><a href="portfolio.html">PORTFOLIO</a></li>
                    <li><a href="skills.html">SKILLS</a></li>
                    <li><a href="contact.html">CONTACT</a></li>
                    <?php
                    session_start();
                    if (isset($_SESSION["loggedIn"])){
                        if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"]) {
                            echo "<li class=topLinks>" . "<a href=addPost.html>" . "NEW BLOG    " . "</a>" . "</li>";
                        }
                        echo "<li class=topLinks>" . "<a href=logOut.php>" . "LOG OUT" . "</a>" . "</li>";
                    }
                    else{
                        echo "<li class=topLinks>" . "<a href=signInPage.php>" . "LOG IN" . "</a>" . "</li>";
                    }
                ?>    
            </ul>
        </nav>
    </header>


    <div class="blogPost">
        
        <h1>Blog <span>Post</span> </h1>
        <form class="Months" method="post">
            <?php
                //session_start();
                if (isset($_SESSION["loggedIn"])){
                    if (isset($_SESSION["username"])){
                        //retrieve only the beginning of the email
                        $user = explode("@", $_SESSION["username"])[0];
                        echo "<label for=months> ".  " Welcome $user " . "</label><br>";
                    }
                    else{
                        echo "<label for='months'>" . "" . "</label><br>";
                        
                    }
                }
            ?>    
            
            <select class="selectMonths" name="months" id="months">
                <option value="0">Choose a month</option>
                <option value="01">Jan</option>
                <option value="02">Feb</option>
                <option value="03">Mar</option>
                <option value="04">Apr</option>
                <option value="05">May</option>
                <option value="06">Jun</option>
                <option value="07">Jul</option>
                <option value="08">Aug</option>
                <option value="09">Sep</option>
                <option value="10">Oct</option>
                <option value="11">Nov</option>
                <option value="12">Dec</option>
            </select>
            <input class="selectMonths" type ="submit" name="Submit" value="Submit">
        </form>

        
        <table class="viewBlogTable">
            <thead>
                <tr>
                    <th class="styleBlogDate">Date Posted</th>
                    <th class="styleBlogText">Blog</th>

                    <?php
                    if (isset($_SESSION["loggedIn"])){
                        if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"]) {
                            echo "<th class=extraFeature>" . "" . "</th>";
                            echo "<th class=extraFeature>" . "</th>";
                        }
                    }
                    ?>    
                    
                </tr>
            </thead>
    
            <?php
                $servername = "127.0.0.1";
                $username = "admin";
                $password = "password";
                $dbname = "ecs417";
                $conn = new mysqli($servername, $username, $password, $dbname);
    
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                //sql query
                $sql = "SELECT blogId, title, text, time, date, comments from blogs";
                $sql2 = "SELECT * from comments";

                $result = $conn->query($sql);
                $results2 = $conn->query($sql2);


                //arrays which will be used to sort
                $date_array = array();
                $time_array = array();
                $combined_DT = array();
                //to print the comments
                $comments_array = array();
       
            
                //filling the arrays
                if ($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        array_push($date_array, $row["date"]);
                        array_push($time_array, $row["time"]);
                    }
                    while ($row = $results2->fetch_assoc()) {
                        $comment = array(
                            "id" => $row["id"],
                            "comment" => $row["comment"],
                            "comment_id"=> $row["comment_id"]
                        );
                        array_push($comments_array, $comment);
                    }
                }
    
                //combine the date & time
                for($q=0; $q<count($time_array); $q++){
                    array_push($combined_DT, date('Y-m-d H:i:s', strtotime("$date_array[$q] $time_array[$q]")));
                }
                
                function bubbleSort($arr){
                    $n = count($arr);
                    //loop each element
                    for($i = 0; $i < $n; $i++){
                        //for each element compare it with every other element
                        for($j = 0; $j < $n-$i-1; $j++){
                            if(strtotime($arr[$j]) < strtotime($arr[$j+1])){
                                $temp = $arr[$j];
                                $arr[$j] = $arr[$j+1];
                                $arr[$j+1] = $temp;
                            }
                        }
                    }
                    return $arr;
                }

                //sort the array
                $combined_DT = bubbleSort($combined_DT);

                
                for($w=0; $w<count($combined_DT); $w++){
                    $date_array[$w] = date('Y-m-d',strtotime($combined_DT[$w]));
                    $time_array[$w] = date('H:i:s',strtotime($combined_DT[$w]));
                }
    
                if(isset($_POST['months'])) {
                    if ($result->num_rows > 0){
                        for($x=0; $x<count($date_array); $x++){
                            $y = true;
                            foreach($result as $row){
                                $blogId = $row["blogId"];
                                $date = strtotime($row["date"]);
                                if($row["date"]==$date_array[$x] && $row["time"]==$time_array[$x] && $y && $_POST['months']==0){
                                    echo "<tr><td class=viewBlogTd>". "<p class=blogDate>". $row["date"] . "</p>" ."<br>"."<p class=blogTime>". $row["time"]. "</p>". "</td><td class=viewBlogTd>". "<p class=blogTitle>". $row["title"]. "</p>". $row["text"] ."</td?</tr>";
                                                
                                    if ($results2->num_rows > 0) {
                                        echo "<table class='commentsTable'>";
                                        echo "<thead><tr> <th>Comments</th> <th></th>  </tr></thead>";
                                        echo "<tbody>";
                                        
                                        foreach ($comments_array as $comment) {
                                            if ($comment["id"] == $blogId) {
                                                if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"]) {
                                                    echo "<tr><td class='commentsTD'>" . $comment["comment"] . "<td> <form method='POST' action='deleteComment.php'> <input type='hidden' name='deleteCommentId' value='" . $comment["comment_id"] . "'>" . "<button name ='deleteBtn' type='submit' class='deleteBtn'>Delete</button></form></td>". "</td></tr>";                                                    
                                                }else{
                                                    echo "<tr><td class='commentsTD'>" . $comment["comment"]."</td></tr>";
                                                }
                                            }
                                        }

                                        //adding  comment area with its button if logged in
                                        if (isset($_SESSION["loggedIn"])){
                                            echo "<tr><td class='addComment'>";
                                            echo "<form method='POST' action='addComment.php'>";
                                            echo "<input type='hidden' name='blogId' value='". $blogId . "'>";
                                            echo "<textarea class='CommentArea' name='comment'></textarea>";
                                            echo "<br>";
                                            echo "<button type='submit' class='addBtn'>Post Comment</button>";
                                            echo "</form>";
                                            echo "</td></tr>";
                                        } else{
                                            echo "<tr><td class='noLogin'><a href='signInPage.php'>Login to add comments</a></td></tr>";
                                        }

                                        //close table
                                        echo "</tbody></table>";
                                        echo "</td>";
                                    } else {
                                        // Nested table for comments
                                        echo "<table class='commentsTable'>";
                                        echo "<thead><tr><th>Comments empty</th></tr></thead>";
                                        echo "<tbody>";
                                        echo "</tbody></table>";
                                        echo "</td>";
                                    }

                                    //show delete post shown only if admin
                                    if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"]) {
                                        echo "<td>";
                                        echo "<form method='POST' action='deleteBlog.php'>";
                                        echo "<input type='hidden' name='postID' value='" . $row["blogId"] . "'>";
                                        echo "<button type='submit' class='deleteBtn'>Delete Blog</button>";
                                        echo "</form>";
                                        echo "</td>";
                                    }
                                    $y = false;
                                }
                                else{
                                    if($row["date"]==$date_array[$x] && $row["time"]==$time_array[$x] && $y && date("m", $date)==$_POST['months']){
                                        echo "<tr><td class=viewBlogTd>". "<p class=blogDate>". $row["date"] . "</p>" ."<br>"."<p class=blogTime>". $row["time"]. "</p>". "</td><td class=viewBlogTd>". "<p class=blogTitle>". $row["title"]. "</p>". $row["text"] ."</td?</tr>";                                         
                                        if ($results2->num_rows > 0) {
                                            echo "<table class='commentsTable'>";
                                            echo "<thead><tr> <th>Comments</th> <th></th> </tr></thead>";
                                            
                                            echo "<tbody>";
                                            
                                            if (empty($comments_array)) {
                                                echo "<tr><td>No comments yet</td></tr>";
                                            } else {
                                                foreach ($comments_array as $comment) {
                                                    if ($comment["id"] == $blogId) {
                                                        if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"]) {
                                                            echo "<tr><td class='commentsTD'>" . $comment["comment"] . "<td> <form method='POST' action='deleteComment.php'> <input type='hidden' name='deleteCommentId' value='" . $comment["comment_id"] . "'>" . "<button name ='deleteBtn' type='submit' class='deleteBtn'>Delete</button></form></td>". "</td></tr>";                                                    
                                                        }
                                                        else{
                                                            echo "<tr><td class='commentsTD'>" . $comment["comment"]."</td></tr>";
                                                        }
                                                    }
                                                }
        
                                                //adding  comment area with its button
        
                                               //adding  comment area with its button
                                            if (isset($_SESSION["loggedIn"])){

                                                echo "<tr><td class='addComment'>";
                                                echo "<form method='POST' action='addComment.php'>";
                                                echo "<input type='hidden' name='blogId' value='". $blogId . "'>";
                                                echo "<textarea class='CommentArea' name='comment'></textarea>";
                                                echo "<br>";
                                                echo "<button type='submit' class='addBtn'>Post Comment</button>";
                                                echo "</form>";
                                                echo "</td></tr>";
                                            } else{
                                                echo "<tr><td class='noLogin'><a href='signInPage.php'>Login to add comments</a></td></tr>";
                                            }
        
        
                                                //close table
                                                echo "</tbody></table>";
                                                echo "</td>";
                                            }
                                        }
    
                                        if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"]) {
                                            echo "<td>";
                                            echo "<form method='POST' action='deletePost.php'>";
                                            echo "<input type='hidden' name='postID' value='" . $row["blogId"] . "'>";
                                            echo "<button type='submit' class='deleteBtn'>Delete</button>";
                                            echo "</form>";
                                            echo "</td>";
                                        }
                                        $y = false;
                                    }
                                }
                            }
                        }
                    }
                }
    
                $conn-> close();
            ?>
    
        </table>
        <br>
        <br><br><br><br><br>
    </div>
</body>
</html>
