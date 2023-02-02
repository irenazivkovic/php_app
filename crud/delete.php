<?php
require "../dbBroker.php";
require  "../model/pregled.php";

if(isset($_POST['id'])){
    
    $status = Pregled::deleteById($_POST['id'], $conn);
    if($status){
        echo 'Success';
    }else{
        echo 'Failed';
    }
}
?>