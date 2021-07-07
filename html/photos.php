<?php

session_start();
if (!isset($_SESSION["id"])) {
    header('Location: signin.php');
    exit();
}

$user_id = $_SESSION["id"];

if (isset($_GET["id"]) && $_GET["id"] != $user_id) {
    $requested_id = $_GET["id"];
}

require_once("../server/database.php");

/*
    ABOUT ME UPDATED
*/
if (isset($_POST["about"]) && !isset($requested_id)) {
    $about = trim($_POST["about"]);

    $sql = "UPDATE users SET about='$about' WHERE id='$user_id'";

    if (mysqli_query($conn, $sql)) {
        $error["class"] = "alert-success";
        $error["message"] = "Submission succeeded: About was successfully updated.";
    } else {
        $error["class"] = "alert-error";
        $error["message"] = "Submission failed: Internal Server Error.";
    }
}


/*
    PHOTO UPLOADED
*/
if (isset($_FILES["photo"]) && !isset($requested_id)) {
    if ($_FILES["photo"]["tmp_name"] == "") {
        $error["class"] = "alert-error";
        $error["message"] = "Submission failed: Server does not allow the upload of such large files.";
    } else {
        $target_dir = '../server/uploads/'.$user_id.'/'.'photos/';
        $imageFileType = strtolower(pathinfo(basename($_FILES["photo"]["name"]),PATHINFO_EXTENSION));
        $target_file = $target_dir . round(microtime(true) * 1000) . "." . $imageFileType;
        $uploadOk = 1;

        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if($check == false) {
            $error["class"] = "alert-error";
            $error["message"] = "Submission failed: Photo must be an image.";
            $uploadOk = 0;
        }

        if ($_FILES["photo"]["size"] > 5000000) {
            $error["class"] = "alert-error";
            $error["message"] = "Submission failed: Image uploaded is too large.";
            $uploadOk = 0;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $error["class"] = "alert-error";
            $error["message"] = "Submission failed: Only JPG, JPEG or PNG files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk != 0) {
            move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);

            $sql = "INSERT INTO photos (photo_path,id_user) VALUES ('$target_file','$user_id')";

            if (mysqli_query($conn, $sql)) {
                $error["class"] = "alert-success";
                $error["message"] = "Submission succeeded: Photo successfully uploaded.";
            } else {
                $error["class"] = "alert-error";
                $error["message"] = "Sign Up failed: Internal Server Error.";
            }
        }
    }
}

/*
    FOLLOW/UNFOLLOW
*/
if (isset($_POST["following"]) && isset($requested_id)) {
    $following = $_POST["following"] === 'true' ? true : false;
    $id = trim($_POST["id"]);

    if ($following) {
        $sql = "DELETE FROM follows WHERE id_user_follows=$user_id AND id_user_followed=$requested_id";

        if (mysqli_query($conn, $sql)) {
            $error["class"] = "alert-success";
            $error["message"] = "Success: You are no longer following this user.";
        } else {
            $error["class"] = "alert-error";
            $error["message"] = "Failed: Internal Server Error.";
        }
    } else {
        $sql = "INSERT INTO follows (id_user_follows,id_user_followed) VALUES ('$user_id','$requested_id')";

        if (mysqli_query($conn, $sql)) {
            $error["class"] = "alert-success";
            $error["message"] = "Success: You are now following this user.";
        } else {
            $error["class"] = "alert-error";
            $error["message"] = "Failed: Internal Server Error.";
        }
    }
}

/*
    GET CURRENT USER
*/
$sql = "SELECT * FROM users WHERE id=$user_id";
$result = mysqli_query($conn, $sql);

$current_user = mysqli_fetch_assoc($result);

if ($current_user["img_path"] == null) {
    $current_user["img_path"] = "https://www.uic.mx/posgrados/files/2018/05/default-user.png";
}
if ($current_user["cover_img_path"] == null) {
    $current_user["cover_img_path"] = "../assets/beach3.jpg";
}

/*
    GET REQUESTED USER
*/
if (isset($requested_id)) {
    $sql = "SELECT * FROM users WHERE id=$requested_id";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 0) {
        header('Location: myProfile.php');
        exit();
    } else {
        $requested_user = mysqli_fetch_assoc($result);
    
        if ($requested_user["img_path"] == null) {
            $requested_user["img_path"] = "https://www.uic.mx/posgrados/files/2018/05/default-user.png";
        }
        if ($requested_user["cover_img_path"] == null) {
            $requested_user["cover_img_path"] = "../assets/beach3.jpg";
        }
    }
}

