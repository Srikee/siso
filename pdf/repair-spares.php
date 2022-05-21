<?php
    include_once("../php/autoload.php");
    include_once("autoload.php");

    if( $STAFF==null ) {
        echo json_encode(array(
    		"status"=>false,
    		"message"=>"กรุณาเข้าสู่ระบบก่อนการใช้งาน"
    	));
    	exit();
    }

    $repair_id = @$_GET["repair_id"];

    $sql = "
        SELECT 
            r.*,
            ui.prefix,
            ui.name,
            ui.sname,
            ui.type,
            ui.department,
            rs.repair_status_name,
            rs.`class`,
            rs.icon,
            st.section_title_name,
            f.fac_name,
            d.dept_name,
            s.sect_name,
            m.major_name,
            rsp.repair_id AS repair_id2,
            rsp.results_check,
            rsp.remark,
            stf.prefix_name,
            stf.staff_name,
            stf.staff_sname,
            stn.section_name
        FROM repair r
            INNER JOIN user_info ui ON ui.username=r.username
            INNER JOIN repair_status rs ON rs.repair_status_id=r.repair_status_id
            INNER JOIN section_title st ON st.section_title_id=r.section_title_id
            INNER JOIN section stn ON stn.section_id=r.section_id
            LEFT JOIN c_fac f ON f.fac_id=r.fac_id
            LEFT JOIN c_dept d ON d.dept_id=r.dept_id
            LEFT JOIN c_sect s ON s.sect_id=r.sect_id
            LEFT JOIN c_major m ON m.major_id=r.major_id
            LEFT JOIN repair_spares rsp ON rsp.repair_id=r.repair_id
            LEFT JOIN staff stf ON stf.username=rsp.username_edit
        WHERE r.repair_id='".$repair_id."'
        ORDER BY r.repair_id DESC
    ";
    $obj = $DATABASE->QueryObj($sql);
    if( sizeof($obj)==0 ) {
        echo json_encode(array(
    		"status"=>false,
    		"message"=>"ไม่พบข้อมูล"
    	));
    	exit();
    }
    $data = $obj[0];

    ob_start(); 
    include("master/start.php");

    function DisplayData($data) {
        if( $data=="" ) echo "-";
        else echo nl2br($data);
    }
?>
<div class="text-center text-bold size-26">ใบแจ้งปัญหา/อะไหล่ซ่อม</div>
<!-- <div class="text-center text-bold size-20">ศูนย์เทคโนโลยีดิจิทัล วิทยาเขตปัตตานี</div> -->
<div class="text-center text-bold size-20 mgb-28"><?php echo $data["section_name"]; ?></div>
<table class="table" cellspacing="0" cellpadding="0" border="0">
    <tr>
        <td>
            <div>
                <span class="text-bold">ผู้แจ้งซ่อม : </span>
                <span class="">
                    <?php echo $data["prefix"]; ?><?php echo $data["name"]; ?>
                    <?php echo $data["sname"]; ?>
                </span>
            </div>
            <div>
                <span class="text-bold">เบอร์มือถือ : </span>
                <span class=""><?php DisplayData($data["repair_tel"]); ?></span>
            </div>
            <div>
                <span class="text-bold">เบอร์ภายใน : </span>
                <span class=""><?php DisplayData($data["repair_tel_in"]); ?></span>
            </div>
        </td>
        <td class="wd-240 text-right">
            <div>
                <span class="text-bold">เลขที่แจ้งปัญหา : </span>
                <span class=""><?php echo $data["repair_id"]; ?>
                </span>
            </div>
            <div>
                <span class="text-bold">วันที่แจ้งปัญหา : </span>
                <span class="">
                    <?php echo DateTh($data["repair_date"]); ?> น.
                </span>
            </div>
            <div>
                <span class="text-bold">สถานะ : </span>
                <span class="<?php echo $data["class"]; ?>">
                    <?php
                        echo $data["repair_status_name"]; 
                    ?>
                </span>
            </div>
        </td>
    </tr>
