<?php session_start();
include_once("../config/db.php");
$db = new DBConnection();
if (isset($_GET["load_zone"])) {
    if ($_POST["active_item"] == "1") {
        $where = "WHERE table_status='" . $_POST["active_item"] . "'";
    } elseif ($_POST["active_item"] == "2") {
        $where = "WHERE table_status='" . $_POST["active_item"] . "'";
    } elseif ($_POST["active_item"] == "3") {
        $where = "";
    } else {
        $where = "WHERE table_zone_fk='" . $_POST["active_item"] . "'";
    }
    $sql = "res_tables AS A LEFT JOIN res_zone AS B ON A.table_zone_fk=B.zone_code $where ORDER BY table_sum,table_luck ASC";
    $sql = $db->fn_read_all($sql);
    foreach ($sql as $row_table) {
        if ($row_table["table_status"] == "1") {
            $status_table = "<span class='text'>ໂຕະວ່າງ</span>";
        } else if ($row_table["table_status"] == "2") {
            $status_table = "<span class='text text-success'>ບໍ່ວ່າງ</span>";
        }

        $fetchRow = $db->fn_fetch_single_field(
            "SUM(CASE WHEN order_list_status_order != '5' THEN 1 ELSE 0 END) as Order_waiting,
        SUM(CASE WHEN order_list_status_order = '5' THEN 1 ELSE 0 END) as Order_success,
        COUNT(*) as amount,format(SUM(order_list_discount_total),0)AS totals",
            "res_orders_list WHERE order_list_table_fk='" . $row_table["table_code"] . "' AND order_list_branch_fk='" . $_SESSION["user_branch"] . "'"
        );

        if ($row_table["table_status"] == "1") {
?>

            <div class="session_grid_item px-0">
                <a href="?pos&table_id=<?php echo base64_encode($row_table["table_code"]); ?>">
                    <div class="img-hover">
                        <div class="session_grid_img img-hover">
                            <ion-icon name="grid-outline" class="color_icon"></ion-icon>
                        </div>
                        <div class="session_gird_text">
                            <?php echo $row_table["table_name"]; ?>
                        </div>
                    </div>
                </a>
            </div>
        <?php } else { ?>
            <div class="session_grid_item px-0">
                <a href="?pos&table_id=<?php echo base64_encode($row_table["table_code"]); ?>">
                    <div class="img-hover">
                        <div class="session_grid_img img-hover">
                            <ion-icon name="checkmark-circle-outline" class="color_icon1"></ion-icon>
                        </div>
                        <div class="session_gird_text1">
                            <?php echo $row_table["table_name"]; ?>
                        </div>
                    </div>
                </a>
            </div>
<?php }
    }
} ?>
<?php if (isset($_GET["product_list"])) {
    if (@$_POST["cate_item"] == "Promotion_11") {
        $sqlPro = $db->fn_fetch_single_all("view_promotion WHERE promo_status='1' AND promo_branch_fk='" . $_SESSION["user_branch"] . "'");
        @$search .= "WHERE product_cate_fk='" . $sqlPro["cate_code"] . "' AND product_branch='" . $sqlPro["promo_branch_fk"] . "' AND pro_detail_gif='2'";
        $pro_detail_gif = "AND pro_detail_gif='2'";
        $statusPro = "2";
    } else {
        if (@$_POST["cate_item"] == "") {
            @$search .= "WHERE product_branch='" . $_SESSION["user_branch"] . "'";
        } else {
            @$search .= "WHERE product_cate_fk='" . @$_POST["cate_item"] . "' AND product_branch='" . $_SESSION["user_branch"] . "'";
        }
        $pro_detail_gif = "";
        $statusPro = "1";
    }


    $sql_product = $db->fn_read_all("view_product_list $search GROUP BY pro_detail_product_fk ORDER BY pro_detail_code ASC");
    if (count($sql_product) > 0) {
        foreach ($sql_product as $row_product) {
            $sql_detail = $db->fn_read_all("view_product_list
            WHERE pro_detail_product_fk='" . $row_product["product_code"] . "' AND product_branch='" . $_SESSION["user_branch"] . "' $pro_detail_gif ORDER BY pro_detail_size_fk ASC ");
            if ($row_product["product_images"] != "") {
                $images = '../assets/img/product_home/' . $row_product["product_images"];
            } else {
                $images = '../assets/img/logo/259987.png';
            }
            $checkAvilable = $db->fn_fetch_rowcount("view_product_list WHERE pro_detail_product_fk='" . $row_product["product_code"] . "' AND product_branch='" . $_SESSION["user_branch"] . "' AND pro_detail_open='2'  ");
            if ($checkAvilable > 0) {
?>
                <div class="session_grid_item px-0" onclick="function_addModal('<?php echo $row_product['product_code'] ?>','<?php echo $statusPro; ?>')">

                    <a href="#">
                        <div class="img-hover">
                            <div class="session_grid_img img-hover">
                                <img src="<?php echo $images; ?>" class="card-img-top" alt="image" style="height:110px;border-radius: 0px;">
                            </div>
                            <div class="session_gird_text2 mt-1 mb-1">
                                <?php echo $row_product["product_name"] ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } else {
                $sql_detail = $db->fn_fetch_single_all("view_promotion WHERE product_code='" . $row_product["product_code"] . "' 
                AND product_branch='" . $_SESSION["user_branch"] . "' 
                AND pro_detail_open='2' AND pro_detail_qty>=promo_qty_total ORDER BY pro_detail_code ASC LIMIT 1");
                if (@$sql_detail["product_images"] != "") {
                    $images_detail = '../assets/img/product_home/' . $sql_detail["product_images"];
                } else {
                    $images_detail = '../assets/img/logo/259987.png';
                }
            ?>
                <div class="session_grid_item px-0" style="border:1px solid red">
                    <a href="#">
                        <span style="background-color: red;padding:4px;color:white;border-radius:4px;font-size:12px">ໝົດແລ້ວ</span>
                        <div class="img-hover">
                            <div class="session_grid_img img-hover">
                                <img src="<?php echo $images; ?>" class="card-img-top" alt="image" style="height:110px;border-radius: 0px;">
                            </div>
                            <div class="session_gird_text2 mt-1 mb-1">
                                <?php echo $row_product["product_name"] ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
        <?php }
    } else { ?>
        <span class="center-screen" style="color:red">
            <center>
                <ion-icon name="trash-outline" style="font-size: 30px !important;"></ion-icon>
                <br>
                ບໍ່ມີລາຍການ
            </center>
        </span>
    <?php }
}
if (isset($_GET["product_modal"])) {
    if ($_POST["status_check_gif"] == "1") {
        $sql_detail = $db->fn_fetch_single_all("res_products_list AS A 
        LEFT JOIN res_products_detail AS B ON A.product_code=B.pro_detail_product_fk
        LEFT JOIN res_unite AS C ON A.product_unite_fk=C.unite_code
        WHERE product_code='" . $_POST["modal_products"] . "' AND product_branch='" . $_SESSION["user_branch"] . "' 
        AND pro_detail_open='2' ORDER BY pro_detail_code ASC LIMIT 1");
        if (@$sql_detail["product_images"] != "") {
            $images_detail = '../assets/img/product_home/' . $sql_detail["product_images"];
        } else {
            $images_detail = '../assets/img/logo/259987.png';
        }
    ?>

        <input type="text" hidden class="txtDetailCode" id="txtDetailCode" name="txtDetailCode" value="<?php echo $sql_detail['pro_detail_code'] ?>">
        <input type="text" hidden class="txtCutStock" id="txtCutStock" name="txtCutStock" value="<?php echo $sql_detail['product_cut_stock'] ?>">
        <input type="text" hidden class="txtUnite" id="txtUnite" name="txtUnite" value="<?php echo $sql_detail['unite_name'] ?>">
        <input type="text" hidden class="txtQty" id="txtQty" name="txtQty" value="<?php echo $sql_detail['pro_detail_qty'] ?>">
        <input type="text" hidden class="txtPrice" id="txtPrice" name="txtPrice" value="<?php echo $sql_detail['pro_detail_sprice'] ?>">
        <input type="text" hidden class="txtCate" id="txtCate" name="txtCate" value="<?php echo $sql_detail['product_cate_fk'] ?>">
        <input type="text" hidden class="txtStatusPro" id="txtStatusPro" name="txtStatusPro" value="1">
        <input type="text" hidden class="txtProJing1" id="txtProJing1" name="txtProJing" value="0">
        <input type="text" hidden class="txtProGif1" id="txtProGif1" name="txtProGif" value="0">
        <input type="text" hidden class="txtGifDefault1" id="txtGifDefault1" name="txtGifDefault" value="0">
        <input type="text" hidden class="start_qty1" id="start_qty1" name="start_qty" value="1">
        <input type="text" hidden class="stock_qty1" id="stock_qty1" name="stock_qty2" value="0">

        <div class="card border-0">
            <img src="<?php echo $images_detail; ?>" class="card-img-top" alt="image">
            <div class="card-body">
                <h5 class="card-title"><?php echo $sql_detail["product_name"]; ?></h5>
                <p class="card-text text-primary">
                    ລາຄາ : <span class="badge bg-dark"><span id="title_price"><?php echo @number_format($sql_detail["pro_detail_sprice"]); ?></span> ກີບ</span>
                </p>

                <div class="quantity mb-3" style="margin-top: -20px;">
                    <button class="minus-btn btn-danger" type="button" id="btn_minus" name="button" onclick="Plus_fn('minus')">
                        <ion-icon name="remove-outline" style="margin-top: 6px;"></ion-icon>
                    </button>
                    <input type="text" autocomplete="off" value="1" class="order_list_pro_qty" id="order_list_pro_qty" name="order_list_pro_qty" value="1" onkeyup="Plus_fn('qtyAll')" onmouseout="Plus_fn('qtyAll')" onmousemove="Plus_fn('qtyAll')">
                    <button class="plus-btn btn-success" type="button" name="button" id="btn_plus" onclick="Plus_fn('plus')">
                        <ion-icon name="add-outline" style="margin-top: 6px;"></ion-icon>
                    </button>
                </div>

                <h5 class="card-title" style="margin-top: -5px;">ໝາຍເຫດ</h5>
                <div class="form-group boxed" style="margin-top: -10px;">
                    <div class="input-wrapper">
                        <input type="text" class="form-control input_color" autocomplete="off" name="order_list_note_remark" id="order_list_note_remark" placeholder="ໝາຍເຫດ">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>

                <h5 class="card-title mt-2">ຂະໜາດ</h5>
                <div class="row">
                    <?php
                    $sql_detail_pos = $db->fn_read_all("view_product_list
                    WHERE pro_detail_product_fk='" . $sql_detail["product_code"] . "' AND pro_detail_open='2' ORDER BY pro_detail_size_fk ASC ");
                    foreach ($sql_detail_pos as $row_detail_pos) {
                        if ($row_detail_pos["pro_detail_code"] == $sql_detail["pro_detail_code"]) {
                            $bgColor = "#fff3dd;";
                        } else {
                            $bgColor = "";
                        }
                    ?>
                        <div class="col-4">
                            <div class="alert alert-outline-danger mb-1 outline1 text-dark" role="alert" style="text-align:center;cursor:pointer;background:<?php echo $bgColor; ?>;" id="size<?php echo $row_detail_pos["pro_detail_code"]; ?>" name="size" onclick="fnChangePrice('<?php echo $row_detail_pos['pro_detail_code']; ?>','<?php echo $row_detail_pos['product_cut_stock']; ?>','1','<?php echo $row_detail_pos['pro_detail_qty'] ?>')">
                                <?php echo $row_detail_pos["unite_name"]; ?><?php echo $row_detail_pos["size_name_la"]; ?>
                                <br>
                                <?php echo @number_format($row_detail_pos["pro_detail_sprice"]); ?> ₭

                            </div>
                        </div>
                    <?php } ?>
                </div>

                <button type="submit" class="btn btn-danger btn-lg btn-block fixed-bottom square" style="width:100%;height:50px;"><ion-icon name="checkmark-outline"></ion-icon> ຢືນຢັນອໍເດີ</button>
                <br><br><br>
            </div>
        </div>
    <?php } else {
        $sql_detail = $db->fn_fetch_single_all("view_promotion
        WHERE product_code='" . $_POST["modal_products"] . "' AND product_branch='" . $_SESSION["user_branch"] . "' 
        AND pro_detail_open='2' AND pro_detail_qty>=promo_qty_total ORDER BY pro_detail_code ASC LIMIT 1");

        if (@$sql_detail["product_images"] != "") {
            @$images_detail = '../assets/img/product_home/' . $sql_detail["product_images"];
        } else {
            @$images_detail = '../assets/img/logo/259987.png';
        }
    ?>

        <input type="text" hidden class="txtDetailCode" id="txtDetailCode" name="txtDetailCode" value="<?php echo $sql_detail['pro_detail_code'] ?>">
        <input type="text" hidden class="txtCutStock" id="txtCutStock" name="txtCutStock" value="<?php echo $sql_detail['product_cut_stock'] ?>">
        <input type="text" hidden class="txtUnite" id="txtUnite" name="txtUnite" value="<?php echo $sql_detail['unite_name'] ?>">
        <input type="text" hidden class="txtQty" id="txtQty" name="txtQty" value="<?php echo $sql_detail['promo_qty_total'] ?>">
        <input type="text" hidden class="txtPrice" id="txtPrice" name="txtPrice" value="<?php echo $sql_detail['pro_detail_sprice'] ?>">
        <input type="text" hidden class="txtCate" id="txtCate" name="txtCate" value="Promotion_11">
        <input type="text" hidden class="txtStatusPro" id="txtStatusPro" name="txtStatusPro" value="2">
        <input type="text" hidden class="txtProJing2" id="txtProJing2" name="txtProJing" value="<?php echo $sql_detail['promo_qty'] ?>">
        <input type="text" hidden class="txtGifDefault2" id="txtGifDefault2" name="txtGifDefault" value="<?php echo $sql_detail['promo_gif_qty'] ?>">
        <input type="text" hidden class="txtProGif2" id="txtProGif2" name="txtProGif" value="<?php echo $sql_detail['promo_gif_qty'] ?>">
        <input type="text" hidden class="start_qty2" id="start_qty2" name="start_qty" value="<?php echo $sql_detail['promo_qty'] ?>">
        <input type="text" hidden class="stock_qty2" id="stock_qty2" name="stock_qty2" value="<?php echo $sql_detail['pro_detail_qty'] ?>">

        <div class="card border-0">
            <img src="<?php echo $images_detail; ?>" class="card-img-top" alt="image">
            <div class="card-body">
                <h5 class="card-title"><?php echo @$sql_detail["product_name"]; ?></h5>
                <p class="card-text text-primary">
                    ລາຄາ : <span class="badge bg-dark"><span id="title_price"><?php echo @number_format(@$sql_detail["pro_detail_sprice"]); ?></span> ກີບ</span>
                </p>

                <div class="quantity mb-3" style="margin-top: -20px;">
                    <button class="minus-btn btn-danger" type="button" id="btn_minus" name="button" onclick="Plus_fn('minus')">
                        <ion-icon name="remove-outline" style="margin-top: 6px;"></ion-icon>
                    </button>
                    <input type="text" autocomplete="off" value="<?php echo @$sql_detail['promo_qty'] ?>" readonly class="order_list_pro_qty order_list_pro_qty2" id="order_list_pro_qty" name="order_list_pro_qty" value="1" onkeyup="Plus_fn('qtyAll')" onmouseout="Plus_fn('qtyAll')" onmousemove="Plus_fn('qtyAll')">
                    <button class="plus-btn btn-success" type="button" name="button" id="btn_plus" onclick="Plus_fn('plus')">
                        <ion-icon name="add-outline" style="margin-top: 6px;"></ion-icon>
                    </button>
                </div>

                <h5 class="card-title" style="margin-top: -5px;">ໝາຍເຫດ</h5>
                <div class="form-group boxed" style="margin-top: -10px;">
                    <div class="input-wrapper">
                        <input type="text" class="form-control input_color" autocomplete="off" name="order_list_note_remark" id="order_list_note_remark" placeholder="ໝາຍເຫດ">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>

                <h5 class="card-title mt-2">ຂະໜາດ</h5>
                <div class="row">
                    <?php
                    $sql_detail_pos = $db->fn_read_all("view_promotion
                        WHERE pro_detail_product_fk='" . @$sql_detail["product_code"] . "' AND pro_detail_open='2' ORDER BY pro_detail_size_fk ASC ");
                    foreach ($sql_detail_pos as $row_detail_pos) {
                        if (@$row_detail_pos["pro_detail_code"] == @$sql_detail["pro_detail_code"]) {
                            $bgColor = "#fff3dd;";
                        } else {
                            $bgColor = "";
                        }

                        if ($row_detail_pos['pro_detail_qty'] >= $row_detail_pos["promo_qty_total"]) {
                            $hidenRadios = "";
                        } else {
                            $hidenRadios = "hidden";
                        }

                    ?>
                        <div class="col-4" <?php echo $hidenRadios ?>>
                            <div class="alert alert-outline-danger mb-1 outline1 text-dark" role="alert" style="text-align:center;cursor:pointer;background:<?php echo $bgColor; ?>;" id="size<?php echo $row_detail_pos["pro_detail_code"]; ?>" name="size" onclick="fnChangePrice('<?php echo $row_detail_pos['pro_detail_code']; ?>','<?php echo $row_detail_pos['product_cut_stock']; ?>','<?php echo $row_detail_pos['promo_qty'] ?>','<?php echo $row_detail_pos['promo_gif_qty'] ?>','<?php echo $row_detail_pos['pro_detail_qty'] ?>')">
                                <?php echo @$row_detail_pos["unite_name"]; ?><?php echo @$row_detail_pos["size_name_la"]; ?>
                                <br>
                                <?php echo @number_format(@$row_detail_pos["pro_detail_sprice"]); ?> ₭
                                <br>
                                ຊື້ <?php echo @number_format(@$row_detail_pos["promo_qty"]); ?>
                                ແຖມ <?php echo @number_format(@$row_detail_pos["promo_gif_qty"]); ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <button type="submit" class="btn btn-danger btn-lg btn-block fixed-bottom square" style="width:100%;height:50px;"><ion-icon name="checkmark-outline"></ion-icon> ຢືນຢັນອໍເດີ</button>
                <br><br><br>
            </div>
        </div>
    <?php }
}
if (isset($_GET["count_modal"])) {
    $sql_count = $db->fn_fetch_rowcount("view_orders WHERE order_list_bill_fk='" . $_POST["bill_no"] . "' AND order_list_status_order='1'");
    echo json_encode($sql_count);
}

if (isset($_GET["loadBill_detail"])) {
    $bill_no=$_POST["bill_no"];
    $table_no=$_POST["table_no"];
    $sqlOrders = $db->fn_read_all("view_orders WHERE order_list_bill_fk='" .  $bill_no . "' 
    AND order_list_table_fk='" . $table_no . "' ORDER BY order_list_code DESC");
    $buttonDisble = $db->fn_fetch_single_all("res_orders_list WHERE order_list_bill_fk='" .  $bill_no . "' AND order_list_status_order='1'");
    if ($buttonDisble > 0) {
        $disableds = "";
        $changeBg = "mydiv";
        $iconSpin = "<i class='fa fa-spinner fa-spin fa-fw fa-lg'></i>";
    } else {
        $disableds = "disabled";
        $changeBg = "";
        $iconSpin = "<i class='fa fa-check fa-fw fa-lg'></i>";
    }

    ?>
    <ul class="listview flush transparent simple-listview no-space mt-3">
        <li>
            <h3 class="m-0">ລາຍການສິນຄ້າ</h3>
            <span class="text-success">ລວມຍອດ</span>
        </li>
        <?php
        if (count($sqlOrders) > 0) {
            foreach ($sqlOrders as $rowOrders) {
                if ($rowOrders["product_images"] != "") {
                    $images = '../assets/img/product_home/' . $rowOrders["product_images"];
                } else {
                    $images = '../assets/img/logo/259987.png';
                }

                if ($rowOrders["order_list_status_order"] == "1" || $rowOrders["order_list_status_order"] == "2") {

                    $disabledDelete = "disabled";
                    $disabledConfirm = "";
                } else {

                    $disabledDelete = "";
                    $disabledConfirm = "disabled";
                }
                @$amount1 += $rowOrders["order_list_discount_total"];
                @$sumQty += $rowOrders["order_list_order_qty"];
                @$sumpercented += $rowOrders["order_list_discount_price"];
                @$gif_total += $rowOrders["order_list_qty_promotion_gif_total"];
        ?>
                <li>
                    <strong>
                        <center><img src="<?php echo $images; ?>" alt="img" class="image-block imaged w86 mb-1"></center>
                        <?php
                        if ($rowOrders["order_list_status_order"] == "1" || $rowOrders["order_list_status_order"] == "2") {
                        ?>
                            <div class="desc">

                                <select name="plusQty" id="plusQty<?php echo $rowOrders['order_list_code'] ?>" <?php echo $disabledConfirm ?> onchange="fnPlusQty('<?php echo $rowOrders['order_list_code'] ?>','<?php echo $rowOrders['product_cut_stock'] ?>','<?php echo $rowOrders['pro_detail_sprice'] ?>','plus','<?php echo $rowOrders['order_list_pro_code_fk'] ?>','<?php echo $rowOrders['order_list_discount_price'] ?>','<?php echo $rowOrders['order_list_qty_promotion_gif'] ?>','<?php echo $rowOrders['order_list_qty_promotion_gif_total'] ?>')">
                                    <option value="">﹢</option>
                                    <?php
                                    if ($rowOrders["product_cut_stock"] == "1") {
                                        for ($i = 1; $i <= 20; $i++) {
                                            echo "<option value='" . $i . "'>" . $i . "</option>";
                                        }
                                    } else {
                                        if ($rowOrders["order_list_status_promotion"] == "1") {
                                            if (@$rowOrders["pro_detail_qty"] >= 100) {
                                                @$orderLimit = "100";
                                            } else {
                                                @$orderLimit = $rowOrders["pro_detail_qty"];
                                            }
                                            for ($i = 1; $i <= @$orderLimit; $i++) {
                                                echo "<option value='" . $i . "'>" . $i . "</option>";
                                            }
                                        } else {
                                            echo "<option value='" . $rowOrders["order_list_qty_promotion_all"] . "'>+" . $rowOrders["order_list_qty_promotion_all"] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <select name="minusQty" id="minusQty<?php echo $rowOrders['order_list_code'] ?>" <?php echo $disabledConfirm ?> onchange="fnPlusQty('<?php echo $rowOrders['order_list_code'] ?>','<?php echo $rowOrders['product_cut_stock'] ?>','<?php echo $rowOrders['pro_detail_sprice'] ?>','minus','<?php echo $rowOrders['order_list_pro_code_fk'] ?>','<?php echo $rowOrders['order_list_discount_price'] ?>','<?php echo $rowOrders['order_list_qty_promotion_gif'] ?>','<?php echo $rowOrders['order_list_qty_promotion_gif_total'] ?>')">
                                    <option value="">﹣</option>
                                    <?php
                                    $totalQty = $rowOrders["order_list_order_qty"] - 1;
                                    if ($rowOrders["product_cut_stock"] == "1") {
                                        for ($i = 1; $i <= ($totalQty); $i++) {
                                            echo "<option value='" . $i . "'>" . $i . "</option>";
                                        }
                                    } else {
                                        if ($rowOrders["order_list_status_promotion"] == "1") {
                                            for ($i = 1; $i <= ($totalQty); $i++) {
                                                echo "<option value='" . $i . "'>" . $i . "</option>";
                                            }
                                        } else {
                                            // $plusLimit=$rowOrders["order_list_order_qty"]-$rowOrders["order_list_qty_promotion_all"];
                                            // for ($i = $rowOrders["order_list_qty_promotion_all"]; $i <= @$plusLimit; $i+=$rowOrders["order_list_qty_promotion_all"]) {
                                            //     echo "<option value='" . $i. "'>" . $i."</option>";
                                            // }
                                            if ($rowOrders["order_list_qty_promotion_gif"] != $rowOrders["order_list_qty_promotion_gif_total"]) {
                                                echo "<option value='" . $rowOrders["order_list_qty_promotion_all"] . "'>-" . $rowOrders["order_list_qty_promotion_all"] . "</option>";
                                            } else {
                                                echo "";
                                            }
                                        }
                                    }
                                    ?>
                                </select>


                            </div>
                        <?php } ?>
                    </strong>
                    <strong class="text-right text-primary">
                        <span style="float: right !important;">
                            <?php echo $rowOrders["product_name"] ?>
                            <?php if ($rowOrders["unite_name"] == "202200001") {
                                echo "";
                            } else {
                                echo $rowOrders["size_name_la"];
                            } ?>

                            <?php
                            if ($rowOrders["order_list_status_promotion"] == "2") {
                                echo "<span class='text-danger' style='font-size:10px'> ( * ໂປຣ ) </span>";
                            }
                            ?>
                        </span>
                        <br>
                        <span style="float: right !important;">
                            <?php
                            if ($rowOrders["order_list_status_promotion"] == "1") {
                            ?>
                                <div class="price text-dark" style="font-family:'Times New Roman', Times, serif">
                                    [ <?php echo $rowOrders["order_list_order_qty"] ?> &nbsp;x &nbsp; <?php echo @number_format($rowOrders["pro_detail_sprice"]) ?> ]
                                    =
                                    <?php
                                    if ($rowOrders["order_list_discount_status"] == "2") {
                                        echo "<s class='text-danger'>" . @number_format($rowOrders["order_list_order_total"]) . "<span class='laoFont'> ກີບ</span>" . "</span><br>" . @number_format($rowOrders["order_list_discount_total"]) . " <span class='laoFont'>ກີບ</span>";
                                    } else {
                                        echo @number_format($rowOrders["order_list_discount_total"]) . " <span class='laoFont'>ກີບ</span>";
                                    }
                                    ?>
                                </div>
                            <?php } else { ?>
                                <div class="price text-dark">
                                    <span class="text-dark">[
                                        ແຖມ <?php echo $rowOrders["order_list_qty_promotion_gif_total"] ?> ]
                                    </span>
                                    [ <?php echo $rowOrders["order_list_order_qty"] ?>
                                    &nbsp;x &nbsp;
                                    <?php echo @number_format($rowOrders["pro_detail_sprice"]) ?> ]
                                    =
                                    <?php
                                    if ($rowOrders["order_list_discount_status"] == "2") {
                                        echo "<s class='text-dark'>" . @number_format($rowOrders["order_list_order_total"]) . "<span class='laoFont'> ກີບ</span>" . "</s><br>" . @number_format($rowOrders["order_list_discount_total"]) . " <span class='laoFont'>ກີບ</span>";
                                    } else {
                                        echo @number_format($rowOrders["order_list_discount_total"]) . " <span class='laoFont'>ກີບ</span>";
                                    }
                                    ?>
                                </div>
                            <?php } ?>

                            <div class="desc" style="float: right !important;">ໝາຍເຫດ :<span class="text-dark"><u> <?php echo $rowOrders["order_list_note_remark"] ?></u></span></div>
                            <br>
                            <span style="float: right !important;text-align:right !important" class="mt-1">
                                <?php
                                if ($rowOrders["order_list_status_order"] == "1" || $rowOrders["order_list_status_order"] == "2") {
                                    if ($rowOrders["product_cut_stock"] == "1") {
                                        $cateDelete = $rowOrders['product_cate_fk'];
                                    } else {
                                        $cateDelete = "Promotion_11";
                                    }
                                ?>
                                    <button type="button" class="btn bg-danger btn-icon btn-info" onclick="fnDeleteOrder('<?php echo $rowOrders['order_list_table_fk'] ?>','<?php echo $rowOrders['order_list_bill_fk'] ?>','<?php echo $rowOrders['order_list_code'] ?>','<?php echo $rowOrders['order_list_pro_code_fk'] ?>','<?php echo $rowOrders['order_list_order_qty'] ?>','<?php echo $rowOrders['product_cut_stock'] ?>','<?php echo $cateDelete; ?>','<?php echo $rowOrders['order_list_qty_promotion_gif_total'] ?>')" style="border:none">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </button>
                                <?php } else { ?>
                                    <ion-icon name="checkmark-circle-outline" style="font-size: 30px;"></ion-icon>
                                <?php }?>

                            </span>
                        </span>


                    </strong>


                </li>
            <?php }?>
            <?php
                @$subAmount += (int)substr($amount1, -3);
                if (@$subAmount == "0") {
                    @$subTotal = (@$amount1);
                } else {
                    @$subTotal = ($amount1 - $subAmount) + 1000;
                }
            ?>
            <li>
                <h3 class="m-0">ລວມມູນຄ່າ:</h3>
                <h3 class="m-0"><?php echo @number_format($subTotal) ?>₭ </h3>
                <input type="text" hidden value="<?php echo ($subTotal) ?>" id="price_total" name="price_total">
                <input type="text" hidden id="sumQty" name="sumQty" value="<?php echo $sumQty; ?>">
                <input type="text" hidden name="countOrder" id="countOrder" value="<?php echo count($sqlOrders); ?>">
                <input type="text" hidden id="sumlistTotal" name="sumlistTotal" value="<?php echo $subTotal1; ?>">
                <input type="text" hidden id="sumGifTotal" name="sumGifTotal" value="<?php echo $gif_total; ?>">
            </li>
        <?php } else { ?>
            <center>
                <div class="col-md-12 pt-4">
                    <br><br><br>
                    <ion-icon name="trash-outline" class="text-danger" style="font-size:30px;"></ion-icon><br>
                    Emty
                </div>
            </center>
        <?php } ?>
        
    </ul>
<?php } ?>