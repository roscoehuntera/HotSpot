<?php

session_start();
if (isset($_SESSION["id"])) {
    header('Location: myProfile.php');
    exit();
}

if (isset($_POST["username"])) {
    require_once("../server/database.php");

    $username = $_POST["username"];
    $password = $_POST["password"];

    if (substr($username,0,1) != "@") {
        $error["class"] = "alert-error";
        $error["message"] = "Sign In failed: Username must start with @.";
    } else {
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);

            if (password_verify($password, $row["password"])) {
                session_start();
                $_SESSION["id"] = $row["id"];
    
                header('Location: myProfile.php');
            } else {
                $error["class"] = "alert-error";
                $error["message"] = "Sign In failed: Invalid Password.";
            }
        } else {
            $error["class"] = "alert-error";
            $error["message"] = "Sign In failed: User does not exist.";
        }
    }

    mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title> HotSpot | Login</title>
    <link rel="stylesheet" href="signin.css"></link>
    <link rel="stylesheet" href="style.css" />

</head>


<!------------------CSS CODE ------------------------->
<style type= "text/css">

@import url('../css/fontFam.css');
/* Start Global rules */
* {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}
/* End Global rules */

/* Start body rules */
body {
    background-image: linear-gradient(-225deg, #84fab0 0%, #8fd3f4 100%);
background-image: linear-gradient(to top, #84fab0 0%, #8fd3f4 100%);
background-attachment: fixed;
background-repeat: no-repeat;

    font-family: var(--MateSC);
/*   the main font */
    font-family: var(--Mate);
opacity: .95;
/* background-image: linear-gradient(to top, #d9afd9 0%, #97d9e1 100%); */
}

:root{
        /*      theme font-family   */
    --Cormorant: 'Cormorant', cursive;
    --Stint : 'Stint', cursive;
    --Mate: 'Mate', cursive;
    --MateSC: 'MateSC', cursive;
}

/* |||||||||||||||||||||||||||||||||||||||||||||*/
/* //////////////////////////////////////////// */




/* End body rules */

/* Start form  attributes */
form {
    width: 450px;
    min-height: 500px;
    height: auto;
    border-radius: 5px;
    margin: 2% auto;
    box-shadow: 0 9px 50px hsla(20, 67%, 75%, 0.31);
    padding: 2%;
    background-image: linear-gradient(-225deg, #84fab0 50%, #8fd3f4 50%);
}
/* form Container */
form .con {
    display: -webkit-flex;
    display: flex;

    -webkit-justify-content: space-around;
    justify-content: space-around;

    -webkit-flex-wrap: wrap;
    flex-wrap: wrap;

    margin: 0 auto;
}

/* the header form form */
header {
    margin: 2% auto 10% auto;
    text-align: center;
}
/* Login title form form */
header h2 {
    font-size: 2.3rem;
    font-family: var(--Mate);
    color: #3e403f;
}
/*  A welcome message or an explanation of the login form */
header p {letter-spacing: 0.05em;}



/* //////////////////////////////////////////// */
/* //////////////////////////////////////////// */


.input-item {
    background: #fff;
    color: #333;
    padding: 14.5px 0px 15px 9px;
    border-radius: 5px 0px 0px 5px;
}



/* Show/hide password Font Icon */
#eye {
    background: #fff;
    color: #333;

    margin: 5.9px 0 0 0;
    margin-left: -20px;
    padding: 50px 9px 19px 0px;
    border-radius: 0px 5px 5px 0px;

    float: right;
    position: relative;
    right: 1%;
    top: -.2%;
    z-index: 5;
    
    cursor: pointer;
}
/* inputs form  */
input[class="form-input"]{
    width: 270px;
    height: 50px;

    margin-top: 2%;
    padding: 15px;
    
    font-size: 1.0rem;
    font-family: var(--Cormorant);
    color: #5E6472;

    outline: none;
    border: none;

    border-radius: 25px;
    transition: 0.2s linear;
    
}
input[id="txt-input"] {width: 270px;}
/* focus  */
input:focus {
    transform: translateX(-2px);
    border-radius: 5px;
}

/* //////////////////////////////////////////// */
/* //////////////////////////////////////////// */

/* buttons  */
button, a.btn {
    display: inline-block;
    color: #252537;

    width: 120px;
    height: 50px;

    padding: 0 20px;
    background: #fff;
    border-radius: 5px;
    
    outline: none;
    border: none;

    cursor: pointer;
    text-align: center;
    transition: all 0.2s linear;
    
    margin: 7% auto;
    letter-spacing: 0.05em;
    
}

a.btn {
    display:flex;
    justify-content:center;
    align-items:center;
    text-decoration:none;
    font-family:Arial;
    font-size:13.333px;
}


/* Submits */
.submits {
    width: 48%;
    display: inline-block;
    float: left;
    margin-left: 2%;
}

/*       Forgot Password button FAF3DD  */
.frgt-pass {background: transparent;}

/*     Sign Up button  */
.sign-up {background: #84fab0 !important;}


/* buttons hover */
button:hover, a.btn:hover {
    transform: translatey(3px);
    box-shadow: none;
}

/* buttons hover Animation */
button:hover, a.btn:hover {
    animation: ani9 0.4s ease-in-out infinite alternate;
}
@keyframes ani9 {
    0% {
        transform: translateY(3px);
    }
    100% {
        transform: translateY(5px);
    }
}


</style>
<!------------------CSS CODE ------------------------->
<body>
    <?php
        if (isset($error)) {
            echo '<div id="alert" class="alert '.$error["class"].'">
                <p>'.$error["message"].'</p>
            </div>';
        }
    ?>
    <div class="overlay">
        <!-- LOGN IN FORM by Omar Dsoky -->
        <form action="" method="POST">
            <!--   con = Container  for items in the form-->
            <div class="con">

            <!--     Start  header Content  -->
            <header class="head-form">
                <h2>Log In</h2>

                <!--     A welcome message or an explanation of the login form -->
                <p>Login here using your username and password</p>
            </header>
            <!--     End  header Content  -->
            <br>
            <div class="field-set">
            
                <!--   user name 
                <span class="input-item">
                <i class="fa fa-user-circle"></i>
                </span>
                -->
                <!--   user name Input-->
                <input class="form-input" id="txt-input" name="username" type="text" maxlength="20" placeholder="@UserName" required>
            
            <br>
            
                <!--   Password
            
                <span class="input-item">
                <i class="fa fa-key"></i>
                </span>
                -->
                <!--   Password Input-->
                <input class="form-input" type="password" name="password" maxlength="30" placeholder="Password" id="pwd" required>
            
                <!--      Show/hide password  
                <span>
                <i class="fa fa-eye" aria-hidden="true" type="button" id="eye"  ></i>
                </span>
                -->
            
                <br>
                <!--        buttons -->
                <!--      button LogIn -->
                <button class="log-in" id="login"> Log In </button>
            </div>
        
            <!--   other buttons -->
            <div class="other">
                <!--      Forgot Password button-->
                <button type="button" class="btn submits frgt-pass">Forgot Password</button>
                <!--     Sign Up button -->
                <a href="./signup.php">
                    <button type="button" class="btn submits sign-up">Sign Up</button>
                </a>

            <!--      End Other the Division -->
            </div>
            
            <!--   End Conrainer  -->
            </div>
        
        <!-- End Form -->
        </form>
    </div>


</body>  
</html>


