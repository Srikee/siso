<?php
    if( isset($_POST["submit"]) ) {
        $patient_id = $_GET["patient_id"];
        $patient_name = $_POST["patient_name"];
        $patient_lname = $_POST["patient_lname"];
        $phone = $_POST["phone"];
        $gender_id = $_POST["gender_id"];
        $idcard = $_POST["idcard"];
        $bdate = $_POST["bdate"];
        $disease = $_POST["disease"];
        $lose = $_POST["lose"];
        if( $DB->QueryHaving("patient", "idcard", $idcard, "patient_id", $patient_id) ) {
            ShowAlert("", "แก้ไขไม่ได้ เนื่องจากเลขที่ประจำตัวซ้ำกับที่มีอยู่แล้ว", "error", "Reload()");
            exit();
        }
        $DB->QueryUpdate("patient", array(
            "patient_name"=>$patient_name,
            "patient_lname"=>$patient_lname,
            "phone"=>$phone,
            "idcard"=>$idcard,
            "gender_id"=>$gender_id,
            "bdate"=>$bdate,
            "disease"=>$disease,
            "lose"=>$lose,
            "edit_by"=>$USER["user_id"],
            "edit_when"=>date("Y-m-d H:i:s")
        ), "patient_id='".$patient_id."'");
        Reload();
    }
?>
<form action="" method="post">
    <div class="form-group row">
        <label for="patient_name" class="col-lg-2 col-form-label">ชื่อ</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" id="patient_name" name="patient_name"
                value="<?php echo $data["patient_name"]; ?>" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="patient_lname" class="col-lg-2 col-form-label">นามสกุล</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" id="patient_lname" name="patient_lname"
                value="<?php echo $data["patient_lname"]; ?>" required>
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
                        $selected = ($row["gender_id"]==$data["gender_id"]) ? "selected" : "";
                        echo '<option value="'.$row["gender_id"].'" '.$selected.'>'.$row["gender_name"].'</option>';
                    }
                ?>
            </select>
        </div>
    </div>
    <div class=" form-group row">
        <label for="phone" class="col-lg-2 col-form-label">เบอร์โทรศัพท์</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $data["phone"]; ?>"
                required>
        </div>
    </div>
    <div class="form-group row">
        <label for="idcard" class="col-lg-2 col-form-label">เลขที่ประจำตัว</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" id="idcard" name="idcard" value="<?php echo $data["idcard"]; ?>"
                required>
        </div>
    </div>
    <div class="form-group row">
        <label for="bdate" class="col-lg-2 col-form-label">วันเกิด</label>
        <div class="col-lg-10">
            <input type="date" class="form-control" id="bdate" name="bdate" value="<?php echo $data["bdate"]; ?>"
                required>
        </div>
    </div>
    <div class="form-group row">
        <label for="bdate" class="col-lg-2 col-form-label">อายุ (ปี)</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" id="age" value="<?php echo CalculateAge($data["bdate"]); ?>"
                disabled>
        </div>
    </div>
    <div class="form-group row">
        <label for="disease" class="col-lg-2 col-form-label">โรคประจำตัว</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" id="disease" name="disease" value="<?php echo $data["disease"]; ?>"
                required>
        </div>
    </div>
    <div class="form-group row">
        <label for="lose" class="col-lg-2 col-form-label">แพ้ยา</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" id="lose" name="lose" value="<?php echo $data["lose"]; ?>" required>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-form-label invisible"></label>
        <div class="col-lg-10">
            <button type="submit" name="submit" class="btn btn-warning mb-2">
                <i class="fas fa-floppy-disk mr-1"></i>
                บันทึกการเปลี่ยนแปลง
            </button>
        </div>
    </div>
</form>
<script>
$(function() {
    $("#idcard").blur(function() {
        var idcard = $(this).val();
        var patient_id = GetUrlParameter("patient_id");
        if (idcard == "") return;
        $.post("api/chk-duplicate-idcard.php", {
            idcard: idcard,
            patient_id: patient_id
        }, function(res) {
            if (res.status == 'ok') {
                ShowAlert({
                    html: "เลขที่ประจำตัวนี้ซ้ำกับรายชื่อผู้ป่วยคนอื่นแล้ว",
                    callback: function() {
                        $("#idcard").focus().select();
                    }
                });
            }
        }, "JSON");
    });
});
</script>