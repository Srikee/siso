<?php
    $sql = "
        SELECT 
            l.*,
            t.treatment_id,
            t.treatment_date
        FROM laboratory l
            INNER JOIN treatment t ON t.treatment_id=l.treatment_id
        WHERE l.patient_id='".$patient_id."'
        ORDER BY l.laboratory_date DESC
    ";
    $obj = $DB->QueryObj($sql);
?>
<div>
    <button class="btn btn-success btn-add" data-toggle="modal" data-target="#modal-data">
        <i class="fas fa-plus mr-1"></i>
        บันทึกการตรวจแลปใหม่
    </button>
</div>
<div class="mt-5">
    <div class="mb-3">พบ <?php echo sizeof($obj); ?> รายการ</div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center" style="width:110px;">วันที่รักษา</th>
                    <th class="text-center" style="width:110px;">วันที่ตรวจแลป</th>
                    <th class="text-center">Lab</th>
                    <th class="text-center">X-ray</th>
                    <th class="text-center">Ultrasound</th>
                    <th class="text-center" style="width:80px;">ไฟล์ผลแลป</th>
                    <th style="width:80px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php if(sizeof($obj)==0) { ?>
                <tr>
                    <th class="text-center" colspan="7">ไม่พบประวัติการตรวจแลป</th>
                </tr>
                <?php } ?>
                <?php 
                    foreach($obj as $row) {
                ?>
                <tr data-json="<?php echo htmlspecialchars(json_encode($row)); ?>">
                    <th class="text-center"><?php echo DateTh($row["treatment_date"]); ?></th>
                    <th class="text-center"><?php echo DateTh($row["laboratory_date"]); ?></th>
                    <td><?php echo $row["lab"]; ?></td>
                    <td><?php echo $row["xray"]; ?></td>
                    <td><?php echo $row["ultrasound"]; ?></td>
                    <td class="text-center p-0 pt-2">
                        <button class="btn btn-info btn-sm btn-file" title="เปิดดู" data-toggle="modal"
                            data-target="#modal-file" style="width:35px;">
                            <i class="fas fa-file-pdf"></i>
                        </button>
                    </td>
                    <td class="text-center p-0 pt-2">
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
        <form action="" enctype="multipart/form-data" method="post" class="modal-content">
            <input type="hidden" id="laboratory_id" name="laboratory_id">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="treatment_id">อ้างอิงข้อมูลการรักษาของวันที่</label>
                    <select class="form-control" id="treatment_id" name="treatment_id" required></select>
                </div>
                <div class="form-group">
                    <label for="laboratory_date">วันที่นัด</label>
                    <input type="date" class="form-control" id="laboratory_date" name="laboratory_date" required>
                </div>
                <div class="form-group">
                    <label for="lab">Lab</label>
                    <input type="text" class="form-control" id="lab" name="lab" required>
                </div>
                <div class="form-group">
                    <label for="xray">X-ray</label>
                    <input type="text" class="form-control" id="xray" name="xray" required>
                </div>
                <div class="form-group">
                    <label for="ultrasound">Ultrasound</label>
                    <input type="text" class="form-control" id="ultrasound" name="ultrasound" required>
                </div>
                <div class="form-group">
                    <label for="filef">
                        ไฟล์ผลแลป
                        <a id="old-file" class="btn-file" data-toggle="modal" data-target="#modal-file"
                            href="Javascript:">เปิดดูไฟล์เดิม</a>
                    </label>
                    <input type="file" class="border p-2 w-100 rounded" id="filef" name="filef" accept="application/pdf"
                        required>
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
<div class="modal fade" id="modal-file">
    <div class="modal-dialog modal-lg">
        <form action="" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ไฟล์ผลแลป</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="file-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>
<script>
$(function() {
    $("body").on("click", ".btn-add", function() {
        $("#modal-data .modal-title").html("บันทึกการตรวจแลปใหม่");
        $("[name=add]").show();
        $("[name=edit]").hide();
        $("#laboratory_id").val("");
        $("#laboratory_date").val("");
        $("#lab").val("");
        $("#xray").val("");
        $("#ultrasound").val("");
        $("#filef").val("").attr("required", "required");
        $("#modal-data").attr("data-json", "");
        $("#old-file").hide();
        $.post("api/patient-data-check-treatment-laboratory.php", {
            patient_id: GetUrlParameter("patient_id")
        }, function(res) {
            if (res.status == 'ok') {
                $("#treatment_id").html("").removeAttr("disabled");
                $.each(res.datas, function(i, v) {
                    var $option = $('<option value="' + v.treatment_id + '">' + DateTh(v
                        .treatment_date) + '</option>');
                    $("#treatment_id").append($option);
                });
            } else {
                ShowAlert({
                    html: res.message,
                    type: 'error',
                    callback: function() {
                        $("#modal-data").modal("hide");
                    }
                });
            }
        }, "JSON");
    });
    $("body").on("click", ".btn-edit", function() {
        $("#modal-data .modal-title").html("แก้ไขการตรวจแลป");
        $("[name=add]").hide();
        $("[name=edit]").show();
        var data = JSON.parse($(this).closest("tr").attr("data-json"));
        $("#laboratory_id").val(data.laboratory_id);
        $("#laboratory_date").val(data.laboratory_date);
        $("#lab").val(data.lab);
        $("#xray").val(data.xray);
        $("#ultrasound").val(data.ultrasound);
        $("#treatment_id").html('<option value="' + data.treatment_id + '">' + DateTh(data
            .treatment_date) + '</option>').attr("disabled", "disabled");
        $("#modal-data").attr("data-json", JSON.stringify(data));
        $("#filef").val("").removeAttr("required");
        $("#old-file").show();
    });
    $("body").on("click", ".btn-del", function() {
        var data = JSON.parse($(this).closest("tr").attr("data-json"));
        if (confirm("ต้องการลบใช่หรือไม่ ?")) {
            SubmitPostData("", {
                "del": "",
                "laboratory_id": data.laboratory_id
            });
        }
    });
    $("body").on("click", ".btn-file", function() {
        var data = JSON.parse($(this).closest("[data-json]").attr("data-json"));
        $("#file-body").html(
            `<iframe src="./files/laboratory/` + data.file +
            `" class="w-100" style="min-height:500px;"></iframe>`);
    });
});
</script>
<?php
    if( isset($_POST["add"]) ) {
        $laboratory_id = $DB->QueryMaxId("laboratory", "laboratory_id");
        $treatment_id = $_POST["treatment_id"];
        $patient_id = $_GET["patient_id"];
        $laboratory_date = $_POST["laboratory_date"];
        $lab = $_POST["lab"];
        $xray = $_POST["xray"];
        $ultrasound = $_POST["ultrasound"];
        $filef = $_FILES["filef"];
        $dir = "files/laboratory/";
        $file = time().".".strtolower(pathinfo(basename($filef["name"]), PATHINFO_EXTENSION));
        move_uploaded_file($filef["tmp_name"], $dir.$file);
        $DB->QueryInsert("laboratory", array(
            "laboratory_id"=>$laboratory_id,
            "treatment_id"=>$treatment_id,
            "patient_id"=>$patient_id,
            "laboratory_date"=>$laboratory_date,
            "lab"=>$lab,
            "xray"=>$xray,
            "ultrasound"=>$ultrasound,
            "file"=>$file,
            "add_by"=>$USER["user_id"],
            "add_when"=>date("Y-m-d H:i:s")
        ));
        Reload();
    }
    if( isset($_POST["edit"]) ) {
        $laboratory_id = $_POST["laboratory_id"];
        $patient_id = $_GET["patient_id"];
        $laboratory_date = $_POST["laboratory_date"];
        $lab = $_POST["lab"];
        $xray = $_POST["xray"];
        $ultrasound = $_POST["ultrasound"];
        $data = array(
            "patient_id"=>$patient_id,
            "laboratory_date"=>$laboratory_date,
            "lab"=>$lab,
            "xray"=>$xray,
            "ultrasound"=>$ultrasound,
            "edit_by"=>$USER["user_id"],
            "edit_when"=>date("Y-m-d H:i:s")
        );
        if( isset($_FILES["filef"]["name"]) && $_FILES["filef"]["name"]!="" ) {
            $filef = $_FILES["filef"];
            $dir = "files/laboratory/";
            $file = time().".".strtolower(pathinfo(basename($filef["name"]), PATHINFO_EXTENSION));
            move_uploaded_file($filef["tmp_name"], $dir.$file);
            $data["file"] = $file;
            $file = $DB->QueryString("SELECT file FROM laboratory WHERE laboratory_id='".$laboratory_id."' ");
            unlink($dir.$file);
        }
        $DB->QueryUpdate("laboratory", $data, "laboratory_id='".$laboratory_id."' ");
        Reload();
    }
    if( isset($_POST["del"]) ) {
        $laboratory_id = $_POST["laboratory_id"];
        $dir = "files/laboratory/";
        $file = $DB->QueryString("SELECT file FROM laboratory WHERE laboratory_id='".$laboratory_id."' ");
        unlink($dir.$file);
        $DB->QueryDelete("laboratory", "laboratory_id='".$laboratory_id."' ");
        Reload();
    }
?>