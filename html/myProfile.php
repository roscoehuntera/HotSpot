<?php

session_start();
if (!isset($_SESSION["id"])) {
    header('Location: signin.php');
    exit();
}

$user_id = $_SESSION["id"];

require_once("../server/database.php");

/*
    ABOUT ME UPDATED
*/
if (isset($_POST["about"])) {
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
    NEW POST
*/
if (isset($_POST["postInput"])) {
    $destination_id = $_POST["location"];
    $post = htmlspecialchars(trim($_POST["postInput"]), ENT_QUOTES);
    $uploadOk = 1;

    $movedPhotosPaths = array();

    if ($_FILES["photos"]["name"][0] != "") {
        $total_files = count($_FILES['photos']['name']);

        for( $i=0 ; $i < $total_files ; $i++ ) {
            if ($_FILES["photos"]["tmp_name"][$i] == "") {
                $error["class"] = "alert-error";
                $error["message"] = "Submission failed: There are one or more photos that exceed the limit of the server upload size.";
                $uploadOk = 0;
            } else {
                $imageFileType = strtolower(pathinfo(basename($_FILES["photos"]["name"][$i]),PATHINFO_EXTENSION));
    
                $check = getimagesize($_FILES["photos"]["tmp_name"][$i]);
                if($check == false) {
                    $error["class"] = "alert-error";
                    $error["message"] = "Submission failed: One or more photos are not valid images.";
                    $uploadOk = 0;
                }
    
                if ($_FILES["photos"]["size"][$i] > 5000000) {
                    $error["class"] = "alert-error";
                    $error["message"] = "Submission failed: One or more photos size is too large (over 5MB).";
                    $uploadOk = 0;
                }
    
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                    $error["class"] = "alert-error";
                    $error["message"] = "Submission failed: Only JPG, JPEG or PNG files are allowed.";
                    $uploadOk = 0;
                }
            }
        }

        if ($uploadOk != 0) {
            $target_dir = "../server/uploads/".$user_id."/photos"."/";
            for( $i=0 ; $i < $total_files ; $i++ ) {
                $imageFileType = strtolower(pathinfo(basename($_FILES["photos"]["name"][$i]),PATHINFO_EXTENSION));
                $target_file = $target_dir . round(microtime(true) * 1000) . $i . "." . $imageFileType;

                move_uploaded_file($_FILES["photos"]["tmp_name"][$i], $target_file);

                array_push($movedPhotosPaths, $target_file);
            }
        }
    }

    if ($uploadOk != 0) {
        $sql = "INSERT INTO posts (post,id_user,id_destination) VALUES ('$post','$user_id','$destination_id')";

        if (mysqli_query($conn, $sql)) {
            $post_id = mysqli_insert_id($conn);
            $error["class"] = "alert-success";
            $error["message"] = "Submission succeeded: Experience successfully posted.";
        } else {
            $error["class"] = "alert-error";
            $error["message"] = "Submission failed: Internal Server Error.";
        }

        foreach ($movedPhotosPaths as $photoPath) {
            $sql = "INSERT INTO photos (photo_path,id_post) VALUES ('$photoPath','$post_id')";

            mysqli_query($conn, $sql);
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
if ($current_user["cover_img_path"] == null) {
    $current_user["cover_img_path"] = "../assets/beach3.jpg";
}

/*
    GET USER POSTS
*/
$posts = array();

$sql = "SELECT * FROM destinations,posts WHERE posts.id_user=$user_id AND destinations.id=posts.id_destination ORDER BY created_at DESC LIMIT 5";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    array_push($posts, $row);
}

/*
    GET ALL RECENT POSTS
*/
$allPosts = array();

$sql = "SELECT * FROM users, destinations, posts WHERE posts.id_user!=$user_id AND posts.id_user=users.id AND destinations.id=posts.id_destination ORDER BY created_at DESC LIMIT 5";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    array_push($allPosts, $row);
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
    GET ALL LOCATIONS
*/

$locations = array();

$sql = "SELECT * FROM destinations";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    array_push($locations, $row);
}

/*
    GET DREAM HAVENS DESTINATIONS
*/
// Initialize array to store the recommended destinations
$destinations = array();

// Get the first recommended destination
$sql = "SELECT * FROM users, destinations  WHERE users.id=$user_id AND destinations.id=users.id_destination_1";
$result = mysqli_query($conn, $sql);

// Add the destination to the array $destinations
$row = mysqli_fetch_assoc($result);
if ($row !== null) {
    array_push($destinations, $row);
}

// Get the second recommended destination
$sql = "SELECT * FROM users, destinations  WHERE users.id=$user_id AND destinations.id=users.id_destination_2";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);
if ($row !== null) {
    array_push($destinations, $row);
}

