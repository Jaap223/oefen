<?php 
require_once 'head/head.php';
require_once 'data/db.php';



//Verwijder een object



class Auto extends Database {


    public function addAuto()
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete'){
    $verwijderObj->delete($_POST['car_id']);
    exit();
}

$delete = new Auto();



?>