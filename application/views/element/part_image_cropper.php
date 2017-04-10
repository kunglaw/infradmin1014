<?php
echo form_input(array("name" => "image", "class" => "thumbnail-filename", "type" => "hidden"));

if (! isset($cropper_id)) {
    $cropper_id = "crop-thumbnail-common";
}
?>
<div id="crop-thumbnail-edit-profile">

    <!-- Current thumbnail -->
    <div class="thumbnail-view">
        +
    </div>

    <!-- Crop and preview -->
    <div class="thumbnail-wrapper" style="display:none;"></div>

    <div class="row thumbnail-wrapper-footer" style="display: none;">
        <div class="avatar-btns" style="display: inline;">
            <button class="btn btn-primary" data-method="rotate" data-option="-90" type="button" title="Rotate -90 degrees">
                <i class="fa fa-undo"></i>
            </button>

            <button class="btn btn-primary" data-method="rotate" data-option="90" type="button" title="Rotate 90 degrees">
                <i class="fa fa-repeat"></i>
            </button>
        </div>

        <span class="pull-right">
            <button class="btn btn-primary third-button thumbnail-upload-button" type="button">Upload</button>
        </span>


    </div>

    <div class="image-progress-upload-background" style="display: none;">
        <div class="progress">
            <div id="progress-upload-thumbnail" class="progress-bar"
                 role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width:1%;">
            </div>
        </div>
    </div>

</div>