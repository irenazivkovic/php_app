<?php

require "dbBroker.php";
require "model/user.php";

session_start();

if(isset($_POST['username']) && isset($_POST['password'])){
    $uname = $_POST['username'];
    $upass = $_POST['password'];


    //kreiramo korisnika
    $korisnik = new User(1,$uname,$upass);
   // $odg = $korisnik->logInUser($uname,$upass, mysqli);
   $odg = User::logInUser($korisnik, $conn); //staticki pristup preko klase

   if($odg->num_rows==1){
        $row = $odg->fetch_row();
        $user_id = $row[0];

        $_SESSION['user_id'] = $user_id;
    
        header('Location: home.php');
        exit();
   }
   else{
    echo `
    <script>
    console.log("Morate da se prijavite");
    </script>`;
    exit();
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Prijava</title>
    <link rel="icon" href="css/img/logo2.png" />
</head>
<body>
    <style type="text/css">
        
        #text{
            height: 25px;
            border-radius: 5px;
            padding: 4px;
            border: solid thin #aaa;
            width: 95%;
        }

        #button{
            padding: 10px;
            width: 100px;
            color:white;
            background-color: #4299c4c7;
            border: none;
            border-radius: 10px;
        }

        #box{
            margin: auto;
            width: 60%;
            padding: 1em;
            height: 780px;
            box-sizing: border-box;
            background-color: #e5f3f8;
            
            background-image: 
                linear-gradient(175deg, rgba(0,0,0,0) 95%, #366b86c7 95%),
                linear-gradient( 85deg, rgba(0,0,0,0) 95%, #366b86c7 95%),
                linear-gradient(175deg, rgba(0,0,0,0) 90%, #4299c4c7 90%),
                linear-gradient( 85deg, rgba(0,0,0,0) 92%, #4299c4c7 92%),
                linear-gradient(175deg, rgba(0,0,0,0) 85%, #56a7d0c7 85%),
                linear-gradient( 85deg, rgba(0,0,0,0) 89%, #56a7d0c7 89%),
                linear-gradient(175deg, rgba(0,0,0,0) 80%, #85c5e6c7 80%),
                linear-gradient( 85deg, rgba(0,0,0,0) 86%, #85c5e6c7 86%),
                linear-gradient(175deg, rgba(0,0,0,0) 75%, #a3daf6c7 75%),
                linear-gradient( 85deg, rgba(0,0,0,0) 83%, #a3daf6c7 83%);
        }
        
    </style>

    
    <div id="box">
        <form method="post">
            <div style="font-size: 30px; margin: 10px; color: #4299c4c7;">Prijava</div>
            <input id="text" type="text" name="username" placeholder="username" style="border-radius: 10px; border-color: #4299c4c7"><br><br>
            <input id="text" type="password" name="password" placeholder="password" style="border-radius: 10px; border-color: #4299c4c7"><br><br>

            <input id="button" type="submit" value="Prijava"><br><br>

        </form>
</body>
</html>