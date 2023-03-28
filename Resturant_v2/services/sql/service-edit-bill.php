<?php session_start();
    include_once("../config/db.php");
    $db = new DBConnection();
    
    if(isset($_GET["editBill"])){
        $limit = $_POST["limit"];
        $page = 1;
        if (@$_POST['page'] > 1) {
            $start = (($_POST['page'] - 1) * $limit);
            $page = $_POST['page'];
        } else {
            $start = 0;
        }


        @$query.="view_daily_report_group";

        if($_POST["start_date"] !="" && $_POST["end_date"] !=""){
            $query.=" WHERE list_bill_date BETWEEN '".$_POST["start_date"]."' AND '".$_POST["end_date"]."' ";
        }else{
            $query.="";
        }

        if($_POST["search_page"] !=""){
            $sqlCheck=$db->fn_fetch_rowcount("res_bill WHERE bill_code LIKE '%".$_POST["search_page"]."%' ");
            if($sqlCheck>0){
                $query.=" AND list_bill_no LIKE '%".$_POST["search_page"]."%'";
            }else{
                $sqlCheck1=$db->fn_fetch_rowcount("res_tables WHERE table_name LIKE '%".$_POST["search_page"]."%' ");
                if($sqlCheck1>0){
                    $query.=" AND table_name LIKE '%".$_POST["search_page"]."%'  ";
                }else{
                    $query.="AND table_name='123578lkujjsdfsd' ";
                }
            }
        }else{
            $query.="";
        }

        if($_POST["typePayment"] !=""){
            $query.="AND list_bill_type_pay_fk='".$_POST["typePayment"]."'";
        }else{
            $query.="";
        }

        if($_POST["search_branch"] !=""){
            $query.="AND list_bill_branch_fk='".$_POST["search_branch"]."'";
        }else{
            $query.="";
        }


        $query.=" AND list_bill_status='1' ORDER BY list_bill_no ".$_POST['order_page']." ";

        if ($_POST["limit"] != "") {
            $filter_query = $query.' LIMIT '.$start.', '.$limit.'';
        } else {
            $filter_query = $query;
        }

        $fetch_sql=$db->fn_read_all($filter_query);
        $total_data = $db->fn_fetch_rowcount($query);
        $total_id = $start + 1;
?>
    <thead style="border: 1px solid white !important;vertical-align:middle !important">
        <tr>
            <td rowspan="2" widtd="5%" style="text-align:center !important;">ແກ້ໄຂ</td>
            <td rowspan="2" widtd="5%" style="text-align:center !important;">ລໍາດັບ</td>
            <td rowspan="2" style="text-align: center;">ວັນທີ່ຂາຍ</td>
            <td rowspan="2" align="center">ເລກບິນ</td>
            <td rowspan="2" align="center">ເບີໂຕະ</td>
            <td rowspan="2">ປະເພດຊໍາລະ</td>
            <td rowspan="2">ຈໍານວນ</td>
            <td rowspan="2">ຍອດຂາຍລວມ</td>
            <td rowspan="2">ລູກຄ້າຕິດໜີ້</td>
            <td colspan="2" align="center">ສ່ວນຫຼຸດ</td>
            <td colspan="3" align="center" class="bg-primary">ຈ່າຍເງິນສົດ</td>
            <td colspan="3" align="center" class="bg-orange">ຈ່າຍເງິນໂອນ</td>
            <td rowspan="2">ເງິນທອນ</td>
            <td rowspan="2">ຍອດຂາຍຕົວຈິງ</td>
        </tr>
        <tr>
            <td align="center">ເງິນ</td>
            <td align="center">ເປີເຊັນ</td>
            <td align="center" class="bg-primary">ກີບ</td>
            <td align="center" class="bg-primary">ບາດ</td>
            <td align="center" class="bg-primary">ໂດຣາ</td>
            <td align="center" class="bg-orange">ກີບ</td>
            <td align="center" class="bg-orange">ບາດ</td>
            <td align="center" class="bg-orange">ໂດຣາ</td>
        </tr>
    </thead>
    <tbody class="table-bordered-y table-sm display">
<?php
        if ($total_data > 0) {
        foreach($fetch_sql as $row_sql){
            @$sumPerPrice+=$row_sql["list_bill_percented_price"];
            if($row_sql["list_bill_type_pay_fk"]!="4"){
                @$amount+=$row_sql["list_bill_amount"];
                @$sumTotal+=$row_sql["list_bill_amount_kip"];
                @$sumTotalKang+=$row_sql["list_bill_amount_kip"];
                @$sumBill=$row_sql["list_bill_amount"];
                @$sumNy=0;
                @$totalNy+=0;

            }else{
                @$amount+=0;
                @$sumTotal+=0;
                @$sumBill=0;
                @$sumNy=$row_sql["list_bill_amount"];
                @$totalNy+=$row_sql["list_bill_amount"];
            }
            
            @$sumPaykip+=$row_sql["list_bill_pay_kip"];
            @$sumPaybath+=$row_sql["list_bill_pay_bath"];
            @$sumPayus+=$row_sql["list_bill_pay_us"];
            @$sumReturn+=$row_sql["list_bill_return"];
            @$sumQty+=$row_sql["list_bill_qty"]+$row_sql["list_bill_sum_qty_promotion"];
            if($row_sql["list_bill_percented"] !="0"){ 
                @$amountPer=$row_sql["list_bill_percented"]."%";
                $amountPercented=$row_sql["list_bill_total_percented"];
            }else{
                @$amountPer="0";
                @$amountPercented="0";
            }

            @$sumtransferKip+=$row_sql["list_bill_transfer_kip"];
            @$sumtransferBath+=$row_sql["list_bill_transfer_bath"];
            @$sumtransferUs+=$row_sql["list_bill_transfer_us"];

            $sumPer+=$amountPercented;

            if($row_sql["list_bill_type_pay_fk"]=="1"){
                $typePayment="ເງິນສົດ";
                $color="";
            }elseif($row_sql["list_bill_type_pay_fk"]=="2"){
                $typePayment="ເງິນໂອນ";
                $color="";
            }elseif($row_sql["list_bill_type_pay_fk"]=="3"){
                $typePayment="ເງິນສົດ-ໂອນ";
                $color="";
            }elseif($row_sql["list_bill_type_pay_fk"]=="4"){
                $typePayment="ຕິດໜີ້";
                $color="text-danger";
            }else{
                $typePayment="ສັ່ງກັບບ້ານ";
                $color="";
            }

?>
            <tr class="table_hover <?php echo $color;?>">
                <td align="center">
                    <?php 
                        if($row_sql['list_bill_date']>=date("Y-m-d",strtotime("-1 day"))){
                            $disabled="";
                        }else{
                            $disabled="disabled";
                        }
                        if($row_sql['list_bill_date']>=date("Y-m-d",strtotime("-1 day"))){
                    ?>
                        <a href="?edit_pos&bill_no=<?php echo base64_encode($row_sql['list_bill_no']);?>&&table_id=<?php echo base64_encode($row_sql["table_code"]);?>&&table_name=<?php echo base64_encode($row_sql["table_name"]);?>" class="btn btn-outline-primary btn-sm editBill_no"><i class="fas fa-pen"></i> ແກ້ໄຂ</a>
                    <?php }else{?>
                        <button type="button" <?php echo $disabled;?> class="btn btn-outline-primary btn-sm editBill_no"><i class="fas fa-pen"></i> ແກ້ໄຂ</button>
                    <?php }?>
                    <button type="button" class="btn btn-outline-danger btn-sm" <?php echo $disabled;?> onclick="deleteBill('<?php echo $row_sql['list_bill_no'];?>')">
                        <i class="fas fa-trash"></i> ຍົກເລີກ
                    </button>
                </td>
                <td align="center"><?php echo $total_id++;?></td>
                <td align="center"><?php echo date("d/m/Y",strtotime($row_sql["list_bill_date"]))?></td>
                <td align="center"><?php echo $row_sql["list_bill_no"]?></td>
                <td align="center"><?php echo $row_sql["table_name"]?></td>
                <td align="center"><?php echo $typePayment;?></td>
                <td align="center"><?php echo @number_format($row_sql["list_bill_qty"]+$row_sql["list_bill_sum_qty_promotion"])?></td>
                <td align="right"><?php echo @number_format($sumBill);?></td>
                <td align="right"><?php echo @number_format($sumNy);?></td>
                <td align="right">
                    <?php echo @number_format($row_sql["list_bill_percented_price"])?>
                </td>
                <td align="right">
                    <?php echo $amountPer;?>
                </td>
                <td align="right"><?php echo @number_format($row_sql["list_bill_pay_kip"])?></td>
                <td align="right"><?php echo @number_format($row_sql["list_bill_pay_bath"])?></td>
                <td align="right"><?php echo @number_format($row_sql["list_bill_pay_us"])?></td> 
                <td align="right"><?php echo @number_format($row_sql["list_bill_transfer_kip"])?></td>
                <td align="right"><?php echo @number_format($row_sql["list_bill_transfer_bath"])?></td>
                <td align="right"><?php echo @number_format($row_sql["list_bill_transfer_us"])?></td>
                <td align="right"><?php echo @number_format($row_sql["list_bill_return"])?></td>
                <td align="right"><?php if($row_sql["list_bill_type_pay_fk"]=="4"){echo "0";}else{echo @number_format($row_sql["list_bill_amount_kip"]);}?></td>
            </tr>
        <?php }?>
        <tr style="border-top:1px solid #DEE2E6;background:#0F253B;color:#eaeaea;font-size:16px !important;">
            <td colspan="6" align="right">ລວມຍອດຂາຍທັງໝົດ</td>
            <td align="center"><?php echo @number_format($sumQty)?></td>
            <td align="right"><?php echo @number_format($amount)?></td>
            <td align="right"><?php echo @number_format($totalNy)?></td>
            <td align="right"><?php echo @number_format($sumPerPrice);?></td>
            <td align="right"><?php echo @number_format($sumPer)?></td>
            <td align="right"><?php echo @number_format($sumPaykip)?></td>
            <td align="right"><?php echo @number_format($sumPaybath)?></td>
            <td align="right"><?php echo @number_format($sumPayus)?></td>
            <td align="right"><?php echo @number_format($sumtransferKip)?></td>
            <td align="right"><?php echo @number_format($sumtransferBath)?></td>
            <td align="right"><?php echo @number_format($sumtransferUs)?></td>
            <td align="right"><?php echo @number_format($sumReturn)?></td>
            <td align="right"><?php echo @number_format($sumTotal)?></td>
        <tr>
        <tr style="border-top:1px solid #DEE2E6">
            <td colspan="19">
                <center>
                    <ul class="pagination">
                            <?php
                            if ($limit != "") {
                                $limit1 = $limit;
                            } else {
                                $limit1 = $total_data;
                            }
                            $total_links = ceil($total_data / $limit1);
                            $previous_link = '';
                            $next_link = '';
                            $page_link = '';
                            if ($total_links > 4) {
                                if ($page < 5) {
                                        for ($count = 1; $count <= 5; $count++) {
                                            $page_array[] = $count;
                                        }
                                        $page_array[] = '...';
                                        $page_array[] = $total_links;
                                } else {
                                        $end_limit = $total_links - 5;
                                        if ($page > $end_limit) {
                                            $page_array[] = 1;
                                            $page_array[] = '...';
                                            for ($count = $end_limit; $count <= $total_links; $count++) {
                                                    $page_array[] = $count;
                                            }
                                        } else {
                                            $page_array[] = 1;
                                            $page_array[] = '...';
                                            for ($count = $page - 1; $count <= $page + 1; $count++) {
                                                    $page_array[] = $count;
                                            }
                                            $page_array[] = '...';
                                            $page_array[] = $total_links;
                                        }
                                }
                            } else {
                                for ($count = 1; $count <= $total_links; $count++) {
                                        $page_array[] = $count;
                                }
                            }

                            for ($count = 0; $count < count($page_array); $count++) {
                                if ($page == $page_array[$count]) {
                                        $page_link .= '
                                            <li class="page-item active">
                                            <div class="page-link" href="#">' . $page_array[$count] . ' <span class="sr-only">(current)</span></div>
                                            </li>
                                        ';

                                        $previous_id = $page_array[$count] - 1;
                                        if ($previous_id > 0) {
                                            $previous_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="' . $previous_id . '"><i class="fas fa-chevron-left"></i></a></li>';
                                        } else {
                                            $previous_link = '
                                                    <li class="page-item disabled">
                                                    <div class="page-link" href="#"><i class="fas fa-chevron-left"></i></div>
                                                    </li>
                                            ';
                                        }
                                        $next_id = $page_array[$count] + 1;
                                        if ($next_id > $total_links) {
                                            $next_link = '
                                            <li class="page-item disabled">
                                                <div class="page-link" href="#"><i class="fas fa-chevron-right"></i></div>
                                            </li>
                                            ';
                                        } else {
                                            $next_link = '<li class="page-item"><div class="page-link" href="javascript:void(0)" data-page_number="' . $next_id . '"><i class="fas fa-chevron-right"></i></div></li>';
                                        }
                                } else {
                                        if ($page_array[$count] == '...') {
                                            $page_link .= '
                                            <li class="page-item disabled">
                                            <div class="page-link" href="#">...</div>
                                            </li>
                                            ';
                                        } else {
                                            $page_link .= '
                                            <li class="page-item"><div class="page-link" href="javascript:void(0)" data-page_number="' . $page_array[$count] . '">' . $page_array[$count] . '</div></li>
                                            ';
                                        }
                                }
                            }

                            $output = $previous_link . $page_link . $next_link;
                            echo $output;
                            ?>
                    </ul>
                </center>
            </td>
        </tr>
        <?php }else{?>
            <tr>
                <td colspan="19" align="center" style="height:380px;padding:150px;color:red">
                    <i class="fas fa-times-circle fa-3x"></i><br>
                    ບໍ່ພົບລາຍການ
                </td>
            </tr>
        <?php }?>
    </tbody>
<?php }
    if(isset($_GET["deleteData"])){
        $delete_list=$db->fn_edit("res_check_bill","list_bill_status='2',list_bill_remark='".$_POST["list_bill_remark"]."',list_bill_cancel_by='".$_POST["list_bill_cancel_by"]."',list_bill_cancel_date='".date("Y-m-d h:i:sa")."' WHERE list_bill_no='".$_POST["bill_no"]."'");
        if($delete_list){
            echo json_encode(array("statusCode"=>200));
        }else{
            echo json_encode(array("statusCode"=>201));
        }
    }
?>

