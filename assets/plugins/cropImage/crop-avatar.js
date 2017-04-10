(function (factory) {
    if (typeof define === "function" && define.amd) {
        define(["jquery"], factory);
    } else {
        factory(jQuery);
    }
})(function ($) {

    "use strict";

    var console = window.console || {
            log: $.noop
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

        //console.log("extension: " + this.$extension);


        this.$thumbnailView = modalObject.find(".thumbnail-view");
        this.$loading = this.$container.find(".loading");
        this.$thumbnailModal = modalObject;

        this.$modalHeader = this.$thumbnailModal.find("#add-content-modal-header");
        this.$errorContainer = this.$thumbnailModal.find("#add-content-error-container");
        this.$thumbnail = this.$thumbnailModal.find("#thumbnail-filename");

        this.$progressContainer = this.$thumbnailModal.find(".image-progress-upload-background");
        this.$progressUpload = this.$progressContainer.find("#progress-upload-thumbnail");

        this.$thumbnailForm = $(".thumbnail-form");
        this.$thumbnailUpload = this.$thumbnailForm.find(".thumbnail-upload");
        this.$thumbnailSrc = this.$thumbnailForm.find(".thumbnail-src");
        this.$thumbnailData = this.$thumbnailForm.find(".thumbnail-data");
        this.$thumbnailInput = this.$thumbnailForm.find(".thumbnail-input");
        this.$thumbnailSave = this.$thumbnailForm.find(".thumbnail-save");

        this.$thumbnailWrapper = this.$thumbnailModal.find(".thumbnail-wrapper");
        this.$thumbnailWrapperFooter = this.$thumbnailModal.find(".thumbnail-wrapper-footer");



        this.init();
    }

    CropAvatar.prototype = {
        constructor: CropAvatar,

        support: {
            fileList: !!$("<input type=\"file\">").prop("files"),
            fileReader: !!window.FileReader,
            formData: !!window.FormData
        },

        init: function () {

            //console.log("init");
            this.support.datauri = this.support.fileList && this.support.fileReader;

            if (!this.support.formData) {
                this.initIframe();
            }

            this.initTooltip();
            this.addListener();



            //$(".cropper-container").css("left", 0);
            //$(".cropper-container").css("top", 0);
        },

        addListener: function () {

            //console.log("add listener");
            this.$thumbnailView.on("click", $.proxy(this.click, this));
            this.$thumbnailInput.on("change", $.proxy(this.change, this));
            this.$thumbnailForm.on("submit", $.proxy(this.submit, this));
        },

        initTooltip: function () {

            //console.log("init tooltip");
            this.$thumbnailView.tooltip({
                placement: "bottom"
            });
        },

        initIframe: function () {

            //console.log("init iframe");
            var iframeName = "thumbnail-iframe-" + Math.random().toString().replace(".", ""),
                $iframe = $('<iframe name="' + iframeName + '" style="display:none;"></iframe>'),
                firstLoad = true,
                _this = this;

            this.$iframe = $iframe;
            this.$thumbnailForm.attr("target", iframeName).after($iframe);

            this.$iframe.on("load", function () {
                var data,
                    win,
                    doc;

                try {
                    win = this.contentWindow;
                    doc = this.contentDocument;

                    doc = doc ? doc : win.document;
                    data = doc ? doc.body.innerText : null;
                } catch (e) {
                }

                if (data) {
                    _this.submitDone(data);
                } else {
                    if (firstLoad) {
                        firstLoad = false;
                    } else {
                        _this.submitFail("Image upload failed!");
                    }
                }

                _this.submitEnd();
            });
        },

        change: function () {

            this.clearError();

            //console.log("change");
            var files,
                file;

            if (this.support.datauri) {
                files = this.$thumbnailInput.prop("files");

                if (files.length > 0) {
                    file = files[0];

                    if (this.isImageFile(file)) {

                        this.$thumbnailView.hide();
                        this.$thumbnailWrapper.show();
                        this.$thumbnailWrapperFooter.show();
                        this.$thumbnailView.css("line-height", "0px");

                        this.read(file);

                    } else {
                        //console.log(">> this is not image file");

                        this.url = null;
                        this.uploaded = false;
                        this.$thumbnailInput.val("");

                        this.showErrorWrapper("Please upload image with correct type.");

                        this.cropDone();
                    }
                }
            } else {
                file = this.$thumbnailInput.val();

                if (this.isImageFile(file)) {
                    this.syncUpload();
                }
            }
        },

        submit: function () {

            //console.log("submit");
            if (!this.$thumbnailSrc.val() && !this.$thumbnailInput.val()) {
                return false;
            }

            if (this.support.formData) {
                this.ajaxUpload();
                return false;
            }
        },

        isImageFile: function (file) {

            //console.log("is image file");
            if (file.type) {
                var pattern = new RegExp("^image\/("+ this.$extension +")$");
                //return /^image\/\w+$/.test(file.type);
                return pattern.test(file.type);
            } else {
                var pattern = new RegExp("\.("+ this.$extension +")$");
                return pattern.test(file);
            }

            //var pattern = new RegExp("\.("+ this.$extension +")$");
            //return pattern.test(file);
        },

        read: function (file) {

            //console.log("read");
            var _this = this,
                fileReader = new FileReader();

            fileReader.readAsDataURL(file);

            fileReader.onload = function () {
                _this.url = this.result
                _this.startCropper();
            };
        },

        startCropper: function () {

            //console.log("start cropper");
            var _this = this;

            if (this.active) {
                this.$img.cropper("replace", this.url);
            } else {
                this.$img = $('<img src="' + this.url + '">');
                this.$thumbnailWrapper.empty().html(this.$img);
                this.$img.cropper({
                    aspectRatio: this.$aspectRatio,
                    done: function (data) {
                        var json = [
                            '{"x":' + data.x,
                            '"y":' + data.y,
                            '"height":' + data.height,
                            '"width":' + data.width + "}"
                        ].join();

                        _this.$thumbnailData.val(json);
                    }
                });

                this.active = true;
            }
        },

        stopCropper: function () {

            //console.log("stop cropper");
            if (this.active) {
                //console.log(">> cropper is active");
                this.$img.cropper("destroy");
                this.$img.remove();
                this.active = false;
            } else {
                //console.log(this.$img);
                //console.log(">> cropper is not active");
            }
        },

        ajaxUpload: function () {

            //console.log("ajax upload");
            var url = this.$thumbnailForm.attr("action"),
                data = new FormData(this.$thumbnailForm[0]),
                _this = this;

            $.ajax(url, {
                type: "post",
                data: data,
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

                    var parsedData = JSON.parse(data);
                    //console.log(parsedData);

                    if (parsedData.message != null) {

                        _this.showErrorWrapper(parsedData.message);
                    } else {
                        _this.clearError();
                    }

                    _this.submitDone(data);
                },

                error: function (XMLHttpRequest, textStatus, errorThrown) {

                    ////console.log(XMLHttpRequest);
                    ////console.log(textStatus);
                    ////console.log(errorThrown);
                    _this.submitFail(textStatus || errorThrown);
                },

                //error: function (data) {
                //    //console.log(data);
                //},

                complete: function () {
                    _this.submitEnd();
                }
            });
        },

        syncUpload: function () {

            //console.log("sync upload");
            this.$thumbnailSave.click();
        },

        submitStart: function () {

            //console.log("submit start");
            this.$thumbnailWrapperFooter.hide();
            this.$progressContainer.show();
        },

        submitDone: function (data) {

            //console.log("submit done");

            try {
                data = $.parseJSON(data);
            } catch (e) {
            }

            // show progress bar after upload is done.
            if (data) {
                if (data.state === 200) {
                    this.$progressUpload.width("100%");
                    if (data.result) {
                        this.url = data.result;
                        this.filename = data.filename;

                        if (this.support.datauri || this.uploaded) {
                            this.uploaded = false;
                            this.cropDone();
                        } else {
                            this.uploaded = true;
                            this.$thumbnailSrc.val(this.url);
                            this.startCropper();
                        }

                        this.$thumbnailInput.val("");
                    } else if (data.message) {
                        this.alert(data.message);
                    }
                } else if (data.state === 400) {
                    this.url = null;
                    this.uploaded = false;
                    this.$thumbnailInput.val("");
                    this.cropDone();
                } else {
                    this.$thumbnailWrapperFooter.show();
                    this.$progressContainer.hide();
                    this.alert("Failed to response");
                }

            } else {
                this.$thumbnailWrapperFooter.show();
                this.$progressContainer.hide();
                this.alert("Failed to response");
            }
        },

        submitFail: function (msg) {

            //console.log("submit fail");

            this.$thumbnailWrapperFooter.show();
            this.$progressContainer.hide();
            this.alert(msg);
        },

        submitEnd: function () {

            //console.log("submit end");
            this.$loading.fadeOut();
        },

        cropDone: function () {

            //console.log("crop done");

            this.$thumbnailSrc.val("");
            this.$thumbnailData.val("");

            if (this.url != null) {
                var fullURL = baseURLWithoutAdmin + this.url;
                this.$thumbnailView.html("<img src ='" + fullURL + "' />");
                this.$thumbnail.val(this.filename);
            } else {
                this.$thumbnailView.html("+");
                this.$thumbnailView.css("line-height", "240px");
            }

            this.stopCropper();
            this.$thumbnailWrapperFooter.hide();
            this.$thumbnailWrapper.hide();
            this.$progressContainer.hide();
            this.$thumbnailView.show();
        },

        alert: function (msg) {
            //console.log("alert");
            var $alert = [
                '<div class="alert alert-danger avatar-alert">',
                '<div class="sub-alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>',
                msg,
                '</div></div>'
            ].join("");

            this.$errorContainer.prepend($alert);
        },

        clearError: function() {
            // remove any error wrapper before showing any new error for image cropper.
            $(".error-wrapper").remove();
        },

        showErrorWrapper: function(message) {

            this.clearError();

            var openWrapper = '<div class="row error-wrapper"><div class="col-md-12">';
            var closeWrapper = '</div></div>';

            this.$thumbnailView.closest(".row").before(
                openWrapper + message + closeWrapper);
        }

    };

    $(function () {

        if ($("#crop-thumbnail-common").length > 0) {
            var cropTool = new CropAvatar($("#crop-thumbnail-common"), "#create-edit-form");
        }

        if ($("#crop-thumbnail-home").length > 0) {
            var cropTool = new CropAvatar($("#crop-thumbnail-home"), "#create-edit-form", "jpg|jpeg", 3, 2);
        }

        if ($("#crop-thumbnail-photo").length > 0) {
            var cropTool = new CropAvatar($("#crop-thumbnail-photo"), "#create-edit-form", "jpg|jpeg");
        }
    });
});
