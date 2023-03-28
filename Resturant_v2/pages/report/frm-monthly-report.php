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
    <title>Daily Report</title>
    <?php $packget_all->main_css(); ?>
    <style>
        td{vertical-align: middle;}
        select{border-radius: 0px !important;}
    </style>
</head>

<body class="pace-done theme-dark">
    <?php $packget_all->main_loadding(); ?>
    <div id="app" class="app app-header-fixed app-sidebar-fixed <?php echo app_sidebar_minified()?>">
        <?php $packget_all->main_header(); ?>
        <?php $packget_all->main_sidebar(); ?>

        <div id="content" class="app-content px-3">
            <form action="services/print-excel/print-monthly-report.php" target="_bank" method="POST">
                <ol class="breadcrumb float-xl-end">
                    <li class="breadcrumb-item active">
                        <button type="submit" name="print" class="btn btn-warning btn-xs">
                            <ion-icon name="print-outline" style="font-size: 25px;"></ion-icon>
                        </button>
                        <button type="submit" name="excel" class="btn btn-success btn-xs">
                            <ion-icon name="download-outline" style="font-size: 25px;"></ion-icon>
                        </button>
                    </li>
                </ol>

                <h4 class="page-header" style="font-size:22px !important;font-weight:bold">
                    <i class="fas fa-file-pdf"></i> ລາຍງານການຂາຍປະຈໍາເດືອນ
                </h4>

                <div class="panel panel-inverse">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="" class="mb-1">ວັນທີ/ເດືອນ/ປີ</label>
                                <input type="date" class="form-control input_color" id="start_date" name="start_date" value="<?php echo date('Y-m-d', strtotime('first day of last month'))?>">
                            </div>
                            <div class="col-md-2">
                                <label for="" class="mb-1">ຫາ ວັນທີ/ເດືອນ/ປີ</label>
                                <input type="date" class="form-control input_color" id="end_date" name="end_date" value="<?php echo date("Y-m-d")?>">
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-2">
                                <label for="" class="mb-1">ຄົ້ນຫາ</label>
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
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <select name="limit_page" id="limit_page" class="select_option">
                                    <option value="30">30</option>
                                    <option value="50">50</option>
                                    <option value="90">90</option>
                                    <option value="150">150</option>
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
                                <thead>
                                    <tr>
                                        <td rowspan="2" widtd="5%" style="text-align:center !important;">ລໍາດັບ</td>
                                        <td rowspan="2" style="text-align: center;">ເດືອນ</td>
                                        <td rowspan="2" align="center">ລວມບິນຂາຍ</td>
                                        <td rowspan="2">ລວມຍອດຂາຍກ່ອນຫຼຸດ</td>
                                        <td colspan="2" align="center">ລວມສ່ວນຫຼຸດ</td>
                                        <td rowspan="2">ລວມຍອດຂາຍຫຼັງຫຼຸດ</td>
                                        <td colspan="3" align="center" style="background-color: #007AFF;">ລວມຍອດເງິນສົດ</td>
                                        <td colspan="3" align="center" style="background-color: #DB4900;">ລວມຍອດເງິນໂອນ</td>
                                        <td rowspan="2">ລວມຍອດເງິນທອນ</td>
                                    </tr>
                                    <tr>
                                        <td>ຫຼຸດເປັນລາຍການ</td>
                                        <td>ຫຼຸດທ້າຍບິນ</td>
                                        <td align="center" style="background-color: #007AFF;">ຈ່າຍກີບ</td>
                                        <td align="center" style="background-color: #007AFF;">ຈ່າຍບາດ</td>
                                        <td align="center" style="background-color: #007AFF;">ຈ່າຍໂດຣາ</td>

                                        <td align="center" style="background-color: #DB4900;">ໂອນກີບ</td>
                                        <td align="center" style="background-color: #DB4900;">ໂອນບາດ</td>
                                        <td align="center" style="background-color: #DB4900;">ໂອນໂດຣາ</td>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        
        <?php $packget_all->main_script(); ?>
        <script src="assets/js/service-all.js"></script>
        <script>
            SearchData();
            function SearchData(){
                var start_date=$("#start_date").val();
                var end_date=$("#end_date").val();
                $.ajax({
                    url:"services/report/monly-report.php?monlyRp",
                    method:"POST",
                    data:{start_date,end_date},
                    success:function(data){
                        $("tbody").html(data);
                    }
                })
            }


        </script>
</body>

</html>