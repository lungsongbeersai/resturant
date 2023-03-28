<?php
include_once('component/app_packget.php');
$packget = new packget();
$db = new DBConnection();

?>

<!doctype html>
<html lang="en">

<head>
    <?php $packget->app_css(); ?>
</head>

<body>
    <?php $packget->app_loading(); ?>
    <?php $packget->app_header(); ?>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="carousel-multiple splide" style="background-color: #FD5900 !important;">
            <div class="splide__track">
                <ul class="splide__list">
                    <li class="splide__slide" onclick="fn_active_item('3')">
                        <a href="#">
                            <div class="user-card">
                                <ion-icon name="layers-outline" style="font-size:40px !important;color:black"></ion-icon>
                                <strong>ທັງໝົດ</strong>
                            </div>
                        </a>
                    </li>
                    <li class="splide__slide" onclick="fn_active_item('1')">
                        <a href="#">
                            <div class="user-card">
                                <!-- <img src="assets/img/logo/round.png" alt="img" class="imaged w-100"> -->
                               <ion-icon name="layers-outline" style="font-size:40px !important;color:black"></ion-icon>
                                <strong>ໂຕະວ່າງ</strong>
                            </div>
                        </a>
                    </li>
                    <li class="splide__slide" onclick="fn_active_item('2')">
                        <a href="#">
                            <div class="user-card">
                                <!-- <img src="assets/img/logo/round.png" alt="img" class="imaged w-100"> -->
                               <ion-icon name="layers-outline" style="font-size:40px !important;color:black"></ion-icon>
                                <strong>ບໍ່ວ່າງ</strong>
                            </div>
                        </a>
                    </li>
                    <?php
                    $sql_zone = $db->fn_read_all("res_zone");
                    foreach ($sql_zone as $row_zone) {
                    ?>
                        <li class="splide__slide active_item" id="<?php echo $row_zone['zone_code'] ?>" onclick="fn_active_item('<?php echo $row_zone['zone_code'] ?>')">
                            <a href="#">
                                <div class="user-card">
                                    <!-- <img src="assets/img/logo/round.png" alt="img" class="imaged w-100"> -->
                                   <ion-icon name="layers-outline" style="font-size:40px !important;color:black"></ion-icon>
                                    <strong>ໂຊນນອກ</strong>
                                </div>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="section mt-3 px-1 mb-4">
            <div class="session_grid px-0" id="show_session_grid">
                
            </div>
        </div>

    </div>


    <!-- Wallet Card -->

    <?php $packget->app_menu(); ?>
    <?php $packget->app_script(); ?>

    <script>
        fn_active_item("3")

        function fn_active_item(active_item) {
            $('.active').not(this).removeClass('active');
            $("#" + active_item).toggleClass('active');
            $.ajax({
                url: "service/sql/service-all.php?load_zone",
                method: "POST",
                data: {
                    active_item
                },
                success: function(data) {
                    $("#show_session_grid").html(data);
                }
            })
        }
    </script>

</body>

</html>