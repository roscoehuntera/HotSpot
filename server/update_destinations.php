<?php

require_once("../server/database.php");

$firstDestination = $_POST["firstDestination"];
$secondDestination = $_POST["secondDestination"];
$thirdDestination = $_POST["thirdDestination"];

$sql = "UPDATE users SET id_destination_1='$firstDestination', id_destination_2='$secondDestination', id_destination_3='$thirdDestination' WHERE id=1";

if (mysqli_query($conn, $sql)) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);

?>