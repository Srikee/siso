<?php
    include_once("../php/autoload.php");

    $start = $_POST["start"];
    $end = $_POST["end"];
    $data = array();

    $ColorExt = array(
        "W"=>"#af9e00",          // กำลังนัด
        "Y"=>"#168f2e",         // เข้าพบแล้ว
        "N"=>"#be0000",         // ยกเลิก
    );

    $sql = "
        SELECT
            a.*,
            p.patient_name,
            p.patient_lname
        FROM appointment a
            INNER JOIN patient p ON p.patient_id=a.patient_id
        WHERE a.appointment_date BETWEEN '".$start."' AND '".$end."'
    ";
    $obj = $DB->QueryObj($sql);
    foreach($obj as $row) {
        $data[] = array(
            "title"=>$row["patient_name"].' '.$row["patient_lname"],
            "start"=>$row["appointment_date"],
            "color"=>$ColorExt[$row["process"]],
            "old"=>$row
        );
    }

    // $data[] = array(
    //     "title"=>'event1',
    //     "start"=>'2022-05-17'
    // );
    // $data[] = array(
    //     "title"=>'event1',
    //     "start"=>'2022-05-17'
    // );

    echo json_encode($data);
    
    
    