// Get the third recommended destination
$sql = "SELECT * FROM users, destinations  WHERE users.id=$user_id AND destinations.id=users.id_destination_3";
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
    <link rel="stylesheet" href="style.css?dummy=wssfssssw" />
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
        margin-top: -500px;
        border-radius: 50%;
        border: solid 2px white;
        object-fit:cover;
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
            
            <img src="<?php echo $current_user["cover_img_path"] ?>" style="width: 100%; height: 300px; object-fit:cover;">
            <img id = "profilePic" src="<?php echo $current_user["img_path"] ?>">
            <br>
            <div style="position:relative;font-size: 20px;"><?php echo $current_user["name"] ?></div>
            <br>
            <form class="about-me" action="" method="POST">
                <label for="about">
                    About Me:
                    <textarea name="about" id="about" rows="10" placeholder="Tell us about you..." maxlength="400" readonly><?php echo $current_user["about"] ?></textarea>
                </label>
                <button type="button" onclick="editAbout(this)">Edit</button>
                <button id="submitAbout" style="display:none;">Submit</button>
            </form>
            <br>
            <ul class="user-nav">
                <li class="nav-link">
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
                </li>
            </ul>
            
        </div>

        <!--Below cover area-->
        <div style="display: flex;">
            <br>

            <!--Posts-->
            <br>
            <div style="min-width: 400px; flex: 8 ;padding: 20px; padding-left: 0px;">
                <form action="" method="POST" style= "border: solid thin #aaa; padding: 10px; background-color: white;" enctype="multipart/form-data">
                    <textarea name="postInput" id="postInput" maxlength="400" placeholder="Your Vacation Awesomeness" required style="outline:0;"></textarea>
                    <label for="location">Location:</label>
                    <select class="location-select" name="location" id="location" required>
                        <?php 
                            foreach ($locations as $location) {
                                echo '
                                    <option value="'.$location["id"].'">'.$location["name"].'</option>
                                ';
                            }
                        ?>
                    </select><br/>
                    <label for="photos" style="cursor:pointer;">
                        Add photos
                        <input type="file" name="photos[]" id="photos" multiple hidden onchange="showPhotosPreview(event,this)" />
                    </label>
                    <span id="photosPreview">0 photos added</span>
                    <input id="postButton" name="postButton" type="submit" value="POST">
                    <br>
                </form>
                <!--Posts-->
                <div id="postBar">
                    <h2 class="text-center">Your Posts</h2>
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
                                <span class="delete-post" onclick="deletePost(this,'.$post["id"].')">&times;</span>
                                <div>
                                    <img src="'.$current_user["img_path"].'" style ="width: 75px;height:75px;object-fit:cover; margin-right: 4px;">
                                </div>
                                <div>
                                    <a href="./user.php?id='.$post["id_user"].'" style="font-weight: bold; text-decoration:none; color: #84fab0;">'.$current_user["username"].'</a>
                                        <p style="margin:0;">'.$post["post"].'</p>
                                    '.$photosString.'
                                    <p style="margin:0;margin-bottom:6px;"><b>Location: '.$post["name"].'</b></p>
                                    <a href="javascript:void(0);" onclick="likePost(this,'.$post["id"].')">'.$likeString.'</a> . <a href="javascript:void(0)" onclick="commentPost('.$post["id"].')">Comment</a> . <a href="javascript:void(0)" onclick="archivePost(this, '.$post["id"].')">'.$archiveString.'</a> . <span style="color: #999;">'.date_format(date_create($post["created_at"]),"F d, Y").'</span>
                                </div>
                            </div>
                            ';
                        }

                        if (count($posts) == 0) {
                            echo "<p class='text-center'>You haven't posted anything. Create your first post now!</p>";
                        }
                    ?>
                </div>

                <div id="postBar">
                    <h2 class="text-center">Recent Posts</h2>
                    <?php
                        foreach ($allPosts as $post) {
                            if ($post["img_path"] == null) {
                                $post["img_path"] = "https://www.uic.mx/posgrados/files/2018/05/default-user.png";
                            }

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
                                    <img src="'.$post["img_path"].'" style ="width: 75px;height:75px;object-fit:cover; margin-right: 4px;">
                                </div>
                                <div>
                                    <a href="./user.php?id='.$post["id_user"].'" style="font-weight: bold; text-decoration:none; color: #84fab0;">'.$post["username"].'</a>
                                        <p style="margin:0;">'.$post["post"].'</p>
                                    '.$photosString.'
                                    <p style="margin:0;margin-bottom:6px;"><b>Location: '.$post["name"].'</b></p>
                                    <a href="javascript:void(0);" onclick="likePost(this,'.$post["id"].')">'.$likeString.'</a> . <a href="javascript:void(0)" onclick="commentPost('.$post["id"].')">Comment</a> . <a href="javascript:void(0)" onclick="archivePost(this, '.$post["id"].')">'.$archiveString.'</a> . <span style="color: #999;">'.date_format(date_create($post["created_at"]),"F d, Y").'</span>
                                </div>
                            </div>
                            ';
                        }

                        if (count($allPosts) == 0) {
                            echo "<p class='text-center'>There are no recent Posts.</p>";
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

                    if (count($destinations) == 0) {
                        echo '<a class="retake-quiz-btn" href="./quiz.php">Take Quiz</a>';
                    } else {
                        echo '<a class="retake-quiz-btn" href="./quiz.php">Retake Quiz</a>';
                    }
                    
                    ?>
        
                </div>
                
            </div>
        </div>

    </div>

    <!------ Profile Content ------->

    <script src="../js/myPage.js?dummy=w2"></script>
</body>
    