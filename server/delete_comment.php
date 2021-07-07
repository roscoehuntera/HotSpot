<?php

session_start();
$user_id = $_SESSION["id"];

require_once("../server/database.php");

$id = $_POST["commentId"];

$sql = "SELECT * FROM comments WHERE id=$id AND id_user='$user_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $sql = "DELETE FROM comments WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        $error["class"] = "alert-success";
        $error["message"] = "You have deleted your comment.";
    } else {
        $error["class"] = "alert-error";
        $error["message"] = "Failed: Internal Server Error.";
    }
} else {
    $error["class"] = "alert-error";
    $error["message"] = "You can't delete a comment that is not yours.";
}

$alert = '
    <div id="alert" class="alert '.$error["class"].'">
        <p>'.$error["message"].'</p>
    </div>
';

if ($error["class"] == "alert-error") {
    $allow = "false";
} else {
    $allow = "true";
}

$payload = array(
    "alert" => $alert,
    "allow" => $allow
);

echo json_encode($payload);

mysqli_close($conn);

?>