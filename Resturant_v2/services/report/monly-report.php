<?php session_start();
    include_once("../config/db.php");
    $db = new DBConnection();
    if(isset($_GET["monlyRp"])){
        $sql=$db->fn_read_all("view_daily_report_month WHERE list_bill_date BETWEEN '".$_POST["start_date"]."' AND '".$_POST["end_date"]."' ");
        $i=1;
        if(count($sql)>0){
        foreach($sql as $rowSql){
            @$sumcountBill+=$rowSql["countBill"];
            @$sumamounts+=$rowSql["amounts"];
            @$sumamountPerlist+=$rowSql["amountPerlist"];
            @$sumamountPerBill+=$rowSql["amountPerBill"];
            @$sumtotals+=$rowSql["totals"];
            @$sumpaykip+=$rowSql["payKip"];
            @$sumpayBath+=$rowSql["payBath"];
            @$sumpayUs+=$rowSql["payUs"];
            @$sumtransferKip+=$rowSql["transferKip"];
            @$sumtransferBath+=$rowSql["transferBath"];
            @$sumtransferUs+=$rowSql["transferUs"];
            @$sumreturnAll+=$rowSql["returnAll"];
?>
    <tr>
        <td align="center"><?php echo $i++;?></td>
        <td align="center"><?php echo $rowSql["monthNow"];?></td>
        <td align="center"><?php echo @number_format($rowSql["countBill"]);?></td>
        <td align="center"><?php echo @number_format($rowSql["amounts"]);?></td>
        <td align="center"><?php echo @number_format($rowSql["amountPerlist"]);?></td>
        <td align="center"><?php echo @number_format($rowSql["amountPerBill"]);?></td>
        <td align="right"><?php echo @number_format($rowSql["totals"]);?></td>
        <td align="right"><?php echo @number_format($rowSql["payKip"]);?></td>
        <td align="right"><?php echo @number_format($rowSql["payBath"]);?></td>
        <td align="right"><?php echo @number_format($rowSql["payUs"]);?></td>
        <td align="right"><?php echo @number_format($rowSql["transferKip"]);?></td>
        <td align="right"><?php echo @number_format($rowSql["transferBath"]);?></td>
        <td align="right"><?php echo @number_format($rowSql["transferUs"]);?></td>
        <td align="right"><?php echo @number_format($rowSql["returnAll"]);?></td>

    </tr>
<?php }?>
    <tr style="border-top:1px solid #DEE2E6;background:#0F253B;color:#eaeaea;font-size:16px !important;">
        <td colspan="2" align="right">ລວມທັງໝົດ</td>
        <td align="center"><?php echo @number_format($sumcountBill)?></td>
        <td align="center"><?php echo @number_format($sumamounts)?></td>
        <td align="center"><?php echo @number_format($sumamountPerlist);?></td>
        <td align="center"><?php echo @number_format($sumamountPerBill)?></td>
        <td align="right"><?php echo @number_format($sumtotals)?></td>
        <td align="right"><?php echo @number_format($sumpaykip)?></td>
        <td align="right"><?php echo @number_format($sumpayBath)?></td>
        <td align="right"><?php echo @number_format($sumpayUs)?></td>
        <td align="right"><?php echo @number_format($sumtransferKip)?></td>
        <td align="right"><?php echo @number_format($sumtransferBath)?></td>
        <td align="right"><?php echo @number_format($sumtransferUs)?></td>
        <td align="right"><?php echo @number_format($sumreturnAll)?></td>
    <tr>
<?php }else{?>
    <tr>
        <td colspan="14" align="center" style="height:380px;padding:150px;color:red">
            <i class="fas fa-times-circle fa-3x"></i><br>
            ບໍ່ພົບລາຍການ
        </td>
    </tr>
<?php } }?>