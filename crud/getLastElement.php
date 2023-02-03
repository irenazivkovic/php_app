<?php
require "../dbBroker.php";
require "../model/pregled.php";


$status = Pregled::getLast($conn);
if ($status) {
    echo json_encode($status->fetch_row());
} else {
    echo $status;
    echo 'Failed';
}