/*
    GET USER PHOTOS
*/
if (isset($requested_id)) {
    $sql = "SELECT * FROM posts,photos WHERE posts.id_user=$requested_id AND photos.id_post=posts.id ORDER BY created_at DESC";
} else {
    $sql = "SELECT * FROM posts,photos WHERE posts.id_user=$user_id AND photos.id_post=posts.id ORDER BY created_at DESC";
}
$result = mysqli_query($conn, $sql);

$photos = array();

while ($row = mysqli_fetch_assoc($result)) {
    array_push($photos, $row);
}

/*
    CHECK IF FOLLOWING CURRENT USER
*/
if (isset($requested_id)) {
    $sql = "SELECT * FROM follows WHERE id_user_follows=$user_id AND id_user_followed=$requested_id";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 0) {
        $following = false;
    } else {
        $following = true;
    }
}

/*
    GET DREAM HAVENS DESTINATIONS
*/
// Initialize array to store the recommended destinations
$destinations = array();

if (isset($requested_id)) {
    $id = $requested_id;
} else {
    $id = $user_id;
}

// Get the first recommended destination
$sql = "SELECT * FROM users, destinations  WHERE users.id=$id AND destinations.id=users.id_destination_1";
$result = mysqli_query($conn, $sql);

// Add the destination to the array $destinations
$row = mysqli_fetch_assoc($result);
if ($row !== null) {
    array_push($destinations, $row);
}

// Get the second recommended destination
$sql = "SELECT * FROM users, destinations  WHERE users.id=$id AND destinations.id=users.id_destination_2";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);
if ($row !== null) {
    array_push($destinations, $row);
}

// Get the third recommended destination
$sql = "SELECT * FROM users, destinations  WHERE users.id=$id AND destinations.id=users.id_destination_3";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);
if ($row !== null) {
    array_push($destinations, $row);
}

mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./css/myPage.css">
    <title>HotSpot | Photos</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="./css/allfonts.css">
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


</head>

