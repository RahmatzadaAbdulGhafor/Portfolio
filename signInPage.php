<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" type="text/css" href="reset.css">
    <link rel="stylesheet"  href="reset.css">
    <link rel="stylesheet" href="styles.css" media="only screen and (min-width: 769px)">
    <link rel="stylesheet" href="mobile.css" media="only screen and (max-width: 769px)">
</head>
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
                <li class="headinglink"><a href="viewBlog.php">VIEW BLOG</a></li>
        </ul>
        </nav>
    </header>


         

    <div class="forms">
        <section class="loginPart">
            <br><br><br><br>
        
            <div class="blog">
                <form class="loginForm" method="post" action="login.php">
                    <h1 class="subtitle">Log-in</h1>
                    <?php

                    if(isset($_GET['error_msg']))
                    {
                    $error = $_GET['error_msg'];
                    echo '<h1 class="invalidDetails">'.$error.'</h1>';
                    }
                    ?>

                    <input class="formfielda" placeholder="Email" type="email" name="email" required>
                    <input type="password" class="formfielda" placeholder="Password"  name="password" required><br>
                    <button type="submit" class="postButton buttons"> Login </button>
                    <button type="reset" class="clearButton buttons"> Clear </button>
                </form>
            </div>
        </section>
    </div>
</body>
</html>