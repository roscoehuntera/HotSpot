<?php

/*
    Get the recommended destinations for the current user (right now it is set to get the recommended destinations for user with ID 1)
*/

require_once("../server/database.php");

// Initialize array to store the recommended destinations
$destinations = array();

// Get the first recommended destination
$sql = "SELECT * FROM users, destinations  WHERE users.id=1 AND destinations.id=users.id_destination_1";
$result = mysqli_query($conn, $sql);

// Add the destination to the array $destinations
while ($row = mysqli_fetch_assoc($result)) {
    array_push($destinations, $row);
}

// Get the second recommended destination
$sql = "SELECT * FROM users, destinations  WHERE users.id=1 AND destinations.id=users.id_destination_2";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    array_push($destinations, $row);
}

// Get the third recommended destination
$sql = "SELECT * FROM users, destinations  WHERE users.id=1 AND destinations.id=users.id_destination_3";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    array_push($destinations, $row);
}

mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./css/myPage.css">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="./css/allfonts.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


</head>

<style type= "text/css">
@import url('../css/fontFam.css');

    #myPage_bar{
        height: 50px;
        background-color: #84fab0;
        color: #0f0f0f;

    }

    #searchBox{
        width: 400px;
        height: 20px;
        border-radius: 5px;
        border: none;
        padding: 4px;
        font-size: 14px;
        background-image: url('../assets/search.png');
        background-repeat: no-repeat;
        background-position: right;
        background-size: 25px;
    }

    #profilePic{
        width: 150px;
        margin-top: -500px;
        border-radius: 50%;
        border: solid 2px white;
    }

    #menuButton{
        width: 100px;
        display: inline-block;
        margin: 2px;

    }

    #destinationsPost1{
        width: 150px;
        float: left;
        margin: 8px;
    }

    #desBar{
        background-color: white;
        min-height: 400px;
        color: #aaa;
        padding: 8 px;
        
        font-size: 20px;
        font-weight:  bold;
        font-family: var(--Cormorant);
    }

    #destinations{
        clear: both;
        font-size: 15px;
        font-family: var(--MateSC);
    }

    textarea{
        width: 100%;
        border: none;
        font-family: var(--Stint);
        font-size: 14px;
        height: 60px;
    }

    #postButton{
        float: right;
        background-color: #84fab0;
        border: none;
        color: white;
        padding: 4px;
        font-size: 14px;
        border-radius: 2px;
        width: 50px;
    }

    #postBar{
        margin-top: 20px;
        background-color: white;
        padding: 10px;
    }

    #post{
        padding: 4px;
        font-size: 13px;
        display: flex;
        margin: 20px;
    }

    .retake-quiz-btn {
        display: block;
        text-decoration: none;
        margin-top: 140px;
        text-align: center;
    }
