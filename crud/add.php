<?php
require "../dbBroker.php";
require "../model/pregled.php";

if (isset($_POST['zubar']) && isset($_POST['grad']) 
    && isset($_POST['kategorija']) && isset($_POST['datum']) && isset($_POST['user_id'])){
    $status = Pregled::add($_POST['zubar'], $_POST['grad'], $_POST['kategorija'], $_POST['datum'], $_POST['user_id'], $conn);
    if ($status) {
        echo 'Success';
    } else {
        echo $status;
        echo 'Failed';
    }
}