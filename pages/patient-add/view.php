<?php
    if( isset($_POST["submit"]) ) {
        $patient_id = $DB->QueryMaxId("patient", "patient_id");
        $patient_name = $_POST["patient_name"];
        $patient_lname = $_POST["patient_lname"];
        $phone = $_POST["phone"];
        $gender_id = $_POST["gender_id"];
        $idcard = $_POST["idcard"];
        $bdate = $_POST["bdate"];
        $disease = $_POST["disease"];
        $lose = $_POST["lose"];
        $DB->QueryInsert("patient", array(
            "patient_id"=>$patient_id,
            "patient_name"=>$patient_name,
            "patient_lname"=>$patient_lname,
            "phone"=>$phone,
            "idcard"=>$idcard,
            "gender_id"=>$gender_id,
            "bdate"=>$bdate,
            "disease"=>$disease,
            "lose"=>$lose,
            "add_by"=>$USER["user_id"],
            "add_when"=>date("Y-m-d H:i:s")
        ));
        ShowAlert("", "เพิ่มรายชื่อแล้ว", "success", "./?page=patient-data&patient_id=".$patient_id);
    }
?>
<div id="wrapper-body">
    <h6 class="mb-5">เพิ่มรายชื่อผู้ป่วย</h6>
    <form action="" method="post">
        <div class="form-group row">
            <label for="patient_name" class="col-lg-2 col-form-label">ชื่อ</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" id="patient_name" name="patient_name" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="patient_lname" class="col-lg-2 col-form-label">นามสกุล</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" id="patient_lname" name="patient_lname" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="gender_id" class="col-lg-2 col-form-label">เพศ</label>
            <div class="col-lg-10">
                <select class="form-control" id="gender_id" name="gender_id" required>
                    <?php
                    $sql = "SELECT * FROM gender ORDER BY gender_id";
                    $obj = $DB->QueryObj($sql);
                    foreach($obj as $row) {
                        echo '<option value="'.$row["gender_id"].'">'.$row["gender_name"].'</option>';
                    }
                ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="phone" class="col-lg-2 col-form-label">เบอร์โทรศัพท์</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="idcard" class="col-lg-2 col-form-label">เลขที่ประจำตัว</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" id="idcard" name="idcard" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="bdate" class="col-lg-2 col-form-label">วันเกิด</label>
            <div class="col-lg-10">
                <input type="date" class="form-control" id="bdate" name="bdate" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="bdate" class="col-lg-2 col-form-label">อายุ (ปี)</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" id="age" disabled>
            </div>
        </div>
        <div class="form-group row">
            <label for="disease" class="col-lg-2 col-form-label">โรคประจำตัว</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" id="disease" name="disease" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="lose" class="col-lg-2 col-form-label">แพ้ยา</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" id="lose" name="lose" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-2 col-form-label invisible"></label>
            <div class="col-lg-10">
                <button type="submit" name="submit" class="btn btn-success mb-2">
                    <i class="fas fa-user-plus mr-1"></i>
                    ยืนยันการเพิ่มรายชื่อ
                </button>
            </div>
        </div>
    </form>
</div>