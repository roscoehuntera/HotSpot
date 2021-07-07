<?php

session_start();
if (!isset($_SESSION["id"])) {
    header('Location: signin.php');
    exit();
}

$user_id = $_SESSION["id"];

if (isset($_GET["id"]) && $_GET["id"] != $user_id) {
    $requested_id = $_GET["id"];
} else {
    header('Location: myProfile.php');
    exit();
}

require_once("../server/database.php");

/*
    FOLLOW/UNFOLLOW
*/
if (isset($_POST["following"])) {
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
    NEW COMMENT
*/
if (isset($_POST["submitComment"])) {
    $post_id = $_POST["postId"];
    $comment = htmlspecialchars(trim($_POST["comment"]), ENT_QUOTES);

    $sql = "INSERT INTO comments (comment,id_post,id_user) VALUES ('$comment','$post_id','$user_id')";

    if (mysqli_query($conn, $sql)) {
        $error["class"] = "alert-success";
        $error["message"] = "Submission succeeded: Your comment has been posted.";
    } else {
        $error["class"] = "alert-error";
        $error["message"] = "Submission failed: Internal Server Error.";
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

/*
    GET REQUESTED USER
*/
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


/*
    GET REQUESTED USER POSTS
*/
$posts = array();

$sql = "SELECT * FROM destinations,posts WHERE posts.id_user=$requested_id AND destinations.id=posts.id_destination ORDER BY created_at DESC LIMIT 5";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    array_push($posts, $row);
}

/*
    CHECK IF FOLLOWING CURRENT USER
*/
$sql = "SELECT * FROM follows WHERE id_user_follows=$user_id AND id_user_followed=$requested_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    $following = false;
} else {
    $following = true;
}

/*
    GET POSTS USER LIKES
*/
$likes = array();

$sql = "SELECT * FROM likes WHERE id_user=$user_id";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    array_push($likes, $row);
}

/*
    GET POSTS USER HAS ARCHIVED
*/
$archives = array();

$sql = "SELECT * FROM archives WHERE id_user=$user_id";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    array_push($archives, $row);
}

/*
    GET ALL PHOTOS
*/

$photos = array();

$sql = "SELECT * FROM photos";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    array_push($photos, $row);
}

/*
    GET DREAM HAVENS DESTINATIONS
*/
// Initialize array to store the recommended destinations
$destinations = array();

// Get the first recommended destination
$sql = "SELECT * FROM users, destinations  WHERE users.id=$requested_id AND destinations.id=users.id_destination_1";
$result = mysqli_query($conn, $sql);

// Add the destination to the array $destinations
$row = mysqli_fetch_assoc($result);
if ($row !== null) {
    array_push($destinations, $row);
}

// Get the second recommended destination
$sql = "SELECT * FROM users, destinations  WHERE users.id=$requested_id AND destinations.id=users.id_destination_2";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);
if ($row !== null) {
    array_push($destinations, $row);
}

