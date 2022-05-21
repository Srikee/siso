<?php
    $sql = "
        SELECT 
            a.*,
            n.nurse_name,
            n.nurse_lname
        FROM appointment a
            INNER JOIN nurse n ON n.nurse_id=a.nurse_id
        WHERE a.patient_id='".$patient_id."'
        ORDER BY a.appointment_date DESC
    ";
    $obj = $DB->QueryObj($sql);
?>
<div>
    <button class="btn btn-success btn-add" data-toggle="modal" data-target="#modal-data">
        <i class="fas fa-plus mr-1"></i>
        บันทึกการนัดใหม่
    </button>
</div>
<div class="mt-5">
    <div class="mb-3">พบ <?php echo sizeof($obj); ?> รายการ</div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center">วันที่นัด</th>
                    <th class="text-center">รายละเอียดการนัด</th>
                    <th class="text-center">สถานะการนัด</th>
                    <th class="text-center">ผู้นัด</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if(sizeof($obj)==0) { ?>
                <tr>
                    <th class="text-center" colspan="5">ไม่พบประวัติการนัด</th>
                </tr>
                <?php } ?>
                <?php 
                    foreach($obj as $row) { 
                        $ProcessExt = [
                            "W"=>"กำลังนัด",
                            "Y"=>"เข้าพบแล้ว",
                            "N"=>"ยกเลิก"
                        ];
                ?>
                <tr data-json="<?php echo htmlspecialchars(json_encode($row)); ?>">
                    <th class="text-center"><?php echo DateTh($row["appointment_date"]); ?></th>
                    <td class="text-center"><?php echo $row["appointment_desc"]; ?></td>
                    <td class="text-center"><?php echo $ProcessExt[$row["process"]]; ?></td>
                    <td class="text-center"><?php echo $row["nurse_name"]; ?> <?php echo $row["nurse_lname"]; ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm btn-edit" title="แก้ไข" data-toggle="modal"
                            data-target="#modal-data">
                            <i class="fas fa-pen"></i>
                        </button>
                        <button class="btn btn-danger btn-sm btn-del" title="ลบ">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="modal-data">
    <div class="modal-dialog modal-md">
        <form action="" method="post" class="modal-content">
            <input type="hidden" id="appointment_id" name="appointment_id">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="appointment_date">วันที่นัด</label>
                    <input type="date" class="form-control" id="appointment_date" name="appointment_date" required>
                </div>
                <div class="form-group">
                    <label for="appointment_desc">รายละเอียดการนัด</label>
                    <input type="text" class="form-control" id="appointment_desc" name="appointment_desc" required>
                </div>
                <div class="form-group">
                    <label for="process">สถานะการนัด</label>
                    <select class="form-control" id="process" name="process" required>
                        <option value="W">กำลังนัด</option>
                        <option value="Y">เข้าพบแล้ว</option>
                        <option value="N">ยกเลิก</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nurse_id">ผู้นัด</label>
                    <select class="form-control" id="nurse_id" name="nurse_id" required>
                        <?php
                            $sql = "SELECT * FROM nurse WHERE status='Y' ORDER BY nurse_name";
                            $obj = $DB->QueryObj($sql);
                            foreach($obj as $row) {
                                echo '<option value="'.$row["nurse_id"].'">'.$row["nurse_name"].' '.$row["nurse_lname"].'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" name="add">
                    <i class="fas fa-plus mr-1"></i>
                    ยืนยันการบันทึก</button>
                <button type="submit" class="btn btn-warning" name="edit">
                    <i class="fas fa-pen mr-1"></i>
                    ยืนยันการแก้ไข</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>
<script>
$(function() {
    $("body").on("click", ".btn-add", function() {
        $(".modal-title").html("บันทึกการนัดใหม่");
        $("[name=add]").show();
        $("[name=edit]").hide();
        $("#appointment_id").val("");
        $("#appointment_date").val("");
        $("#appointment_desc").val("");
        $("#nurse_id").val("");
    });
    $("body").on("click", ".btn-edit", function() {
        $(".modal-title").html("แก้ไขการนัด");
        $("[name=add]").hide();
        $("[name=edit]").show();
        var data = JSON.parse($(this).closest("tr").attr("data-json"));
        $("#appointment_id").val(data.appointment_id);
        $("#appointment_date").val(data.appointment_date);
        $("#appointment_desc").val(data.appointment_desc);
        $("#nurse_id").val(data.nurse_id);
    });
    $("body").on("click", ".btn-del", function() {
        var data = JSON.parse($(this).closest("tr").attr("data-json"));
        if (confirm("ต้องการลบใช่หรือไม่ ?")) {
            SubmitPostData("", {
                "del": "",
                "appointment_id": data.appointment_id
            });
        }
    });
});
</script>
<?php
    if( isset($_POST["add"]) ) {
        $appointment_id = $DB->QueryMaxId("appointment", "appointment_id");
        $patient_id = $_GET["patient_id"];
        $appointment_date = $_POST["appointment_date"];
        $appointment_desc = $_POST["appointment_desc"];
        $nurse_id = $_POST["nurse_id"];
        $process = $_POST["process"];
        $DB->QueryInsert("appointment", array(
            "appointment_id"=>$appointment_id,
            "patient_id"=>$patient_id,
            "appointment_date"=>$appointment_date,
            "appointment_desc"=>$appointment_desc,
            "nurse_id"=>$nurse_id,
            "process"=>$process,
            "add_by"=>$USER["user_id"],
            "add_when"=>date("Y-m-d H:i:s")
        ));
        Reload();
    }
    if( isset($_POST["edit"]) ) {
        $appointment_id = $_POST["appointment_id"];
        $patient_id = $_GET["patient_id"];
        $appointment_date = $_POST["appointment_date"];
        $appointment_desc = $_POST["appointment_desc"];
        $nurse_id = $_POST["nurse_id"];
        $process = $_POST["process"];
        $DB->QueryUpdate("appointment", array(
            "patient_id"=>$patient_id,
            "appointment_date"=>$appointment_date,
            "appointment_desc"=>$appointment_desc,
            "nurse_id"=>$nurse_id,
            "process"=>$process,
            "edit_by"=>$USER["user_id"],
            "edit_when"=>date("Y-m-d H:i:s")
        ), "appointment_id='".$appointment_id."' ");
        Reload();
    }
    if( isset($_POST["del"]) ) {
        $appointment_id = $_POST["appointment_id"];
        $DB->QueryDelete("appointment", "appointment_id='".$appointment_id."' ");
        Reload();
    }
?>