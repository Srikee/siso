<?php
    $search = @$_GET["search"];
?>
<div id="wrapper-body">
    <form action="" method="get">
        <input type="text" class="form-control mb-2" name="search" placeholder="ค้นหาผู้ป่วย..."
            value="<?php echo $search; ?>" required>
        <small class="form-text text-muted mb-3">ค้นหาผู้ป่วย พิมพ์ ชื่อ หรือนามสกุล หรือเลขที่ประจำตัว
            หรือเบอร์โทรศัพท์
            อย่างใดอย่างหนึ่ง</small>
        <button type="submit" class="btn btn-info mr-2">
            <i class="fas fa-search mr-1"></i>
            ค้นหา
        </button>
        <a href="./" class="btn btn-danger">
            <i class="fas fa-times mr-1"></i>
            ล้าง
        </a>
    </form>
    <?php 
        if($search!="") { 
            $sql = "
                SELECT * FROM patient 
                WHERE idcard LIKE '%".$search."%'
                    OR patient_name LIKE '%".$search."%'
                    OR patient_lname LIKE '%".$search."%'
                    OR phone LIKE '%".$search."%'
            ";
            $obj = $DB->QueryObj($sql);
    ?>
    <div class="mt-5">
        <div class="mb-3">พบ <?php echo sizeof($obj); ?> รายการ</div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center" style="width:60px;">ลำดับ</th>
                        <th class="text-center" style="width:140px;">เลขที่ประจำตัว</th>
                        <th>ชื่อผู้ป่วย</th>
                        <th class="text-center" style="width:160px;">เบอร์โทรศัพท์</th>
                        <th style="width:140px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(sizeof($obj)==0) { ?>
                    <tr>
                        <th class="text-center" colspan="5">ไม่พบรายชื่อผู้ป่วย</th>
                    </tr>
                    <?php } ?>
                    <?php foreach($obj as $key=>$row) { ?>
                    <tr>
                        <th class="text-center"><?php echo $key+1; ?></th>
                        <td class="text-center"><?php echo $row["idcard"]; ?></td>
                        <td><?php echo $row["patient_name"]; ?> <?php echo $row["patient_lname"]; ?></td>
                        <td class="text-center"><?php echo $row["phone"]; ?></td>
                        <td class="text-center p-0 pt-2">
                            <a href="./?page=patient-data&search=<?php echo $search; ?>&patient_id=<?php echo $row["patient_id"]; ?>"
                                class="btn btn-secondary btn-sm">
                                <i class="fas fa-folder-open mr-1"></i>
                                เปิดดูประวัติ
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php } ?>
</div>