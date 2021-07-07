<?php

session_start();
$user_id = $_SESSION["id"];

require_once("../server/database.php");

$postId = $_POST["postId"];

$sql = "SELECT * FROM likes WHERE id_user=$user_id AND id_post=$postId";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    // CREATE LIKE
    $sql = "INSERT INTO likes (id_user,id_post) VALUES ('$user_id','$postId')";

    if (mysqli_query($conn, $sql)) {
        $error["class"] = "alert-success";
        $error["message"] = "You now like this post.";
    } else {
        $error["class"] = "alert-error";
        $error["message"] = "Like submission failed: Internal Server Error.";
    }
} else {
    // REMOVE LIKE
    $sql = "DELETE FROM likes WHERE id_user=$user_id AND id_post=$postId";

    if (mysqli_query($conn, $sql)) {
        $error["class"] = "alert-success";
        $error["message"] = "You no longer like this post.";
    } else {
        $error["class"] = "alert-error";
        $error["message"] = "Unlike submission failed: Internal Server Error.";
    }
}

echo '
    <div id="alert" class="alert '.$error["class"].'">
        <p>'.$error["message"].'</p>
    </div>
';

mysqli_close($conn);

?>