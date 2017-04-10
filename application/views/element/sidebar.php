<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">

            <?php

            $class_list = array();
            $page_list = $this->session->userdata("page_list");
            $total_page = $this->session->userdata("total_page");

            for ($i = 1; $i <= $total_page; $i++) {
                $class_list[$i] = "";
            }

            $sidebar_flag = $this->session->userdata("sidebar_flag");
            if ($sidebar_flag) {
                $class_list[$sidebar_flag] = "active";
            }

            foreach ($this->session->userdata("page_list") as $page):
            ?>
                <li>
                    <a href="<?php echo base_url() . $page["route"]; ?>"
                       class="<?php echo @$class_list[$page["id"]]; ?>">

                        <b><?php echo $page["name"]; ?></b>
                    </a>
                </li>

            <?php endforeach; ?>

        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->