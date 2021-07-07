<?php

session_start();
$user_id = $_SESSION["id"];

require_once("../server/database.php");

$id = $_POST["postId"];

$sql = "DELETE FROM posts WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    $error["class"] = "alert-success";
    $error["message"] = "You have deleted your post.";
} else {
    $error["class"] = "alert-error";
    $error["message"] = "Failed: Internal Server Error.";
}

echo '
    <div id="alert" class="alert '.$error["class"].'">
        <p>'.$error["message"].'</p>
    </div>
';

mysqli_close($conn);

?>