<?php
    $sql = "
        SELECT 
            p.*,
            t.treatment_id,
            t.treatment_date
        FROM payment p
            INNER JOIN treatment t ON t.treatment_id=p.treatment_id
        WHERE p.patient_id='".$patient_id."'
        ORDER BY p.payment_date DESC
    ";
    $obj = $DB->QueryObj($sql);
?>
<div>
    <button class="btn btn-success btn-add" data-toggle="modal" data-target="#modal-data">
        <i class="fas fa-plus mr-1"></i>
        บันทึกการชำระเงินใหม่
    </button>
</div>
<div class="mt-5">
    <div class="mb-3">พบ <?php echo sizeof($obj); ?> รายการ</div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center" style="width:110px;">วันที่รักษา</th>
                    <th class="text-center" style="width:110px;">วันที่ชำระเงิน</th>
                    <th class="text-center" style="width:130px;">ยอดเงิน (บาท)</th>
                    <th class="text-center" style="width:95px;">ไฟล์สลิปเงิน</th>
                    <th class="text-center">หมายเหตุ</th>
                    <th style="width:80px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php if(sizeof($obj)==0) { ?>
                <tr>
                    <th class="text-center" colspan="6">ไม่พบประวัติการชำระเงิน</th>
                </tr>
                <?php } ?>
                <?php 
                    foreach($obj as $row) {
                ?>
                <tr data-json="<?php echo htmlspecialchars(json_encode($row)); ?>">
                    <th class="text-center"><?php echo DateTh($row["treatment_date"]); ?></th>
                    <th class="text-center"><?php echo DateTh($row["payment_date"]); ?></th>
                    <td class="text-center"><?php echo number_format($row["amount"], 0); ?></td>
                    <td class="text-center p-0 pt-2">
                        <button class="btn btn-info btn-sm btn-file" title="เปิดดู" data-toggle="modal"
                            data-target="#modal-file" style="width:35px;">
                            <i class="fas fa-file-pdf"></i>
                        </button>
                    </td>
                    <td class="text-center"><?php echo $row["remark"]; ?></td>
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
            <input type="hidden" id="payment_id" name="payment_id">
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
                    <label for="payment_date">วันที่ชำระเงิน</label>
                    <input type="date" class="form-control" id="payment_date" name="payment_date" required>
                </div>
                <div class="form-group">
                    <label for="amount">ยอดเงิน (บาท)</label>
                    <input type="number" class="form-control" id="amount" name="amount" required>
                </div>
                <div class="form-group">
                    <label for="filef">
                        ไฟล์สลิปเงิน
                        <a id="old-file" class="btn-file" data-toggle="modal" data-target="#modal-file"
                            href="Javascript:">เปิดดูไฟล์เดิม</a>
                    </label>
                    <input type="file" class="border p-2 w-100 rounded" id="filef" name="filef" accept="image/*"
                        required>
                </div>
                <div class="form-group">
                    <label for="remark">หมายเหตุ</label>
                    <input type="text" class="form-control" id="remark" name="remark" required>
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
    <div class="modal-dialog modal-md">
        <form action="" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ไฟล์สลิปเงิน</h5>
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
        $("#modal-data .modal-title").html("บันทึกการชำระเงินใหม่");
        $("[name=add]").show();
        $("[name=edit]").hide();
        $("#payment_id").val("");
        $("#payment_date").val("");
        $("#amount").val("");
        $("#remark").val("");
        $("#filef").val("").attr("required", "required");
        $("#modal-data").attr("data-json", "");
        $("#old-file").hide();
        $.post("api/patient-data-check-treatment-payment.php", {
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
        $("#modal-data .modal-title").html("แก้ไขการชำระเงิน");
        $("[name=add]").hide();
        $("[name=edit]").show();
        var data = JSON.parse($(this).closest("tr").attr("data-json"));
        $("#payment_id").val(data.payment_id);
        $("#payment_date").val(data.payment_date);
        $("#amount").val(data.amount);
        $("#remark").val(data.remark);
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
                "payment_id": data.payment_id
            });
        }
    });
    $("body").on("click", ".btn-file", function() {
        var data = JSON.parse($(this).closest("[data-json]").attr("data-json"));
        $("#file-body").html(
            `<img src="./files/payment/` + data.file +
            `" class="w-100"></img>`);
    });
});
</script>
<?php
    if( isset($_POST["add"]) ) {
        $payment_id = $DB->QueryMaxId("payment", "payment_id");
        $treatment_id = $_POST["treatment_id"];
        $patient_id = $_GET["patient_id"];
        $payment_date = $_POST["payment_date"];
        $amount = $_POST["amount"];
        $remark = $_POST["remark"];
        $filef = $_FILES["filef"];
        $dir = "files/payment/";
        $file = time().".".strtolower(pathinfo(basename($filef["name"]), PATHINFO_EXTENSION));
        move_uploaded_file($filef["tmp_name"], $dir.$file);
        $DB->QueryInsert("payment", array(
            "payment_id"=>$payment_id,
            "treatment_id"=>$treatment_id,
            "patient_id"=>$patient_id,
            "payment_date"=>$payment_date,
            "amount"=>$amount,
            "remark"=>$remark,
            "file"=>$file,
            "add_by"=>$USER["user_id"],
            "add_when"=>date("Y-m-d H:i:s")
        ));
        Reload();
    }
    if( isset($_POST["edit"]) ) {
        $payment_id = $_POST["payment_id"];
        $patient_id = $_GET["patient_id"];
        $payment_date = $_POST["payment_date"];
        $amount = $_POST["amount"];
        $remark = $_POST["remark"];
        $data = array(
            "patient_id"=>$patient_id,
            "payment_date"=>$payment_date,
            "amount"=>$amount,
            "remark"=>$remark,
            "edit_by"=>$USER["user_id"],
            "edit_when"=>date("Y-m-d H:i:s")
        );
        if( isset($_FILES["filef"]["name"]) && $_FILES["filef"]["name"]!="" ) {
            $filef = $_FILES["filef"];
            $dir = "files/payment/";
            $file = time().".".strtolower(pathinfo(basename($filef["name"]), PATHINFO_EXTENSION));
            move_uploaded_file($filef["tmp_name"], $dir.$file);
            $data["file"] = $file;
            $file = $DB->QueryString("SELECT file FROM payment WHERE payment_id='".$payment_id."' ");
            unlink($dir.$file);
        }
        $DB->QueryUpdate("payment", $data, "payment_id='".$payment_id."' ");
        Reload();
    }
    if( isset($_POST["del"]) ) {
        $payment_id = $_POST["payment_id"];
        $dir = "files/payment/";
        $file = $DB->QueryString("SELECT file FROM payment WHERE payment_id='".$payment_id."' ");
        unlink($dir.$file);
        $DB->QueryDelete("payment", "payment_id='".$payment_id."' ");
        Reload();
    }
?>