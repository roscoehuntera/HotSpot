<?php

session_start();
if (isset($_SESSION["id"])) {
    $logged = true;
} else {
    $logged = false;
}

// Connect to the database
require_once("../server/database.php");

if (isset($_GET["query"])) {
    $query = " WHERE name LIKE '%".$_GET["query"]."%'";
} else {
    $query = "";
}

// Select all destinations in the database
$sql = "SELECT * FROM destinations$query";
$result = mysqli_query($conn, $sql);

// Initialize array to store each destination in a proper format
$destinations = array();

// For each row (for each single destination)
while ($row = mysqli_fetch_assoc($result)) {
    // Add the destination to the array $destinations
    array_push($destinations, $row);
}

mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HotSpot | Destinations</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="./css/allfonts.css">
    <link rel="stylesheet" href="style.css?dummy=sdd5" />

    <!-- Custom Style  
    <link rel="stylesheet" href="./css/home.css">
    -->

</head>

<!------------------CSS CODE ------------------------->
<style type= "text/css">

@import url('../css/fontFam.css');


html, body{
    margin: 0%;
    box-sizing: border-box;
    overflow-x: hidden;
}

:root{

    /*      Theme colors        */
    --text-gray: #000000;
    --text-light : #000000da;
    --bg-color: #0f0f0f;
    --white: #ffffff;
    --midnight: #1ec5af;

    /* gradient color   */
    --gradient: linear-gradient(120deg, #84fab0 0%, #8fd3f4 100%);
    --gradient1: linear-gradient(120deg, #5efc98 0%, #8fd3f4 100%);

    /*      theme font-family   */
    --Cormorant: 'Cormorant', cursive;
    --Stint : 'Stint', cursive;
    --Mate: 'Mate', cursive;
    --MateSC: 'MateSC', cursive;
}


/* ---------------- Global Classes ---------------*/

a{
    text-decoration: none;
    color: var(--text-gray);
}

.flex-row{
    display: flex;
    flex-direction: row;    
    flex-wrap: wrap;
}

ul{
    list-style-type: none;
}

h1{
    font-family: var(--Mate);
    font-size: 2.5rem;
}

h2{
    font-family: var(--Mate);
}

h3{
    font-family: var(--Cormorant);
    font-size: 1.3rem;
}

.btn{
    display: inline-block;
    border: none;
    border-radius: 2rem;
    padding: 1rem 3rem;
    font-size: 1rem;
    font-family: var(--Mate);
    cursor: pointer;
}

span{
    font-family: var(--Cormorant);
}

.container{
    margin: 0 5vw;
}

.text-gray{
    color: var(--text-gray);
}

p{
    font-family: var(--Mate);
    color: var(--text-light);
}

/* ------x------- Global Classes -------x-------*/

/* --------------- navbar ----------------- */

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
    color: black;
}

.collapse{
    height: 30rem;
}

.nav .nav-items{
    display: flex;
    margin: 0;
}



.nav .nav-items .nav-link{
    padding: 1.6rem 1rem;
    font-size: .9rem;
    position: relative;
    font-family: var(--Mate);
    font-size: .9rem;
    text-align:center;
    
}

.nav .nav-items .nav-link:hover{
    background-color: #84fab0;
}

.nav .nav-items .nav-link:hover a{
    color: var(--white);
}

.nav .nav-items .navlink-right{
    padding: 1.6rem 1rem;
    font-size: .9rem;
    /*position: relative;*/
    font-family: var(--Mate);
    font-size: .9rem;
    text-align: right;
    margin-left: auto;
    
}

.nav .nav-items .navlink-right:hover{
    background-color: #84fab0;
}

.nav .nav-items .navlink-right:hover a{
    color: var(--white);
}

.nav .nav-brand a{
    font-size: 2.0rem;
    padding: 1rem 0;
    display: block;
    font-family: var(--Cormorant);
    font-size: 1.8rem;
}

.nav .social{
    padding: 1.4rem 0
}

.nav .social i{
    padding: 0 .2rem;
}

.nav .social i:hover{
    color: #84fab0;
}

/* -------x------- navbar ---------x------- */


/* ----------------- Main Content----------- */

/* --------------- Site title ---------------- */
main .site-title{
    background: url('../assets/beach5.jpg');
    background-size: cover;
    height: 120vh;
    display: flex;
    justify-content: center;
}

main .site-title .site-background{
    padding-top: 10rem;
    text-align: center;
    color: var(--white);
}

main .site-title h1, h3{
    margin: .3rem;
}

main .site-title .btn{
    margin: 1.8rem;
    background: var(--gradient);
}

main .site-title .btn:hover{
    background: transparent;
    border: 1px solid var(--white);
    color: var(--white);
}

/* --------x------ Site title --------x------- */







/* ---------x------- Main Content -----x----- */


/* ----------------- Footer --------------------- */

footer.footer{
    height: 100%;
    background: #84fab0;
    position: relative;
}

footer.footer .container{
    display: grid;
    grid-template-columns: repeat(4, 1fr);
}

footer.footer .about-us{
    color: white;
}

footer.footer .container > div{
    flex-grow: 1;
    flex-basis: 0;
    padding: 3rem .9rem;
}

footer.footer .container h2{
    color: var(--white);
}


footer.footer .follow div i{
    color: var(--white);
    padding: 0 .4rem;
}

footer.footer .rights{
    justify-content: center;
    font-family: var(--Stint);
}

footer.footer .rights h4 a{
    color: var(--white);
}

footer.footer .move-up{
    position: absolute;
    right: 6%;
    top: 50%;
}

footer.footer .move-up span{
    color: var(--midnight);
}

footer.footer .move-up span:hover{
    color: var(--white);
    cursor: pointer;
}

footer.footer button.contactbtn{
    border: none;
    border-radius: 2rem;
    padding: 2rem 3rem;
    font-size: 2rem;
    font-family: var(--Mate);
    cursor: pointer;
}

footer.footer .contactbtn{
    margin: 1.8rem;
    background: var(--gradient1);
}

footer.footer .contactbtn:hover{
    background: transparent;
    border: 1px solid var(--white);
    color: var(--white);
}

/* ---------x------- Footer ----------x---------- */

/*              Viewport less then or equal to 1130px            */

@media only screen and (max-width: 1130px){
    .site-content .post-content > .post-image .post-info{
        left: 2rem !important;
        bottom: 1.2rem !important;
        border-radius: 0% !important;
    }

    .site-content .sidebar .popular-post .post-info{
        display: none !important;
    }

    footer.footer .container{
        grid-template-columns: repeat(2, 1fr);
    }

}

/*      x       Viewport less then or equal to 1130px    x     */


/*              Viewport less then or equal to 750px for the media equity            */

@media only screen and (max-width: 750px){
    .nav .nav-menu, .nav .nav-items{
        flex-direction: column;
    }

    .nav .toggle-collapse{
        display: initial;
    }

    main .site-content{
        grid-template-columns: 100%;
    }

    footer.footer .container{
        grid-template-columns: repeat(1, 1fr);
    }

}


/*        x      Viewport less then or equal to 750px       x     */


/*              Viewport less then or equal to 520px            */

@media only screen and (max-width: 520px){
    main .blog{
        height: 125vh;
    }

    .site-content .post-content > .post-image .post-info{
        display: none;
    }

    footer.footer .container > div{
        padding:  1rem .9rem !important;
    }

    footer .rights{
        padding: 0 1.4rem;
        text-align: center;
    }

    nav .toggle-collapse{
        width: 80% !important;
    }

}


</style>



<!------------------CSS CODE ------------------------->


<body>

    <!-- ----------------------------  Navigation ---------------------------------------------- -->

    <nav class="nav">
        <div class="nav-menu flex-row">
            <div class="nav-brand">
                <a href="./home.php" class="text-gray">HotSpot</a>
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
                            echo '<li class="navlink-right">
                                <a href="./signout.php">SIGN OUT</a>
                            </li>';
                        } else {
                            echo '<li class="navlink-right">
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

    <!-- ------------x---------------  Navigation --------------------------x------------------- -->

    <!----------------------------- Main Site Section ------------------------------>

    <main class="container-custom">
        <?php
            if ($query !== "") {
                echo '<h1 class="text-center">Destinations that match: '.$_GET["query"].'</h1>';
            } else {
                echo '<h1 class="text-center">All Destinations</h1>';
            }
        ?>
        <div class="all-destinations-container">
            <?php
                foreach ($destinations as $destination) {
                    echo '
                    <a href="./single-destination.php?id='.$destination["id"].'" class="single-destination-card">
                        <img src="'.$destination["img_url"].'" />
                        <p>'.$destination["name"].'</p>
                    </a>
                    ';
                }
            ?>
        </div>

        <?php
            if ($logged) {
                echo '<div class="text-center" style="margin-bottom: 2rem;"><a href="./add-destination.php"><button class="btn">Add A Destination</button></a></div>';
            }
        ?>
    </main>
    

    <!---------------x------------- Destinations You Should See Section ---------------x-------------->


    <!-- --------------------------- Footer ---------------------------------------- -->

    <footer class="footer">
        <div class="container">
            <div class="about-us" data-aos="fade-right" data-aos-delay="200">
                <h2>About us</h2>
                <p>Creators are Akeylah Roscoe Hunter, Sophia McGlew, and Daniel Johnston. This websiter was created for our senior project 
                    for 2021. This website was created to allow users to share their travel experiences and to inspire other users who are planning their own vacations.
                </p>
            </div>
            
            <a href="contactus.php">
            <button class="contactbtn">Contact Us
            </button>
            </a>
        </div>

        <div class="move-up">
            <span><i class="fas fa-arrow-circle-up fa-2x"></i></span>
        </div>
    </footer>

    <!-- -------------x------------- Footer --------------------x------------------- -->

    <!-- Jquery Library file -->
    <script src="./js/jquery.min.js"></script>

    <!-- --------- Owl-Carousel js ------------------->
    <script src="./js/owl.carousel.min.js"></script>

    <!-- ------------ AOS js Library  ------------------------- -->
    <script src="./js/aos.js"></script>

    <!-- Main Java file -->
    <script src="./js/main.js"></script>
</body>

</html>