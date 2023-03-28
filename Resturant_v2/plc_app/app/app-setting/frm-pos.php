<?php
include_once('component/app_packget.php');
$packget = new packget();
$db = new DBConnection();

@$table_id = base64_decode($_GET["table_id"]);
$sqlCount = $db->fn_fetch_rowcount("res_bill WHERE bill_table='" . $table_id . "' AND bill_status='1' AND bill_branch='" . $_SESSION["user_branch"] . "' ");
if ($sqlCount == 0) {
    $auto_number = $db->fn_autonumber("bill_code", "res_bill");
    $sql = "'" . $auto_number . "','" . $table_id . "','" . $_SESSION["user_branch"] . "','1'";
    $insertBill = $db->fn_insert("res_bill", $sql);
}
$table_name = $db->fn_fetch_single_all("res_tables WHERE table_code='" . $table_id . "' ");
$billName = $db->fn_fetch_single_all("res_bill WHERE bill_table='" . $table_id . "' AND bill_status='1' ");
?>
<!doctype html>
<html lang="en">

<head>
    <?php $packget->app_css(); ?>
    <style>
        /* Product Quantity */
        .quantity {
            padding-top: 20px;
            margin-right: 60px;
        }

        .quantity input {
            /* -webkit-appearance: none; */
            border: none;
            text-align: center;
            width: 32px;
            font-size: 16px;
            color: #43484D;
            font-weight: 300;
        }

        button[class*=btn] {
            width: 30px;
            height: 30px;
            background-color: #E1E8EE;
            border-radius: 6px;
            border: none;
            cursor: pointer;
        }

        .minus-btn img {
            margin-bottom: 3px;
        }

        .plus-btn img {
            margin-top: 2px;
        }

        button:focus,
        input:focus {
            outline: 0;
        }

        /* Total Price */
        .total-price {
            width: 83px;
            padding-top: 27px;
            text-align: center;
            font-size: 16px;
            color: #43484D;
            font-weight: 300;
        }
    </style>
</head>

