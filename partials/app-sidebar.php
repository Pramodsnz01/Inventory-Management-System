<?php
   $user = $_SESSION['user'];

?>



<div class="dashboard_sidebar" id="dashboard_sidebar">
    <h3 class="dashboard_logo" id="dashboard_logo">IMS</h3>
    <div class="dashboardSidebar_user">
        <img src="profile.png" alt="User image." id="userImage">
        <span><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></span>
    </div>
    <div class="dashboardSidebar_menus">
        <ul class="dashboardMenu_lists">
            <!-- class="menuActive" -->
            <li class="liMainMenu">
                <a href="./dashboard.php"><i class="fa fa-dashboard menuIcons"></i><span class="menuText">
                        Dashboard</span></a>
            </li>
            <li class="liMainMenu">
                <a href="javascript:void(0);" class="showHideSubMenu">
                    <i class="fa fa-tag menuIcons showHideSubMenu"></i>
                    <span class="menuText showHideSubMenu"> Product</span>
                    <i class="fa fa-angle-left menuIcons leftAngleIcon showHideSubMenu"></i>
                </a>
                <ul class="subMenus" id="user">
                    <li><a class="subMenuLink" href="./product-view.php"><i class="fa fa-circle-o"></i> View Product</a></li>
                    <li><a class="subMenuLink" href="./product-add.php"><i class="fa fa-circle-o"></i> Add Product</a></li>
                    <li><a class="subMenuLink" href="./product-order.php"><i class="fa fa-circle-o"></i> Order Product</a></li>
                </ul>
            </li>
            <li class="liMainMenu ">
                <a href="javascript:void(0);" class="showHideSubMenu">
                    <i class="fa fa-truck menuIcons showHideSubMenu"></i>
                    <span class="menuText showHideSubMenu"> Supplier</span>
                    <i class="fa fa-angle-left menuIcons leftAngleIcon showHideSubMenu"></i>
                </a>
                <ul class="subMenus" id="user">
                    <li><a class="subMenuLink" href="./supplier-view.php"><i class="fa fa-circle-o"></i> View Supplier</a></li>
                    <li><a class="subMenuLink" href="./supplier-add.php"><i class="fa fa-circle-o"></i> Add Supplier</a></li>
                </ul>
            </li>
            <li class="liMainMenu showHideSubMenu">
                <a href="javascript:void(0);" class="showHideSubMenu">
                    <i class="fa fa-user-plus menuIcons showHideSubMenu"></i>
                    <span class="menuText showHideSubMenu"> User</span>
                    <i class="fa fa-angle-left menuIcons leftAngleIcon showHideSubMenu"></i>
                </a>
                <ul class="subMenus" id="user">
                    <li><a class="subMenuLink" href="./users-view.php"><i class="fa fa-circle-o"></i> View User</a></li>
                    <li><a class="subMenuLink" href="./users-add.php"><i class="fa fa-circle-o"></i> Add User</a></li>
                </ul>
            </li>

        </ul>
    </div>
</div>