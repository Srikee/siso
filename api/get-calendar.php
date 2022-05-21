<?php
    include_once("../php/autoload.php");

    $start = $_POST["start"];
    $end = $_POST["end"];
    $data = array();


    $sql = "
        SELECT
            a.*,
            p.patient_name,
            p.patient_lname
        FROM appointment a
            INNER JOIN patient p ON p.patient_id=a.patient_id
        WHERE a.process='W'
            AND a.appointment_date BETWEEN '".$start."' AND '".$end."'
    ";
    $obj = $DB->QueryObj($sql);
    foreach($obj as $row) {
        $data[] = array(
            "title"=>$row["patient_name"].' '.$row["patient_lname"],
            "start"=>$row["appointment_date"],
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
    
    
    