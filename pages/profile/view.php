<?php
    function edit() {
        global $DATABASE, $GLOBAL, $STAFF;
        $sql = "SELECT * FROM staff WHERE username='".$STAFF["username"]."'  ";
        $obj = $DATABASE->QueryObj($sql);
        if( sizeof($obj)==0 ) {
            ShowAlert('', 'ไม่พบข้อมูล', 'error');
            return;
        }
        $objStaff = $obj[0];
        $dir = FTP_DIR."staffs/";
        $upload = UploadFile("image", $dir, time(), $GLOBAL["ALLOW_IMAGE"]);
        if( $upload["status"]==false ) {
            ShowAlert('', $upload["message"], 'error');
            return;
        }
        RemoveFile($dir.$objStaff["image"]);
        $field['image'] = $upload["fileName"];
        if( $DATABASE->QueryUpdate("staff", $field, "username='".$STAFF['username']."'") ) {
            $STAFF = GetStaff();
            ShowAlert('', 'แก้ไขรูปโปรไฟล์สำเร็จ', 'success', './?page=profile');
        } else {
            ShowAlert('', 'ไม่สามารถติดต่อฐานข้อมูลได้ !!!', 'error');
        }
    }
    if( isset($_POST['btn-edit-profile']) && $_POST['btn-edit-profile'] == "submit") {
        edit();
    }
?>
<div class="wrapper-title">
    โปรไฟล์ของฉัน
</div>
<div id="wrapper-body">
    <div class="container-fluid p-3">
        <form action="" method="post" id="profile" class="row">
            <div class="col-md-auto">
                <div class="profile-image">
                    <a href="#">
                        <img id="profile-image" class="img-thumbnail mb-4" src="images/no-staff.png"
                            alt="Profile Image">
                    </a>
                    <!-- <div id="edit" class="mb-2">
                        <button type="button" id="btn-edit" class="btn btn-raised btn-success btn-sm btn-block"><i
                                class="fas fa-pencil-alt mr-2"></i> เปลี่ยนรูปโปรไฟล์</button>
                    </div> -->
                    <!-- <div id="confirm" class="row mb-2" style="display: none;">
                        <div class="col pr-1">
                            <button type="button" id="btn-confirm"
                                class="btn btn-raised btn-success btn-sm btn-block"><i class="fas fa-check mr-2"></i>
                                ยืนยัน</button>
                        </div>
                        <div class="col pl-1">
                            <button type="button" id="btn-cancel" class="btn btn-raised btn-danger btn-sm btn-block"><i
                                    class="fas fa-times mr-2"></i> ยกเลิก</button>
                        </div>
                    </div>
                    <a href="Javascript:" class="btn btn-raised btn-danger btn-sm btn-block logout"><i
                            class="fas fa-sign-out-alt mr-2"></i> ออกจากระบบ</a> -->
                </div>
            </div>
            <div class="col">
                <div class="mb-4">
                    <label class="d-block">ชื่อ</label>
                    <div class="detail">
                        <input type="text" class="form-control" name="user_name"
                            value="<?php echo $USER["user_name"]; ?>" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="d-block">นามสกุล</label>
                    <div class="detail">
                        <input type="text" class="form-control" name="user_lname"
                            value="<?php echo $USER["user_lname"]; ?>" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="d-block">Username</label>
                    <div class="detail">
                        <input type="text" class="form-control" value="<?php echo $USER["username"]; ?>" disabled>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="d-block">Password</label>
                    <div class="detail">
                        <input type="password" class="form-control" name="password"
                            value="<?php echo $USER["password"]; ?>" required>
                    </div>
                </div>
                <button type="submit" name="edit" class="btn btn-warning">
                    <i class="fas fa-floppy-disk mr-1"></i>
                    บันทึกการเปลี่ยนแปลง
                </button>
            </div>
        </form>
    </div>
</div>
<?php
if( isset($_POST["edit"]) ) {
    $user_name = $_POST["user_name"];
    $user_lname = $_POST["user_lname"];
    $password = $_POST["password"];
    $DB->QueryUpdate("user", array(
        "user_name"=>$user_name,
        "user_lname"=>$user_lname,
        "password"=>$password,
        "edit_by"=>$USER["user_id"],
        "edit_when"=>date("Y-m-d H:i:s")
    ), "user_id='".$USER["user_id"]."'");
    Reload();
}
?>