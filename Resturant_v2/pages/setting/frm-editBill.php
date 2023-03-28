<?php
include_once('component/main_packget_all.php');
$packget_all = new packget_all();
function app_sidebar_minified(){
    echo "app-sidebar-minified";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cancel Bill</title>
    <?php $packget_all->main_css(); ?>
</head>

<body class="pace-done theme-dark">
    <?php $packget_all->main_loadding(); ?>
    <div id="app" class="app app-header-fixed app-sidebar-fixed <?php echo app_sidebar_minified()?>">
        <?php $packget_all->main_header(); ?>
        <?php $packget_all->main_sidebar(); ?>

        <div id="content" class="app-content px-3">
                <div class="row">
                    <div class="col-md-7">
                        <h4 class="page-header" style="font-size:22px !important;font-weight:bold">
                            <i class="fas fa-file-alt"></i> ລາຍການບິນຂາຍ
                        </h4>
                    </div>
                    <div class="col-md-5">
                        <div class="alert alert-orange text-dark" role="alert" style="background-color: #fff3d6 !important;border:1px solid #d69704;font-size:14px;">
                            <span class="text-danger">ໝາຍເຫດ</span> : ສາມາດແກ້ໄຂ ຫຼື ຍົກເລີກບິນຂາຍຍ້ອນຫຼັງໄດ້ 1 ມື້ເທົ່ານັ້ນ !
                        </div>
                    </div>
                </div>

                <div class="panel panel-inverse">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="" class="mb-1">ວັນທີ່ຂາຍ ວ/ດ/ປ</label>
                                <input type="date" class="form-control input_color" id="start_date" name="start_date" value="<?php echo date("Y-m-d")?>">
                            </div>
                            <div class="col-md-2">
                                <label for="" class="mb-1">ຫາວັນທີ່ ວ/ດ/ປ</label>
                                <input type="date" class="form-control input_color" id="end_date" name="end_date" value="<?php echo date("Y-m-d")?>">
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="" class="mb-1">ຊື່ຮ້ານ <span class="text-danger">*</span></label>
                                    <select name="search_store" id="search_store" class="form-select search_store" onchange="res_searchBranch('search_store')">
                                        <option value="">ເລືອກ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="" class="mb-1">ສາຂາ <span class="text-danger">*</span></label>
                                    <select name="search_branch" id="search_branch" class="form-select search_branch">
                                        <option value="">ເລືອກ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="" class="mb-1">ປະເພດຊໍາລະ</label>
                                <select name="typePayment" id="typePayment" class="form-select typePayment">
                                    <option value="">ທັງໝົດ</option>
                                    <option value="1">ເງິນສົດ</option>
                                    <option value="2">ເງິນໂອນ</option>
                                    <option value="3">ເງິນສົດ-ໂອນ</option>
                                    <option value="4">ບິນຕິດໜີ້</option>
                                    <!-- <option value="5">ບິນສັ່ງກັບບ້ານ</option> -->
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="" class="mb-1">ເລກບິນ/ເບີໂຕະ</label>
                                <div class="input-group">
                                    <input type="text" id="search_page" name="search_page" class="form-control input_color" placeholder="Search...">
                                    <button type="button" class="btn btn-primary search" onclick="SearchData()">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-inverse">
                    <div class="panel-body px-1">
                        <div class="row">
                            <div class="col-md-2">
                                <select name="limit_page" id="limit_page" class="select_option">
                                    <option value="100">100</option>
                                    <option value="150">150</option>
                                    <option value="500">500</option>
                                    <option value="1000">1000</option>
                                    <option value="">ທັງໝົດ</option>
                                </select>
                            </div>
                            <div class="col-md-9"></div>
                            <div class="col-md-1">
                                <select name="order_page" id="order_page" class="select_option">
                                    <option value="ASC">ນ້ອຍຫາໃຫຍ່</option>
                                    <option value="DESC">ໃຫຍ່ຫານ້ອຍ</option>
                                    
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body px-0" style="margin-top:-14px;">
                        <div class="table-responsive">
                            <table class="table" id="showData">
                                
                            </table>
                            
                        </div>
                    </div>
                </div>
        </div>


        <div class="modal fade" id="modal_remark" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">ເຫດຜົນທີ່ຍົກເລີກ</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="frmCancelBill">
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="" class="mb-2">ເຫດຜົນທີ່ຍົກເລີກ <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control input_color" id="list_bill_remark" name="list_bill_remark" placeholder="ປ້ອນເຫດຜົນທີ່ຍົກເລີກ" autocomplete="off" required>
                                        <input type="text" hidden name="bill_no" id="bill_no">
                                    </div>
                                    <div class="form-group mb-2 mt-2">
                                        <label for="" class="mb-2">ຍົກເລີກບິນໂດຍ</label>
                                        <input type="text" class="form-control input_color" value="<?php echo $_SESSION["users_name"]?>" autocomplete="off" required readonly style="background:#eff1f2">
                                        <input type="text" class="form-control input_color" hidden id="list_bill_cancel_by" name="list_bill_cancel_by" value="<?php echo $_SESSION["users_id"]?>" autocomplete="off" required>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <div class="alert alert-orange text-dark" role="alert">
                                        <span class="text-danger">ໝາຍເຫດ</span> : ເມື່ອຍົກເລີກບິນແລ້ວຈະບໍ່ສາມາດກູ້ກັບຄືນມາໄດ້ !
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-primary btn-lg" id="btn_payment"><i class="fas fa-trash"></i> ຢືນຢັນ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
        <?php $packget_all->main_script(); ?>
        <script src="assets/js/service-all.js"></script>
        <script>
            res_storeSearch('search_store');
            res_store('branch_store');

            $(document).on("click",".editBill_no",function(){
                $("#modalCheckbill").modal("show");
            });

            SearchData(1);
            function SearchData(page="1"){
                var start_date=$("#start_date").val();
                var end_date=$("#end_date").val();
                var limit=$("#limit_page").val();
                var order_page=$("#order_page").val();
                var search_page=$("#search_page").val();
                var typePayment=$("#typePayment").val();
                var search_branch=$("#search_branch").val();
                $.ajax({
                    url:"services/sql/service-edit-bill.php?editBill",
                    method:"POST",
                    data:{page,start_date,end_date,limit,order_page,search_page,typePayment,search_branch},
                    success:function(data){
                        $("#showData").html(data);
                    }
                })
            }

            $(document).on('click', '.page-link', function() {
                var page = $(this).data('page_number');
                if (page != undefined) {
                    SearchData(page);
                }
            });

            function deleteBill(BillID){
                $("#bill_no").val(BillID);
                $("#list_bill_remark").val("");
                $("#list_bill_remark").focus();
                $("#modal_remark").modal("show");
            }

            $("#frmCancelBill").on("submit",function(event){
                event.preventDefault();
                Swal.fire({
                    title: 'ແຈ້ງເຕືອນ?',
                    text: "ຢືນຢັນການຍົກເລີກບິນ!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<i class="fas fa-save"></i> ຢືນຢັນ',
                    cancelButtonText: '<i class="fas fa-times"></i> ປິດ'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "services/sql/service-edit-bill.php?deleteData",
                            method: "POST",
                            data:new FormData(this),
                            contentType:false,
                            processData:false,
                            success: function(data) {
                                var dataResult = JSON.parse(data);
                                if (dataResult.statusCode == 200) {
                                    successfuly('ລຶບຂໍ້ມູນສໍາເລັດແລ້ວ');
                                    $("#frmCancelBill")[0].reset();
                                    $("#modal_remark").modal("hide");
                                    SearchData(1);
                                } else {
                                    Error_data();
                                }
                            }
                        });
                    }
                })
            });


        </script>
        
</body>

</html>