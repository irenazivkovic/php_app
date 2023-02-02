<?php

require "../dbBroker.php";
require "../model/pregled.php";

if(isset($_POST['id'])) {
    $myArray = Pregled::getById($_POST['id'], $conn);
    echo json_encode($myArray);
}
?>