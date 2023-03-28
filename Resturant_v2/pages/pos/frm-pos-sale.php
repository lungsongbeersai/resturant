<?php
include_once('component/main_packget_all.php');
$packget_all = new packget_all();
$db = new DBConnection();
@$table_id = base64_decode($_GET["table_id"]);
$sqlCount = $db->fn_fetch_rowcount("res_bill WHERE bill_table='" . $table_id . "' AND bill_status='1' AND bill_branch='" . $_SESSION["user_branch"] . "' ");
if ($sqlCount == 0) {
    $auto_number = $db->fnBillNumber("bill_code", "res_bill");
    $sql = "'" . $auto_number . "','" . $table_id . "','" . $_SESSION["user_branch"] . "','1'";
    $insertBill = $db->fn_insert("res_bill", $sql);
}
$table_name = $db->fn_fetch_single_all("res_tables WHERE table_code='" . $table_id . "' ");
$billName = $db->fn_fetch_single_all("res_bill WHERE bill_table='" . $table_id . "' AND bill_status='1' ");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Frm Sale</title>
    <?php $packget_all->main_css(); ?>
    <?php include("style-pos.php") ?>
    <style>
        input[readonly] {
            background-color: #EFEFEF !important;
        }
    </style>
</head>

<body class='pace-top'>
    <?php $packget_all->main_loadding(); ?>

    <div id="app" class="app app-content-full-height app-without-sidebar app-without-header bg-white">

        <div id="content" class="app-content p-0">
            <div class="pos pos-customer" id="pos-customer" style="background-color:#f4f1ef !important;">
                <div class="pos-menu" style="overflow-y:hidden !important;background:#DB4900 !important;">
                    <div class="logo">
                        <a href="?table_list">
                            <div class="logo-img"><img src="assets/img/logo/fork.png"></div>
                            <div class="logo-text text-light">ຮ້ານພີແອວຊີ</div>

                        </a>
                    </div>
                    <div class="nav-container">
                        <div data-scrollbar="true" data-height="100%" data-skip-mobile="true">
                            <ul class="nav nav-tabs">
                                <?php
                                $sql_group = $db->fn_read_all("res_category");
                                foreach ($sql_group as $row_grou) {
                                ?>
                                    <li class="nav-item">
                                        <div class="nav-link active1" id="<?php echo $row_grou['cate_code']; ?>" onclick="load_category('<?php echo $row_grou['cate_code']; ?>')" style="cursor:pointer">
                                            <i class="fa fa-fw fa-utensils me-1 ms-n2" style="font-size:25px"></i>
                                            <?php echo $row_grou["cate_name"]; ?>
                                        </div>
                                    </li>
                                <?php } ?>
                                <br>
                                <br>
                            </ul>
                        </div>
                    </div>
                    <div class="logo Promotion_11" id="Promotion_11" style="background:#030405 !important;cursor:pointer" onclick="load_category('Promotion_11')">
                        <div class="text-center">
                            <i class="fas fa-gift fa-2x text-light"></i>
                            <div class="logo-text text-light">ໂປຣໂມຊັນ</div>
                        </div>
                    </div>
                </div>


                <div class="pos-content" style="overflow:hidden">
                    <div class="pos-content-container" data-scrollbar="true" data-height="100%" data-skip-mobile="true">
                        <div class="row mb-3">
                            <div class="col-md-9">
                                <a href="?table_list" type="button" class="btn btn-danger text-light"> <i class="fas fa-arrow-circle-left"></i> ກັບຄືນ</a>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <div class="input-group-text position-absolute top-0 bottom-0 bg-none border-0 pe-0" style="z-index: 1;">
                                        <i class="fa fa-search opacity-5"></i>
                                    </div>
                                    <input type="text" class="form-control ps-35px bg-light" id="search_product" name="search_product" onkeyup="fn_search_product('search_product')" placeholder="Search" style="border:2px solid #DB4900 !important;" />
                                </div>
                            </div>
                        </div>

                        <div class="product-row product_menu">

                        </div>

                        <!-- <a class="btn btn-default" data-bs-toggle="offcanvas" href="#offcanvasEndExample">
                            <i class="fa fa-arrow-right fa-fw mx-1 opacity-5"></i> Right
                        </a> -->
                    </div>
                </div>

                <div id="showOrderMenu"></div>



            </div>

            <!-- <a href="#" class="pos-mobile-sidebar-toggler" data-toggle-class="pos-mobile-sidebar-toggled" data-target="#pos-customer"> -->
            <a href="#" class="pos-mobile-sidebar-toggler" data-toggle-class="pos-mobile-sidebar-toggled" data-toggle-target="#pos-customer">
                <svg viewBox="0 0 16 16" class="img" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z" />
                    <path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z" />
                </svg>
                <span class="badge">5</span>
            </a>
        </div>
        <a href="javascript:;" class="btn btn-icon btn-circle btn-primary btn-scroll-to-top" data-toggle="scroll-to-top">
            <i class="fa fa-angle-up"></i>
        </a>

        <div class="modal modal-pos-item fade" id="modal_product_item">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="addOrder">
                        <input type="text" hidden name="table_no" id="table_no" value="<?php echo @$table_id; ?>">
                        <input type="text" hidden name="table_name_list" id="table_name_list" value="<?php echo @$table_name["table_name"]; ?>">
                        <input type="text" hidden name="bill_no" id="bill_no" value="<?php echo @$billName["bill_code"]; ?>">
                        
                        <div class="modal-body p-0">
                            <div style="cursor:pointer" data-bs-dismiss="modal" class="btn-close position-absolute top-0 end-0 m-4"></div>
                            <div class="pos-product modal_detail">

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modalPercented" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <form id="addPercented">
                        <div class="modal-body" style="background-color: #f4f1ef !important;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">ປະເພດການຫຼຸດ</label>
                                        <select class="form-control form-select" name="type_discount" id="type_discount" onchange="changTypeDiscount('type_discount','percented','');">
                                            <option value="1">ຫຼຸດເປັນ %</option>
                                            <option value="2">ຫຼຸດເປັນເງິນ</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2"><span id="label_percented">ເປີເຊັນ %</span></label>
                                        <input type="text" class="form-control input_color percented" id="percented" name="percented" maxlength="10" onkeyup="changTypeDiscount('type_discount','percented','');" placeholder="00" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">ມູນຄ່າອາຫານ</label>
                                        <input type="text" class="form-control input_color" id="discount_price" name="discount_price" disabled required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="" class="mb-2">ສ່ວນຫຼຸດທີ່ໄດ້ຮັບ</label>
                                        <input type="text" class="form-control input_color" id="discount_amount" name="discount_amount" placeholder="00" readonly required autocomplete="off" style="background-color: #E9E9E9;">
                                        <input type="text" hidden id="discount_total" name="discount_total">
                                        <input type="text" hidden id="discount_oldPrice" name="discount_oldPrice">
                                        <input type="text" hidden id="proID" name="proID">
                                    </div>
                                </div>
                                <div class="col-md-4 px-0">
                                    <button type="button" class="btn btn-dark btn-lg btn_block" onclick="changTypeDiscount('type_discount','percented','7')" style="padding: 15px !important;border-color: white !important;">7</button>
                                </div>
                                <div class="col-md-4 px-0">
                                    <button type="button" class="btn btn-dark btn-lg btn_block" onclick="changTypeDiscount('type_discount','percented','8')" style="padding: 15px !important;border-color: white !important;">8</button>
                                </div>
                                <div class="col-md-4 px-0">
                                    <button type="button" class="btn btn-dark btn-lg btn_block" onclick="changTypeDiscount('type_discount','percented','9')" style="padding: 15px !important;border-color: white !important;">9</button>
                                </div>
                                <div class="col-md-4 px-0">
                                    <button type="button" class="btn btn-dark btn-lg btn_block" onclick="changTypeDiscount('type_discount','percented','4')" style="padding: 15px !important;border-color: white !important;">4</button>
                                </div>
                                <div class="col-md-4 px-0">
                                    <button type="button" class="btn btn-dark btn-lg btn_block" onclick="changTypeDiscount('type_discount','percented','5')" style="padding: 15px !important;border-color: white !important;">5</button>
                                </div>
                                <div class="col-md-4 px-0">
                                    <button type="button" class="btn btn-dark btn-lg btn_block" onclick="changTypeDiscount('type_discount','percented','6')" style="padding: 15px !important;border-color: white !important;">6</button>
                                </div>
                                <div class="col-md-4 px-0">
                                    <button type="button" class="btn btn-dark btn-lg btn_block" onclick="changTypeDiscount('type_discount','percented','1')" style="padding: 15px !important;border-color: white !important;">1</button>
                                </div>
                                <div class="col-md-4 px-0">
                                    <button type="button" class="btn btn-dark btn-lg btn_block" onclick="changTypeDiscount('type_discount','percented','2')" style="padding: 15px !important;border-color: white !important;">2</button>
                                </div>
                                <div class="col-md-4 px-0">
                                    <button type="button" class="btn btn-dark btn-lg btn_block" onclick="changTypeDiscount('type_discount','percented','3')" style="padding: 15px !important;border-color: white !important;">3</button>
                                </div>
                                <div class="col-md-4 px-0">
                                    <button type="button" class="btn btn-dark btn-lg btn_block" onclick="changTypeDiscount('type_discount','percented','0')" style="padding: 15px !important;border-color: white !important;">0</button>
                                </div>
                                <div class="col-md-8 px-0">
                                    <button type="button" class="btn btn-orange btn-lg btn_block" style="width:100%;padding: 15px !important;border-color: white !important;" onclick="del()">
                                        <i class="fas fa-backspace" style="font-size: 16px;"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-primary btn-lg" id="btn_save"><i class="fas fa-save"></i> ຢືນຢັນ</button>
                            <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal" aria-hidden="true"><i class="fas fa-times"></i> ປິດ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modalCheckbill" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog" style="max-width:550px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">ສໍາລະເງິນ</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="frmBill">
                        <div class="modal-body">
                            <div class="row">
                                <input type="text" hidden name="bill_no1" id="bill_no1" value="<?php echo base64_encode(@$billName["bill_code"]); ?>">
                                <input type="text" hidden name="table_code1" id="table_code1" value="<?php echo @$table_name["table_code"]; ?>">
                                <input type="text" hidden name="tableName" id="tableName" value="<?php echo base64_encode(@$table_name["table_name"]); ?>">

                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">ຊື່ລູກຄ້າ</label>
                                        <div class="input-group">
                                            <select class="form-control form-select" name="list_bill_custommer_fk" id="list_bill_custommer_fk" style="border-radius:0px ;">
                                                <?php
                                                $cusFull = $db->fn_read_all("res_custommer ORDER BY cus_code ASC");
                                                foreach ($cusFull as $rowFull) {
                                                    echo "<option value='" . $rowFull["cus_code"] . "'>" . $rowFull["cus_name"] . "</option>";
                                                }
                                                ?>
                                            </select>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-primary btn-lg text-100" id="btnCustommer" data-bs-toggle="modal" style="border-radius:0px ;">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">ປະເພດການຊໍາລະ</label>
                                        <select class="form-control form-select" name="list_bill_type_pay_fk" id="list_bill_type_pay_fk" onchange="changeTypePayment()">
                                            <option value="1">- ເງິນສົດ</option>
                                            <option value="2">- ໂອນ</option>
                                            <option value="3">- ເງິນສົດ ແລະ ໂອນ</option>
                                            <option value="4">- ຕິດໜີ້</option>
                                            <!-- <option value="5">- ສັ່ງກັບບ້ານ</option> -->
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">ລວມທັງໝົດ </label>
                                        <input type="text" class="form-control input_color" name="list_bill_amount" id="list_bill_amount" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">ສ່ວນຫຼຸດ/ກີບ</label>
                                        <input type="text" class="form-control input_color calculator_price CalculatorData" autocomplete="off" name="per_price" id="per_price" placeholder="0.0" onkeyup="fn_calucator()">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">ສ່ວນຫຼຸດ %</label>
                                        <input type="text" class="form-control input_color calculator_price CalculatorData" autocomplete="off" maxlength="3" name="per_cented" id="per_cented" placeholder="%" onkeyup="fn_calucatorPercented()">
                                    </div>
                                </div>
                                <?php
                                $sqlRate = $db->fn_fetch_single_all("res_exchange ORDER BY ex_auto DESC LIMIT 1");
                                ?>
                                <input type="text" hidden value="<?php echo @($sqlRate["ex_bath_kip"]) ?>" name="list_rate_bat_kip" id="list_rate_bat_kip">
                                <input type="text" hidden value="<?php echo @($sqlRate["ex_dolar_kip"]) ?>" name="list_rate_us_kip" id="list_rate_us_kip">
                                <input type="text" hidden name="list_bill_qty" id="list_bill_qty">
                                <input type="text" hidden name="list_bill_count_order" id="list_bill_count_order">
                                <input type="text" hidden name="sumTotalPercented" id="sumTotalPercented">
                                <input type="text" hidden id="sumGif_pro" name="sumGif_pro">
                                <input type="text" hidden name="branch_code" id="branch_code" value="<?php echo $_SESSION["user_branch"];?>">
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">ມູນຄ່າຕ້ອງຊໍາລະ/ກີບ</label>
                                        <input type="text" class="form-control input_color calculator_price" id="list_bill_amount_kip" name="list_bill_amount_kip" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">1 THB=<span class="text-danger"><?php echo @number_format($sqlRate["ex_bath_kip"]) ?></span></label>
                                        <input type="text" class="form-control input_color" id="list_bill_amount_bath" name="list_bill_amount_bath" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">1 USD=<span class="text-danger" id="rate_us"><?php echo @number_format($sqlRate["ex_dolar_kip"]) ?></span></label>
                                        <input type="text" class="form-control input_color" id="list_bill_amount_us" name="list_bill_amount_us" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="mb-2"> ຊໍາລະເງິນສົດ ກີບ <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control input_color calculator_price CalculatorData require_cash list_pay_kip" autocomplete="off" id="list_pay_kip" name="list_pay_kip" placeholder="0.0">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">ຊໍາລະເງິນສົດ THB</label>
                                        <input type="text" class="form-control input_color calculator_price CalculatorData require_cash" autocomplete="off" id="list_bill_pay_bath" name="list_bill_pay_bath" placeholder="0.0">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">ຊໍາລະເງິນສົດ USD</label>
                                        <input type="text" class="form-control input_color calculator_price CalculatorData require_cash" autocomplete="off" id="list_bill_pay_us" name="list_bill_pay_us" placeholder="0.0">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="" class="mb-2"> ເງິນໂອນກີບ <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control input_color calculator_price CalculatorData require_transfer" readonly autocomplete="off" id="transfer_kip" name="transfer_kip" placeholder="0.0">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">ໂອນບາດ THB</label>
                                        <input type="text" class="form-control input_color calculator_price CalculatorData require_transfer" readonly autocomplete="off" id="transfer_bath" name="transfer_bath" placeholder="0.0">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">ໂອນໂດຣາ USD</label>
                                        <input type="text" class="form-control input_color calculator_price CalculatorData require_transfer" readonly autocomplete="off" id="transfer_us" name="transfer_us" placeholder="0.0">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group mb-2">
                                        <label for="" class="mb-2">ເງິນທອນ ກີບ</label>
                                        <input type="text" class="form-control input_color" id="list_bill_return" name="list_bill_return" placeholder="0.0" readonly>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-warning btn-lg" id="printPreview"><i class="fas fa-print"></i> ພິມບິນ</button>
                            <button type="submit" class="btn btn-primary btn-lg" id="btn_payment" disabled><i class="fas fa-save"></i> ຊໍາລະເງິນ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade" id="mdCustommer" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">ເພີ່ມຂໍ້ມູນລູກຄ້າ</h4>
                        <button type="button" class="btn-close manageBill" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <form id="insertCustommer">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">ຊື່ ແລະ ນາມສະກຸນ <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control input_color" name="cus_name" id="cus_name" placeholder="ຊື່ ແລະ ນາມສະກຸນລູກຄ້າ" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">ເບີໂທລະສັບ</label>
                                        <input type="text" class="form-control input_color" name="cus_address" id="cus_address" placeholder="ປ້ອນເບີໂທລະສັບ" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-1">
                                        <label for="" class="mb-2">ທີ່ຢູ່ </label>
                                        <input type="text" class="form-control input_color" name="cus_tel" id="cus_tel" placeholder="ປ້ອນທີ່ຢູ່" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> ບັນທຶກ</button>
                            <a href="javascript:;" class="btn btn-danger manageBill" data-bs-dismiss="modal"><i class="fas fa-times"></i> ປິດ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade" id="mdRemove" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form id="frmRemoveTb">
                        <div class="modal-body">
                            <div class="row" id="showRemove">

                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-sync-alt"></i> ຢືນຢັນຍ້າຍໂຕະ</button>
                            <a href="javascript:;" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times"></i> ປິດ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="offcanvas offcanvas-end" id="offcanvasEndExample">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">ໂຕະຫຼັກ <span class="text-danger"><?php echo @$table_name["table_name"]; ?></span></h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
                <form id="confirmSumTable">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="" class="mb-2" style="font-size:12px">1.ເລືອກໂຊນ <span class="text-danger">*</span></label>
                                <select name="table_zone_fk" id="table_zone_fk" class="form-select" onchange="ChangeZone()">
                                    <?php
                                    $res_group = $db->fn_read_all("res_zone ORDER BY zone_code ASC");
                                    echo "<option value=''>ເລືອກ</option>";
                                    if (count($res_group) > 0) {
                                        foreach ($res_group as $row_group) {
                                            echo "<option value='" . $row_group["zone_code"] . "'>" . $row_group["zone_name"] . "</option>";
                                        }
                                    } else {
                                        echo "<option value=''>ເລືອກ</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="" class="mb-2" style="font-size:12px">2.ເລືອກໂຕະ <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <select name="tbList" id="tbList" class="form-select tbList">
                                        <option value="">ເລືອກ</option>
                                    </select>
                                    <button type="button" class="btn btn-primary addRow" onclick="addMove()">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12" id="loadTable">

                        </div>
                    </div>
                </form>
            </div>
        </div>



        <div class="modal fade" id="modalCut_list" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="frmCutlist">
                        <div class="modal-body">
                            <div class="row" id="showCut_list">

                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>

    </div>

   

    <?php
    $packget_all->main_script();
    ?>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vaafb692b2aea4879b33c060e79fe94621666317369993" integrity="sha512-0ahDYl866UMhKuYcW078ScMalXqtFJggm7TmlUtp0UlD4eQk0Ixfnm5ykXKvGJNFjLMoortdseTfsRT8oCfgGA==" data-cf-beacon='{"rayId":"7a1e910a9e0a5d54","version":"2023.2.0","r":1,"token":"4db8c6ef997743fda032d4f73cfeff63","si":100}' crossorigin="anonymous"></script>
    <script>

        $("#frmCutlist").on("submit",function(event){
            event.preventDefault();
            Swal.fire({
                title: "ແຈ້ງເຕືອນ",
                text: "ຢືນຢັນການແຍກຈ່າຍ ? ",
                icon: 'warning',
                width: 450,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<i class="fas fa-save"></i> ຢືນຢັນ',
                cancelButtonText: '<i class="fas fa-times"></i> ປິດ',
            }).then((result) => {
                if (result.isConfirmed) {
                    var tableEnd=$("#tableEnd").val();
                    $.ajax({
                        url: "services/sql/service-pos.php?cutlist_url",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            Swal.fire({
                                position: 'top-center',
                                icon: 'success',
                                title: '<h4>ແຍກຈ່າຍສໍາເລັດ</h4>',
                                showConfirmButton: false,
                                width: 250,
                                timer: 1500
                            }).then((result) => {
                                location.href = "?pos&table_id=" + tableEnd;
                            });
                        }
                    })
                }
            })
        });

        $(document).on("change",".checkAll",function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
            if(this.checked===true){
                $("#save_payments").attr("disabled",false);
            }else{
                $("#save_payments").attr("disabled",true);
            }
        });     
        
        $(document).on("change",".check_list",function(){
            if ($(".check_list:checked").length == 0) {
                $('#save_payments').attr('disabled', true);
            } else {
                $('#save_payments').attr('disabled', false);
            }

        });

        function fnCut_list(billNo,tableID,tableName){
            $.ajax({
                url: "services/sql/service-pos.php?cutList",
                method:"POST",
                data:{billNo,tableID,tableName},
                success:function(data){
                    $("#modalCut_list").modal("show");
                    $("#showCut_list").html(data);
                }
            })
           
        }

        $(document).on("click","#bokenTb",function(){
            Swal.fire({
                title: "ແຈ້ງເຕືອນ",
                text: "ທ່ານຕ້ອງການແຍກໂຕະແທ້ ຫຼື ບໍ ? ",
                icon: 'warning',
                width: 450,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<i class="fas fa-save"></i> ຢືນຢັນ',
                cancelButtonText: '<i class="fas fa-times"></i> ປິດ',
            }).then((result) => {
                if (result.isConfirmed) {
                    var bill_no=$("#bill_no").val();
                    var table_no=$("#table_no").val();
                    $.ajax({
                        url: "services/sql/service-pos.php?editBoken",
                        method: "POST",
                        data:{bill_no,table_no},
                        success: function(data) {
                            location.href = "?table_list";
                        }
                    })
                }
            })
        });

        $("#confirmSumTable").on("submit", function(event) {
            event.preventDefault();
            Swal.fire({
                title: "ແຈ້ງເຕືອນ",
                text: "ທ່ານຕ້ອງການລວມໂຕະແທ້ ຫຼື ບໍ? ",
                icon: 'warning',
                width: 450,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<i class="fas fa-save"></i> ຢືນຢັນ',
                cancelButtonText: '<i class="fas fa-times"></i> ປິດ',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "services/sql/service-pos.php?editStatusTb",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            location.href = "?table_list";
                        }
                    })
                }
            });
        });

        // $(document).on("click",".confirmExite",function(){
        //     var confirmExite=$(this).attr("Id");
        //     $.ajax({
        //         url: "services/sql/service-pos.php?deleteMoveAll",
        //         method: "POST",
        //         data: {
        //             confirmExite
        //         },
        //         success: function(data) {
        //            $("#mdSumTable").modal("hide");
        //         }
        //     })
        // });
        loadSumTable()
        function loadSumTable(){
            var bill_no=$("#bill_no").val();
            var table_no=$("#table_no").val();
            $.ajax({
                url: "services/sql/service-pos.php?sumTable",
                method: "POST",
                data:{bill_no,table_no},
                success:function(data){
                    $("#loadTable").html(data);
                }
            })
        }

        function ChangeZoneMove() {
            var table_zone_fk = $("#table_zone_fk").val();
            var table_no=$("#table_no").val();
            $.ajax({
                url: "services/sql/service-pos.php?fetchZoneMoves",
                method: "POST",
                data: {
                    table_zone_fk,table_no
                },
                success: function(data) {
                    $("#endTb").html(data);
                }
            })
        }

        function ChangeZone() {
            var table_zone_fk = $("#table_zone_fk").val();
            var table_no=$("#table_no").val();
            $.ajax({
                url: "services/sql/service-pos.php?fetchTable",
                method: "POST",
                data: {
                    table_zone_fk,table_no
                },
                success: function(data) {
                    $("#tbList").html(data);
                }
            })
        }

        function fnMoveTb(urlData, modalID, showID) {
            var billNo = $("#bill_no1").val();
            var tableCode = $("#table_code1").val();
            var tableName = $("#tableName").val();
            $.ajax({
                url: "services/sql/service-pos.php?" + urlData,
                method: "POST",
                data: {
                    tableCode,
                    tableName,
                    billNo
                },
                success: function(data) {
                    $("#" + modalID).modal("show");
                    $("#" + showID).html(data);
                    loadMoveTb();
                }
            })
        }

        function loadMoveTb() {
            var bill_no = $("#bill_no").val();
            var table_no = $("#table_no").val();
            var table_name = $("#table_name_list").val();
            $.ajax({
                url: "services/sql/service-pos.php?loadMoveTb",
                method: "POST",
                data: {
                    table_no,
                    table_name,
                    bill_no
                },
                success: function(data) {
                    $("#tbodyMove").html(data);
                }
            })
        }

        function addMove() {
            var tbList = $("#tbList").val();
            var table_no = $("#table_no").val();
            var bill_no = $("#bill_no").val();
            if (tbList != "") {
                $.ajax({
                    url: "services/sql/service-pos.php?insertMove",
                    method: "POST",
                    data: {
                        tbList,
                        table_no,
                        bill_no
                    },
                    success: function(data) {
                        var dataResult = JSON.parse(data);
                        if (dataResult.statusCode == 201) {
                            ErrorFuntion("ໂຕະນີ້ລໍຖ້າກົດຢືນຢັນລວມໂຕະກັບໂຕະອື່ນຢູ່ !");
                        }else{
                            loadSumTable()
                        }
                    }
                })
            } else {
                $("#tbList").focus();
            }

        }

        function fnDelete(dataID,oldTable,Newtable) {
            $.ajax({
                url: "services/sql/service-pos.php?deleteData",
                method: "POST",
                data: {
                    dataID,oldTable,Newtable
                },
                success: function(data) {
                    loadSumTable()
                }
            })
        }


        $("#frmRemoveTb").on("submit", function(event) {
            event.preventDefault();
            Swal.fire({
                title: "ແຈ້ງເຕືອນ",
                text: "ທ່ານຕ້ອງການຍ້າຍໂຕະແທ້ ຫຼື ບໍ? ",
                icon: 'warning',
                width: 400,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<i class="fas fa-save"></i> ຢືນຢັນ',
                cancelButtonText: '<i class="fas fa-times"></i> ປິດ',
            }).then((result) => {
                if (result.isConfirmed) {
                    var endTb = $("#endTb").val();
                    var bill_no = $("#bill_no").val();
                    $.ajax({
                        url: "services/sql/service-pos.php?urlRemoveTb",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            $("#mdRemove").modal("hide");
                            $("#frmRemoveTb")[0].reset();
                            Swal.fire({
                                position: 'top-center',
                                icon: 'success',
                                title: '<h4>ຍ້າຍໂຕະສໍາເລັດແລ້ວ</h4>',
                                showConfirmButton: false,
                                width: 250,
                                timer: 1500
                            }).then((result) => {
                                location.href = "?pos&table_id=" + endTb;
                            });
                        }
                    })
                }
            })
        });
    </script>
    <script>
        //=====================Load Category=================================

        socket.on('successOrder_co_dr', (response) => {
            var bill_code = document.querySelector("#bill_no").value;
            if (response.bill_no===bill_code) {
                load_orders();
            }
        })

        $("#frmBill").on("submit", function(event) {
            event.preventDefault();
            var list_bill_return = Number($("#list_bill_return").val().replace(/[^0-9\.-]+/g, ""));
            var bill_no = $("#bill_no1").val();
            var tableName = $("#tableName").val();
            var table_code = $("#table_code1").val();
            var per_price = Number($("#per_price").val().replace(/[^0-9\.-]+/g, ""));
            var per_cented = $("#per_cented").val();
            var list_bill_amount_kip = Number($("#list_bill_amount_kip").val().replace(/[^0-9\.-]+/g, ""));
            var countBill = $("#list_bill_count_order").val();
            var pay_kip = Number($("#list_pay_kip").val().replace(/[^0-9\.-]+/g, ""));
            var pay_bath = Number($("#list_bill_pay_bath").val().replace(/[^0-9\.-]+/g, ""));
            var pay_us = Number($("#list_bill_pay_us").val().replace(/[^0-9\.-]+/g, ""));
            var type_payment = $("#list_bill_type_pay_fk").val();
            var transfer_kip = Number($("#transfer_kip").val().replace(/[^0-9\.-]+/g, ""));
            var transfer_bath = Number($("#transfer_bath").val().replace(/[^0-9\.-]+/g, ""));
            var transfer_us = Number($("#transfer_us").val().replace(/[^0-9\.-]+/g, ""));
            var branch_code=$("#branch_code").val();

            if ($("#list_bill_type_pay_fk").val() === "3") {
                var countCash = 0;
                $.each($(".require_cash"), function() {
                    countCash += $(this).val().length;
                });

                var counttransfer = 0;
                $.each($(".require_transfer"), function() {
                    counttransfer += $(this).val().length;
                });

                if (countCash === 0 && counttransfer === 0) {
                    $("#list_pay_kip").focus();
                } else if (countCash != 0 && counttransfer === 0) {
                    $("#transfer_kip").focus();
                } else {
                    if (list_bill_return >= "0") {
                        $.ajax({
                            url: "services/sql/service-pos.php?insertAll",
                            method: "POST",
                            data: new FormData(this),
                            contentType: false,
                            processData: false,
                            success: function(data) {
                                var dataResult = JSON.parse(data);
                                if (dataResult.statusCode == 200) {
                                    var openWindow = window.open("?checkBill&&bill_no=" + bill_no + "&&tableName=" + tableName + "&&per_price=" + per_price + "&&per_cented=" + per_cented + "&&total=" + list_bill_amount_kip + "&&countBill=" + countBill + "&&pay_kip=" + pay_kip + "&&pay_bath=" + pay_bath + "&&pay_us=" + pay_us + "&&list_bill_return=" + list_bill_return + "&&type_payment=" + type_payment + "&&table_code=" + table_code + "&&transfer_kip=" + transfer_kip + "&&transfer_bath=" + transfer_bath + "&&transfer_us=" + transfer_us+"&&branch_code="+branch_code, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=200,width=1000,height=500");
                                    openWindow.document.close();
                                    openWindow.focus();
                                    openWindow.print();
                                    setTimeout(function() {
                                        openWindow.close();
                                        location.href = "?table_list";
                                    }, 1000)
                                }
                            }
                        })
                    } else {
                        ErrorFuntion("ທ່ານປ້ອນຈໍານວນເງິນຍັງບໍ່ຄົບ !");
                        $("#list_pay_kip").focus();
                    }
                }
            } else {
                if (list_bill_return >= "0") {
                    $.ajax({
                        url: "services/sql/service-pos.php?insertAll",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            var dataResult = JSON.parse(data);
                            if (dataResult.statusCode == 200) {
                                var openWindow = window.open("?checkBill&&bill_no=" + bill_no + "&&tableName=" + tableName + "&&per_price=" + per_price + "&&per_cented=" + per_cented + "&&total=" + list_bill_amount_kip + "&&countBill=" + countBill + "&&pay_kip=" + pay_kip + "&&pay_bath=" + pay_bath + "&&pay_us=" + pay_us + "&&list_bill_return=" + list_bill_return + "&&type_payment=" + type_payment + "&&table_code=" + table_code + "&&transfer_kip=" + transfer_kip + "&&transfer_bath=" + transfer_bath + "&&transfer_us=" + transfer_us+"&&branch_code="+branch_code, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=200,width=1000,height=500");
                                openWindow.document.close();
                                openWindow.focus();
                                openWindow.print();
                                setTimeout(function() {
                                    openWindow.close();
                                    location.href = "?table_list";
                                }, 1000)
                            }
                        }
                    })
                } else {
                    ErrorFuntion("ທ່ານປ້ອນຈໍານວນເງິນຍັງບໍ່ຄົບ !");
                    $("#list_pay_kip").focus();
                }
            }

        });

        $("#printPreview").click(function() {
            var bill_no = $("#bill_no1").val();
            var tableName = $("#tableName").val();
            var per_price = Number($("#per_price").val().replace(/[^0-9\.-]+/g, ""));
            var per_cented = $("#per_cented").val();
            var list_bill_amount_kip = Number($("#list_bill_amount_kip").val().replace(/[^0-9\.-]+/g, ""));
            var countBill = $("#countBill").val();
            var branch_code=$("#branch_code").val();
            var openWindow = window.open("?previewBill&&bill_no=" + bill_no + "&&tableName=" + tableName + "&&per_price=" + per_price + "&&per_cented=" + per_cented + "&&total=" + list_bill_amount_kip + "&&countBill=" + countBill+"&&branch_code="+branch_code, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=200,width=1000,height=500");
            openWindow.document.close();
            openWindow.focus();
            openWindow.print();
            setTimeout(function() {
                openWindow.close();
            }, 1000)
        });


        $("#insertCustommer").on("submit", function(e) {
            e.preventDefault();
            $.ajax({
                url: "services/sql/service-pos.php?insertCustommer",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(data) {
                    $("#mdCustommer").modal("hide");
                    $("#modalCheckbill").modal("show");
                    $("#list_bill_custommer_fk").html(data);
                    $("#insertCustommer")[0].reset();
                }
            })
        });

        $("#btnCustommer").click(function() {
            $("#mdCustommer").modal("show");
            $("#insertCustommer")[0].reset();
        });

        //===================Load MoveTable==================================

        function fn_calucator() {
            var per_price = Number($("#per_price").val().replace(/[^0-9\.-]+/g, ""));
            var per_cented = Number($("#per_cented").val().replace(/[^0-9\.-]+/g, ""));

            var list_bill_amount = Number($("#list_bill_amount").val().replace(/[^0-9\.-]+/g, ""));
            var list_bill_amount_kip1 = Number($("#list_bill_amount_kip").val().replace(/[^0-9\.-]+/g, ""));
            var list_bill_amount_bath1 = Number($("#list_bill_amount_bath").val().replace(/[^0-9\.-]+/g, ""));
            var list_bill_amount_us1 = Number($("#list_bill_amount_us").val().replace(/[^0-9\.-]+/g, ""));
            var list_rate_bat_kip = Number($("#list_rate_bat_kip").val().replace(/[^0-9\.-]+/g, ""));
            var list_rate_us_kip = Number($("#list_rate_us_kip").val().replace(/[^0-9\.-]+/g, ""));


            var totalPercented = list_bill_amount * (per_cented / 100);
            var sumPercentedKip = parseFloat(totalPercented + per_price);
            var sumPercentedbath = parseFloat(totalPercented + per_price);
            var sumPercentedus = parseFloat(totalPercented + per_price);

            var list_bill_amount_kip = parseFloat(list_bill_amount - sumPercentedKip);
            var list_bill_amount_bath = parseFloat(list_bill_amount - sumPercentedbath) / list_rate_bat_kip;
            var list_bill_amount_us = parseFloat(list_bill_amount - sumPercentedus) / list_rate_us_kip;

            $("#list_bill_amount_kip").val(numeral(list_bill_amount_kip).format('0,000'));
            $("#list_bill_amount_bath").val(numeral(list_bill_amount_bath).format('0,000'));

            if (list_bill_amount_us >= 1) {
                $("#list_bill_amount_us").val(numeral(list_bill_amount_us).format('0,000'));
            } else {
                $("#list_bill_amount_us").val(1);
            }




            var sliceData = $("#list_bill_amount_kip").val().slice(-3);
            if (sliceData > 0) {
                if (sliceData === "000") {
                    var showPrice = parseFloat(list_bill_amount_kip);
                    $("#list_bill_amount_kip").val(numeral(showPrice).format('0,000'));
                } else {
                    var showPrice = parseFloat(list_bill_amount_kip - sliceData + 1000);
                    $("#list_bill_amount_kip").val(numeral(showPrice).format('0,000'));
                }
            }



            var list_bill_amount_kip2 = Number($("#list_bill_amount_kip").val().replace(/[^0-9\.-]+/g, ""));
            var list_bill_amount_bath2 = Number($("#list_bill_amount_bath").val().replace(/[^0-9\.-]+/g, ""));
            var list_bill_amount_us2 = Number($("#list_bill_amount_us").val().replace(/[^0-9\.-]+/g, ""));
            var list_pay_kip_convert = Number($("#list_pay_kip").val().replace(/[^0-9\.-]+/g, ""));
            var list_bill_pay_bath_convert = Number($("#list_bill_pay_bath").val().replace(/[^0-9\.-]+/g, ""));
            var list_bill_pay_us_convert = Number($("#list_bill_pay_us").val().replace(/[^0-9\.-]+/g, ""));
            var convert_transfer_kip = Number($("#transfer_kip").val().replace(/[^0-9\.-]+/g, ""));
            var convert_transfer_bath = Number($("#transfer_bath").val().replace(/[^0-9\.-]+/g, ""));
            var convert_transfer_us = Number($("#transfer_us").val().replace(/[^0-9\.-]+/g, ""));

            if (per_price != "0") {
                $("#per_price").val(numeral(per_price).format('0,000'));
                $("#per_cented").val("");
            }

            $("#list_pay_kip").val(numeral(list_pay_kip_convert).format('0,000'));
            $("#list_bill_pay_bath").val(numeral(list_bill_pay_bath_convert).format('0,000'));
            $("#list_bill_pay_us").val(numeral(list_bill_pay_us_convert).format('0,000'));

            $("#transfer_kip").val(numeral(convert_transfer_kip).format('0,000'));
            $("#transfer_bath").val(numeral(convert_transfer_bath).format('0,000'));
            $("#transfer_us").val(numeral(convert_transfer_us).format('0,000'));


            listKipConvert = numeral(list_pay_kip_convert).format('0,000');
            listthaiConvert = numeral(list_bill_pay_bath_convert).format('0,000');
            listusConvert = numeral(list_bill_pay_us_convert).format('0,000');
            transferKipConvert = numeral(convert_transfer_kip).format('0,000');
            transferBathConvert = numeral(convert_transfer_bath).format('0,000');
            transferusConvert = numeral(convert_transfer_us).format('0,000');

            if (listKipConvert === "0") {
                $("#list_pay_kip").val("");
            }
            if (listthaiConvert === "0") {
                $("#list_bill_pay_bath").val("");
            }
            if (listusConvert === "0") {
                $("#list_bill_pay_us").val("");
            }
            if (transferKipConvert === "0") {
                $("#transfer_kip").val("");
            }
            if (transferBathConvert === "0") {
                $("#transfer_bath").val("");
            }
            if (transferusConvert === "0") {
                $("#transfer_us").val("");
            }

            sumKip = parseFloat(list_pay_kip_convert + convert_transfer_kip - list_bill_amount_kip2);
            sumBath = parseFloat(list_bill_pay_bath_convert + convert_transfer_bath) * list_rate_bat_kip;
            sumUs = parseFloat(list_bill_pay_us_convert + convert_transfer_us) * list_rate_us_kip;


            sumTotal = parseFloat(sumKip) + parseFloat(sumBath) + parseFloat(sumUs);
            $("#list_bill_return").val(numeral(sumTotal).format('0,000'));

            TotalReturn = $("#list_bill_return").val().slice(-3);
            convertBath = parseFloat(list_bill_pay_bath_convert + convert_transfer_bath);
            convertUs = parseFloat(list_bill_pay_us_convert + convert_transfer_us);


            if (convertBath === list_bill_amount_bath2) {
                $("#list_bill_return").val("0");
                $("#list_pay_kip").val("");
                $("#list_bill_pay_us").val("");
                $("#transfer_us").val("");
            } else if (convertUs === list_bill_amount_us2) {
                $("#transfer_kip").val("");
                $("#list_bill_pay_bath").val("");
                $("#transfer_bath").val("");
                $("#list_bill_return").val("0");
            } else {
                if (TotalReturn <= 900) {
                    var showPrice = parseFloat(sumTotal - TotalReturn);
                    $("#list_bill_return").val(numeral(showPrice).format('0,000'));
                } else {
                    $("#list_bill_return").val(numeral(sumTotal).format('0,000'));
                }
            }

            $("#btn_payment").attr("disabled", false);


            if (listKipConvert === "0" && listthaiConvert === "0" && listusConvert === "0" && transferKipConvert === "0" && transferBathConvert === "0" && transferusConvert === "0") {
                $("#btn_payment").attr("disabled", true);
                $("#list_bill_return").val("0");
            }

            if (listKipConvert === "" && listthaiConvert === "" && listusConvert === "" && transferKipConvert === "" && transferBathConvert === "" && transferusConvert === "") {
                $("#btn_payment").attr("disabled", true);
                $("#list_bill_return").val("0");
            }

        }

        $(document).on("keyup", ".CalculatorData", function() {
            if ($("#per_cented").val() != "") {
                $("#per_price").val("");
                fn_calucator()
            } else {
                $("#per_cented").val("");
                fn_calucator()
            }
        });

        $(document).on("click", ".manageBill", function() {
            $("#modalCheckbill").modal("show");
            var price_total = $("#price_total").val();
            var totalKip = Number(price_total.replace(/[^0-9\.-]+/g, ""));
            var list_rate_bat_kip = Number($("#list_rate_bat_kip").val().replace(/[^0-9\.-]+/g, ""));
            var list_rate_us_kip = Number($("#list_rate_us_kip").val().replace(/[^0-9\.-]+/g, ""));
            var totalRate_bat_kip = (totalKip / list_rate_bat_kip);
            var totalRate_bat_us = (totalKip / list_rate_us_kip);
            var countOrder = $("#countOrder").val();
            $("#sumGif_pro").val($("#sumGifTotal").val());
            $("#sumTotalPercented").val($("#sumlistTotal").val());
            $("#list_bill_count_order").val(countOrder);
            $("#list_bill_qty").val($("#sumQty").val());
            $("#list_bill_amount").val(numeral(totalKip).format('0,000'));
            $("#list_bill_amount_kip").val(numeral(totalKip).format('0,000'));
            $("#list_bill_amount_bath").val(numeral(totalRate_bat_kip).format('0,000'));

            if (totalRate_bat_us >= 1) {
                $("#list_bill_amount_us").val(numeral(totalRate_bat_us).format('0,000'));
            } else {
                $("#list_bill_amount_us").val(1);
            }

            $("#list_bill_return").val("")
            $("#per_price").val("");
            $("#per_cented").val("");
            $("#list_pay_kip").val("");
            $("#list_bill_pay_bath").val("");
            $("#list_bill_pay_us").val("");
            $("#transfer_kip").val("");
            $("#transfer_bath").val("");
            $("#transfer_us").val("");
            $("#countBill")[0].selectedIndex = 0;
            changeTypePayment()

        });


        function changeTypePayment() {
            var list_bill_type_pay_fk = $("#list_bill_type_pay_fk").val();

            if (list_bill_type_pay_fk === "1") {
                $('#list_pay_kip').focus();
                $('#list_pay_kip').prop('readonly', false);
                $('#list_bill_pay_bath').prop('readonly', false);
                $('#list_bill_pay_us').prop('readonly', false);

                $('#transfer_kip').prop('readonly', true);
                $('#transfer_bath').prop('readonly', true);
                $('#transfer_us').prop('readonly', true);
                $("#list_pay_kip").val("");
                $("#list_bill_pay_bath").val("");
                $("#list_bill_pay_us").val("");
                $("#transfer_kip").val("");
                $("#transfer_bath").val("");
                $("#transfer_us").val("");
                if ($('#list_pay_kip').val() === "" || $('#list_bill_pay_bath').val() === "" || $('#list_bill_pay_us') === "") {
                    $("#btn_payment").attr("disabled", true);
                } else {
                    $("#btn_payment").attr("disabled", false);
                }

            } else if (list_bill_type_pay_fk === "2") {
                $('#transfer_kip').focus();
                $('#list_pay_kip').prop('readonly', true);
                $('#list_bill_pay_bath').prop('readonly', true);
                $('#list_bill_pay_us').prop('readonly', true);
                $('#transfer_kip').prop('readonly', false);
                $('#transfer_bath').prop('readonly', false);
                $('#transfer_us').prop('readonly', false);
                $("#list_pay_kip").val("");
                $("#list_bill_pay_bath").val("");
                $("#list_bill_pay_us").val("");
                $("#transfer_kip").val("");
                $("#transfer_bath").val("");
                $("#transfer_us").val("");

                if ($('#transfer_kip').val() === "" || $('#transfer_bath').val() === "" || $('#transfer_us') === "") {
                    $("#btn_payment").attr("disabled", true);
                } else {
                    $("#btn_payment").attr("disabled", false);
                }

            } else if (list_bill_type_pay_fk === "3") {
                $('#list_pay_kip').focus();
                $('#list_pay_kip').prop('readonly', false);
                $('#list_bill_pay_bath').prop('readonly', false);
                $('#list_bill_pay_us').prop('readonly', false);
                $('#transfer_kip').prop('readonly', false);
                $('#transfer_bath').prop('readonly', false);
                $('#transfer_us').prop('readonly', false);

                // if($('.require_cash').val().length<0){
                //     $('.require_cash').prop('required',true);
                // }else if($('.require_transfer').val().length<0){
                //     $('.require_transfer').prop('required',true);
                // }else{
                //     $('.require_cash').prop('required',false);
                //     $('.require_transfer').prop('required',false);
                // }
                $("#btn_payment").attr("disabled", false);
            } else {
                $('#list_pay_kip').prop('readonly', true);
                $('#list_bill_pay_bath').prop('readonly', true);
                $('#list_bill_pay_us').prop('readonly', true);
                $('#transfer_kip').prop('readonly', true);
                $('#transfer_bath').prop('readonly', true);
                $('#transfer_us').prop('readonly', true);
                $("#list_pay_kip").val("");
                $("#list_bill_pay_bath").val("");
                $("#list_bill_pay_us").val("");
                $("#transfer_kip").val("");
                $("#transfer_bath").val("");
                $("#transfer_us").val("");
                $("#btn_payment").attr("disabled", false);
            }
        }

        $(document).on("click", "#addCustommer", function() {
            $("#md_custommer").modal("show");
        });

        function loadTable(pagesLoad) {
            $.ajax({
                url: "services/sql/service-moveTable.php?loadTableList",
                method: "POST",
                data: {
                    pagesLoad
                },
                success: function(data) {
                    $("#loadMove").html(data);
                }
            })
        }

        load_category('20230000001')

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

        function load_category(cate_item) {
            if(cate_item==="Promotion_11"){
                $('.active1').not(this).removeClass('active');
                $("#" + cate_item).toggleClass('active');
                $("#Promotion_11").css("background","#103460");
            }else{
                $('.active1').not(this).removeClass('active');
                $("#" + cate_item).toggleClass('active');
                $("#Promotion_11").css("background","#030405");
            }
            
            $.ajax({
                url: "services/sql/service-pos.php?product_list",
                method: "POST",
                data: {
                    cate_item
                },
                success: function(data) {
                    $(".product_menu").html(data)
                }
            })
        }
        //=====================Load Orders===================================

       

        load_orders()

        function load_orders() {
            var table_no = $("#table_no").val();
            var table_name_list = $("#table_name_list").val();
            var bill_no = $("#bill_no").val();

            $.ajax({
                url: "services/sql/service-pos.php?order_list",
                method: "POST",
                data: {
                    table_no,
                    table_name_list,
                    bill_no
                },
                success: function(data) {
                    $("#showOrderMenu").html(data)
                }
            })
        }
        //=====================Search Products===============================
        function fn_search_product(search_product) {
            var search_product1 = $("#" + search_product).val();
            $.ajax({
                url: "services/sql/service-pos.php?product_list",
                method: "POST",
                data: {
                    search_product1
                },
                success: function(data) {
                    if (search_product1 != "") {
                        $(".product_menu").html(data)
                    } else {
                        load_category('202200001')
                    }

                }
            })
        }

        //======================Use Orders====================================
        $(document).on("click", ".modal_products", function() {
            var modal_products = $(this).attr("Id");
            var status_check_gif=$("#status_check_gif").val();
            $.ajax({
                url: "services/sql/service-pos.php?product_modal",
                method: "POST",
                data: {
                    modal_products,status_check_gif
                },
                success: function(data) {
                    $("#modal_product_item").modal("show");
                    $(".modal_detail").html(data);
                }
            })

        });

        //=======================Change Price=================================
        function fnChangePrice(pro_detail_code, product_cut_stock,txtStatusPro,txtgif,stockQty) {
            if(txtStatusPro==="1"){
                start_qty="1";
                start_gif="0";
                $("#txtProGif").val("0");
                $("#txtProJing1").val("0");
                $("#txtGifDefault2").val("0");
                $(".stock_qty2").val("0");
            }else{
                start_qty=txtStatusPro;
                $("#txtProGif2").val(txtgif);
                $("#txtGifDefault2").val(txtgif);
                $("#txtProJing2").val(start_qty);
                $(".stock_qty2").val(stockQty);
            }

            

            $.ajax({
                url: "services/sql/service-pos.php?changePrice",
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

        //=======================Plus and Minus================================
        function Plus_fn(dataInput) {
            var convertProQty = $(".order_list_pro_qty").val();
            var order_list_pro_qty = Number(convertProQty.replace(/[^0-9\.-]+/g, ""));
            var txtDetailCode = $(".txtDetailCode").val();
            var txtCutStock = $(".txtCutStock").val();
            var txtUnite = $(".txtUnite").val();
            var txtQty = $(".txtQty").val();
            var txtStatusPro=$(".txtStatusPro").val();
           
            
            if(txtStatusPro==="1"){
                var stock_qty2=$(".stock_qty1").val();
                start_qty=Number($(".start_qty1").val().replace(/[^0-9\.-]+/g, ""));
                var txtProJing1=$(".txtProJing1").val();
                var txtGifDefault=$(".txtGifDefault1").val();
                txtProGif=parseFloat(txtGifDefault)+parseFloat(txtProJing1);
                $(".txtProGif1").val(txtProGif);
                totalQty_check=order_list_pro_qty;
            }else{
                var stock_qty2=$(".stock_qty2").val();
                start_qty=Number($(".start_qty2").val().replace(/[^0-9\.-]+/g, ""));
                var txtProJing2=$(".txtProJing2").val();
                var txtGifDefault=$(".txtGifDefault2").val();
                var gifPro=$(".txtProGif2").val();

                if (dataInput === "plus") {
                    txtProGif=parseFloat(txtGifDefault)+parseFloat(gifPro);
                    $(".txtProGif2").val(txtProGif);
                    totalQty_check=parseFloat(order_list_pro_qty)+parseFloat(gifPro);
                }else if (dataInput === "minus") {
                    if(gifPro===txtGifDefault){
                        $(".txtProGif2").val(txtGifDefault);
                    }else{
                        txtProGif=parseFloat(gifPro)-parseFloat(txtGifDefault);
                        $(".txtProGif2").val(txtProGif);
                    }
                    totalQty_check=parseFloat(order_list_pro_qty)-parseFloat(gifPro);
                }
            }


            if (txtCutStock === "2") {
                $.ajax({
                    url: "services/sql/service-pos.php?changeQty",
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
                            ErrorFuntion("ເຄື່ອງດຶ່ມໃນສະຕ໋ອກມີແຕ່ " + dataResult.qtyStock + " " + txtUnite);
                        } else if (dataResult.statusCode === 202) {
                            ErrorFuntion("ເຄື່ອງດຶ່ມໝົດແລ້ວ");
                        }else if(dataResult.statusCode===203){
                            $('.order_list_pro_qty').val(numeral(dataResult.qtyStock).format('0,000'));
                            $('.txtProGif2').val(dataResult.qtyAmount);
                            ErrorFuntion("ເຄື່ອງດຶ່ມບໍ່ພໍຂາຍ+ແຖມ ");
                        }else {
                            if (dataResult.statusCode != "0") {
                                $('.order_list_pro_qty').val(numeral(dataResult.statusCode).format('0,000'));
                            } else {
                                $('.order_list_pro_qty').val(numeral(start_qty).format('0,000'));
                            }
                        }
                    }
                })

            } else {
                if (dataInput === "plus") {
                    plus_total = parseFloat(order_list_pro_qty+start_qty);
                    $('.order_list_pro_qty').val(numeral(plus_total).format('0,000'));
                } else if (dataInput === "minus") {
                    if (order_list_pro_qty != "1") {
                        plus_total = parseFloat(order_list_pro_qty-start_qty);
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
            }
        }
        //=======================Add Orders====================================
        $("#addOrder").on("submit", function(event) {
            event.preventDefault();
            $.ajax({
                url: "services/sql/service-pos.php?addProduct",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(data) {
                    var dataResult = JSON.parse(data);
                    if (dataResult.statusCode == 200) {
                        $("#modal_product_item").modal("hide");
                        // successfuly("ເພີ່ມສໍາເລັດແລ້ວ");
                        load_orders();
                        load_category(dataResult.Cate)
                    } else if (dataResult.statusCode == 300) {
                        $("#modal_product_item").modal("hide");
                        // successfuly("ສັ່ງເພີ່ມສໍາເລັດ");
                        load_orders();
                        load_category(dataResult.Cate);
                        commitOrders(2);
                    } else {
                        ErrorFuntion("ສິນຄ້າໃນສະຕ໋ອກໝົດແລ້ວ");
                        loadContent(1)
                    }
                }
            })
        });

        //=======================Delete Orders=================================
        function fnDeleteOrder(idTb,idBill,idOrder, idProduct, idQty, idStock, idCate,gifAmount) {
            var totalQty=parseFloat(idQty)+parseFloat(gifAmount);
            $.ajax({
                url: "services/sql/service-pos.php?deleteOrder",
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
                        load_orders();
                        load_category(idCate)
                        commitOrders(2);
                    } else {
                        Error_data();
                    }
                }
            });
        }

        //=====================Discount Orders=================================
        function fnDiscount(idOrder, idAmount, idPrice) {
            $("#modalPercented").modal("show");
            $("#discount_price").val(numeral(idPrice).format('0,000'));
            $("#discount_oldPrice").val(idPrice)
            $("#proID").val(idOrder);
            $("#percented").val("");
            $("#discount_amount").val("");
            $("#discount_total").val("");
            auto_focus("modalPercented", "percented");
            changTypeDiscount('type_discount', 'percented', '');
        }

        //=====================Caculator Discount==============================
        function changTypeDiscount(type_discount, percented, numberKeybord) {
            var type_discount1 = $("#" + type_discount).val();
            var percented1 = $("#" + percented).val() + numberKeybord;
            var discount_price1 = $("#discount_price").val();
            var discount_price = Number(discount_price1.replace(/[^0-9\.-]+/g, ""));
            var inputPer = Number(percented1.replace(/[^0-9\.-]+/g, ""));

            if (type_discount1 === "1") {
                $("#label_percented").text("ເປີເຊັນ %");
                if (percented1.length <= "3") {
                    if (percented1 === "0") {
                        $("#" + percented).val("");
                    } else {
                        if (percented1 <= 100) {
                            var amount = parseFloat((percented1 / 100) * discount_price);
                            var total = discount_price - amount;
                            if (percented1 === "") {
                                $("#" + percented).val("");
                                $("#discount_amount").val("");
                                $("#discount_total").val("");
                                $("#" + percented).focus();
                                auto_focus("modalPercented", "percented");
                            } else {
                                $("#" + percented).val(numeral(percented1).format('0,000'));
                                $("#discount_total").val(numeral(total).format('0,000'));
                                $("#discount_amount").val(numeral(amount).format('0,000'));
                                $("#" + percented).focus();
                            }
                        } else {
                            $("#" + percented).val(numeral("100").format('0,000'));
                            $("#discount_amount").val(numeral(discount_price).format('0,000'));
                        }
                    }

                } else {
                    if (percented1.length <= "3") {
                        del()
                    } else {
                        $("#" + percented).val(numeral("100").format('0,000'));
                        $("#discount_amount").val(numeral(discount_price).format('0,000'));
                    }
                }
            } else {
                $("#label_percented").text("ຫຼຸດເປັນເງິນ");
                if (percented1 === "") {
                    $("#" + percented).val("");
                    $("#" + percented).focus();
                } else {
                    if (discount_price >= inputPer) {
                        var total = parseFloat(discount_price - inputPer);
                        $("#" + percented).val(numeral(percented1).format('0,000'));
                        $("#discount_amount").val(numeral(percented1).format('0,000'));
                        $("#discount_total").val(numeral(total).format('0,000'));
                    } else {
                        var total = discount_price;
                        $("#" + percented).val(numeral(total).format('0,000'));
                        $("#discount_amount").val(numeral(total).format('0,000'));
                        $("#discount_total").val("0");
                    }


                }
            }
        }
        //=====================Delete Discount==================================
        function del() {
            var currentValue = percented.value;
            percented.value = currentValue.substr(0, percented.value.length - 1);
            var discount_price = Number($("#discount_price").val().replace(/[^0-9\.-]+/g, ""));
            var inputPer = Number(percented.value.replace(/[^0-9\.-]+/g, ""));
            var type_discount = $("#type_discount").val();
            if (type_discount === "1") {
                var amount = parseFloat((inputPer / 100) * discount_price);
                var total = discount_price - amount;
                if (percented.value === "" || percented.value === "0") {
                    $("#percented").val("");
                } else {
                    $("#percented").val(numeral(inputPer).format('0,000'));
                    $("#discount_total").val(numeral(total).format('0,000'));
                    $("#discount_amount").val(numeral(amount).format('0,000'));
                }
                $("#percented").focus();
            } else {
                var total = parseFloat(discount_price - inputPer);
                $("#percented").val(numeral(percented.value).format('0,000'));
                $("#discount_amount").val(numeral(percented.value).format('0,000'));
                $("#discount_total").val(numeral(total).format('0,000'));
                if (percented.value === "" || percented.value === "0") {
                    $("#discount_total").val("");
                } else {
                    $("#discount_total").val(numeral(total).format('0,000'));
                }
            }
        }
        //=====================PlusQty Orders===================================
        function fnPlusQty(idOrder, cutStock, price, plus, proCode, perPrice,gifQty,gifAmount) {
            if (plus === "plus") {
                var plusQty = $("#plusQty" + idOrder).val();
            } else {
                var plusQty = $("#minusQty" + idOrder).val();
            }
            $.ajax({
                url: "services/sql/service-pos.php?changPlusQty",
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
                    load_orders();
                    commitOrders();
                }
            });
        }



        //=====================Sumib Discount===================================
        $("#addPercented").on("submit", function(event) {
            event.preventDefault();
            if ($("#percented").val() == "") {
                $("#percented").focus();
                return false;
            } else {
                $.ajax({
                    url: "services/sql/service-pos.php?editPercented",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        var dataResult = JSON.parse(data);
                        if (dataResult.statusCode == 200) {
                            $("#modalPercented").modal("hide");
                            successfuly("ເພີ່ມສ່ວນຫຼຸດສໍາເລັດແລ້ວ");
                            load_orders();
                        }

                    }
                })
            }
        })
        //=====================Confirm Orders===================================

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
            // socket.emit('order', info)

            $.ajax({
                url: "services/sql/service-pos.php?editStatusTable",
                method: "POST",
                data: {
                    table_no,
                    bill_no
                },
                success: function(data) {
                    load_orders();
                    socket.emit('order', info)
                }
            })
        });

    </script>

    <script>
        socket.on('showTable', (response) => {
            load_orders();
        })
    </script>

</body>

</html>