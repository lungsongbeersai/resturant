<?php
include_once('component/app_packget.php');
$packget = new packget();
?>
<!doctype html>
<html lang="en">

<head>
    <?php $packget->app_css(); ?>
</head>

<body style="background-color:#006EB6;">
    <?php $packget->app_loading(); ?>

    <div class="appHeader px-0" style="background-color:#006EB6;color:white">
        <div class="left">
            <a href="#" class="headerButton goBack text-light">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle mt-2">
            <h2 class="text-light" style="font-size:25px;font-family:LAOS_Bold">ປ່ຽນລະຫັດຜ່ານ</h2>
        </div>
    </div>

    
    <div id="appCapsule">

        <div class="section mt-3 text-center">
            <div class="avatar-section">
                <div>
                    <?php 
                        if($_SESSION["employ_profile"] !=""){
                            $image_profile="../assets/image/company/".$_SESSION["employ_profile"];
                        }else{
                            $image_profile="../assets/image/logo/no.jpg";
                        }
                    ?>
                    <img src="<?php echo $image_profile;?>" alt="avatar" class="imaged w100 rounded">
                </div>
            </div>
        </div>

        <div class="section mt-3">
            <h4 class="text-light">ປ່ຽນລະຫັດຜ່ານໃໝ່</h4>
        </div>
        <div class="section mb-5 p-1">
        
            <form id="frm_change">
                <div class="card">
                    <div class="card-body pb-1">
                        <!-- <div class="form-group boxed">
                            <div class="input-wrapper">
                                <label class="label" for="app_login_email" style="font-size:16px !important;">ອີເມວໃໝ່ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="app_login_email" name="app_login_email" autofocus autocomplete="off" placeholder="ປ້ອນອີເມວໃໝ່">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div> -->
                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <label class="label" for="txt_password" style="font-size:16px !important;">ລະຫັດຜ່ານໃໝ່ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="txt_password" name="txt_password" autocomplete="off" placeholder="ປ້ອນລະຫັດຜ່ານໃໝ່">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <label class="label" for="app_login_password" style="font-size:16px !important;">ຢືນຢັນລະຫັດຜ່ານໃໝ່ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="app_login_password" name="app_login_password" autocomplete="off" placeholder="ຢືນຢັນລະຫັດຜ່ານໃໝ່">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group boxed mt-5 mb-2">
                            <button type="submit" class="btn btn-primary btn-block"><ion-icon name="lock-open-outline"></ion-icon> ປ່ຽນລະຫັດ</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <div class="modal fade dialogbox" id="error_warning" data-bs-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-size:25px;font-weight:bold;">ແຈ້ງເຕືອນ</h5>
                </div>
                <div class="modal-body text-dark">
                    ຂໍອະໄພ ! ລະຫັດຜ່ານບໍ່ກົງກັນ
                </div>
                <div class="modal-footer">
                    <div class="btn-inline">
                        <button type="button" class="btn btn-text-danger" data-bs-dismiss="modal"><ion-icon name="close-circle-outline"></ion-icon> ປິດ</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade dialogbox" id="confirm_changeP" data-bs-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ແຈ້ງເຕືອນ</h5>
                </div>
                <div class="modal-body">
                    ຕ້ອງການປ່ຽນລະຫັດຜ່ານແທ້ ຫຼື ບໍ່ ?
                </div>
                <div class="modal-footer">
                    <div class="btn-inline">
                        <a href="#" class="btn btn-text-danger" data-bs-dismiss="modal">
                            <ion-icon name="close-outline"></ion-icon>
                            ປິດ
                        </a>
                        <a href="#" class="btn btn-text-primary" onclick="confirm_password()">
                            <ion-icon name="checkmark-outline"></ion-icon>
                            ຕົກລົງ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $packget->app_menu(); ?>
    <?php $packget->app_script(); ?>
    <script>
        $("#frm_change").on("submit",function(event){
            event.preventDefault();
            var txt_password=$("#txt_password").val();
            var app_login_password=$("#app_login_password").val();

            if(txt_password!=app_login_password){
                $("#error_warning").modal("show");
            }else{
                $("#confirm_changeP").modal("show");
            }
            
        });

        function confirm_password(){
            var app_login_password=$("#app_login_password").val();
            $.ajax({
                url: "service/sql/login-sql.php?change_password",
                method: "POST",
                data:{app_login_password},
                success: function(data) {
                    var dataResult = JSON.parse(data);
                    if (dataResult.statusCode == 200) {
                        location.href = "?login";
                    } else if (dataResult.statusCode == 201) {
                        loadContent(1);
                    }
                }
            })
        }
    </script>
</body>

</html>