// Get the third recommended destination
$sql = "SELECT * FROM users, destinations  WHERE users.id=$requested_id AND destinations.id=users.id_destination_3";
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
    <title>HotSpot | My Page</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="./css/allfonts.css">
    <link rel="stylesheet" href="style.css?dummy=ssssss" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- JQuery for http requests -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


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
        margin-top: 20px;
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
            
            <img src="<?php echo $requested_user["cover_img_path"] ?>" style="width: 100%; height: 300px;object-fit:cover;">
            <img id = "profilePic" src="<?php echo $requested_user["img_path"] ?>">
            <br>
            <div style="position:relative;font-size: 20px;">
                <?php echo $requested_user["name"] ?>
                <form action="" method="POST" class="follow-form">
                    <input type="hidden" name="following" id="following" value="<?php echo $following ? "true" : "false"; ?>" />
                    <input type="hidden" name="id" id="id" value="<?php echo $requested_id ?>" />
                    <button class="follow-btn">
                        <?php
                        if ($following) {
                            echo 'Unfollow';
                        } else {
                            echo 'Follow';
                        }
                        ?>
                    </button>
                </form>
            </div>
            <br>
            <div class="about-me">
                <label for="about">
                    About Me:
                    <textarea name="about" id="about" rows="10" placeholder="This user's About Me section is empty." maxlength="400" required readonly><?php echo $requested_user["about"] ?></textarea>
                </label>
            </div>
            <br>
            <ul class="user-nav">
                <li class="nav-link">
                    <a href="./myProfile.php">My Profile</a>
                </li>
                <li class="nav-link">
                    <a href="./user.php?id=<?php echo $requested_id ?>">Posts</a>
                </li>
                <li class="nav-link">
                    <a href="./photos.php?id=<?php echo $requested_id ?>">Photos</a>
                </li>
            </ul>
            
        </div>

        <!--Below cover area-->
        <div style="display: flex;">
            <br>

            <!--Posts-->
            <br>
            <div style="min-width: 400px; flex: 8 ;padding: 20px; padding-left: 0px;">
                <!--Posts-->
                <div id="postBar" style="margin-top:0;">
                    <h2 class="text-center"><?php echo $requested_user["username"] ?>'s Posts</h2>
                    <?php
                        foreach ($posts as $post) {
                            $likeString = "Like";
                            foreach ($likes as $like) {
                                if ($like["id_post"] == $post["id"]) {
                                    $likeString = "Unlike";
                                }
                            }

                            $archiveString = "Archive";
                            foreach ($archives as $archive) {
                                if ($archive["id_post"] == $post["id"]) {
                                    $archiveString = "Unarchive";
                                }
                            }

                            $photosString = '<div class="post-photos-container">';
                            foreach ($photos as $photo) {
                                if ($photo["id_post"] == $post["id"]) {
                                    $photosString .= '<img src="'.$photo["photo_path"].'" onclick="previewPhoto(this)" />';
                                }
                            }
                            $photosString .= '</div>';
                            
                            echo '
                            <div id= "post">
                                <div>
                                    <img src="'.$requested_user["img_path"].'" style ="width: 75px;height:75px;object-fit:cover; margin-right: 4px;">
                                </div>
                                <div>
                                    <a href="./user.php?id='.$post["id_user"].'" style="font-weight: bold; text-decoration:none; color: #84fab0;">'.$requested_user["username"].'</a>
                                        <p style="margin:0;">'.$post["post"].'</p>
                                    '.$photosString.'
                                    <p style="margin:0;margin-bottom:6px;"><b>Location: '.$post["name"].'</b></p>
                                    <a href="javascript:void(0);" onclick="likePost(this,'.$post["id"].')">'.$likeString.'</a> . <a href="javascript:void(0)" onclick="commentPost('.$post["id"].')">Comment</a> . <a href="javascript:void(0)" onclick="archivePost(this,'.$post["id"].')">'.$archiveString.'</a> . <span style="color: #999;">'.date_format(date_create($post["created_at"]),"F d, Y").'</span>
                                </div>
                            </div>
                            ';
                        }

                        if (count($posts) == 0) {
                            echo "<p class='text-center'>This user has no posts.</p>";
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
                    foreach ($destinations as $destination) {
                        echo '<a href="./single-destination.php?id='.$destination["id"].'" target="_blank" id="destinations" style="display:block">
                                <img id= "destinationsPost1" src="'.$destination['img_url'].'">
                                <br>
                                '.$destination['name'].'
                            </a>';
                    }

                    if (count($destinations) == 0) {
                        echo '<p class="text-center" style="margin-top:80px;">This user has not taken Dream Havens Quiz.</p>';
                    }
                    ?>
        
                </div>
                
            </div>
        </div>

    </div>

    <!------ Profile Content ------->

    <script src="../js/myPage.js"></script>
</body>
    