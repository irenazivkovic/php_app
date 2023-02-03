<?php

require "dbBroker.php";
require "model/pregled.php";

session_start();

if (!($_SESSION['user_id'])) {
    header("Location: index.php");
    die();
}

$result = Pregled::getAll($_SESSION['user_id'], $conn);
if (!$result) {
    echo "Greska kod upita<br>";
    die();
}
if ($result->num_rows == 0) {
    echo "Nema pregleda";
    die();
} 
else {
?>
<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="icon" href="css/img/logo2.png" />
        <link rel="stylesheet" href="css/home.css">
        <title>Stomatološka ordinacija AnaDent</title>
    </head>

    <body>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>localStorage.setItem('UserID', <?php echo $_SESSION['user_id']?>)</script>
    
        <div class="navbar" >
        <img src="css/img/logo.png" style="width: 120px; cursor: pointer;">
            <ul>
                <li>
                <input type="text" id="search-input" class="btn" placeholder="Pretrazite pregled po kategoriji..." onkeyup="pretrazi()" style="width: 500px;">
                </li>
                <li>
                <button id="btn-dodaj" class="btn" data-toggle="modal" data-target="#myModal">Zakaži pregled</button>
                </li>
               
            </ul>
        </div>

        <div class="container" id="container">
            <?php
                while ($red = $result->fetch_array()) {
                    ?>
            <div class="card text-white bg-info mb-6 pregled" id=<?php echo $red['id'] ?> style="width:15%; position: static; border-radius: 20px; text-align: center; margin: 30px 30px;">       
                <div class="card-header"><h3><b>Zakazan pregled</b></h3></div>
                <div class="card-body">
                    <ul style="list-style: none;">
                        <li>Zubar: <?php echo $red["zubar"] ?></li>
                        <li>Grad: <?php echo $red["grad"] ?></li>
                        <li class="category">Kategorija: <?php echo $red["kategorija"] ?></li>
                        <li>Datum: <?php echo $red["datum"] ?></li>
                        <li>
                            <label class="radio-btn">
                                <input type="radio" name="checked-donut" value=<?php echo $red["id"]?>>
                                <span class="checkmark"></span>
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
        <?php
            }  
        }
        ?>
        </div>

        <div class="opcije">
            <button id="btn-izbrisi" class="btn" style="width: 150px;padding: 15px 0; text-align: center; margin: 20px 10px;border-radius: 20px; background-color:#337ab7; color:#fff;">Obrisi pregled</button>
            <a class="btn btn-primary" href="logout.php" role="button" style="width: 150px;padding: 15px 0; text-align: center; margin: 20px 10px;border-radius: 20px;">Kraj rada</a>
        </div>
        
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!--Modalna forma za dodavanje-->
                <div class="modal-content" style="border: 4px solid #006699; background-size: cover; background-position: center;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="container pregled-form">
                            <form action="#" method="post" id="dodajForm">
                                <h3 id="naslov" style="color:  #006699" text-align="center">Dodavanje pregleda</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" style="width: 400px;border: 1px solid #006699" name="zubar" class="form-control" placeholder="Zubar *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" style="width: 400px;border: 1px solid #006699" name="grad" class="form-control" placeholder="Grad  *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" style="width: 400px;border: 1px solid #006699" name="kategorija" class="form-control" placeholder="Kategorija *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="date" style="width: 400px;border: 1px solid #006699" name="datum" class="form-control" placeholder="Kategorija *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <button id="btnDodaj" type="submit" class="btn btn-success btn-block" style="background-color:  #006699; border: 1px solid white;"><i class="glyphicon glyphicon-plus"></i> Dodaj pregled
                                            </button>
                                        </div>

                                    </div>


                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" style="color: white; background-color:  #006699; border: 1px solid white" data-dismiss="modal">Zatvori</button>
                    </div>
                </div>

            </div>
        </div>

        <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
        <script src="js/main.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <script>
        function pretrazi() {

            const input = document.getElementById("search-input");
            const filter = input.value.toUpperCase();

            let toHidden = [];

            $('.category').each((index, element) => {
                const pattern = new RegExp(`^${filter}.*`);
                const kategorija = (element.innerHTML.split(': ')[1]).toUpperCase();
                
                if(filter === '') {
                    toHidden.push(false);
                }else {
                    toHidden.push(!pattern.test(kategorija));
                }
                
            });

            $('.pregled').each((index, element) => {
                element.hidden = toHidden[index];
            });

            /*
            for (i = 0; i < tr.length; i++) {
                td1 = tr[i].getElementsByTagName("li")[1];
                td2 = tr[i].getElementsByTagName("li")[2];
                td3 = tr[i].getElementsByTagName("li")[3];
                td4 = tr[i].getElementsByTagName("li")[4];

                if (td1 || td2 || td3 || td4) {
                    txtValue1 = td1.textContent || td1.innerText;
                    txtValue2 = td2.textContent || td2.innerText;
                    txtValue3 = td3.textContent || td3.innerText;
                    txtValue4 = td4.textContent || td4.innerText;

                    if (txtValue1.toUpperCase().indexOf(filter) > -1 || txtValue2.toUpperCase().indexOf(filter) > -1 ||
                        txtValue3.toUpperCase().indexOf(filter) > -1 || txtValue4.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
            */
        }

    </script>
    </body>

    </html>