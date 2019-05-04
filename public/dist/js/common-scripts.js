if(typeof CSRF_TOKEN === 'undefined') {
    var csrf_meta = $('meta[name=csrf-token]'),
        CSRF_TOKEN = csrf_meta.length ? csrf_meta.attr("content") : '';
}

function myAlert(msg, ok, timeout, fields) {
    ok = typeof ok !== 'undefined' ? ok : false;
    timeout = typeof timeout !== 'undefined' ? timeout : 3000;
    if (msg === undefined) {
        if (ok)
            msg = 'Done! Operation Was Successful.';
        else
            msg = 'Error! Something Wrong Happened.';
    }
    var state = 'alert-danger',
        sign = '<i class="sign fa fa-times-circle fa-2x"></i> ',
        closeBtn = '<button class="close close-sm" type="button" onclick="$(\'#alertbox\').fadeOut()"> <i class="fa fa-remove"></i> </button>';
    msg = '<strong>' + msg + '</strong>';
    if (ok) {
        state = 'alert-success';
        sign = '<i class="sign fa fa-check-circle fa-2x"></i> ';
    }
    var fieldsHtml = '';
    if(typeof fields !== 'undefined') {
        fieldsHtml += '<ul>';
        $.each(fields, function (k, v) {
            fieldsHtml += '<li>'+v+'</li>';
        });
        fieldsHtml += '</ul>';
    }
    var alertBox = $('#alertbox');
    if (! alertBox.length > 0) {
        $('body:first').append('<div id="alertbox" class="alert alert-success fade in"></div>');
        alertBox = $('#alertbox');
    }
    if(alertBox.is(':visible'))
        alertBox.hide();
    alertBox
        .html(closeBtn + msg + sign + fieldsHtml)
        .removeClass('alert-danger')
        .removeClass('alert-success')
        .addClass(state);
    alertBox.slideDown();
    setTimeout(function () {
        alertBox.fadeOut();
    }, timeout);
}

$(function () {
    $("[data-hide]").on("click", function () {
        $(this).closest("." + $(this).attr("data-hide")).fadeOut();
        return false;
    });

    $("[data-ckeditor]").each(function () {
        CKEDITOR.replace($(this).attr('id') != undefined ? $(this).attr('id') : $(this).attr('name'), {
            filebrowserImageBrowseUrl: '/filemanager?type=Images',
            filebrowserImageUploadUrl: '/filemanager/upload?type=Images&_token=' + CSRF_TOKEN,
            filebrowserBrowseUrl: '/filemanager?type=Files',
            filebrowserUploadUrl: '/filemanager/upload?type=Files&_token=' + CSRF_TOKEN
        });
    });

    $("[data-img-preview]").each(function () {
        var img = $(this).data('img-preview');
        $(this).change(function () {
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(img).attr('src', e.target.result).show();
                };

                reader.readAsDataURL(this.files[0]);
            }
        });
    });

    $("video").click(function(e){
        // handle click if not Firefox (Firefox supports this feature natively)
        if (typeof InstallTrigger === 'undefined') {

            // get click position
            var clickY = (e.pageY - $(this).offset().top);
            var height = parseFloat( $(this).height() );

            // avoids interference with controls
            if (clickY > 0.82*height) return;

            // toggles play / pause
            this.paused ? this.play() : this.pause();
        }
    });

    $("[data-video-duration]").each(function () {
        var elem = $(this), video = document.getElementById(elem.data('video-duration').replace('#', ''));
        video.addEventListener('loadeddata', function() {
            elem.text(toHHMMSS(this.duration));
        }, false);
    });

    if ($.fn.tagsinput) {
        $('.tags-input').tagsinput({
            allowDuplicates: false,
            confirmKeys: [13, 188]
        });
    }

    $('.bootstrap-tagsinput input').on('keyup keypress', function(e){
        if (e.keyCode === 13){
            e.keyCode = 188;
            e.preventDefault();
        }
    });
});