</table>
<div class="mgt-15 mgb-3" style="border-bottom: 3px solid #000;"></div>
<div class="mgb-15" style="border-bottom: 1px solid #000;"></div>
<table class="table" cellspacing="0" cellpadding="0" border="0">
    <tr>
        <td class="wd-100 text-bold">ผู้แจ้งปัญหา</td>
        <td class="wd-15">:</td>
        <td class="wd-260">
            <?php echo $data["prefix"]; ?><?php echo $data["name"]; ?>
            <?php echo $data["sname"]; ?>
        </td>
        <td class="wd-90 text-bold">อีเมล</td>
        <td class="wd-15">:</td>
        <td><?php DisplayData($data["repair_email"]); ?></td>
    </tr>
    <tr>
        <td class="text-bold">เบอร์มือถือ</td>
        <td>:</td>
        <td><?php DisplayData($data["repair_tel"]); ?></td>
        <td class="text-bold">เบอร์ภายใน</td>
        <td>:</td>
        <td><?php DisplayData($data["repair_tel_in"]); ?></td>
    </tr>
    <?php if( $data["type"]=="Staffs" ) { ?>
    <tr>
        <td class="wd-100 text-bold">ส่วนงาน</td>
        <td class="wd-15">:</td>
        <td colspan="4">
            <?php DisplayData($data["fac_name"]); ?>
        </td>
    </tr>
    <tr>
        <td class="wd-100 text-bold">หน่วยงาน</td>
        <td class="wd-15">:</td>
        <td colspan="4">
            <?php DisplayData($data["dept_name"]); ?>
        </td>
    </tr>
    <tr>
        <td class="wd-100 text-bold">งาน</td>
        <td class="wd-15">:</td>
        <td colspan="4">
            <?php DisplayData($data["sect_name"]); ?>
        </td>
    </tr>
    <?php } else if( $data["type"]=="Students" ) { ?>
    <tr>
        <td class="wd-100 text-bold">คณะ</td>
        <td class="wd-15">:</td>
        <td colspan="4">
            <?php DisplayData($data["fac_name"]); ?>
        </td>
    </tr>
    <tr>
        <td class="wd-100 text-bold">สาขาวิชา</td>
        <td class="wd-15">:</td>
        <td colspan="4">
            <?php DisplayData($data["major_name"]); ?>
        </td>
    </tr>
    <?php } else { ?>
    <tr>
        <td class="wd-100 text-bold">หน่วยงาน</td>
        <td class="wd-15">:</td>
        <td colspan="4">
            <?php DisplayData($data["department"]); ?>
        </td>
    </tr>
    <?php } ?>
    <tr>
        <td class="wd-100 text-bold">หัวข้อแจ้งปัญหา</td>
        <td class="wd-15">:</td>
        <td colspan="4"><?php DisplayData($data["section_title_name"]); ?></td>
    </tr>
</table>
<div class="text-bold mgt-15">รายละเอียดแจ้งปัญหา</div>
<div class=""><?php DisplayData($data["repair_desc"]); ?></div>
<div class="text-bold mgt-15">ผลการตรวจเช็ค/อะไหล่</div>
<div class=""><?php DisplayData($data["results_check"]); ?></div>
<div class="text-bold mgt-15">หมายเหตุ</div>
<div class=""><?php DisplayData($data["remark"]); ?></div>
<table class="table mgt-40" cellspacing="0" cellpadding="0">
    <tr>
        <td class="w-50 text-center">
            <div class="text-bold">ผู้แจ้งซ่อม</div><br>
            <div class="">___________________________</div><br>
            <div class="">
                (
                <?php echo $data["prefix"]; ?><?php echo $data["name"]; ?>
                <?php echo $data["sname"]; ?>
                )
            </div>
        </td>
        <td class="w-50 text-center">
            <div class="text-bold">ผู้ตรวจเช็ค</div><br>
            <div class="">___________________________</div><br>
            <div class="">
                (
                <?php 
                    if($data["prefix_name"]=="") {
                        echo '<span class="text-danger">ไม่ปรากฎผู้ตรวจเช็ค</span>';
                    } else {
                        echo $data["prefix_name"].$data["staff_name"]." ".$data["staff_sname"];
                    }
                ?>
                )
            </div>
        </td>
    </tr>
</table>

<?php
    
    include("master/end.php");
    $html = ob_get_clean();
    // echo $html;

    $mpdf = GetNewMPDF();
    $mpdf->WriteHTML($html);
    $mpdf->Output();