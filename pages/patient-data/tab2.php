<?php
    $sql = "
        SELECT 
            t.*,
            n.nurse_name,
            n.nurse_lname
        FROM treatment t
            INNER JOIN nurse n ON n.nurse_id=t.nurse_id
        WHERE patient_id='".$patient_id."'
        ORDER BY treatment_date DESC
    ";
    $obj = $DB->QueryObj($sql);
?>
<div>
    <button class="btn btn-success btn-add" data-toggle="modal" data-target="#modal-data">
        <i class="fas fa-plus mr-1"></i>
        บันทึกการรักษาใหม่
    </button>
</div>
<div class="mt-5">
    <div class="mb-3">พบ <?php echo sizeof($obj); ?> รายการ</div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center">วันที่รักษา</th>
                    <th class="text-center">อาการเจ็บป่วย</th>
                    <th class="text-center">การวินิจฉัย</th>
                    <th class="text-center">การรักษา</th>
                    <th class="text-center">ผู้รักษา</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if(sizeof($obj)==0) { ?>
                <tr>
                    <th class="text-center" colspan="6">ไม่พบประวัติการรักษา</th>
                </tr>
                <?php } ?>
                <?php foreach($obj as $row) { ?>
                <tr data-json="<?php echo htmlspecialchars(json_encode($row)); ?>">
                    <th class="text-center"><?php echo DateTh($row["treatment_date"]); ?></th>
                    <td class="text-center"><?php echo $row["symptom"]; ?></td>
                    <td class="text-center"><?php echo $row["diagnosis"]; ?></td>
                    <td class="text-center"><?php echo $row["treatment"]; ?></td>
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
            <input type="hidden" id="treatment_id" name="treatment_id">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="treatment_date">วันที่รักษา</label>
                    <input type="date" class="form-control" id="treatment_date" name="treatment_date" required>
                </div>
                <div class="form-group">
                    <label for="symptom">อาการเจ็บป่วย</label>
                    <input type="text" class="form-control" id="symptom" name="symptom" required>
                </div>
                <div class="form-group">
                    <label for="diagnosis">การวินิจฉัย</label>
                    <input type="text" class="form-control" id="diagnosis" name="diagnosis" required>
                </div>
                <div class="form-group">
                    <label for="treatment">การรักษา</label>
                    <input type="text" class="form-control" id="treatment" name="treatment" required>
                </div>
                <div class="form-group">
                    <label for="nurse_id">ผู้รักษา</label>
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
        $(".modal-title").html("บันทึกการรักษาใหม่");
        $("[name=add]").show();
        $("[name=edit]").hide();
        $("#treatment_id").val("");
        $("#treatment_date").val("");
        $("#symptom").val("");
        $("#diagnosis").val("");
        $("#treatment").val("");
        $("#nurse_id").val("");
    });
    $("body").on("click", ".btn-edit", function() {
        $(".modal-title").html("แก้ไขการรักษา");
        $("[name=add]").hide();
        $("[name=edit]").show();
        var data = JSON.parse($(this).closest("tr").attr("data-json"));
        $("#treatment_id").val(data.treatment_id);
        $("#treatment_date").val(data.treatment_date);
        $("#symptom").val(data.symptom);
        $("#diagnosis").val(data.diagnosis);
        $("#treatment").val(data.treatment);
        $("#nurse_id").val(data.nurse_id);
    });
    $("body").on("click", ".btn-del", function() {
        var data = JSON.parse($(this).closest("tr").attr("data-json"));
        if (confirm("ต้องการลบใช่หรือไม่ ?")) {
            SubmitPostData("", {
                "del": "",
                "treatment_id": data.treatment_id
            });
        }
    });
});
</script>
<?php
    if( isset($_POST["add"]) ) {
        $treatment_id = $DB->QueryMaxId("treatment", "treatment_id");
        $patient_id = $_GET["patient_id"];
        $treatment_date = $_POST["treatment_date"];
        $symptom = $_POST["symptom"];
        $diagnosis = $_POST["diagnosis"];
        $treatment = $_POST["treatment"];
        $nurse_id = $_POST["nurse_id"];
        $DB->QueryInsert("treatment", array(
            "treatment_id"=>$treatment_id,
            "patient_id"=>$patient_id,
            "treatment_date"=>$treatment_date,
            "symptom"=>$symptom,
            "diagnosis"=>$diagnosis,
            "treatment"=>$treatment,
            "nurse_id"=>$nurse_id,
            "add_by"=>$USER["user_id"],
            "add_when"=>date("Y-m-d H:i:s")
        ));
        Reload();
    }
    if( isset($_POST["edit"]) ) {
        $treatment_id = $_POST["treatment_id"];
        $patient_id = $_GET["patient_id"];
        $treatment_date = $_POST["treatment_date"];
        $symptom = $_POST["symptom"];
        $diagnosis = $_POST["diagnosis"];
        $treatment = $_POST["treatment"];
        $nurse_id = $_POST["nurse_id"];
        $DB->QueryUpdate("treatment", array(
            "patient_id"=>$patient_id,
            "treatment_date"=>$treatment_date,
            "symptom"=>$symptom,
            "diagnosis"=>$diagnosis,
            "treatment"=>$treatment,
            "nurse_id"=>$nurse_id,
            "edit_by"=>$USER["user_id"],
            "edit_when"=>date("Y-m-d H:i:s")
        ), "treatment_id='".$treatment_id."' ");
        Reload();
    }
    if( isset($_POST["del"]) ) {
        $treatment_id = $_POST["treatment_id"];
        $DB->QueryDelete("treatment", "treatment_id='".$treatment_id."' ");
        Reload();
    }
?>