// confirm box
$.fn.confirm = function (options) {
    var settings = $.extend({}, $.fn.confirm.defaults, options);

    return this.each(function () {
        var element = this;

        $('.modal-title', this).html(settings.title);
        $('.message', this).html(settings.message);
        $('.confirm', this).html(settings.confirm);
        $('.dismiss', this).html(settings.dismiss);

        $(this).on('click', '.confirm', function (event) {
            $(element).data('confirm', true);
        });

        $(this).on('hide.bs.modal', function (event) {
            if ($(this).data('confirm')) {
                $(this).trigger('confirm', event);
                $(this).removeData('confirm');
            } else {
                $(this).trigger('dismiss', event);
            }

            $(this).off('confirm dismiss');
        });

        $(this).modal('show');
    });
};
$.fn.confirm.defaults = {
    title: 'هشدار',
    message: 'اطمینان دارید؟',
    confirm: 'بلی',
    dismiss: 'خیر'
};
var confirm_form_submit = false;
$(function () {
    $('.confirm_form').submit(function (e) {
        if (confirm_form_submit) {
            confirm_form_submit = false;
            return;
        }
        e.preventDefault();
        var confirm_form = $(this);
        $('#confirm').confirm().on({
            confirm: function () {
                confirm_form_submit = true;
                confirm_form.trigger('submit');
            },
            dismiss: function () {
                confirm_form_submit = false;
                confirm_form.trigger('submit');
            }
        });
    });
});
// end confirm box

