<?php
    $p = @$_GET["p"]*1; if($p==0) $p = 1;
    $search = @$_GET["search"];

    $condition_search = "";
    if( $search!="" ) {
        $condition_search .= " AND (
            p.patient_name LIKE '%".$search."%'
            OR p.patient_name LIKE '%".$search."%'
            OR p.phone LIKE '%".$search."%'
        )";
    }
    
    $sql = "
        SELECT
            p.*
        FROM patient p
        WHERE 1=1
            ".$condition_search."
        ORDER BY p.patient_id DESC
    ";
    $show = $GLOBAL["SHOW"];
    $all = sizeof( $DB->QueryObj($sql) );
    $p_all = ceil( $all/$show );
    $start = ($p-1)*$show;
    $objData = $DB->QueryObj($sql." LIMIT ".$start.", ".$show);
?>
<div id="wrapper-body">
    <h6 class="mb-5">รายชื่อผู้ป่วย</h6>
    <div class="mb-4">
        <a href="./?page=patient-add" class="btn btn-success" title="เพิ่มรายชื่อผู้ป่วยใหม่">
            <i class="fas fa-plus"></i> เพิ่มรายชื่อผู้ป่วยใหม่
        </a>
    </div>
    <div class="row mb-3">
        <div class="col">
            <form id="frm-search" autocomplete="off">
                <div class="input-group inner-icon">
                    <span class="fa fa-search form-control-feedback"></span>
                    <input type="text" id="search" class="form-control" placeholder="ค้นหา"
                        value="<?php echo $search; ?>" style="border-radius: .25rem;">
                    <?php if($search!="") { ?>
                    <div class="input-group-append">
                        <a href="?page=<?php echo $PAGE; ?>" class="btn btn-outline-secondary"
                            title="ล้างการค้นหา">ล้าง</a>
                    </div>
                    <?php } ?>
                </div>
                <small class="form-text text-muted mb-3">ค้นหา โดยระบุ ชื่อ หรือนามสกุล หรือเบอร์โทรศัพท์ และกด
                    Enter</small>
            </form>
        </div>
        <div class="col-md-auto">
            <!-- แสดง Pagination -->
            <?php 
                if( sizeof($objData)>0 ) { 
                    $href = "./?page=".$PAGE;
                    if( isset($_GET["search"]) ) $href .= "&search=".$_GET["search"];
                    $p_show = 7;
                    $diff_center = floor($p_show/2);
                    $min_page = $p-$diff_center;
                    $max_page = $p+$diff_center;
                    $duration = 0;
                    if( $min_page<1 ) $duration=1-$min_page;
                    else if( $max_page>$p_all ) $duration=$p_all-$max_page;
                    $min_page = $min_page+$duration;
                    $max_page = $max_page+$duration;
                    if( $min_page<=0 ) $min_page = 1;
                    if( $max_page>$p_all ) $max_page = $p_all;
            ?>
            <nav aria-label="Page navigation" class="float-right">
                <ul class="pagination mb-2">
                    <?php 
                        $disabled_pr = "";
                        $href_pr = $href;
                        if( $p-1>1 ) $href_pr .= "&p=".($p-1);
                        if( $p==1 ) {
                            $disabled_pr = "disabled";
                            $href_pr = "#";
                        }
                    ?>
                    <li class="page-item <?php echo $disabled_pr; ?>">
                        <a class="page-link" href="<?php echo $href; ?>" title="หน้าแรก">
                            << </a>
                    </li>
                    <li class="page-item <?php echo $disabled_pr; ?>">
                        <a class="page-link" href="<?php echo $href_pr; ?>" title="หน้าก่อนหน้า">
                            < </a>
                    </li>
                    <?php
                        for($i=$min_page; $i<=$max_page; $i++) {
                            $href_p = $href;
                            if( $i>1 ) $href_p .= "&p=".$i;
                            $active = "";
                            if( $i==$p ) $active = "active";
                            echo '<li class="page-item '.$active.'"><a class="page-link" href="'.$href_p.'">'.$i.'</a></li>';
                        }
                    ?>
                    <?php 
                        $disabled_ne = "";
                        $href_ne = $href;
                        $href_ne .= "&p=".($p+1);
                        if( $p==$p_all ) {
                            $disabled_ne = "disabled";
                            $href_ne = "#";
                        }
                    ?>
                    <li class="page-item <?php echo $disabled_ne; ?>">
                        <a class="page-link" href="<?php echo $href_ne; ?>" title="หน้าถัดไป">></a>
                    </li>
                    <li class="page-item <?php echo $disabled_ne; ?>">
                        <a class="page-link" href="<?php echo $href."&p=".$p_all; ?>" title="หน้าสุดท้าย">>></a>
                    </li>
                </ul>
            </nav>
            <?php
                }
            ?>
            <!-- สิ้นสุดแสดง Pagination -->
        </div>
    </div>
    <h6>ค้นพบทั้งพบ <?php echo $all; ?> รายการ</h6>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col">ชื่อ-นามสกุล</th>
                    <th scope="col">เบอร์โทรศัพท์</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if( sizeof($objData)==0 ) {
                        echo '
                            <tr>
                                <td colspan="4" class="text-center">
                                    ไม่พบรายการ
                                </td>
                            </tr>
                        ';
                    }
                    foreach($objData as $key=>$row) {
                        echo '
                            <tr data-json="'.htmlspecialchars(json_encode($row)).'">
                                <th class="text-center order">'.(($show*($p-1))+($key+1)).'</th>
                                <td>'.$row["patient_name"].' '.$row["patient_lname"].'</td>
                                <td>'.$row["phone"].'</td>
                                <td class="p-0 pt-1 pr-1 text-right">
                                    <a href="./?page=patient-edit&patient_id='.$row["patient_id"].'" title="แก้ไข" class="btn-edit btn btn-light text-warning btn-sm" style="width: 32px">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <button title="ลบ" class="btn-del btn btn-light text-danger btn-sm" style="width: 32px">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        ';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php
    if( isset($_POST["del"]) ) {
        $patient_id = $_POST["patient_id"];
        if( $DB->QueryHaving("treatment", "patient_id", $patient_id) ) {
            ShowAlert("", "ลบไม่ได้ เนื่องจากมีการประวัติการรักษาแล้ว", "error", "./?page=".$PAGE);
            exit();
        }
        if( $DB->QueryHaving("appointment", "patient_id", $patient_id) ) {
            ShowAlert("", "ลบไม่ได้ เนื่องจากมีการบันทึกการนัดหมายแล้ว", "error", "./?page=".$PAGE);
            exit();
        }
        $DB->QueryDelete("patient", "patient_id='".$patient_id."' ");
        Reload();
    }
?>