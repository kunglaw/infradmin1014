</div>
<!-- /#wrapper -->

<?php if (
    NEED_IMAGE_TOOLS_GLOBAL ||
    (isset($need_image_tools) ? $need_image_tools : FALSE)
): ?>

    <script type="text/javascript">
        var baseURLWithoutAdmin = '';
    </script>

    <script type="text/javascript"
            src="<?php echo bower_url(); ?>cropper/dist/cropper.min.js"></script>
    <script type="text/javascript"
            src="<?php echo plugin_url(); ?>crop-avatar/js/main.js"></script>

    <?php
    echo form_open_multipart("misc/crop", array("class" => "thumbnail-form"));
    ?>
    <!-- Upload image and data -->
    <div class="thumbnail-upload">
        <input class="thumbnail-src" name="thumbnail_src" type="hidden">
        <input class="thumbnail-data" name="thumbnail_data" type="hidden">
        <input class="thumbnail-input" name="thumbnail_file" type="file" style="display: none;">
        <button class="thumbnail-save" type="submit" style="display:none;">Save</button>
    </div>
    <?php echo form_close(); ?>

    <script type="text/javascript">
        $(document).ready(function() {

            $("#crop-thumbnail-common .thumbnail-view").click(function(){
                $(".thumbnail-form .thumbnail-input").click();
            });

            $("#crop-thumbnail-common .thumbnail-upload-button").click(function(){
                $(".thumbnail-form .thumbnail-save").click();
            });

        });
    </script>

<?php endif; ?>


<!-- <script src="<?php //echo plugin_url() ."bootstrap3/"; ?>js/bootstrap.min.js"></script> -->

<!-- <script src="<?php //echo plugin_url() ."tags_input/"; ?>bootstrap-tagsinput-angular.min.js"></script> -->

<!-- Metis Menu Plugin JavaScript -->
<script src="<?php echo plugin_url() ."sb-admin-2/"; ?>js/plugins/metisMenu/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="<?php echo plugin_url() ."sb-admin-2/"; ?>js/sb-admin-2.js"></script>

<?php isset($extra_script) ? $this->load->view($extra_script) : "" ?>
</body>

</html>