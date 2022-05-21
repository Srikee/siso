<?php
    $nurse_id = $_GET["nurse_id"];
    if( isset($_POST["submit"]) ) {
        $nurse_id = $_GET["nurse_id"];
        $nurse_name = $_POST["nurse_name"];
        $nurse_lname = $_POST["nurse_lname"];
        $status = $_POST["status"];
        $DB->QueryUpdate("nurse", array(
            "nurse_name"=>$nurse_name,
            "nurse_lname"=>$nurse_lname,
            "status"=>$status,
            "add_by"=>$USER["user_id"],
            "add_when"=>date("Y-m-d H:i:s")
        ), "nurse_id='".$nurse_id."'");
        ShowAlert("", "แก้ไขรายชื่อแล้ว", "success", "./?page=nurse");
    }
    $sql = "SELECT * FROM nurse WHERE nurse_id='".$nurse_id."' ";
    $obj = $DB->QueryObj($sql);
    if( sizeof($obj)!=1 ) {
        LinkTo("./?page=nurse");
        exit();
    }
    $data = $obj[0];
?>
<div id="wrapper-body">
    <h6 class="mb-5">แก้ไขรายชื่อผู้รักษา</h6>
    <form action="" method="post">
        <div class="form-group row">
            <label for="nurse_name" class="col-lg-2 col-form-label">ชื่อ</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" id="nurse_name" name="nurse_name"
                    value="<?php echo $data["nurse_name"]; ?>" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="nurse_lname" class="col-lg-2 col-form-label">นามสกุล</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" id="nurse_lname" name="nurse_lname"
                    value="<?php echo $data["nurse_lname"]; ?>" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="status" class="col-lg-2 col-form-label">สถานะ</label>
            <div class="col-lg-10">
                <select class="form-control" id="status" name="status" required>
                    <option value="Y" <?php if($data["status"]=="Y") echo 'selected'; ?>>ใช้งานได้</option>
                    <option value="N" <?php if($data["status"]=="N") echo 'selected'; ?>>ยกเลิก</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-2 col-form-label invisible"></label>
            <div class="col-lg-10">
                <button type="submit" name="submit" class="btn btn-warning mb-2">
                    <i class="fas fa-pen mr-1"></i>
                    ยืนยันการแก้ไข
                </button>
            </div>
        </div>
    </form>
</div>