<style type= "text/css">
@import url('../css/fontFam.css');

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

    #myPage_bar{
        height: 50px;
        background-color: #84fab0;
        color: #0f0f0f;

    }

    #searchBox{
        width: 400px;
        height: 20px;
        border-radius: 5px;
        padding: 4px;
        font-size: 14px;
        background-image: url('../assets/search.png');
        background-repeat: no-repeat;
        background-position: right;
        background-size: 25px;
    }

    #profilePic{
        width: 150px;
        height: 150px;
        object-fit:cover;
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
        height:100px;
        object-fit:cover;
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
        color:inherit;
        text-decoration:none;
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
        background-color: white;
        padding: 10px;
    }

    #postBar h2 {
        color: #84cef3;
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
    <?php
        if (isset($error)) {
            echo '<div id="alert" class="alert '.$error["class"].'">
                <p>'.$error["message"].'</p>
            </div>';
        }
    ?>

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
                    <li class="nav-link">
                        <a href="./archive.php">ARCHIVE</a>
                    </li>
                    <li class="nav-link">
                        <a href="./contactus.php">CONTACT US</a>
                    </li>
                    <li class="navlink-right">
                        <a href="./signout.php">SIGN OUT</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ------------x---------------  Navigation --------------------------x------------------- -->

    <br>
    <!------ Turquiose Bar------->
    <div id="myPage_bar">
    <div style="width: 800px; margin: auto; font-size: 30px;">

        <a class="my-page-logo" href="./home.php">HotSpot</a>
        <img src="<?php echo $current_user["img_path"] ?>" style="width: 50px; height: 50px;object-fit:cover;float: right;">
    </div>

    </div>
    <!------ Turquiose Bar------->

    <!------ Profile Content ------->
    <div style="width: 800px; margin:auto;min-height: 400px;">
        <div style="background-color: white; text-align: center; color: #84cef3;">
            
            <img src="<?php if (isset($requested_id)) {echo $requested_user["cover_img_path"];} else {echo $current_user["cover_img_path"];} ?>" style="width: 100%; height: 300px;object-fit:cover;">
            <img id = "profilePic" src="<?php if (isset($requested_id)) {echo $requested_user["img_path"];} else {echo $current_user["img_path"];} ?>">
            <br>
            <div style="position:relative;font-size: 20px;">
                <?php 
                if (isset($requested_id)) {
                    echo $requested_user["name"];
                    echo '<form action="" method="POST" class="follow-form">
                        <input type="hidden" name="following" id="following" value="';
                    if ($following) {
                        echo 'true';
                    } else {
                        echo 'false';
                    }
                    echo '" />
                        <input type="hidden" name="id" id="id" value="'.$requested_id.'" />
                        <button class="follow-btn">';
                    if ($following) {
                        echo 'Unfollow';
                    } else {
                        echo 'Follow';
                    }
                    echo '</button>
                    </form>';
                } else {
                    echo $current_user["name"];
                }
                ?>

            </div>
            <br>
            <form class="about-me" action="" method="POST">
                <label for="about">
                    About Me:
                    <textarea name="about" id="about" rows="10" placeholder="<?php if (isset($requested_id)) {echo "This user's About Me section is empty.";} else {echo "Tell us about you...";} ?>" maxlength="400" readonly><?php if (isset($requested_id)) {echo $requested_user["about"];} else {echo $current_user["about"];} ?></textarea>
                </label>
                <?php
                if (!isset($requested_id)) {
                    echo '<button type="button" onclick="editAbout(this)">Edit</button><button id="submitAbout" style="display:none;">Submit</button>';
                }
                ?>
            </form>
            <br>
            <ul class="user-nav">
                <?php
                    if (!isset($requested_id)) {
                        echo '<li class="nav-link">
                            <a href="./myProfile.php">My Profile</a>
                        </li>
                        <li class="nav-link">
                            <a href="./timeline.php">Timeline</a>
                        </li>
                        <li class="nav-link">
                            <a href="./photos.php">Photos</a>
                        </li>
                        <li class="nav-link">
                            <a href="./settings.php">Settings</a>
                        </li>';
                    } else {
                        echo '<li class="nav-link">
                            <a href="./myProfile.php">My Profile</a>
                        </li>
                        <li class="nav-link">
                            <a href="./user.php?id='.$requested_id.'">Posts</a>
                        </li>
                        <li class="nav-link">
                            <a href="./photos.php?id='.$requested_id.'">Photos</a>
                        </li>';
                    }
                ?>
            </ul>
            
        </div>

        <!--Below cover area-->
        <div style="display: flex;">
            <br>

            <!--Posts-->
            <br>
            <div style="min-width: 400px; flex: 8 ;padding: 20px; padding-left: 0px;">
                <!--Posts-->
                <div id="postBar">
                    <?php
                        if (!isset($requested_id)) {
                            echo '<h2 class="text-center">Your Photos</h2>';
                        } else {
                            echo '<h2 class="text-center">'.$requested_user["username"]."'s Photos</h2>";
                        }
                        echo '<div class="photo-wrapper">';
                        foreach ($photos as $photo) {
                            echo '<div class="photo-container"><img src="'.$photo["photo_path"].'" onclick="previewPhoto(this)" style="cursor:pointer;"/><span>'.date_format(date_create($photo["created_at"]),"F d, Y").'</span></div>';
                        }
                        echo '</div>';

                        if (count($photos) == 0) {
                            if (!isset($requested_id)) {
                                echo "<p class='text-center' style='width:100%;'>You haven't posted any photo. Post your first photo now!</p>";
                            } else {
                                echo "<p class='text-center'>This user has not posted any photo.</p>";
                            }
                        }
                    ?>
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
                        echo '<a href="./single-destination.php?id='.$destination["id"].'" target="_blank" id="destinations" style="display:block">
                                <img id= "destinationsPost1" src="'.$destination['img_url'].'">
                                <br>
                                '.$destination['name'].'
                            </a>';
                    }

                    if (isset($requested_id)) {
                        if (count($destinations) == 0) {
                            echo '<p class="text-center" style="margin-top:80px;">This user has not taken Dream Havens Quiz.</p>';
                        }
                    } else {
                        if (count($destinations) == 0) {
                            echo '<a class="retake-quiz-btn" href="./quiz.php">Take Quiz</a>';
                        } else {
                            echo '<a class="retake-quiz-btn" href="./quiz.php">Retake Quiz</a>';
                        }
                    }
                    
                    ?>
        
                </div>
                
            </div>
        </div>

    </div>

    <!------ Profile Content ------->

    <script>
        function editAbout(button) {
            button.style.display = "none";
            document.getElementById("submitAbout").style.display = "inline-block";
            document.getElementById("about").removeAttribute("readonly");
        }

        function previewPhoto(img) {
            window.open(img.src);
        }
    </script>
</body>
    