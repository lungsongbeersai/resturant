<?php
include_once('component/app_packget.php');
$packget = new packget();

?>
    <!doctype html>
    <html lang="en">
    <head>
        <?php $packget->app_css(); ?>
        <style>
            .label{
                font-size: 14px !important;
                font-weight: bold !important;
            }
            .form-control{
                font-size: 16px !important;
                height: 50px !important;
            }
            body{
                overflow: hidden;
            }
        </style>
    </head>

    <body style="background-color:#c64500;">

        <?php $packget->app_loading(); ?>

        <!-- App Capsule -->
        <div id="appCapsule">
            <form id="login_form">
                <div class="section mb-5">
                    <div class="card">
                        <div class="card-body">
                            <center>
                                <!-- <p class="text-dark" style="font-size:30px;font-family:'Times New Roman', Times, serif">WELCOME TO</p> -->
                                <img src="../assets/img/logo/002.png" alt="" class="imaged w160">
                            </center>
                            <!-- <div class="form-group boxed">
                                <div class="input-wrapper">
                                    <label class="label" for="email1">ຊື່ຜູ້ໃຊ້ <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-100" id="login_email" name="login_email" autocomplete="off" placeholder="ປ້ອນຊື່ຜູ້ໃຊ້" autofocus>
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div> -->

                            <div class="form-group boxed">
                                <div class="input-wrapper">
                                    <label class="label" for="password1">ລະຫັດຜ່ານ <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control text-100" id="users_password" name="users_password" autofocus autocomplete="off" placeholder="*********">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="form-check form-check-inline mt-1 mb-4">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" onclick="myFunction('users_password')">
                                <label class="form-check-label" for="inlineCheckbox1"></label>
                            </div>
                            <span class="text-dark">ສະແດງລະຫັດ</span>

                            <div class="form-group boxed">
                                <br>
                                <button type="submit" class="btn btn-lg btn-block btn-info"> ☞ ເຂົ້າສູ່ລະບົບ</button>
                            </div>
                            <div class="form-group text-right mt-1">
                                ເວີຊັນ : <span style="font-family:'Times New Roman', Times, serif">1</span> 
                            </div>
                            
                        
                        </div>
                    </div>
                </div>
            </form>
            <div id="div1" style="color:#25AAE2"></div>
        </div>
        <!-- * App Capsule -->
        
        


        <div id="frm_notification" class="notification-box">
            <div class="notification-dialog ios-style">
                <div class="notification-header">
                    <div class="in">
                        <strong>ແຈ້ງເຕືອນ</strong>
                    </div>
                    <div class="right">
                        <a href="#" class="close-button">
                            <ion-icon name="close-circle"></ion-icon>
                        </a>
                    </div>
                </div>
                <div class="notification-content">
                    <div class="in">
                            <h3 class="subtitle text-warning">
                                <ion-icon name="close-circle-outline"></ion-icon> ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ
                            </h3>
                    </div>
                </div>
            </div>
        </div>


        <?php $packget->app_script(); ?>

        <script>
            login("login_form","users_password","frm_notification");
            // $(function() { 
            //     $(this).bind("contextmenu", function(e) { 
            //         e.preventDefault(); 
            //     }); 
            // }); 
        </script>
    </body>
</html>
