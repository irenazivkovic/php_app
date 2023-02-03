<?php 


class Pregled{
    public $id;
    public $zubar;
    public $grad;
    public $kategorija;
    public $datum;
    public $user_id;

    public function __construct($id=null, $zubar=null, $grad=null, $kategorija=null, $datum=null){
        $this->id=$id;
        $this->zubar=$zubar;
        $this->grad=$grad;
        $this->kategorija=$kategorija;
        $this->datum=$datum;
    }

    public static function getAll($user_id, mysqli $conn){
        $query = "SELECT * FROM pregled WHERE user_id=$user_id";
        return $conn->query($query);
    }

    public static function getById($id,mysqli $conn){
        $query = "SELECT * FROM pregled WHERE id=$id";
        $myArray = array();
        $rezultat = $conn->query($query);
        if($rezultat){
            while($red = $rezultat->fetch_array()){
                $myArray[] = $red;
            }
        }

        return $myArray;
    }

    public static function deleteById($id, mysqli $conn){
        $query = "DELETE FROM pregled WHERE id=$id";
        return $conn->query($query);
    }

    public static function add($zubar, $grad, $kategorija, $datum, $user_id, mysqli $conn){
        $query = "INSERT INTO pregled(zubar, grad, kategorija, datum, user_id) VALUES('$zubar','$grad', '$kategorija', '$datum', $user_id)";
        return $conn->query($query);
    }

    public static function getLast(mysqli $conn)
    {
        $q = "SELECT * FROM pregled ORDER BY id DESC LIMIT 1";
        return $conn->query($q);
    }
}
?>