// ajax form submission
$.fn.ajaxForm = function (settings) {
    var config = $.extend({
        reset: false,
        progressBar: 'success',
        showProgressBar: false,
        closeModal: false,
        showAlert: true,
        showErrorMessages: true,
        callback: function () {
        },
        callbackParams: undefined
    }, settings);

    return this.each(function () {
        var form = $(this);
        form.find(":submit").click(function () {
            form.find(":submit").removeAttr("clicked");
            $(this).attr("clicked", "true");
        });
        form.submit(function (e) {
            e.preventDefault();
            var ckeditors = [];
            if (form.find('textarea')) {
                form.find('textarea').each(function () {
                    var name = $(this).attr('id') !== undefined ? $(this).attr('id') : $(this).attr('name');
                    if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances[name]) {
                        CKEDITOR.instances[name].updateElement();
                        $(this).html(CKEDITOR.instances[name].getData());
                        ckeditors.push(name);
                    }
                });
            }
            var formData = new FormData(form[0]),
                hasErrors = form.find('.has-error'),
                btn = form.find(':submit[clicked=true]'),
                btnHtml = btn.html(),
                hasCheckboxes = form.find('input[type="checkbox"]'),
                _progress,
                progress_outer;
            if (hasErrors.length) {
                hasErrors.removeClass('has-error').find('.help-block').remove();
            }
            if (hasCheckboxes.length) {
                hasCheckboxes.not(':checked').each(function () {
                    formData.append($(this).attr('name'), 0);
                });
            }
            if(btn[0].hasAttribute('name'))
                formData.append(btn.attr('name'), btn.val());
            btn.html('<i class="fa fa-spin fa-spinner"></i>');
            var url = form.attr('action');
            if (form.find('input[name="_method"]').length) {
                url += '/' + form.find('input[name="id"]').val();
            }
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                xhr: function () {
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload && config.showProgressBar) {
                        if (!form.find('.progress').length) {
                            btn.parent().append('<div class="progress progress-outer"> <div class="progress-bar progress-bar-' + config.progressBar + ' progress-bar-striped active"></div> </div>');
                        }
                        _progress = form.find('.progress-bar');
                        progress_outer = form.find('.progress');
                        progress_outer.show();
                        myXhr.upload.addEventListener('progress', function (e) {
                            var done = e.loaded, total = e.total;
                            _progress.css({'width': (Math.floor(done / total * 1000) / 10) + '%'});
                        }, false);
                    }
                    return myXhr;
                },
                success: function (data) {
                    var image = form.find('input[type="file"]'),
                        hasSelectpicker = form.find('select.selectpicker'),
                        hasSelect2 = form.find('select.select2'),
                        hasTagsInput = form.find('.tags-input, [data-role="tagsinput"]');
                    if (image.length && typeof data.imagePreview !== 'undefined') {
                        image.val('');
                        if ($(image.data('preview')).length) {
                            $(image.data('preview')).hide().attr('src', '');
                            $(image.data('preview')).attr('src', data.imagePreview).show();
                        } else if (image.data('preview').length) {
                            image.after('<img id="' + image.data('preview') + '" src="' + data.imagePreview + '" class="img-thumbnail img-preview">');
                        }
                    }
                    if (hasSelectpicker.length && data.refreshSelectpicker !== undefined) {
                        hasSelectpicker.find('.added').removeClass('added');
                        hasSelectpicker.find('option:selected').addClass('added');
                        var targetSelectpicker = hasSelectpicker;
                        if (hasSelectpicker.data('picker-type') !== undefined) {
                            var pickerType = hasSelectpicker.data('picker-type');
                            targetSelectpicker = $('select[data-picker-type="' + pickerType + '"]');
                        }
                        targetSelectpicker.find('*').not('.added').remove();
                        $.each(data.refreshSelectpicker, function (key, value) {
                            var values = [];
                            for (var k in value)
                                values.push(value[k]);
                            targetSelectpicker.append('<option value="' + values[0] + '" data-tokens="' + values[1] + '">' + values[2] + '</option>');
                        });
                        targetSelectpicker.selectpicker('refresh');
                    }
                    if (typeof config.callback === 'function') {
                        config.callbackParams = $.extend(config.callbackParams, data);
                        config.callback.call(this, config.callbackParams);
                    }
                    if (config.reset) {
                        form[0].reset();
                        if (image.length && $(image.data('img-preview')).length) {
                            var imgPreview = $(image.data('img-preview'));
                            if (imgPreview.hasClass('text-gray'))
                                imgPreview.attr('src', '');
                            else
                                $(image.data('img-preview')).hide();
                        }
                        if (ckeditors.length) {
                            $.each(ckeditors, function (k, name) {
                                CKEDITOR.instances[name].updateElement();
                                CKEDITOR.instances[name].setData('');
                            });
                        }
                        if (hasSelectpicker.length)
                            hasSelectpicker.selectpicker('refresh');
                        if(hasSelect2.length) {
                            hasSelect2.each(function () {
                                $(this).select2('val', '');
                            });
                        }
                        if(hasTagsInput.length)
                            hasTagsInput.tagsinput('removeAll');
                    }
                    if (config.closeModal)
                        form.closest('.modal').modal('hide');
                    if (config.showAlert)
                        myAlert(data.status, true);
                },
                error: function (data) {
                    data = data.responseJSON;
                    if (typeof data !== 'undefined') {
                        var alertStatus = data.status;
                        $.each(data, function (key, value) {
                            var input = form.find('*[name="' + key + '"]:first');
                            if (input.length) {
                                if(key === 'status')
                                    alertStatus = undefined;
                                input.closest('.form-group').addClass('has-error');
                                if (config.showErrorMessages)
                                    input.after('<span class="help-block"> <strong>' + value + '</strong> </span>');
                            }
                        });
                        myAlert(alertStatus);
                    } else
                        myAlert();
                },
                complete: function () {
                    if (progress_outer !== undefined && progress_outer.length) {
                        progress_outer.hide();
                        _progress.css({'width': '0'});
                    }
                    btn.html(btnHtml);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    });
};
// end ajax form submission

// ajax move tr up or down
$.fn.goUpDown = function (settings) {
    var config = $.extend({
        url: null,
        showAlert: false,
        callback: function () {
        },
        callbackParams: undefined
    }, settings);

    return this.each(function () {
        $(this).click(function () {
            var btn = $(this),
                btnHtml = btn.html(),
                tr = btn.closest('tr'),
                id = btn.data('id'),
                action = btn.data('action');
            btn.html('<i class="fa fa-spin fa-spinner"></i>');
            $.post(config.url + '/' + id + '/move', {_token: CSRF_TOKEN, action: action})
                .done(function (resp) {
                    if (resp.status) {
                        if (action == 'up')
                            tr.insertBefore(tr.prev());
                        else if (action == 'down')
                            tr.insertAfter(tr.next());
                        if (config.showAlert)
                            myAlert(undefined, true);
                    } else
                        myAlert();
                })
                .fail(function () {
                    myAlert();
                })
                .always(function () {
                    btn.html(btnHtml);
                });
        });
    });
};
// end ajax move tr up or down

// multiple modal fix
$(document)
    .on('show.bs.modal', '.modal', function () {
        var zIndex = 1040 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function () {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    })
    .on('hidden.bs.modal', '.modal', function () {
        $('.modal:visible').length && $(document.body).addClass('modal-open');
    });
// end multiple modal fix

// working with jquery.livequery
$(function () {
    if ($.fn.livequery) {
        $('.tooltips').livequery(function () {
            $(this).tooltip();
        });

        $("[data-edit-form]").livequery(function () {
            $(this).each(function () {
                $(this).click(function () {
                    var btn = $(this),
                        btnHtml = btn.html(),
                        url = btn.data('edit-action'),
                        id = btn.data('edit-id'),
                        form = $(btn.data('edit-form')),
                        hasErrors = form.find('.has-error'),
                        hasImgs = form.find('input[type="file"]'),
                        hasSelectpicker = form.find('select.selectpicker'),
                        hasSelect2 = form.find('select.select2'),
                        hasTagsInput = form.find('.tags-input, [data-role="tagsinput"]'),
                        ckeditors = [];
                    if (form.find('textarea')) {
                        form.find('textarea').each(function () {
                            var name = $(this).attr('id') !== undefined ? $(this).attr('id') : $(this).attr('name');
                            if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances[name]) {
                                CKEDITOR.instances[name].updateElement();
                                CKEDITOR.instances[name].setData('');
                                ckeditors.push($(this));
                            }
                        });
                    }
                    if (hasErrors.length)
                        hasErrors.removeClass('has-error').find('.help-block').remove();
                    if (hasImgs.length && hasImgs.data('preview') !== undefined) {
                        var img = $(hasImgs.data('preview'));
                        img.hide();
                    }
                    if (hasSelectpicker.length && hasSelectpicker.find('.added').length)
                        hasSelectpicker.find('.added').remove();
                    if(hasTagsInput.length)
                        hasTagsInput.tagsinput('removeAll');
                    form[0].reset();
                    if (url !== undefined) {
                        btn.html('<i class="fa fa-spin fa-spinner"></i>');
                        $.ajax({
                            method: 'post',
                            url: url,
                            data: {_token: CSRF_TOKEN},
                            dataType: 'json',
                            success: function (data) {
                                $.each(data, function (key, value) {
                                    if (key === 'imagePreview' && value.length) {
                                        img.attr('src', value).show();
                                        return;
                                    }
                                    if (key === 'selectpicker' && hasSelectpicker.length) {
                                        hasSelectpicker
                                            .prepend('<option class="added" value="' + value[0] + '" data-tokens="' + value[1] + '" selected>' + value[2] + '</option>')
                                            .selectpicker('refresh');
                                        return;
                                    }
                                    if(key === 'tags' && hasTagsInput.length) {
                                        $.each(value, function (k, v) {
                                            hasTagsInput.tagsinput('add', v);
                                        });
                                        hasTagsInput.tagsinput('refresh');
                                    }
                                    if (hasSelectpicker.length)
                                        hasSelectpicker.selectpicker('refresh');
                                    if(hasSelect2.length){
                                        hasSelect2.each(function () {
                                            if($(this).attr('name') === key + '[]' ) {
                                                $(this).find('option').each(function () {
                                                    if(jQuery.inArray($(this).val(), value) !== -1)
                                                        $(this).prop('selected', true);
                                                });
                                                $(this).change();
                                            }
                                        });
                                    }
                                    var input = form.find('*[name="' + key + '"], *[name^="' + key + '["]');
                                    if (input.length && input.attr('type') !== 'file') {
                                        if (input.length > 1)
                                            form.find('*[name="' + key + '"][type="radio"][value="' + value + '"], *[name^="' + key + '"][type="checkbox"][value="' + value + '"]').prop('checked', true).change();
                                        else if (input.attr('type') === 'checkbox') {
                                            if (value == '1')
                                                input.prop('checked', true).change();
                                            else if (value == '0')
                                                input.prop('checked', false).change();
                                        } else
                                            input.val(value).change();
                                    }
                                });
                                if (ckeditors.length) {
                                    $.each(ckeditors, function (k, elem) {
                                        var name = elem.attr('id') !== undefined ? elem.attr('id') : elem.attr('name');
                                        CKEDITOR.instances[name].setData(elem.val());
                                        CKEDITOR.instances[name].updateElement();
                                    });
                                }
                                form.closest('.modal').modal('show');
                            },
                            error: function () {
                                myAlert();
                            },
                            complete: function () {
                                btn.html(btnHtml);
                            }
                        });
                    } else if (id !== undefined) {
                        form.find('input[name="id"]').val(id);
                        form.closest('.modal').modal('show');
                    }
                });
            });
        });

        $('.slugme').livequery(function () {
            $(this).change(function () {
                var target = $($(this).data('target'));
                var tmp = $('<div>');
                var slug = $(this).val();
                tmp.text(slug);
                slug = tmp.text();
                var trimmed = $.trim(slug);
                slug = trimmed.replace(/\s/g, '-').replace(/-+/g, '-').replace(/^-|-$/g, '');
                slug = slug.toLowerCase();
                target.val(slug);
            });
        });

        $('.galleryTable').livequery(function () {
            $(this).mouseover(function () {
                $(this).find('.editbtns').stop().slideToggle();
                $(this).find('span:first').stop().slideToggle();
            });
            $(this).mouseout(function () {
                $(this).find('.editbtns').stop().slideToggle();
                $(this).find('span:first').stop().slideToggle();
            });
        });
    } else {
        $('.tooltips').tooltip();
    }
});
//

// seconds to time string with format hh:mm:ss
function toHHMMSS(sec) {
    var sec_num = parseInt(sec, 10); // don't forget the second param
    var hours = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    if (hours < 10) {
        hours = "0" + hours;
    }
    if (minutes < 10) {
        minutes = "0" + minutes;
    }
    if (seconds < 10) {
        seconds = "0" + seconds;
    }
    return hours + ':' + minutes + ':' + seconds;
}

function printElem(elem)
{
    var contents = $(elem).html(),
        printFrame = $('#printframe');
    printFrame.contents().find("#printContents").html(contents);
    setTimeout(function () {
        printFrame[0].contentWindow.print();
        setTimeout(function () {
            printFrame.contents().find("#printContents").html('');
        }, 700);
    }, 700);
}

/* Utility function to convert a canvas to a BLOB */
function dataURLToBlob(dataURL) {
    var BASE64_MARKER = ';base64,', parts, contentType, raw;
    if (dataURL.indexOf(BASE64_MARKER) === -1) {
        parts = dataURL.split(',');
        contentType = parts[0].split(':')[1];
        raw = parts[1];

        return new Blob([raw], {type: contentType});
    }

    parts = dataURL.split(BASE64_MARKER);
    contentType = parts[0].split(':')[1];
    raw = window.atob(parts[1]);

    var rawLength = raw.length,
        uInt8Array = new Uint8Array(rawLength);

    for (var i = 0; i < rawLength; ++i)
        uInt8Array[i] = raw.charCodeAt(i);

    return new Blob([uInt8Array], {type: contentType});
}
/* End Utility function to convert a canvas to a BLOB      */

/**
 * Number.prototype.format(n, x, s, c)
 *
 * @param integer n: length of decimal
 * @param integer x: length of whole part
 * @param mixed   s: sections delimiter
 * @param mixed   c: decimal delimiter
 */
Number.prototype.format = function(n, x, s, c) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
        num = this.toFixed(Math.max(0, ~~n));

    return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
};
// Examples :
// 12345678.9.format(2, 3, '.', ',');  => "12.345.678,90"
// 123456.789.format(4, 4, ' ', ':');  => "12 3456:7890"
// 12345678.9.format(0, 3, '-');       => "12-345-679"
