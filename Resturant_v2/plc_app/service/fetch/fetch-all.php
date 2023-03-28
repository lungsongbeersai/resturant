<?php session_start();
    include_once("../config/db.php");
    $db = new DBConnection();
    if(isset($_GET["active_item"])){
        @$_SESSION["id_link"]=$_POST["id_link"];
    }
?>