<style>
#sidebarToggleTop:hover {
    background-color: #373840 !important;
}

#sidebarToggleTop:focus {
    box-shadow: none !important;
}
</style>
<nav class="navbar navbar-expand navbar-light bg-secondary topbar mb-4 static-top shadow">
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3 text-white">
        <i class="fa fa-bars"></i>
    </button>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-sm-inline text-white small">
                    <?php echo $USER['user_name']; ?>
                    <?php echo $USER['user_lname']; ?>
                </span>
                <img class="img-profile rounded-circle" src="../fileupload/staffs/<?php echo $USER["image"]; ?>"
                    alt="Profile" onerror="OnError(this, 'images/no-staff.png')">
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <!-- <a class="dropdown-item" href="./?page=profile">
                    <i class="fas fa-user fa-sm fa-fw mr-2"></i>
                    โปรไฟล์ของฉัน
                </a>
                <div class="dropdown-divider"></div> -->
                <a class="dropdown-item logout" href="Javascript:">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                    ออกจากระบบ
                </a>
            </div>
        </li>
    </ul>
</nav>