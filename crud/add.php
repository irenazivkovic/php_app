<?php
require "../dbBroker.php";
require "../model/pregled.php";

if (isset($_POST['zubar']) && isset($_POST['grad']) 
    && isset($_POST['kategorija']) && isset($_POST['datum'])){
    $status = Pregled::add($_POST['zubar'], $_POST['grad'], $_POST['kategorija'], $_POST['datum'], $conn);
    if ($status) {
        echo 'Success';
    } else {
        echo $status;
        echo 'Failed';
    }
}