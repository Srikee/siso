$(function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'th',
        events: function (info, successCallback, failureCallback) {
            var start = moment(info.start.valueOf()).format("YYYY-MM-DD");
            var end = moment(info.end.valueOf()).format("YYYY-MM-DD");
            $.post("api/get-calendar.php", {
                start: start,
                end: end
            }, function (res) {
                successCallback(res);
            }, "JSON");
        },
        eventClick: function (info) {
            var data = info.event._def.extendedProps.old;
            console.log(data);
            var popup;
            var $title = $('\
                <div>\
                    <h6 class="m-0 font-weight-bold">รายละเอียด</h6>\
                </div>\
            ');
            var $contents = $('\
                <div>\
                </div>\
            ');
            $footer = $('\
                <div class="text-right">\
                    <button class="btn btn-light btn-close border"><i class="fas fa-times"></i> ปิดหน้าจอ</button>\
                </div>\
            ');
            $footer.find('.btn-close').click(function (event) {
                popup.close();
            });
            $.post("pages/" + PAGE + "/info.php", {
                appointment_id: data.appointment_id
            }, function (res) {
                $contents.html(res);
            });
            popup = new jBox('Modal', {
                title: $title,
                content: $contents,
                // footer: $footer,
                width: "500px",
                height: "330px",
                draggable: 'title',
                overlay: true,
                addClass: 'uiRevert',
                onClose: function () { },
                onOpen: function () { }
            });
            popup.open();
        }
    });
    calendar.render();
});