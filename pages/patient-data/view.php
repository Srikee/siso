<?php
    $old_param = "";
    $old_param .= (@$_GET["old_search"]!="") ? "&search=".$_GET["old_search"] : "";
    $old_param .= (@$_GET["old_p"]!="") ? "&p=".$_GET["old_p"] : "";

    $old_param2 = $old_param;
    $old_param2 = str_replace("&search", "&old_search", $old_param2);
    $old_param2 = str_replace("&p", "&old_p", $old_param2);

    $patient_id = @$_GET["patient_id"];
    $tab = $_GET["tab"] ?? "1";

    $sql = "
        SELECT 
            p.*,
            g.gender_name
        FROM patient p
            INNER JOIN gender g ON g.gender_id=p.gender_id
        WHERE p.patient_id='".$patient_id."'
    ";
    $obj = $DB->QueryObj($sql);
    if( sizeof($obj)!=1 ) {
        Back();
        exit();
    }
    $data = $obj[0];
?>
<div id="wrapper-body">
    <div class="mb-4">
        <a href="./?page=patient<?php echo $old_param; ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i>
            ย้อนกลับ
        </a>
    </div>
    <div class="card mb-3">
        <div class="card-body profile">
            <h6 class="mb-4 text-dark">ข้อมูลผู้ป่วย</h6>
            <div class="row profile-row">
                <div class="col-auto profile-left">
                    ชื่อ-นามสกุล
                </div>
                <div class="col profile-right">
                    <?php echo $data["patient_name"]; ?> <?php echo $data["patient_lname"]; ?>
                </div>
                <div class="col-auto profile-left">
                    เพศ
                </div>
                <div class="col profile-right">
                    <?php echo $data["gender_name"]; ?>
                </div>
            </div>
            <div class="row profile-row">
                <div class="col-auto profile-left">
                    เบอร์โทรศัพท์
                </div>
                <div class="col profile-right">
                    <?php echo $data["phone"]; ?>
                </div>
                <div class="col-auto profile-left">
                    เลขที่ประจำตัว
                </div>
                <div class="col profile-right">
                    <?php echo $data["idcard"]; ?>
                </div>
            </div>
            <div class="row profile-row">
                <div class="col-auto profile-left">
                    วันเกิด
                </div>
                <div class="col profile-right">
                    <?php echo DateTh($data["bdate"]); ?>
                </div>
                <div class="col-auto profile-left">
                    อายุ
                </div>
                <div class="col profile-right">
                    <?php echo CalculateAge($data["bdate"]); ?> ปี
                </div>
            </div>
            <div class="row profile-row">
                <div class="col-auto profile-left">
                    โรคประจำตัว
                </div>
                <div class="col profile-right">
                    <?php echo $data["disease"]; ?>
                </div>
                <div class="col-auto profile-left">
                    แพ้ยา
                </div>
                <div class="col profile-right">
                    <?php echo $data["lose"]; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs justify-content-center">
                <li class="nav-item">
                    <a class="nav-link <?php if($tab=="1") echo "active"; ?>"
                        href="./?page=patient-data<?php echo $old_param2; ?>&patient_id=<?php echo $patient_id; ?>">
                        <i class="fas fa-user-pen mr-1"></i>
                        แก้ไขข้อมูลผู้ป่วย
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($tab=="2") echo "active"; ?>"
                        href="./?page=patient-data<?php echo $old_param2; ?>&patient_id=<?php echo $patient_id; ?>&tab=2">
                        <i class="fas fa-stethoscope mr-1"></i>
                        ประวัติการรักษา
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($tab=="3") echo "active"; ?>"
                        href="./?page=patient-data<?php echo $old_param2; ?>&patient_id=<?php echo $patient_id; ?>&tab=3">
                        <i class="fas fa-calendar-days mr-1"></i>
                        การนัดหมาย
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($tab=="4") echo "active"; ?>"
                        href="./?page=patient-data<?php echo $old_param2; ?>&patient_id=<?php echo $patient_id; ?>&tab=4">
                        <i class="fas fa-flask-vial mr-1"></i>
                        การตรวจ Lab
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($tab=="5") echo "active"; ?>"
                        href="./?page=patient-data<?php echo $old_param2; ?>&patient_id=<?php echo $patient_id; ?>&tab=5">
                        <i class="fas fa-dollar-sign mr-1"></i>
                        การชำระเงิน
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body" style="min-height: 400px;">
            <?php include("tab".$tab.".php"); ?>
        </div>
    </div>
</div>