<?php
include_once('component/main_packget_all.php');
$packget_all = new packget_all();
function app_sidebar_minified()
{
    echo "app-sidebar-minified";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bast sale</title>
    <?php $packget_all->main_css(); ?>
</head>

<body class="pace-done theme-dark">
    <?php $packget_all->main_loadding(); ?>
    <div id="app" class="app app-header-fixed app-sidebar-fixed <?php echo app_sidebar_minified() ?>">
        <?php $packget_all->main_header(); ?>
        <?php $packget_all->main_sidebar(); ?>

        <div id="content" class="app-content px-3">
            <form action="services/print-excel/print-bast-sale-report.php" target="_bank" method="POST">
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
                    <i class="fas fa-file-alt"></i> ລາຍງານສິນຄ້າຂາຍດີ
                </h4>

                <div class="panel panel-inverse">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="" class="mb-1">ວັນທີ່ຂາຍ ວ/ດ/ປ</label>
                                <input type="date" class="form-control input_color" id="start_date" name="start_date" value="<?php echo date("Y-m-d") ?>">
                            </div>
                            <div class="col-md-2">
                                <label for="" class="mb-1">ຫາວັນທີ່ ວ/ດ/ປ</label>
                                <input type="date" class="form-control input_color" id="end_date" name="end_date" value="<?php echo date("Y-m-d") ?>">
                            </div>
                            <div class="col-md-2">
                                <label for="" class="mb-1">ຊື່ຮ້ານ</label>
                                <div class="form-group">
                                    <select name="search_store" id="search_store" class="form-select search_store" required onchange="res_searchBranch('search_store')">
                                        <option value="">ເລືອກ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="" class="mb-1">ຊື່ສາຂາ</label>
                                <div class="form-group">
                                    <select name="search_branch" id="search_branch" class="form-select search_branch">
                                        <option value="">ເລືອກ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <label for="" class="mb-1">ປະເພດສິນຄ້າ</label>
                                <select name="type_cate" id="type_cate" class="form-select type_cate">
                                    <option value="">ທັງໝົດ</option>
                                    <option value="1">ອາຫານ</option>
                                    <option value="2">ເຄື່ອງດຶ່ມ</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <label for="" class="mb-1">ລຽງຕາມ</label>
                                <select name="orderBy" id="orderBy" class="form-select orderBy">
                                    <option value="1">ຈໍານວນ</option>
                                    <option value="2">ຍອດເງິນ</option>
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
                    <div class="panel-body px-0" style="margin-top:-16px;">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td align="center">ວັນທີ່</td>
                                        <td align="center">ປະເພດ</td>
                                        <td align="center">ລໍາດັບ</td>
                                        <td>ຊື່ອາຫານ ຫຼື ເຄື່ອງດຶ່ມ</td>
                                        <td align="center">ລາຄາ</td>
                                        <td align="center">ຈໍານວນ</td>
                                        <td align="center">ຍອດລວມ</td>
                                    </tr>
                                </thead>
                                <tbody class="table-bordered-y">

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
            res_storeSearch('search_store');
            res_store('branch_store');
            SearchData(1);

            function SearchData(page = "1") {
                var start_date = $("#start_date").val();
                var end_date = $("#end_date").val();
                var type_cate = $("#type_cate").val();
                var search_branch = $("#search_branch").val();
                // var limit=$("#limit_page").val();
                // var order_page=$("#order_page").val();
                var search_page = $("#search_page").val();
                var orderBy = $("#orderBy").val();
                $.ajax({
                    url: "services/report/bast-sale-report.php?report",
                    method: "POST",
                    data: {
                        page,
                        start_date,
                        end_date,
                        type_cate,
                        search_page,
                        orderBy,
                        search_branch
                    },
                    // data:{page,start_date,end_date,type_cate,limit,order_page,search_page,orderBy},
                    success: function(data) {
                        $("tbody").html(data);
                    }
                })
            }

            // $(document).on('click', '.page-link', function() {
            //     var page = $(this).data('page_number');
            //     if (page != undefined) {
            //         SearchData(page);
            //     }
            // });
        </script>
</body>

</html>