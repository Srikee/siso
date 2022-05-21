<?php
    include_once("../../php/autoload.php");

    $appointment_id = $_POST["appointment_id"];
    $sql = "
        SELECT
            a.*,
            p.patient_id,
            p.patient_name,
            p.patient_lname,
            n.nurse_name,
            n.nurse_lname
        FROM appointment a
            INNER JOIN patient p ON p.patient_id=a.patient_id
            INNER JOIN nurse n ON n.nurse_id=a.nurse_id
        WHERE a.appointment_id='".$appointment_id."'
    ";
    $obj = $DB->QueryObj($sql);
    $data = $obj[0];
?>
<table class="table">
    <tr>
        <td>ชื่อ-นามสกุล</td>
        <td><?php echo $data["patient_name"]; ?> <?php echo $data["patient_lname"]; ?></td>
    </tr>
    <tr>
        <td>วันที่นัด</td>
        <td><?php echo DateTh($data["appointment_date"]); ?></td>
    </tr>
    <tr>
        <td>รายละเอียดการนัด</td>
        <td><?php echo $data["appointment_desc"]; ?></td>
    </tr>
    <tr>
        <td>ผู้นัด</td>
        <td><?php echo $data["nurse_name"]; ?> <?php echo $data["nurse_lname"]; ?></td>
    </tr>
</table>
<a href="./?page=patient-data&patient_id=<?php echo $data["patient_id"]; ?>" class="btn btn-info">เปิดดูประวัติ</a>