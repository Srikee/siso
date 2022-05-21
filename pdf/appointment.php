<?php
    include_once("../php/autoload.php");
    include_once("autoload.php");

    $appointment_id = @$_GET["appointment_id"];

    $sql = "
        SELECT 
            a.*,
            p.patient_name,
            p.patient_lname,
            p.phone,
            n.nurse_name,
            n.nurse_lname
        FROM appointment a
            INNER JOIN patient p ON p.patient_id=a.patient_id
            INNER JOIN nurse n ON n.nurse_id=a.nurse_id
        WHERE a.appointment_id='".$appointment_id."'
    ";
    $obj = $DB->QueryObj($sql);
    if( sizeof($obj)==0 ) {
        echo json_encode(array(
    		"status"=>false,
    		"message"=>"ไม่พบข้อมูล"
    	));
    	exit();
    }
    $data = $obj[0];

    ob_start(); 
    include("master/start.php");
?>
<style>
.table tr:nth-child(odd) {
    background-color: #e1e1e1;
}
</style>
<div class="text-center text-bold size-36 mgb-10">ใบแจ้งการนัดหมาย</div>
<div class="text-center text-bold size-28 mgb-1">CLINIC POMPOMS</div>
<div class="text-center text-bold size-22 mgb-30">โทร. 0629657107, 0862864871, 0918720444</div>
<table class="table size-24" cellspacing="0" cellpadding="10" border="0">
    <tr>
        <td width="25%">รหัสการนัด</td>
        <td class="text-right">
            <?php echo $data["appointment_id"]; ?>
        </td>
    </tr>
    <tr>
        <td>ชื่อผู้ป่วย</td>
        <td class="text-right">
            <?php echo $data["patient_name"]; ?> <?php echo $data["patient_lname"]; ?>
        </td>
    </tr>
    <tr>
        <td>เบอร์มือถือ</td>
        <td class="text-right"><?php echo $data["phone"]; ?></td>
    </tr>
    <tr>
        <td>วันที่การนัดหมาย</td>
        <td class="text-right"><?php echo DateTh($data["appointment_date"]); ?></td>
    </tr>
    <tr>
        <td>รายละเอียดการนัด</td>
        <td class="text-right"><?php echo $data["appointment_desc"]; ?></td>
    </tr>
    <tr>
        <td>ผู้นัด</td>
        <td class="text-right">
            <?php echo $data["nurse_name"]; ?> <?php echo $data["nurse_lname"]; ?>
        </td>
    </tr>
</table>

<?php
    
    include("master/end.php");
    $html = ob_get_clean();
    // echo $html;

    $mpdf = GetNewMPDF();
    $mpdf->WriteHTML($html);
    $mpdf->Output();