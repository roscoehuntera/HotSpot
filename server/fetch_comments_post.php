<?php

session_start();
$user_id = $_SESSION["id"];

require_once("../server/database.php");

$postId = $_POST["postId"];

$sql = "SELECT * FROM users,posts WHERE posts.id=$postId AND users.id=posts.id_user";
$result = mysqli_query($conn, $sql);

$post_info = mysqli_fetch_assoc($result);
if ($post_info["img_path"] == null) {
    $post_info["img_path"] = "https://www.uic.mx/posgrados/files/2018/05/default-user.png";
}


$comments = array();

$sql = "SELECT * FROM users,comments WHERE comments.id_post=$postId AND comments.id_user=users.id";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    if ($row["img_path"] == null) {
        $row["img_path"] = "https://www.uic.mx/posgrados/files/2018/05/default-user.png";
    }
    array_push($comments, $row);
}

$number_of_comments = mysqli_num_rows($result);

$photos = array();

$sql = "SELECT * FROM photos WHERE id_post=$postId";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    array_push($photos, $row);
}

$sql = "SELECT * FROM likes WHERE id_post=$postId";
$result = mysqli_query($conn, $sql);

$number_of_likes = mysqli_num_rows($result);

$post_info["comments"] = $number_of_comments;
$post_info["likes"] = $number_of_likes;

$payload = array(
    "postInfo" => $post_info,
    "comments" => $comments,
    "photos" => $photos
);

echo json_encode($payload);

mysqli_close($conn);

?>