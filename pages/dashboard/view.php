<?php
    $treatment_all = $DB->QueryNumRow("SELECT * FROM treatment ");
    $appointment_all = $DB->QueryNumRow("SELECT * FROM appointment WHERE process='W' ");
    $patient_all = $DB->QueryNumRow("SELECT * FROM patient WHERE status='Y' ");
    $payment_all = $DB->QueryString("SELECT SUM(amount) FROM payment ");
    $treatment_today = $DB->QueryNumRow("SELECT * FROM treatment WHERE treatment_date LIKE '".date("Y-m-d")."%'");
?>
<div id="wrapper-body">
    <div class="row mb-5">
        <div class="col-md-4 mb-3">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs text-primary text-uppercase mb-3" style="font-size: 26px;">
                                การรักษาทั้งหมด</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 34px;">
                                <?php echo number_format($treatment_all, 0); ?> ครั้ง
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-stethoscope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="card border-left-danger shadow h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-sm text-danger text-uppercase mb-1">กำลังนัดทั้งหมด</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo number_format($appointment_all, 0); ?> รายการ
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar-days fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card border-left-success shadow h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-sm text-success text-uppercase mb-1">ผู้ป่วยทั้งหมด</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo number_format($patient_all, 0); ?> คน
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card border-left-info shadow h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-sm text-info text-uppercase mb-1">รายรับทั้งหมด</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo number_format($payment_all, 0); ?> บาท
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card border-left-warning shadow h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-sm text-warning text-uppercase mb-1">ผู้มาใช้บริการวันนี้</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo number_format($treatment_today, 0); ?> ครั้ง
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-clock fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="font-size: 80px;" class="text-center">
        เปาะมะไก่เกิน
    </div>
</div>