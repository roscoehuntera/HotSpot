<?php

session_start();
$user_id = $_SESSION["id"];

require_once("../server/database.php");

$postId = $_POST["postId"];

$sql = "SELECT * FROM archives WHERE id_user=$user_id AND id_post=$postId";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    // CREATE LIKE
    $sql = "INSERT INTO archives (id_user,id_post) VALUES ('$user_id','$postId')";

    if (mysqli_query($conn, $sql)) {
        $error["class"] = "alert-success";
        $error["message"] = "You have archived this post.";
    } else {
        $error["class"] = "alert-error";
        $error["message"] = "Archive submission failed: Internal Server Error.";
    }
} else {
    // REMOVE LIKE
    $sql = "DELETE FROM archives WHERE id_user=$user_id AND id_post=$postId";

    if (mysqli_query($conn, $sql)) {
        $error["class"] = "alert-success";
        $error["message"] = "This post is no longer archived.";
    } else {
        $error["class"] = "alert-error";
        $error["message"] = "Unarchive submission failed: Internal Server Error.";
    }
}

echo '
    <div id="alert" class="alert '.$error["class"].'">
        <p>'.$error["message"].'</p>
    </div>
';

mysqli_close($conn);

?>