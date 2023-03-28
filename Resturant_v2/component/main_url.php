<?php
session_start();
class Page{
    public function mypage(){
        date_default_timezone_set('Asia/Bangkok');
        include_once('services/config/db.php');
        if (@$_SESSION['myApp'] != '1') {
            include_once('login.php');
        } else {
            if (isset($_REQUEST['main'])) {
                include_once('pages/main/main.php');
            }elseif (isset($_REQUEST['company'])) {
                include_once('pages/setting/frm-companyinfo.php');
            }elseif (isset($_REQUEST['branch'])) {
                include_once('pages/setting/frm-branch-list.php');
            }elseif (isset($_REQUEST['custommer'])) {
                include_once('pages/setting/frm-custommer-list.php');
            }elseif (isset($_REQUEST['rate_exchange'])) {
                include_once('pages/setting/frm-rate-exchange.php');
            } elseif (isset($_REQUEST['group-large'])) {
                include_once('pages/setting/frm-group-large.php');
            } elseif (isset($_REQUEST['category'])) {
                include_once('pages/setting/frm-category.php');
            }elseif (isset($_REQUEST['zone'])) {
                include_once('pages/setting/frm-zone.php');
            }elseif (isset($_REQUEST['table-list'])) {
                include_once('pages/setting/frm-table-list.php');
            }elseif (isset($_REQUEST['unite'])) {
                include_once('pages/setting/frm-unite.php');
            }elseif (isset($_REQUEST['colors'])) {
                include_once('pages/setting/frm-colors.php');
            }elseif (isset($_REQUEST['add_product'])) {
                include_once('pages/products/frm-add-product.php');
            }elseif (isset($_REQUEST['product_list'])) {
                include_once('pages/products/frm-product-list.php');
            }elseif (isset($_REQUEST['table_list'])) {
                include_once('pages/pos/frm-pos-table.php');
            }elseif (isset($_REQUEST['pos'])) {
                include_once('pages/pos/frm-pos-sale.php');
            }elseif (isset($_REQUEST['cooks'])) {
                include_once('pages/pos/frm-pos-cook.php');
            }elseif (isset($_REQUEST['bar'])) {
                include_once('pages/pos/frm-pos-bar.php');
            }elseif(isset($_REQUEST['previewBill'])) {
                include_once('pages/print/frm-preview-bill.php');
            }elseif(isset($_REQUEST['checkBill'])) {
                include_once('pages/print/frm-check-bill.php');
            }elseif(isset($_REQUEST['dailyReport'])) {
                include_once('pages/report/frm-daily-report.php');
            }elseif(isset($_REQUEST['monthlyReport'])) {
                include_once('pages/report/frm-monthly-report.php');
            }elseif(isset($_REQUEST['bast-sale'])) {
                include_once('pages/report/frm-bast-sale.php');
            }elseif(isset($_REQUEST['count-stock'])) {
                include_once('pages/report/frm-count-stock.php');
            }
            elseif(isset($_REQUEST['permission'])) {
                include_once('pages/setting/frm-permission.php');
            }elseif(isset($_REQUEST['userlogin'])) {
                include_once('pages/setting/frm-userlogin.php');
            }elseif(isset($_REQUEST['order-item'])) {
                include_once('pages/setting/frm-orders-item.php');
            }elseif(isset($_REQUEST['receive'])) {
                include_once('pages/setting/frm-receive.php');
            }elseif(isset($_REQUEST['ny_list'])) {
                include_once('pages/setting/frm-ny-list.php');
            }elseif(isset($_REQUEST['cancel_list'])) {
                include_once('pages/report/frm-cancel-list.php');
            }elseif(isset($_REQUEST['promotion'])) {
                include_once('pages/setting/frm-promotion.php');
            }elseif(isset($_REQUEST['expenses'])) {
                include_once('pages/setting/frm-expenses.php');
            }elseif(isset($_REQUEST['editBill'])) {
                include_once('pages/setting/frm-editBill.php');
            }elseif(isset($_REQUEST['edit_pos'])) {
                include_once('pages/pos/frm-edit-pos-sale.php');
            }elseif(isset($_REQUEST['print_edit'])) {
                include_once('pages/print/frm-check-bill-edit.php');
            }elseif(isset($_REQUEST['print_Preview'])) {
                include_once('pages/print/frm-print-Preview.php');
            }elseif(isset($_REQUEST['logout'])) {
                include_once('logout.php');
            } else {
                include_once('logout.php');
            }
        }
    }
}?>
