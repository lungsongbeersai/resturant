<?php
include_once('component/app_packget.php');
$packget = new packget();
$db = new DBConnection();

@$bill_no = base64_decode($_GET["bill_no"]);
@$table_id = base64_decode($_GET["table_id"]);
@$table_name = base64_decode($_GET["table_name"]);


?>
<!doctype html>
<html lang="en">

<head>
    <?php $packget->app_css(); ?>
    <style>
        .laoFont{
            font-family: LAOS !important;
        }
    </style>
</head>

<body class="bg-white">
    <?php $packget->app_loading(); ?>
    <div class="appHeader text-light" style="background-color:#fd5900;border-bottom: 1px solid #fd5900;">
        <div class="left">
            <a href="?pos&table_id=<?php echo base64_encode($table_id); ?>" class="headerButton goBack text-light">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle mt-2">
            <h2 class="text-light" style="font-size:30px;text-shadow: 1px 1px 2px black;font-family:LAOS_Bold">
                <b>ເບີໂຕະ <span style="font-family:'Times New Roman', Times, serif;"><?php echo $table_name; ?></span></b>
            </h2>
        </div>
        <div class="right" id="confirm_orders" style="cursor: pointer;">
            <ion-icon name="print"></ion-icon>
        </div>
    </div>
    <div id="appCapsule">
        <div class="section mt-2 mb-2">
            <div class="listed-detail mt-2">
                <div class="icon-wrapper">
                    <div class="iconbox">
                        <img src="../assets/img/logo/002.png" alt="img" class="image-block imaged w100">
                    </div>
                </div>
                <h2 class="text-center mt-1">ລາຍການສັ່ງອາຫານ</h2>
            </div>

            <div class="listed-detail mt-2">
                <div class="left">
                    <h3 class="title">ໂຕະເບີ : <span class="font_Bold"><?php echo @$table_name ?></span></h3>
                </div>

                <div class="right">
                    <h4 class="title">ເລກບິນ : <?php echo @$bill_no ?> ວັນທີ:<?php echo date("d/m/Y", strtotime(date("Y-m-d"))) ?></h4>
                </div>

                <?php
                    @$sqlCount_sound = $db->fn_fetch_single_field("count(case when order_list_status='1' AND order_list_sound_notify='1' then 1 end) as count_cook,
                    count(case when order_list_status='2' AND order_list_sound_notify='1' then 1 end) as count_drink", "res_orders_list 
                    WHERE order_list_bill_fk='" . $bill_no . "' AND order_list_sound_notify='1'");
                ?>
                <input type="text" id="bill_no" hidden value="<?php echo $bill_no ?>">
                <input type="text" id="table_no" hidden value="<?php echo @$table_id ?>">
                <input type="text" id="sum_cook" hidden value="<?php echo @$sqlCount_sound["count_cook"] ?>">
                <input type="text" id="sum_drink" hidden value="<?php echo @$sqlCount_sound["count_drink"] ?>">
            </div>

            <div id="BList">
                

            </div>

        </div>
    </div>
    <?php $packget->app_script(); ?>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vaafb692b2aea4879b33c060e79fe94621666317369993" integrity="sha512-0ahDYl866UMhKuYcW078ScMalXqtFJggm7TmlUtp0UlD4eQk0Ixfnm5ykXKvGJNFjLMoortdseTfsRT8oCfgGA==" data-cf-beacon='{"rayId":"7a1e910a9e0a5d54","version":"2023.2.0","r":1,"token":"4db8c6ef997743fda032d4f73cfeff63","si":100}' crossorigin="anonymous"></script>
    <script>
        

        load_billDetail()
        function load_billDetail(){
            var bill_no=$("#bill_no").val();
            var table_no=$("#table_no").val();
            $.ajax({
                url: "service/sql/service-all.php?loadBill_detail",
                method: "POST",
                data:{bill_no,table_no},
                success: function(data) {
                    $("#BList").html(data)
                }
            })
        }

        function commitOrders(statusID) {
            var table_no = document.querySelector("#table_no").value;
            var bill_no = document.querySelector("#bill_no").value;
            var sum_cook = document.querySelector("#sum_cook").value;
            var sum_drink = document.querySelector("#sum_drink").value;
            var status = "" + statusID;
            var status_submit_edit_qty="2";
            var info = {
                table_no,
                bill_no,
                sum_cook,
                sum_drink,
                statusID,
                status_submit_edit_qty
            }
            socket.emit('order', info)
        }

        function fnPlusQty(idOrder, cutStock, price, plus, proCode, perPrice,gifQty,gifAmount) {
            if (plus === "plus") {
                var plusQty = $("#plusQty" + idOrder).val();
            } else {
                var plusQty = $("#minusQty" + idOrder).val();
            }
            $.ajax({
                url: "../services/sql/service-pos.php?changPlusQty",
                method: "POST",
                data: {
                    idOrder,
                    cutStock,
                    plusQty,
                    price,
                    plus,
                    proCode,
                    perPrice,
                    gifQty,
                    gifAmount
                },
                success: function(data) {
                    load_billDetail()
                    commitOrders();
                }
            });
        }
        

        $(document).on("click", "#confirm_orders", function() {
            var table_no = document.querySelector("#table_no").value;
            var bill_no = document.querySelector("#bill_no").value;
            var sum_cook = document.querySelector("#sum_cook").value;
            var sum_drink = document.querySelector("#sum_drink").value;
            var statusID = "1";
            var status_submit_edit_qty="1";
            var info = {
                table_no,
                bill_no,
                sum_cook,
                sum_drink,
                statusID,
                status_submit_edit_qty
            }
            $.ajax({
                url: "../services/sql/service-pos.php?editStatusTable",
                method: "POST",
                data: {
                    table_no,
                    bill_no
                },
                success: function(data) {
                    load_billDetail();
                    socket.emit('order', info)
                }
            })
        });

        function fnDeleteOrder(idTb,idBill,idOrder, idProduct, idQty, idStock, idCate,gifAmount) {
            var totalQty=parseFloat(idQty)+parseFloat(gifAmount);
            $.ajax({
                url: "../services/sql/service-pos.php?deleteOrder",
                method: "POST",
                data: {
                    idTb,
                    idBill,
                    idOrder,
                    idProduct,
                    idQty,
                    idStock,
                    gifAmount,
                    totalQty
                },
                success: function(data) {
                    var dataResult = JSON.parse(data);
                    if (dataResult.statusCode == 200) {
                        load_billDetail();
                        commitOrders(2);
                    } else {
                        Error_data();
                    }
                }
            });
        }

    </script>

    <script>
        socket.on('showTable', (response) => {
            load_billDetail();
        })
    </script>

</body>

</html>