</style>
<body style= "font-family: var(--Cormorant); background-color: #e6f2ea;">

    <br>
    <!------ Turquiose Bar------->
    <div id="myPage_bar">
        <div style="width: 800px; margin: auto; font-size: 30px;">

            HotSpot &nbsp &nbsp &nbsp <input type="text" id="searchBox" placeholder="Search Your Travel Dreams">
            <img src="../assets/testprofile.jpg" style="width: 50px; height: 50px;float: right;">
        </div>

    </div>
    <!------ Turquiose Bar------->

    <!------ Profile Content ------->
    <div style="width: 800px; margin:auto;min-height: 400px;">
        <div style="background-color: white; text-align: center; color: #84cef3;">
            
            <img src="../assets/beach3.jpg" style="width: 100%; height: 300px;">
            <img id = "profilePic" src="../assets/testprofile.jpg">
            <br>
            <div style="font-size: 20px;">Test Profile</div>
            <br>
            <div id = "menuButton">
                <li class="nav-link">
                    <a href="timeline.html">Timeline</a>
                </li>
            </div>
            <div id = "menuButton">About</div>
            <div id = "menuButton">Dream Havens</div>
            <div id = "menuButton">Photos</div>
            <div id = "menuButton">Settings</div>
            
        </div>

        <!--Below cover area-->
        <div style="display: flex;">
            <br>

            <!--Posts-->
            <br>
            <div style="min-width: 400px; flex: 8 ;padding: 20px; padding-left: 0px;">
                <div style= "border: solid thin #aaa; padding: 10px; background-color: white;">
                    <textarea placeholder="Your Vacation Awesomness"></textarea>
                    <input id="postButton" type="submit" value="POST">
                    <br>

                </div>
                <!--Posts-->
                <div id="postBar">
                    <!--Posts 1-->
                    <div id= "post">

                        
                        <div>
                            <img src="../assets/testuser1.jpg" style ="width: 75px; margin-right: 4px;">
                        </div>

                        <div>
                            <div style="font-weight: bold; color: #84fab0;">User 1</div>
                                We're glad you're our Customer and we want to make sure you have the most rewarding relationship possible with Discover® card. If there is anything else we can do to help, please let us know. Knowledgeable Account Managers are available to assist you, 24 hours a day, 7 days a week by calling 1-800-DISCOVER (1-800-347-2683), or you can always visit us 
                            <br/><br/>
                            
                            <a href="">Star</a> . <a href="">Comment</a> . <a href="">Archive</a> . <span style="color: #999;">June 11, 2021</span>
                        </div>

                    </div>

                    <!--Posts 2-->
                    <div id= "post">

                        
                        <div>
                            <img src="../assets/testuser1.jpg" style ="width: 75px; margin-right: 4px;">
                        </div>

                        <div>
                            <div style="font-weight: bold; color: #84fab0;">User 1</div>
                                We're glad you're our Customer and we want to make sure you have the most rewarding relationship possible with Discover® card. If there is anything else we can do to help, please let us know. Knowledgeable Account Managers are available to assist you, 24 hours a day, 7 days a week by calling 1-800-DISCOVER (1-800-347-2683), or you can always visit us 
                            <br/><br/>
                            <i class="fas fa-stars"></i>
                            <a href="">Star</a> . <a href="">Comment</a> . <a href="">Archive</a> . <span style="color: #999;">June 7, 2021</span>
                        </div>

                    </div>

                    <!--Posts 3-->
                    <div id= "post">

                        
                        <div>
                            <img src="../assets/testuser1.jpg" style ="width: 75px; margin-right: 4px;">
                        </div>

                        <div>
                            <div style="font-weight: bold; color: #84fab0;">User 1</div>
                                We're glad you're our Customer and we want to make sure you have the most rewarding relationship possible with Discover® card. If there is anything else we can do to help, please let us know. Knowledgeable Account Managers are available to assist you, 24 hours a day, 7 days a week by calling 1-800-DISCOVER (1-800-347-2683), or you can always visit us 
                            <br/><br/>
                            <i class="fas fa-stars"></i>
                            <a href="">Star</a> . <a href="">Comment</a> . <a href="">Archive</a> . <span style="color: #999;">June 1, 2021</span>
                        </div>

                    </div>

                </div>
                <!--Posts-->

            </div>

            <!--Dreams Haven-->
            <div style="min-height: 400px; flex: 4; padding: 20px; padding-right: 0px; padding-left: 0px;">
            
                <div id= "desBar">
                    Dream Havens<br>

                    <?php

                    // for each recommended destination, display an HTML element with the destination information
                    foreach ($destinations as $destination) {
                        echo '<div id="destinations">
                                <img id= "destinationsPost1" src="'.$destination['img_url'].'">
                                <br>
                                '.$destination['name'].'
                            </div>';
                    }
                    
                    ?>

                    <a class="retake-quiz-btn" href="./quiz.php">Retake Quiz</a>
        
                </div>
                
            </div>
        </div>

    </div>

    <!------ Profile Content ------->
</body>
    