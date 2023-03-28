<?php
session_start();
class App{
    public function myapp(){
        date_default_timezone_set('Asia/Bangkok');
        include_once('service/config/db.php');
        if(@$_SESSION['myApp'] !='1'){
            include_once('login.php');
        }else{
            if(isset($_REQUEST['home'])){
                include_once('app/app-main/index.php');
            }elseif(isset($_REQUEST['pos'])){
                include_once('app/app-setting/frm-pos.php');
            }elseif(isset($_REQUEST['bill_detail'])){
                include_once('app/app-setting/frm-bill-detail.php');
            }elseif(isset($_REQUEST['logout'])){
                include_once('logout.php');
            }else{
                include_once('login.php');
            }
        }
    }
}
?>