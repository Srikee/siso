<?php
    include_once("../php/autoload.php");

    $patient_id = $_POST["patient_id"];

    $sql = "
        SELECT
            t.*
        FROM treatment t
        WHERE t.patient_id='".$patient_id."'
            AND t.treatment_id NOT IN ( SELECT treatment_id FROM payment )
        ORDER BY t.patient_id DESC
    ";
    $datas = $DB->QueryObj($sql);
    if( sizeof($datas)==0 ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ไม่สามารถเพิ่มการชำระเงินได้ เนื่องจากผู้ป่วยคนนี้ไม่มีประวัติการรักษาที่ใช้งานได้"
        ));
        exit();
    }
    echo json_encode(array(
        "status"=>"ok",
        "datas"=>$datas
    ));
    
    
    