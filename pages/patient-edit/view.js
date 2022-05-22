$(function () {
    $("#bdate").change(function () {
        var age = CalculateAge($(this).val());
        $("#age").val(age);
    });
    $("#idcard").blur(function () {
        var idcard = $(this).val();
        var patient_id = GetUrlParameter("patient_id");
        if (idcard == "") return;
        $.post("api/chk-duplicate-idcard.php", {
            idcard: idcard,
            patient_id: patient_id
        }, function (res) {
            if (res.status == 'ok') {
                ShowAlert({
                    html: "เลขที่ประจำตัวนี้ซ้ำกับรายชื่อผู้ป่วยคนอื่นแล้ว",
                    callback: function () {
                        $("#idcard").focus().select();
                    }
                });
            }
        }, "JSON");
    });
});