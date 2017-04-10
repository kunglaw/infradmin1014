(function (factory) {
         if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        // Node / CommonJS
        factory(require('jquery'));
    } else {
        factory(jQuery);
    }
})(function ($) {

    'use strict';

    var console = window.console || {
            log: function () {
            }
        };

    /**
     *
     * @param $element
     * @param modalSelector
     * @param widthRatio
     * @param heightRatio
     * @constructor
     */
    function CropAvatar($element, modalSelector, allowedExtensions, widthRatio, heightRatio) {
        this.$container = $element;
        var modalObject = $(modalSelector);

        if (widthRatio == null || heightRatio == null) {
            this.$aspectRatio = 0;
        } else if (widthRatio == 0 || heightRatio == 0) {
            this.$aspectRatio = 0;
        } else {
            this.$aspectRatio = widthRatio / heightRatio;
        }

        if (allowedExtensions == null) {
            this.$extension = "jpg|jpeg|png|gif";
        } else {
            this.$extension = allowedExtensions;
        }

        this.$avatarView = modalObject.find(".thumbnail-view");
        this.$avatar = this.$avatarView.find('img');
        this.$loading = this.$container.find(".loading");
        this.$avatarModal = modalObject;

        this.$modalHeader = this.$avatarModal.find("#add-content-modal-header");
        this.$errorContainer = this.$avatarModal.find("#add-content-error-container");
        this.$avatarImageInputHidden = this.$avatarModal.find(".thumbnail-filename");

        this.$progressContainer = this.$avatarModal.find(".image-progress-upload-background");
        this.$progressUpload = this.$progressContainer.find("#progress-upload-thumbnail");

        this.$avatarForm = $(".thumbnail-form");
        this.$avatarUpload = this.$avatarForm.find(".thumbnail-upload");
        this.$avatarSrc = this.$avatarForm.find(".thumbnail-src");
        this.$avatarData = this.$avatarForm.find(".thumbnail-data");
        this.$avatarInput = this.$avatarForm.find(".thumbnail-input");
        this.$avatarSave = this.$avatarForm.find(".thumbnail-save");

        this.$avatarBtns = this.$container.find('.avatar-btns');

        this.$avatarWrapper = this.$avatarModal.find(".thumbnail-wrapper");
        this.$avatarPreview = this.$avatarModal.find('.avatar-preview');

        this.$avatarWrapperFooter = this.$avatarModal.find(".thumbnail-wrapper-footer");

        this.filename = null;

        this.init();
    }

    CropAvatar.prototype = {
        constructor: CropAvatar,

        support: {
            fileList: !!$('<input type="file">').prop('files'),
            blobURLs: !!window.URL && URL.createObjectURL,
            formData: !!window.FormData
        },

        init: function () {
            this.support.datauri = this.support.fileList && this.support.blobURLs;

            if (!this.support.formData) {
                this.initIframe();
            }

            this.initTooltip();
            this.initModal();
            this.addListener();
        },

        addListener: function () {
            this.$avatarView.on('click', $.proxy(this.click, this));
            this.$avatarInput.on('change', $.proxy(this.change, this));
            this.$avatarForm.on('submit', $.proxy(this.submit, this));
            this.$avatarBtns.on('click', $.proxy(this.rotate, this));
        },

        initTooltip: function () {
            this.$avatarView.tooltip({
                placement: 'bottom'
            });
        },

        initModal: function () {
            //this.$avatarModal.modal({
            //    show: false
            //});
        },

        initPreview: function () {
            var url = this.$avatar.attr('src');

            //this.$avatarPreview.empty().html('<img src="' + url + '">');
        },

        initIframe: function () {
            var target = 'upload-iframe-' + (new Date()).getTime(),
                $iframe = $('<iframe>').attr({
                    name: target,
                    src: ''
                }),
                _this = this;

            // Ready ifrmae
            $iframe.one('load', function () {

                // respond response
                $iframe.on('load', function () {
                    var data;

                    try {
                        data = $(this).contents().find('body').text();
                    } catch (e) {
                        console.log(e.message);
                    }

                    if (data) {
                        try {
                            data = $.parseJSON(data);
                        } catch (e) {
                            console.log(e.message);
                        }

                        _this.submitDone(data);
                    } else {
                        _this.submitFail('Image upload failed!');
                    }

                    _this.submitEnd();

                });
            });

            this.$iframe = $iframe;
            this.$avatarForm.attr('target', target).after($iframe.hide());
        },

        click: function () {
            //this.$avatarModal.modal('show');
            this.initPreview();
        },

        change: function () {
            var files,
                file;

            if (this.support.datauri) {
                files = this.$avatarInput.prop('files');

                if (files.length > 0) {
                    file = files[0];

                    if (this.isImageFile(file)) {
                        if (this.url) {
                            URL.revokeObjectURL(this.url); // Revoke the old one
                        }

                        this.$avatarView.hide();
                        this.$avatarWrapper.show();
                        this.$avatarWrapperFooter.show();

                        this.url = URL.createObjectURL(file);
                        this.startCropper();

                    } else {

                        this.url = null;
                        this.uploaded = false;
                        this.$avatarInput.val("");

                        this.showErrorWrapper("Please upload image with correct type.");
                        this.cropDone();
                    }

                }
            } else {
                file = this.$avatarInput.val();

                if (this.isImageFile(file)) {
                    this.syncUpload();
                }
            }
        },

        submit: function () {

            console.log("data submitted");

            if (!this.$avatarSrc.val() && !this.$avatarInput.val()) {
                return false;
            }

            if (this.support.formData) {
                this.ajaxUpload();
                return false;
            }
        },

        rotate: function (e) {
            var data;

            if (this.active) {
                data = $(e.target).data();

                if (data.method) {
                    this.$img.cropper(data.method, data.option);
                }
            }
        },

        isImageFile: function (file) {

            if (file.type) {
                var pattern = new RegExp("^image\/("+ this.$extension +")$");
                //return /^image\/\w+$/.test(file.type);
                return pattern.test(file.type);
            } else {
                var pattern = new RegExp("\.("+ this.$extension +")$");
                return pattern.test(file);
            }
        },

        startCropper: function () {
            var _this = this;

            if (this.active) {
                this.$img.cropper('replace', this.url);
            } else {
                this.$img = $('<img src="' + this.url + '">');
                this.$avatarWrapper.empty().html(this.$img);

                this.$img.cropper({
                    aspectRatio: this.$aspectRatio, // change the aspect ratio to allow flexibility
                    //preview: this.$avatarPreview.selector,
                    strict: false,
                    crop: function (data) {

                        var json = [
                            '{"x":' + data.x,
                            '"y":' + data.y,
                            '"height":' + data.height,
                            '"width":' + data.width,
                            '"rotate":' + data.rotate + '}'
                        ].join();

                        _this.$avatarData.val(json);
                    },
                    maxWidth: 300,
                    maxHeight: 200
                });

                this.active = true;
            }
        },

        stopCropper: function () {
            if (this.active) {

                //this.$img.cropper('destroy');
                //this.$img.remove();
                this.active = false;
            }
        },

        ajaxUpload: function () {

            var url = this.$avatarForm.attr('action'),
                data = new FormData(this.$avatarForm[0]),
                _this = this;

            $.ajax(url, {
                type: 'post',
                data: data,
                dataType: 'json',
                processData: false,
                contentType: false,

                xhr: function () {
                    var xhr = new window.XMLHttpRequest();
                    //Upload progress
                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                            _this.$progressUpload.width(percentComplete + "%");
                        }
                    }, false);
                    return xhr;
                },

                beforeSend: function () {
                    _this.submitStart();
                },

                success: function (data) {

                    console.log("ajaxUpload success");
                    console.log(data);

                    if (data.message != null) {
                        _this.showErrorWrapper(data.message);
                    } else {
                        _this.clearError();
                    }

                    _this.submitDone(data);
                },

                error: function (XMLHttpRequest, textStatus, errorThrown) {

                    console.log(textStatus);
                    _this.submitFail(textStatus || errorThrown);
                },

                complete: function () {
                    _this.submitEnd();
                }
            });
        },

        syncUpload: function () {
            this.$avatarSave.click();
        },

        submitStart: function () {
            this.$avatarWrapperFooter.hide();
            this.$progressContainer.show();
            this.$loading.fadeIn();
        },

        submitDone: function (data) {

            if ($.isPlainObject(data) && data.state === 200) {
                if (data.result) {
                    this.url = data.result;
                    this.filename = data.filename;

                    if (this.support.datauri || this.uploaded) {
                        this.uploaded = false;
                        this.cropDone();
                    } else {
                        this.uploaded = true;
                        this.$avatarSrc.val(this.url);
                        this.startCropper();
                    }

                    this.$avatarInput.val('');
                } else if (data.message) {
                    this.alert(data.message);
                }
            } else if (data.state === 400) {
                this.url = null;
                this.uploaded = false;
                this.$avatarInput.val("");
                this.cropDone();
            } else {
                this.$avatarWrapperFooter.show();
                this.$progressContainer.hide();
                this.alert("Failed to response");
            }

        },

        submitFail: function (msg) {

            this.$avatarWrapperFooter.show();
            this.$progressContainer.hide();
            this.alert(msg);
        },

        submitEnd: function () {
            this.$loading.fadeOut();
        },

        cropDone: function () {
            this.$avatarForm.get(0).reset();
            this.$avatar.attr('src', this.url);
            this.$avatarImageInputHidden.val(this.filename);

            this.stopCropper();
            //this.$avatarModal.modal('hide');

            var time = new Date().getTime();

            this.$avatarView.find("img").prop("src", this.url);
            this.$avatarView.html('<img src="'+ this.url +'?'+ time +'">');

            this.$avatarWrapperFooter.hide();
            this.$avatarWrapper.hide();
            this.$progressContainer.hide();
            this.$avatarView.show();
        },

        alert: function (msg) {
            var $alert = [
                '<div class="alert alert-danger avatar-alert alert-dismissable">',
                '<button type="button" class="close" data-dismiss="alert">&times;</button>',
                msg,
                '</div>'
            ].join('');

            this.$avatarUpload.after($alert);
        },

        clearError: function() {
            // remove any error wrapper before showing any new error for image cropper.
            $(".error-wrapper").remove();
        },

        showErrorWrapper: function(message) {

            this.clearError();

            var openWrapper = '<div class="row error-wrapper"><div class="col-md-12">';
            var closeWrapper = '</div></div>';

            this.$avatarView.closest(".row").before(
                openWrapper + message + closeWrapper);
        }
    };

    $(function () {

        if ($("#crop-thumbnail-edit-profile").length > 0) {
            new CropAvatar($("#crop-thumbnail-edit-profile"), "#user-edit-own-form");
        }

        if ($("#crop-thumbnail-common").length > 0) {
            new CropAvatar($("#crop-thumbnail-common"), "#create-edit-form");
        }

    });

});
