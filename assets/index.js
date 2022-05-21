$(function () {
    toggleImageViewer($("[data-image-viewer]"));
    $('[data-title]').tooltip();
    var href = window.location.href;
    window.history.replaceState({}, '', href);
});

function toggleImageViewer(ctrl) {
    if (ctrl.length == 0) return;
    ctrl.fancybox();
}

function ShowImage(src) {
    $.fancybox({
        'type': 'image',
        'padding': 0,
        'overlayShow': false,
        'href': src
    });
}

function ShowAlert(option) {
    option.title = option.title || 'แจ้งข้อความ';
    option.html = option.html || 'ระบุข้อความ';
    option.type = option.type || 'info'; // success, error, warning, info, question
    option.confirmButtonColor = option.confirmButtonColor || '#3085d6';
    option.confirmButtonText = option.confirmButtonText || '<i class="fa fa-check"></i> ตกลง';
    option.allowOutsideClick = option.allowOutsideClick || false;
    option.allowEscapeKey = option.allowEscapeKey || false;
    option.callback = option.callback || function () { };
    swal(option).then(function (result) {
        option.callback(true);
    });
}

function ShowConfirm(option) {
    option.title = option.title || 'คำยืนยัน ?';
    option.html = option.html || 'ระบุข้อความ';
    option.type = option.type || 'question'; // success, error, warning, info, question
    option.showCancelButton = option.showCancelButton || true;
    option.confirmButtonColor = option.confirmButtonColor || '#3085d6';
    option.cancelButtonColor = option.cancelButtonColor || '#d33';
    option.confirmButtonText = option.confirmButtonText || '<i class="fa fa-check"></i> ตกลง';
    option.cancelButtonText = option.cancelButtonText || '<i class="fa fa-times"></i> ยกเลิก';
    option.allowOutsideClick = option.allowOutsideClick || false;
    option.allowEscapeKey = option.allowEscapeKey || false;
    option.callback = option.callback || function () { };
    swal(option).then(function (result) {
        option.callback(true);
    }, function (dismiss) {
        option.callback(false);
    });
}

function FileChange(allow_types, allow_size, ctrl, to, df, cb) {
    if (!df) df = "";
    var input = $(ctrl)[0];
    if (input.files && input.files[0]) {
        var name = input.files[0].name;
        var size = input.files[0].size;
        var type = input.files[0].type; // "image/jpeg" | image/png | image/gif | image/pjpeg
        var arr = name.split(".");
        var fType = (arr[arr.length - 1]).toLowerCase(); // "jpeg" | png | gif | pjpeg
        if (arr.length < 2 || ($.inArray(fType, allow_types) == -1)) {
            ShowAlert({
                html: "รูปแบบไม่รองรับ รองรับเฉพาะ " + AcceptImplode(allow_types) + " เท่านั้น",
                type: "error",
                callback: function () {
                    $(ctrl).val('');
                    if (to) $(to).attr('src', df);
                    if (cb) cb(false);
                }
            });
            return;
        }
        if (size > allow_size * 1024 * 1024) {
            ShowAlert({
                html: "ขนาดของไฟล์ที่คุณเลือกเท่ากับ " + (size / 1024 / 1024).toFixed(2) + " MB ซึ่งสูงกว่าที่กำหนด กรุณาเลือกไฟล์ที่ไม่เกิน " + allow_size + " MB",
                type: "error",
                callback: function () {
                    $(ctrl).val('');
                    if (to) $(to).attr('src', df);
                    if (cb) cb(false);
                }
            });
            return;
        }
        if (to) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(to).attr('src', e.target.result);
                if (cb) cb(true);
            };
            reader.readAsDataURL(input.files[0]);
        }
    } else {
        ShowAlert({
            html: "รูปแบบไม่รองรับ รองรับเฉพาะ " + AcceptImplode(allow_types) + " เท่านั้น",
            type: "error",
            callback: function () {
                $(ctrl).val('');
                $(to).attr('src', df);
                if (cb) cb(false);
            }
        });
    }
}

function ToNum(strNum) {
    if (strNum == null || strNum == "") return 0;
    strNum = strNum.replace(" %", "");
    strNum = strNum.replace(",", "");
    return strNum;
}

function LinkTo(url) {
    location.href = url;
}

function Reload() {
    location.reload();
}

function Back() {
    window.history.back();
}

function SubmitPostData(url, data) {
    var $form = $("<form></form>");
    $form.attr("method", "post");
    $form.attr({
        'method': 'post',
        'action': url
    });
    $.each(data, function (i, v) {
        var $input = $("<input type='hidden'>");
        $input.attr({
            'name': i,
            'value': v
        });
        $form.append($input);
    });
    $form.appendTo('body');
    $form.submit();
}

function GetFormData(form_id) {
    var formData = new FormData();
    var x = $(form_id).serializeArray();
    for (var i = 0; i < x.length; i++) {
        formData.append(x[i].name, x[i].value);
    }
    x = $(form_id).find("[type=file][name]");
    for (var i = 0; i < x.length; i++) {
        var name = $(x[i]).attr('name');
        var value = x[i].files[0];
        if (value) {
            formData.append(name, value);
        }
    }
    return formData;
}

function AcceptImplode(type) {
    var str = "";
    for (var i = 0; i < type.length; i++) {
        str += "." + type[i];
        if (i < type.length - 1) {
            str = str + ", ";
        }
    }
    return str;
}

function OnError(ctrl, df) {
    $(ctrl).attr("src", df);
}

