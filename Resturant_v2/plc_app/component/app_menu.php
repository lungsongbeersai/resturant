    <?php 
        if(@$_SESSION["id_link"]=="home"){
            $active_home="active";
        }else if(@$_SESSION["id_link"]=="insurance-limit"){
            $active_limit="active";
        }else if(@$_SESSION["id_link"]=="setting"){
            $active_setting="active";
        }else{
            $active_home="active";
        }
    ?>
    <div class="appBottomMenu" style="z-index:999 !important;">
        <a href="?home" class="item <?php echo $active_home;?>" onclick="active_item('home')">
            <div class="col">
                <ion-icon name="home"></ion-icon>
                <strong>ໜ້າຫຼັກ</strong>
            </div>
        </a>
        <a href="?logout" class="item">
            <div class="col">
                <ion-icon name="power-outline"></ion-icon>
                <strong>ອອກຈາກລະບົບ</strong>
            </div>
        </a>

    </div>