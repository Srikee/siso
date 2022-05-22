$(function () {
    $("#bdate").change(function () {
        var age = CalculateAge($(this).val());
        $("#age").val(age);
    });
});