<?php
/**
 * Created by PhpStorm.
 * User: pulung
 * Date: 30/10/14
 * Time: 10:37
 */
?>

<div class="row">
    <div class="col-md-12" id="notification-area">

        <?php if ($type != "" && $message != ""): ?>
        <div class="alert alert-<?php echo $type; ?> alert-dismissible">
            <div class="sub-alert-<?php echo $type; ?>">
                <?php echo $message; ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>