var initPhotoSwipeFromDOM = function (gallerySelector) {
    var parseThumbnailElements = function (el) {
        var thumbElements = el.childNodes,
            numNodes = thumbElements.length,
            items = [],
            figureEl,
            linkEl,
            size,
            item;
        for (var i = 0; i < numNodes; i++) {
            figureEl = thumbElements[i];
            if (figureEl.nodeType !== 1) {
                continue;
            }
            linkEl = figureEl.children[0];
            size = linkEl.getAttribute('data-size').split('x');
            item = {
                src: linkEl.getAttribute('href'),
                w: parseInt(size[0], 10),
                h: parseInt(size[1], 10)
            };
            if (figureEl.children.length > 1) {
                item.title = figureEl.children[1].innerHTML;
            }
            if (linkEl.children.length > 0) {
                item.msrc = linkEl.children[0].getAttribute('src');
            }
            item.el = figureEl;
            items.push(item);
        }
        return items;
    };
    var closest = function closest(el, fn) {
        return el && (fn(el) ? el : closest(el.parentNode, fn));
    };
    var onThumbnailsClick = function (e) {
        e = e || window.event;
        e.preventDefault ? e.preventDefault() : e.returnValue = false;
        var eTarget = e.target || e.srcElement;
        var clickedListItem = closest(eTarget, function (el) {
            return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
        });
        if (!clickedListItem) {
            return;
        }
        var clickedGallery = clickedListItem.parentNode,
            childNodes = clickedListItem.parentNode.childNodes,
            numChildNodes = childNodes.length,
            nodeIndex = 0,
            index;
        for (var i = 0; i < numChildNodes; i++) {
            if (childNodes[i].nodeType !== 1) {
                continue;
            }
            if (childNodes[i] === clickedListItem) {
                index = nodeIndex;
                break;
            }
            nodeIndex++;
        }
        if (index >= 0) {
            openPhotoSwipe(index, clickedGallery);
        }
        return false;
    };
    var photoswipeParseHash = function () {
        var hash = window.location.hash.substring(1),
            params = {};
        if (hash.length < 5) {
            return params;
        }
        var vars = hash.split('&');
        for (var i = 0; i < vars.length; i++) {
            if (!vars[i]) {
                continue;
            }
            var pair = vars[i].split('=');
            if (pair.length < 2) {
                continue;
            }
            params[pair[0]] = pair[1];
        }
        if (params.gid) {
            params.gid = parseInt(params.gid, 10);
        }
        return params;
    };
    var openPhotoSwipe = function (index, galleryElement, disableAnimation, fromURL) {
        var pswpElement = document.querySelectorAll('.pswp')[0],
            gallery,
            options,
            items;
        items = parseThumbnailElements(galleryElement);
        options = {
            galleryUID: galleryElement.getAttribute('data-pswp-uid'),
            getThumbBoundsFn: function (index) {
                var thumbnail = items[index].el.getElementsByTagName('img')[0],
                    pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                    rect = thumbnail.getBoundingClientRect();
                return {
                    x: rect.left,
                    y: rect.top + pageYScroll,
                    w: rect.width
                };
            }
        };
        if (fromURL) {
            if (options.galleryPIDs) {
                for (var j = 0; j < items.length; j++) {
                    if (items[j].pid == index) {
                        options.index = j;
                        break;
                    }
                }
            } else {
                options.index = parseInt(index, 10) - 1;
            }
        } else {
            options.index = parseInt(index, 10);
        }
        if (isNaN(options.index)) {
            return;
        }
        if (disableAnimation) {
            options.showAnimationDuration = 0;
        }
        gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
        gallery.init();
    };
    var galleryElements = document.querySelectorAll(gallerySelector);
    for (var i = 0, l = galleryElements.length; i < l; i++) {
        galleryElements[i].setAttribute('data-pswp-uid', i + 1);
        galleryElements[i].onclick = onThumbnailsClick;
    }
    var hashData = photoswipeParseHash();
    if (hashData.pid && hashData.gid) {
        openPhotoSwipe(hashData.pid, galleryElements[hashData.gid - 1], true, true);
    }
};

function GetUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
};

var POPUP;

function ShowLoading() {
    POPUP = new jBox('Modal', {
        title: '<span class="font-weight-bold">กำลังประมวลผล...</span>',
        content: '\
            <div class="progress" style="height: 30px;">\
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>\
            </div>\
            ',
        width: "500px",
        height: "60px",
        draggable: false,
        overlay: true,
        closeOnClick: false,
        closeButton: false,
        onClose: function () {
            setTimeout(function () {
                POPUP.destroy();
            }, 200);
        }
    });
    POPUP.open();
}

function HideLoading() {
    POPUP.close();
}

function BindUnload(form_id) {
    var _old = "";
    var _bind = false;
    var get_value = function (form_id) {
        var val = $(form_id).serializeArray();
        return JSON.stringify(val);
    }
    _old = get_value(form_id);
    $(form_id).change(function () {
        var _new = get_value(this);
        if (_old == _new) {
            if (_bind == true) {
                $(window).unbind("beforeunload");
                _bind = false;
            }
        } else {
            if (_bind == false) {
                $(window).unbind("beforeunload").bind("beforeunload", function () { return ""; });
                _bind = true;
            }
        }
    });
}

function UnbindUnload() {
    $(window).unbind("beforeunload");
}

function ScrollTo(id, move = 0) {
    // ScrollTo("#first-scroll", -30);  | id="first-scroll"
    $('html,body').animate({
        scrollTop: $(id).offset().top + move
    }, 'slow');
}