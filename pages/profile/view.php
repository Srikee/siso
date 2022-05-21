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
        <div id="profile" class="row">
            <div class="col-md-auto">
                <div class="profile-image">
                    <a href="../fileupload/staffs/<?php echo $STAFF["image"]; ?>" data-image-viewer>
                        <img id="profile-image" class="img-thumbnail mb-4"
                            src="../fileupload/staffs/<?php echo $STAFF["image"]; ?>" alt="Profile Image"
                            onerror="onError(this)">
                    </a>
                    <div id="edit" class="mb-2">
                        <button type="button" id="btn-edit" class="btn btn-raised btn-success btn-sm btn-block"><i
                                class="fas fa-pencil-alt mr-2"></i> เปลี่ยนรูปโปรไฟล์</button>
                    </div>
                    <div id="confirm" class="row mb-2" style="display: none;">
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
                            class="fas fa-sign-out-alt mr-2"></i> ออกจากระบบ</a>
                </div>
            </div>
            <div class="col">
                <div class="mb-4">
                    <label class="d-block">ชื่อ-นามสกุล</label>
                    <div class="detail"><?php echo $STAFF["prefix_name"]; ?><?php echo $STAFF["staff_name"]; ?>
                        <?php echo $STAFF["staff_sname"]; ?></div>
                </div>
                <div class="mb-4">
                    <label class="d-block">อีเมลล์</label>
                    <div class="detail"><?php echo $STAFF["email"]; ?></div>
                </div>
                <div class="mb-4">
                    <label class="d-block">ชื่อผู้ใช้งาน</label>
                    <div class="detail"><?php echo $STAFF["username"]; ?></div>
                </div>
                <div class="mb-4">
                    <label class="d-block">สิทธิ์การใช้งาน</label>
                    <div class="detail">
                        <?php 
                            // PrintData($STAFF);
                            $txt = "";
                            $count = 1;
                            $sql = "
                                SELECT
                                    `level`.*,
                                    staff_level.username
                                FROM `level`
                                    LEFT JOIN staff_level ON staff_level.level_id=`level`.level_id AND staff_level.username='".$STAFF["username"]."'
                                ORDER BY `level`.level_id
                            ";
                            $obj = $DATABASE->QueryObj($sql);
                            foreach($obj as $key=>$row) {
                                if( $row["username"]!="" ) {
                                    $txt .= "<div>".$count.". [".$row["program_code"]."] ".$row["level_desc"]."</div>";
                                    $count++;
                                }
                            }
                            if( $STAFF["permit"]["section-admin"]=="Y" ) {
                                $txt .= '<div>'.$count.'. [section-admin] ผู้มีสิทธิ์ตั้งค่าส่วนงานสำหรับหน่วยงาน <b>'.$STAFF["section"]["section_name"].'</b></div>';
                                $count++;
                            }
                            if( $STAFF["permit"]["section-data"]=="Y" ) {
                                $txt .= '<div>'.$count.'. [section-data] เจ้าหน้าที่สำหรับหน่วยงาน <b>'.$STAFF["section"]["section_name"].'</b></div>';
                                $count++;
                            }


                            if( $txt=="" ) {
                                $txt .= '<div>'.$count.'. ไม่พบสิทธิ์ใช้งานใดๆ สำหรับคุณ</div>';
                                $count++;
                            }
                            echo $txt;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>