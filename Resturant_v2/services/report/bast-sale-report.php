<?php session_start();
    include_once("../config/db.php");
    $db = new DBConnection();
    if(isset($_GET["report"])){

        if($_POST["start_date"] !="" && $_POST["end_date"] !=""){
            @$query.=" WHERE check_bill_list_date BETWEEN '".$_POST["start_date"]."' AND '".$_POST["end_date"]."' ";
        }else{
            @$query.="";
        }

        if($_POST["search_branch"] !=""){
            @$query.="AND check_bill_list_branch_fk='".$_POST["search_branch"]."' ";
        }else{
            @$query.="";
        }

        if($_POST["type_cate"] !=""){
            @$query.=" AND check_bill_list_status='".$_POST["type_cate"]."'";
        }else{
            @$query.="";
        }


        $sql=$db->fn_read_all("view_bast_sale $query GROUP BY check_bill_list_date,group_code,check_bill_list_branch_fk ORDER BY group_code ASC");
        $i=1;
        if(count($sql)>0){
        foreach($sql as $rowSql){
            // @$total+=$rowSql["totalAll"];
            $sqlGroup=$db->fn_read_all("view_bast_sale WHERE group_code='".$rowSql["group_code"]."' GROUP BY group_code ");
            foreach($sqlGroup as $rowGroup){
        ?>
            <tr>
                <td align="center" style="border-bottom: 1px solid #dbdbdb !important;"><?php echo date("d/m/Y",strtotime($rowSql["check_bill_list_date"]))?></td>
                <td style="border-bottom: 1px solid #dbdbdb !important;" colspan="6"><b>- ປະເພດ<?php echo $rowGroup["group_name"]?> </b></td>
            </tr>

            <?php 
                if($_POST["orderBy"]=="1"){
                    $orderBy="ORDER BY sumQty DESC";
                }else{
                    $orderBy="ORDER BY amounts DESC";
                }
                $j=1;
                $sqlBast=$db->fn_read_all("view_bast_sale WHERE group_code='".$rowGroup["group_code"]."' 
                AND check_bill_list_date='".$rowSql["check_bill_list_date"]."' $orderBy");
                foreach($sqlBast as $rowBast){
                    @$amount+=$rowBast["amounts"];
            ?>
            <tr>
                <td></td>
                <td></td>
                <td align="center"><?php echo $j++;?></td>
                <td><?php echo $rowBast["fullProname"]?></td>
                <td align="center"><?php echo @number_format($rowBast["check_bill_list_pro_price"])?></td>
                <td align="center"><?php echo @number_format($rowBast["sumQty"])?></td>
                <td align="center"><?php echo @number_format($rowBast["amounts"])?></td>
            </tr>
            <?php } 
            $subTotal=$db->fn_fetch_single_all("view_subtotal WHERE group_code='".$rowGroup["group_code"]."' 
            AND check_bill_list_date='".$rowSql["check_bill_list_date"]."' $orderBy");
            $granQty+=$subTotal["sumQty"];
            $grantotal+=$subTotal["amounts"];
            ?>
            
            <tr style="border-top:1px solid #dbdbdb;background:#fcebe3;font-size:16px !important">
                <td colspan="5" align="right">ລວມຍອດ</td>
                <td align="center"><?php echo @number_format($subTotal["sumQty"])?></td>
                <td align="center"><?php echo @number_format($subTotal["amounts"])?></td>
            </tr>
            <?php }?>


    <?php }?>
    <tr style="border-top:1px solid #DEE2E6;background:#0F253B;color:#eaeaea;font-size:16px !important;">
        <td colspan="5" align="right">ລວມທັງໝົດ</td>
        <td align="center"><?php echo @number_format($granQty)?></td>
        <td align="center"><?php echo @number_format($grantotal)?></td>
    <tr>
<?php }else{?>
    <tr>
        <td colspan="8" align="center" style="height:380px;padding:150px;color:red">
            <i class="fas fa-times-circle fa-3x"></i><br>
            ບໍ່ພົບລາຍການ
        </td>
    </tr>
<?php } }?>