<style>
.sidebar-dark .nav-item.active {
    background-color: #414141;
}

.sidebar-dark .nav-item.active .nav-link {
    font-weight: initial;
}

.sidebar .nav-item .collapse .collapse-inner .collapse-item,
.sidebar .nav-item .collapsing .collapse-inner .collapse-item {
    /* padding: 0.5rem 0.2rem; */
}

.sidebar .nav-item .collapse .collapse-inner .collapse-item.active,
.sidebar .nav-item .collapsing .collapse-inner .collapse-item.active {
    color: #ffffff;
    font-weight: initial;
    background-color: #959595;
}
</style>
<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="./">
        <div class="sidebar-brand-icon">
            <img src="images/logo.png?version=<?php echo VERSION; ?>" alt="" style="width:50px; border-radius: 13px;">
        </div>
        <div class="sidebar-brand-text mx-3">CLINIC POMPOMS</div>
    </a>
    <hr class="sidebar-divider my-0">

    <?php 
        /***************************************** แดชบอร์ด ***********************************************/
        $menu = array("dashboard"); 
    ?>
    <li class="nav-item <?php if(in_array($PAGE, $menu)) echo 'active'; ?>">
        <a class="nav-link" href="./">
            <i class="fas fa-fw fa-chart-pie"></i>
            <span>แดชบอร์ด</span>
        </a>
    </li>






    <?php 
        /***************************************** ปฏิทินการนัดหมาย ***********************************************/
        $menu = array("calendar"); 
    ?>
    <!-- <li class="nav-item <?php if(in_array($PAGE, $menu)) echo 'active'; ?>">
        <a class="nav-link" href="./?page=calendar">
            <i class="fas fa-fw fa-calendar-days"></i>
            <span>ปฏิทินการนัดหมาย</span>
        </a>
    </li> -->



    <?php 
        /***************************************** รายชื่อผู้ป่วย ***********************************************/
        $menu = array("patient", "patient-data", "patient-add", "patient-edit"); 
    ?>
    <li class="nav-item <?php if(in_array($PAGE, $menu)) echo 'active'; ?>">
        <a class="nav-link" href="./?page=patient">
            <i class="fas fa-fw fa-users"></i>
            <span>รายชื่อผู้ป่วย</span>
        </a>
    </li>




    <?php 
        /***************************************** รายชื่อผู้รักษา ***********************************************/
        $menu = array("nurse", "nurse-add", "nurse-edit"); 
    ?>
    <li class="nav-item <?php if(in_array($PAGE, $menu)) echo 'active'; ?>">
        <a class="nav-link" href="./?page=nurse">
            <i class="fas fa-fw fa-user-nurse"></i>
            <span>รายชื่อผู้รักษา</span>
        </a>
    </li>



    <?php 
        /***************************************** รายงาน ***********************************************/
        $menu = array(
            "calendar",
            "appointment"
        );
    ?>
    <li class="nav-item <?php if(in_array($PAGE, $menu)) echo 'active'; ?>">
        <a class="nav-link <?php if(!in_array($PAGE, $menu)) echo 'collapsed'; ?>" href="" data-toggle="collapse"
            data-target="#collapsePages2">
            <i class="fas fa-fw fa-chart-line"></i>
            <span>รายงาน</span>
        </a>
        <div id="collapsePages2" class="collapse <?php if(in_array($PAGE, $menu)) echo 'show'; ?>"
            data-parent="#accordionSidebar">
            <div class="sidebar-submenu bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php if( in_array($PAGE, array("calendar")) ) echo 'active'; ?>"
                    href="./?page=calendar">ปฏิทินการนัดหมาย
                </a>
                <a class="collapse-item <?php if( in_array($PAGE, array("appointment")) ) echo 'active'; ?>"
                    href="./?page=appointment">รายการกำลังนัดทั้งหมด
                </a>
            </div>
        </div>
    </li>


</ul>