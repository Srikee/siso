<?php
    include_once("../php/autoload.php");

    $idcard = $_POST["idcard"];
    $patient_id = @$_POST["patient_id"];
    
    if( $DB->QueryHaving("patient", "idcard", $idcard, "patient_id", $patient_id) ) {
        echo json_encode(array(
            "status"=>"ok"
        ));
    } else {
        echo json_encode(array(
            "status"=>"no"
        ));
    }
    
    
    