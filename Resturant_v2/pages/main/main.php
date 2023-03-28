<?php
include_once('component/main_packget_all.php');
$packget_all = new packget_all();
function app_sidebar_minified()
{
    // echo "app-sidebar-minified";
    echo "";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Main app</title>
    <?php $packget_all->main_css(); ?>
    <style>
        .font_size {
            font-size: 14px !important;
        }

        .fw-bold {
            font-size: 16px !important;
        }

        .stats-title {
            font-size: 16px !important;
            color:#0F253B !important
        }
        .stats-number{
            color:#0F253B !important;
        }
        .stats-desc{
            color:#2d06d8 !important;
        }
        .widget-stats{
            border-radius: 0px !important;
        }

        fieldset.scheduler-border {
            border: 1px groove #ddd !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
            margin-top: 30px !important;
        }

        legend.scheduler-border {
            font-size: 1.2em !important;
            font-weight: bold !important;
            text-align: left !important;
            width: auto;
            padding: 0 10px;
            border-bottom: none;
            margin-top: -15px;
            background-color: white;
            color: black;
        }

    </style>
</head>

<body class="pace-done theme-dark" style="background-color: white !important;">
    <?php $packget_all->main_loadding(); ?>
    <div id="app" class="app app-header-fixed app-sidebar-fixed <?php echo app_sidebar_minified() ?>">
        <?php $packget_all->main_header(); ?>
        <?php $packget_all->main_sidebar(); ?>

        <div id="content" class="app-content">

            <ol class="breadcrumb float-xl-end">
                <li class="breadcrumb-item active">
                    <button type="button" name="print" class="btn btn-warning btn-xs" data-bs-toggle="modal" data-bs-target="#modalPreview">
                        <ion-icon name="print-outline" style="font-size: 25px;"></ion-icon>
                    </button>
                </li>
            </ol>


            <h1 class="page-header">☞ ຍອດຂາຍລະອຽດ</h1>
            <div class="row">
                <div class="col-xl-4 col-md-6">
                    <div class="widget widget-stats bg-gray-300">
                        <div class="stats-icon stats-icon-lg"><ion-icon name="wallet-outline"></ion-icon></div>
                        <div class="stats-content">
                            <div class="stats-title"><div class="flag-icon flag-icon-la h5 rounded mb-0" title="la" id="la"></div> ຍອດຂາຍເງິນສົດ ກີບ</div>
                            <div class="stats-number" id="total_kip">0</div>
                            <div class="stats-progress progress">
                                <div class="progress-bar" style="width: 1%;"></div>
                            </div>
                            <div class="stats-desc">✔ ເງິນສົດ</div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="widget widget-stats bg-gray-300">
                        <div class="stats-icon stats-icon-lg"><ion-icon name="wallet-outline"></ion-icon></div>
                        <div class="stats-content">
                            <div class="stats-title"><div class="flag-icon flag-icon-th h5 rounded mb-0" title="th" id="th"></div> ຍອດຂາຍເງິນສົດ ບາດ</div>
                            <div class="stats-number" id="total_bath">0</div>
                            <div class="stats-progress progress">
                                <div class="progress-bar" style="width: 1%;"></div>
                            </div>
                            <div class="stats-desc">✔ ເງິນສົດ</div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="widget widget-stats bg-gray-300">
                        <div class="stats-icon stats-icon-lg"><ion-icon name="wallet-outline"></ion-icon></div>
                        <div class="stats-content">
                            <div class="stats-title"><div class="flag-icon flag-icon-us h5 rounded mb-0" title="us" id="us"></div> ຍອດຂາຍເງິນສົດ ໂດຣາ</div>
                            <div class="stats-number" id="total_us">0</div>
                            <div class="stats-progress progress">
                                <div class="progress-bar" style="width: 1%;"></div>
                            </div>
                            <div class="stats-desc">✔ ເງິນສົດ</div>
                        </div>
                    </div>
                </div>


                <div class="col-xl-4 col-md-6">
                    <div class="widget widget-stats bg-gray-300">
                        <div class="stats-icon stats-icon-lg"><ion-icon name="wallet-outline"></ion-icon></div>
                        <div class="stats-content">
                            <div class="stats-title"><div class="flag-icon flag-icon-la h5 rounded mb-0" title="la" id="la"></div> ຍອດຂາຍເງິນໂອນ ກີບ</div>
                            <div class="stats-number" id="transfer_kip">0</div>
                            <div class="stats-progress progress">
                                <div class="progress-bar" style="width: 1%;"></div>
                            </div>
                            <div class="stats-desc">✔ ເງິນໂອນ</div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="widget widget-stats bg-gray-300">
                        <div class="stats-icon stats-icon-lg"><ion-icon name="wallet-outline"></ion-icon></div>
                        <div class="stats-content">
                            <div class="stats-title"><div class="flag-icon flag-icon-th h5 rounded mb-0" title="th" id="th"></div> ຍອດຂາຍເງິນໂອນ ບາດ</div>
                            <div class="stats-number" id="transfer_bath">0</div>
                            <div class="stats-progress progress">
                                <div class="progress-bar" style="width: 2%;"></div>
                            </div>
                            <div class="stats-desc">✔ ເງິນໂອນ</div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="widget widget-stats bg-gray-300">
                        <div class="stats-icon stats-icon-lg"><ion-icon name="wallet-outline"></ion-icon></div>
                        <div class="stats-content">
                            <div class="stats-title"><div class="flag-icon flag-icon-us h5 rounded mb-0" title="us" id="us"></div> ຍອດຂາຍເງິນໂອນ ໂດຣາ</div>
                            <div class="stats-number" id="transfer_us">0</div>
                            <div class="stats-progress progress">
                                <div class="progress-bar" style="width: 1%;"></div>
                            </div>
                            <div class="stats-desc">✔ ເງິນໂອນ</div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12 col-md-12">
                    <h1 class="page-header">☞ ຍອດຂາຍລວມ</h1>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="widget widget-stats bg-gray-300">
                        <div class="stats-icon stats-icon-lg"><ion-icon name="wallet-outline"></ion-icon></div>
                        <div class="stats-content">
                            <div class="stats-title"><div class="flag-icon flag-icon-la h5 rounded mb-0" title="la" id="la"></div> ຍອດຂາຍຕົວຈິງ ( ກີບ )</div>
                            <div class="stats-number" id="totals">0</div>
                            <div class="stats-progress progress">
                                <div class="progress-bar" style="width: 70.1%;"></div>
                            </div>
                            <div class="stats-desc">ຍອດຂາຍຕົວຈິງໝົດມື້</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="widget widget-stats bg-gray-300">
                        <div class="stats-icon stats-icon-lg"><ion-icon name="wallet-outline"></ion-icon></div>
                        <div class="stats-content">
                            <div class="stats-title"><div class="flag-icon flag-icon-la h5 rounded mb-0" title="la" id="la"></div> ເງິນທອນທັງໝົດ ( ກີບ )</div>
                            <div class="stats-number" id="total_return">0</div>
                            <div class="stats-progress progress">
                                <div class="progress-bar" style="width: 70.1%;"></div>
                            </div>
                            <div class="stats-desc">ຍອດເງິນທອນໝົດມື້</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="widget widget-stats bg-gray-300">
                        <div class="stats-icon stats-icon-lg"><ion-icon name="wallet-outline"></ion-icon></div>
                        <div class="stats-content">
                            <div class="stats-title"><div class="flag-icon flag-icon-la h5 rounded mb-0" title="la" id="la"></div> ຍອດເງິນຕິດໜີ້ ( ກີບ )</div>
                            <div class="stats-number" id="total_ny">0</div>
                            <div class="stats-progress progress">
                                <div class="progress-bar" style="width: 70.1%;"></div>
                            </div>
                            <div class="stats-desc">ຍອດຂາຍລູກຄ້າຕິດໜີ້</div>
                        </div>
                    </div>
                </div>

                
                <div class="modal fade" id="modalPreview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                        <!-- <div class="modal-header">
                            <h5 class="modal-title" id="modalPreviewLabel">ແບບການພິມ</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div> -->
                        <div class="modal-body">
                            <form action="services/print-excel/print-deshboard.php" method="POST" target="_bank">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border"><h3><ion-icon name="print-outline" style="font-size: 25px;"></ion-icon> ເລືອກພິມລາຍງານ</h3></legend>
                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="printAll" name="printData" value="1" checked />
                                                <label class="form-check-label" for="printAll">ພິມລາຍງານແບບລວມ</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="printList" name="printData" value="2" />
                                                <label class="form-check-label" for="printList">ພິມລາຍງານແບບລະອຽດ</label>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-warning"><ion-icon name="print-outline" style="font-size: 25px;"></ion-icon><br>ພິມຂໍ້ມູນ</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><ion-icon name="close-outline" style="font-size: 25px;"></ion-icon><br>ປິດໜ້າຕ່າງ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php $packget_all->main_script(); ?>
    <script>
        load_Dashboard()

        function load_Dashboard() {
            $.ajax({
                url: "services/sql/service-dashboard.php?fetch",
                method: "POST",
                dataType: "json",
                success: function(data) {
                    $("#totals").html(numeral(data.total).format('0,000'));
                    $("#total_kip").html(numeral(data.amount_cash_kip).format('0,000'));
                    $("#total_bath").html(numeral(data.amount_cash_bath).format('0,000'));
                    $("#total_us").html(numeral(data.amount_cash_us).format('0,000'));
                    $("#transfer_kip").html(numeral(data.amount_transfer_kip).format('0,000'));
                    $("#transfer_bath").html(numeral(data.amount_transfer_bath).format('0,000'));
                    $("#transfer_us").html(numeral(data.amount_transfer_us).format('0,000'));
                    $("#total_return").html(numeral(data.return_all).format('0,000'));
                    $("#total_ny").html(numeral(data.amount_ny).format('0,000'));
                }
            })
        }
    </script>

</body>

</html>