<body>
    <?php $packget->app_loading(); ?>
    <div class="appHeader text-light" style="background-color:#fd5900;border-bottom: 1px solid #fd5900;">
        <div class="left">
            <a href="?home" class="headerButton text-light">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle mt-2">
            <h2 class="text-light" style="font-size:30px;text-shadow: 1px 1px 2px black;font-family:LAOS_Bold">
                <b>ເບີໂຕະ <span style="font-family:'Times New Roman', Times, serif;"><?php echo @$table_name["table_name"]; ?></span></b>
            </h2>
        </div>
        <div class="right" style="cursor: pointer;">
            <a href="?bill_detail&bill_no=<?php echo base64_encode(@$billName["bill_code"])?>&table_name=<?php echo base64_encode(@$table_name["table_name"])?>&table_id=<?php echo base64_encode(@$table_id)?>" class="headerButton">
                <ion-icon class="icon" name="notifications-outline"></ion-icon>
                <span class="badge badge-dark" id="count_notification">0</span>
            </a>
        </div>
    </div>
    <div id="appCapsule">
        <div class="carousel-multiple splide" style="background-color: #FD5900 !important;">
            <div class="splide__track">
                <ul class="splide__list">
                    <li class="splide__slide" id="" onclick="load_category('')" style="cursor:pointer">
                        <a href="#">
                            <div class="user-card">
                                <ion-icon name="fast-food-outline" style="font-size:40px !important;color:black"></ion-icon>
                                <strong>ທັງໝົດ</strong>
                            </div>
                        </a>
                    </li>

                    <?php
                    $check_promotion = $db->fn_fetch_single_all("res_promotion WHERE promo_status='1' ");
                    if ($check_promotion) {
                    ?>
                        <li class="splide__slide Promotion_11" id="Promotion_11" onclick="load_category('Promotion_11')" style="cursor:pointer">
                            <a href="#">
                                <div class="user-card">
                                    <ion-icon name="gift-outline" style="font-size:40px !important;color:black"></ion-icon>
                                    <strong>ໂປຣໂມຊັນ</strong>
                                </div>
                            </a>
                        </li>

                    <?php } ?>


                    <?php
                    $sql_group = $db->fn_read_all("res_category");
                    foreach ($sql_group as $row_grou) {
                    ?>

                        <li class="splide__slide" id="<?php echo $row_grou['cate_code']; ?>" onclick="load_category('<?php echo $row_grou['cate_code']; ?>')" style="cursor:pointer">
                            <a href="#">
                                <div class="user-card">
                                    <ion-icon name="fast-food-outline" style="font-size:40px !important;color:black"></ion-icon>
                                    <strong><?php echo $row_grou["cate_name"]; ?></strong>
                                </div>
                            </a>
                        </li>

                    <?php } ?>



                    <input type="text" hidden name="table_no" id="table_no" value="<?php echo @$table_id; ?>">
                    <input type="text" hidden name="table_name_list" id="table_name_list" value="<?php echo @$table_name["table_name"]; ?>">
                    <input type="text" hidden name="bill_no" id="bill_no" value="<?php echo @$billName["bill_code"]; ?>">
                </ul>
            </div>
        </div>


        <div class="section mt-3 px-1 mb-4">
            <div class="session_grid px-0 product_menu" id="product_menu">

            </div>
        </div>

    </div>


    <div id="toast-9" class="toast-box toast-center">
        <div class="in">
            <ion-icon name="checkmark-circle" class="text-success"></ion-icon>
            <div class="text">
                ເພີ່ມລາຍການສໍາເລັດ
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-text-light close-button btn-danger"> ປິດ</button>
    </div>

    <div class="modal fade modalbox" id="modal_product_item" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form id="addOrder">
                <input type="text" hidden name="table_no" id="table_no" value="<?php echo @$table_id; ?>">
                <input type="text" hidden name="table_name_list" id="table_name_list" value="<?php echo @$table_name["table_name"]; ?>">
                <input type="text" hidden name="bill_no" id="bill_no" value="<?php echo @$billName["bill_code"]; ?>">
                <div class="modal-content">
                    <div class="modal-header">
                        <a href="#" data-bs-dismiss="modal"><ion-icon name="chevron-back-outline" style="font-size: 20px;"></ion-icon></a>
                        <h5 class="modal-title">ລາຍລະອຽດ</h5>
                    </div>
                    <div class="modal-body full modal_detail">

                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade dialogbox" id="Error_modal_stock" data-bs-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-icon text-white">
                    <ion-icon name="checkmark-circle"></ion-icon>
                </div>
                <div class="modal-header">
                    <h5 class="modal-title text-white">ແຈ້ງເຕືອນ</h5>
                </div>
                <div class="modal-body text-white">
                    ເຄື່ອງດຶ່ມໃນສະຕ໋ອກຄົງເຫຼືອ <span class="notify_stock"></span>
                </div>
                <div class="modal-footer">
                    <div class="btn-inline bg-dark">
                        <a href="#" class="btn text-danger" data-bs-dismiss="modal">ປິດໜ້າຕ່າງ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade dialogbox" id="Error_modal_out_off_stock" data-bs-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-icon text-white">
                    <ion-icon name="checkmark-circle"></ion-icon>
                </div>
                <div class="modal-header">
                    <h5 class="modal-title text-white">ແຈ້ງເຕືອນ</h5>
                </div>
                <div class="modal-body text-white">
                    ເຄື່ອງດຶ່ມໝົດແລ້ວ
                </div>
                <div class="modal-footer">
                    <div class="btn-inline bg-dark">
                        <a href="#" class="btn text-danger" data-bs-dismiss="modal">ປິດໜ້າຕ່າງ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade dialogbox" id="Error_modal_free" data-bs-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-icon text-white">
                    <ion-icon name="checkmark-circle"></ion-icon>
                </div>
                <div class="modal-header">
                    <h5 class="modal-title text-white">ແຈ້ງເຕືອນ</h5>
                </div>
                <div class="modal-body text-white">
                    ເຄື່ອງດຶ່ມບໍ່ພໍຂາຍ+ແຖມ
                </div>
                <div class="modal-footer">
                    <div class="btn-inline bg-dark">
                        <a href="#" class="btn text-danger" data-bs-dismiss="modal">ປິດໜ້າຕ່າງ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    

    <?php $packget->app_script(); ?>
    <script>
        load_category('');

        function load_category(cate_item) {
            $.ajax({
                url: "service/sql/service-all.php?product_list",
                method: "POST",
                data: {
                    cate_item
                },
                success: function(data) {
                    $(".product_menu").html(data)
                }
            })
        }

        function function_addModal(modal_products, status_check_gif) {
            $.ajax({
                url: "service/sql/service-all.php?product_modal",
                method: "POST",
                data: {
                    modal_products,
                    status_check_gif
                },
                success: function(data) {
                    $("#modal_product_item").modal("show");
                    $(".modal_detail").html(data);
                }
            })
        }

        function Plus_fn(dataInput) {
            var convertProQty = $(".order_list_pro_qty").val();
            var order_list_pro_qty = Number(convertProQty.replace(/[^0-9\.-]+/g, ""));
            var txtDetailCode = $(".txtDetailCode").val();
            var txtCutStock = $(".txtCutStock").val();
            var txtUnite = $(".txtUnite").val();
            var txtQty = $(".txtQty").val();
            var txtStatusPro = $(".txtStatusPro").val();

            if (txtStatusPro === "1") {
                var stock_qty2 = $(".stock_qty1").val();
                start_qty = Number($(".start_qty1").val().replace(/[^0-9\.-]+/g, ""));
                var txtProJing1 = $(".txtProJing1").val();
                var txtGifDefault = $(".txtGifDefault1").val();
                txtProGif = parseFloat(txtGifDefault) + parseFloat(txtProJing1);
                $(".txtProGif1").val(txtProGif);
                totalQty_check = order_list_pro_qty;
            } else {
                var stock_qty2 = $(".stock_qty2").val();
                start_qty = Number($(".start_qty2").val().replace(/[^0-9\.-]+/g, ""));
                var txtProJing2 = $(".txtProJing2").val();
                var txtGifDefault = $(".txtGifDefault2").val();
                var gifPro = $(".txtProGif2").val();

                if (dataInput === "plus") {
                    txtProGif = parseFloat(txtGifDefault) + parseFloat(gifPro);
                    $(".txtProGif2").val(txtProGif);
                    totalQty_check = parseFloat(order_list_pro_qty) + parseFloat(gifPro);
                } else if (dataInput === "minus") {
                    if (gifPro === txtGifDefault) {
                        $(".txtProGif2").val(txtGifDefault);
                    } else {
                        txtProGif = parseFloat(gifPro) - parseFloat(txtGifDefault);
                        $(".txtProGif2").val(txtProGif);
                    }
                    totalQty_check = parseFloat(order_list_pro_qty) - parseFloat(gifPro);
                }
            }


            if (txtCutStock === "1") {
                if (dataInput === "plus") {
                    plus_total = parseFloat(order_list_pro_qty + start_qty);
                    $('.order_list_pro_qty').val(numeral(plus_total).format('0,000'));
                } else if (dataInput === "minus") {
                    if (order_list_pro_qty != "1") {
                        plus_total = parseFloat(order_list_pro_qty - start_qty);
                        $('.order_list_pro_qty').val(numeral(plus_total).format('0,000'));
                    } else {
                        $('.order_list_pro_qty').val(numeral(start_qty).format('0,000'));
                    }

                } else if (dataInput === "qtyAll") {
                    if (order_list_pro_qty != "0") {
                        $('.order_list_pro_qty').val(numeral(order_list_pro_qty).format('0,000'));
                    } else {
                        $('.order_list_pro_qty').val(numeral(start_qty).format('0,000'));
                    }
                }
            } else {
                $.ajax({
                    url: "../services/sql/service-pos.php?changeQty",
                    method: "POST",
                    data: {
                        txtDetailCode,
                        order_list_pro_qty,
                        txtCutStock,
                        dataInput,
                        start_qty,
                        txtProGif,
                        txtStatusPro,
                        totalQty_check,
                        txtGifDefault,
                        stock_qty2
                    },
                    success: function(data) {
                        var dataResult = JSON.parse(data);
                        if (dataResult.statusCode === 201) {
                            $('.order_list_pro_qty').val(numeral(dataResult.qtyStock).format('0,000'));
                            $("#Error_modal_stock").modal("show");
                            $(".notify_stock").html(+dataResult.qtyStock + " " + txtUnite);
                        } else if (dataResult.statusCode === 202) {
                            $("#Error_modal_out_off_stock").modal("show");
                        } else if (dataResult.statusCode === 203) {
                            $('.order_list_pro_qty').val(numeral(dataResult.qtyStock).format('0,000'));
                            $('.txtProGif2').val(dataResult.qtyAmount);
                            $("#Error_modal_free").modal("show");
                        } else {
                            if (dataResult.statusCode != "0") {
                                $('.order_list_pro_qty').val(numeral(dataResult.statusCode).format('0,000'));
                            } else {
                                $('.order_list_pro_qty').val(numeral(start_qty).format('0,000'));
                            }
                        }
                    }
                })
            }
        }

        function fnChangePrice(pro_detail_code, product_cut_stock, txtStatusPro, txtgif, stockQty) {
            if (txtStatusPro === "1") {
                start_qty = "1";
                start_gif = "0";
                $("#txtProGif").val("0");
                $("#txtProJing1").val("0");
                $("#txtGifDefault2").val("0");
                $(".stock_qty2").val("0");
            } else {
                start_qty = txtStatusPro;
                $("#txtProGif2").val(txtgif);
                $("#txtGifDefault2").val(txtgif);
                $("#txtProJing2").val(start_qty);
                $(".stock_qty2").val(stockQty);
            }

            $(".outline1").css("background-color", "");
            $("#size" + pro_detail_code).css("background-color", "#fff3dd");

            $.ajax({
                url: "../services/sql/service-pos.php?changePrice",
                method: "POST",
                data: {
                    pro_detail_code
                },
                dataType: "json",
                success: function(data) {
                    $("#order_list_pro_qty").val(start_qty);
                    $("#start_qty2").val(start_qty);
                    $("#txtQty").val();
                    $("#txtDetailCode").val(data.pro_detail_code);
                    $("#txtCutStock").val(data.product_cut_stock);
                    $("#txtQty").val(data.pro_detail_qty);
                    $("#txtPrice").val(data.pro_detail_sprice);
                    $("#title_price").text(numeral(data.pro_detail_sprice).format('0,000'));
                }
            })
        }
        Count_Orders()
        function Count_Orders(){
            var bill_no=$("#bill_no").val();
            $.ajax({
                url: "service/sql/service-all.php?count_modal",
                method: "POST",
                data:{bill_no},
                dataType:"json",
                success:function(data){
                    if(data>0){
                        $("#count_notification").html(data);
                    }else{
                        $("#count_notification").html("0");
                    }
                }
            });
        }

        $("#addOrder").on("submit", function(event) {
            event.preventDefault();
            $.ajax({
                url: "../services/sql/service-pos.php?addProduct",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(data) {
                    Count_Orders();
                    var dataResult = JSON.parse(data);
                    if (dataResult.statusCode == 200) {
                        $("#modal_product_item").modal("hide");
                        toastbox('toast-9',2000)
                        // successfuly("ເພີ່ມສໍາເລັດແລ້ວ");
                        // load_orders();
                        // load_category(dataResult.Cate)
                    } else if (dataResult.statusCode == 300) {
                        $("#modal_product_item").modal("hide");
                        // successfuly("ສັ່ງເພີ່ມສໍາເລັດ");
                        // load_orders();
                        toastbox('toast-9',2000)
                        // load_category(dataResult.Cate);
                        commitOrders(2);
                    } else {
                        // ErrorFuntion("ສິນຄ້າໃນສະຕ໋ອກໝົດແລ້ວ");
                        loadContent(1)
                    }
                }
            })
        });

        

    </script>

</body>

</html>