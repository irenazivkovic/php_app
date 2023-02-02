<?php
require "../dbBroker.php";
require "../model/pregled.php";


$status = Pregled::getLast($conn);
if ($status) {
    echo $status->fetch_column();
} else {
    echo $status;
    echo 'Failed';
}
