<?php
    if( isset($_POST["submit"]) ) {
        $nurse_id = $DB->QueryMaxId("nurse", "nurse_id");
        $nurse_name = $_POST["nurse_name"];
        $nurse_lname = $_POST["nurse_lname"];
        $status = $_POST["status"];
        $DB->QueryInsert("nurse", array(
            "nurse_id"=>$nurse_id,
            "nurse_name"=>$nurse_name,
            "nurse_lname"=>$nurse_lname,
            "status"=>$status,
            "add_by"=>$USER["user_id"],
            "add_when"=>date("Y-m-d H:i:s")
        ));
        ShowAlert("", "เพิ่มรายชื่อแล้ว", "success", "./?page=nurse");
    }
?>
<div id="wrapper-body">
    <h6 class="mb-5">เพิ่มรายชื่อผู้รักษา</h6>
    <form action="" method="post">
        <div class="form-group row">
            <label for="nurse_name" class="col-lg-2 col-form-label">ชื่อ</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" id="nurse_name" name="nurse_name" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="nurse_lname" class="col-lg-2 col-form-label">นามสกุล</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" id="nurse_lname" name="nurse_lname" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="status" class="col-lg-2 col-form-label">สถานะ</label>
            <div class="col-lg-10">
                <select class="form-control" id="status" name="status" required>
                    <option value="Y">ใช้งานได้</option>
                    <option value="N">ยกเลิก</option>
                </select>
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