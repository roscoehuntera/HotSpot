<?php

session_start();
if (isset($_SESSION["id"])) {
    $logged = true;
    $user_id = $_SESSION["id"];

    require_once("../server/database.php");

    /*
        GET CURRENT USER
    */
    $sql = "SELECT * FROM users WHERE id=$user_id";
    $result = mysqli_query($conn, $sql);

    $current_user = mysqli_fetch_assoc($result);

    mysqli_close($conn);
} else {
    $logged = false;
}
if (isset($_POST["userId"])) {
    require("../server/database.php");

    $subject = htmlspecialchars(trim($_POST["subject"]), ENT_QUOTES);

    $sql = "INSERT INTO contact_us (subject,id_user) VALUES ('$subject','$user_id')";

    if (mysqli_query($conn, $sql)) {
        $error["class"] = "alert-success";
        $error["message"] = "Submission succeeded: Message sucessfully sent.";
    } else {
        $error["class"] = "alert-error";
        $error["message"] = "Submission failed: Internal Server Error.";
    }

    mysqli_close($conn);
} else if (isset($_POST["name"])) {
    require_once("../server/database.php");

    $name = htmlspecialchars(trim($_POST["name"]), ENT_QUOTES);
    $email = trim($_POST["email"]);
    $subject = htmlspecialchars(trim($_POST["subject"]), ENT_QUOTES);

    $sql = "INSERT INTO contact_us (subject,name,email) VALUES ('$subject','$name','$email')";

    if (mysqli_query($conn, $sql)) {
        $error["class"] = "alert-success";
        $error["message"] = "Submission succeeded: Message sucessfully sent.";
    } else {
        $error["class"] = "alert-error";
        $error["message"] = "Submission failed: Internal Server Error.";
    }

    mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>HotSpot | Contact Us</title>

        <!--Custom Style-->
        <link rel="stylesheet" href="contactus.css" />
        <link rel="stylesheet" href="style.css?dummy=299" />
    </head>

    <!------------------CSS CODE ------------------------->
    <style type="text/css">

        @import url('../css/fonts.css');

        html {
            margin: 0%;
            box-sizing: border-box;
            overflow-x: hidden;
            font-size:13.8px;
        }

        body{
            margin: 0%;
            box-sizing: border-box;
            overflow-x: hidden;
        }

        :root{
            /* Theme colors */
            --text-gray: #000000;
            --text-light : #000000da;
            --bg-color:#0f0f0f;
            --white:#ffffff;
            --midnight:#84fab0;

            /*gradient color*/
            --sky: linear-gradient(120deg, #8fd3f4 0%, #84fab0 100%);

            /* theme font-family */
            --Abel:'Abel',cursive;
            --Anton:'Anton',cursive;
            --Josefin:'Josefin',cursive;
            --Lexend:'Lexend',cursive;
            --Livvic:'Livvic',cursive;
        }

        /*-----------Global Classes------*/

        a{
            text-decoration: none;
            color: var(--text-gray);
        }

        .flex-row{
            display: flex;
            flew-direction: row;
            flew-wrap: wrap;
        }

        ul{
            list-style-type: none;
        }



        button.btn{
            border: none;
            border-radius: 2rem;
            padding: 1rem 3rem;
            font-size: 1rem;
            font-family: var(--Lexend);
            cursor: pointer;
        }

        /*------x----Global Classes---x---*/


        /*----------navbar---------*/

        .nav{
    background: white;
    padding: 0 2rem;
    transition: height 1s ease-in-out;
    text-align: center;
}

        .nav .nav-menu{
            justify-content: space-between;
        }

        .nav .toggle-collapse{
            position: absolute;
            top: 0%;
            width: 90%;
            cursor: pointer;
            display: none;
        }

        .nav .toggle-collapse .toggle-icons{
            display: flex;
            justify-content: flex-end;
            padding: 1.7rem 0;
        }

        .nav .toggle-collapse .toggle-icons i{
            font-size: 1.4rem;
            color: var(--text-gray);
        }

        .collapse{
            height: 20rem;
        }

        .nav .nav-items{
            display: flex;
            margin: 0;
        }

        .nav .nav-items .nav-link{
            padding: 1.6rem 1rem;
            font-size: 1.1rem;
            position: relative;
            font-family: var(--Lexend);
            font-size: 1.1rem;
        }

        .nav .nav-items .nav-link:hover{
            background-color: var(--midnight);
        }

        .nav .nav-items .nav-link:hover a{
            color:var(--white);
        }

        .nav .nav-brand a{
            font-szie: 1.6rem;
            padding: 1rem 0;
            display: block;
            font-family: var(--Lexend);
            font-size: 1.6rem;
        }


        /*---x------navbar-----x----*/

        /*-----------Main Content--------*/

        h2{
            text-align: center;
            font-family: var(--Lexend);
            font-weight: 10;
            font-size: 1.6rem;
            padding-bottom: 1rem;
        }

        /* Input Style */
        input[type=text],input[type=email], select, textarea {
            width: 100%;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-top: 6px;
            margin-bottom: 16px;
            resize: vertical;
            font-family: var(--Lexend);
        }

          /* Submit Button Style */
        input[type=submit] {
            background-color: #84fab0;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

          /* Button hover style */
        input[type=submit]:hover {
            background-color: #4ad3c7;
        }

          /* Background*/
        .container {
            border-radius: 5px;
            background-color: #8fd3f4;
            padding: 20px;
        }

        #searchBox {
            font-family: Arial;
            margin:0;
            height:32px;
            border:2px solid #000;
        }
    </style>
    <!------------------CSS CODE------------------------->

    <body>
        <?php
            if (isset($error)) {
                echo '<div id="alert" class="alert '.$error["class"].'">
                    <p>'.$error["message"].'</p>
                </div>';
            }
        ?>
        <!----------------------------------Navigation---------------------------------->
        <nav class="nav">
            <div class="nav-menu flex-row">
                <div class="nav-brand">
                    <a href="./home.php" class="text-gray" style="font-size:28.8px;">HotSpot</a>
                </div>
                <form class="search-form" action="./destinations.php" method="GET">
                <input type="text" id="searchBox" name="query" placeholder="Search Your Travel Dreams"/>
            </form>
                <div class="toggle-collapse">
                    <div class="toggle-icons">
                        <i class="fas fa-bars"></i>
                    </div>
                </div>
                <div>
                    <ul class="nav-items">
                        <li class="nav-link">
                            <a href="home.php">HOME</a>
                        </li>
                        <li class="nav-link">
                            <a href="./destinations.php">DESTINATIONS</a>
                        </li>
                        <?php
                            if ($logged) {
                                echo '<li class="nav-link">
                                    <a href="./myProfile.php">MY PROFILE</a>
                                </li>
                                <li class="nav-link">
                                    <a href="./archive.php">ARCHIVE</a>
                                </li>';
                            }
                        ?>
                        <li class="nav-link">
                            <a href="./contactus.php">CONTACT US</a>
                        </li>
                        <?php
                            if ($logged) {
                                echo '<li class="nav-link">
                                    <a href="./signout.php">SIGN OUT</a>
                                </li>';
                            } else {
                                echo '<li class="nav-link">
                                    <a href="./signin.php">SIGN IN/SIGN-UP</a>
                                </li>';
                            }
                        ?>
                        <!---<li class="navlink-right">
                        <a href="#">CREATE AN ACCOUNT</a>                
                        </li>--->
                    </ul>
                </div>
            </div>
        </nav>
        <!------------------x---------------Navigation------------------x--------------->

        <h2>CONTACT US</h2>

        <div class="container container-custom">
            <form action="" method="POST">
                <?php
                    if ($logged) {
                        echo '<label for="fname">Name</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            placeholder="Your name..."
                            maxlength="80"
                            value="'.$current_user["name"].'"
                            required
                            readonly
                        />
                        <label for="email">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Your email..."
                            maxlength="80"
                            value="'.$current_user["email"].'"
                            required
                            readonly
                        />
                        <input
                            type="hidden"
                            id="userId"
                            name="userId"
                            value="'.$user_id.'"
                            />';
                    } else {
                        echo '<label for="fname">Name</label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    placeholder="Your name..."
                                    maxlength="80"
                                    required
                                />
                                <label for="email">Email</label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    placeholder="Your email..."
                                    maxlength="80"
                                    required
                                />';
                    }
                ?>
                

                <label for="subject">Subject</label>
                <textarea
                    id="subject"
                    name="subject"
                    placeholder="Write something.."
                    style="height: 200px"
                    maxlength="800"
                    required
                ></textarea>

                <input type="submit" value="Submit" />
            </form>
        </div>
    </body>
</html>
