<?php
    include_once("php/autoload.php");

    if( $USER==null ) {
        LinkTo("./login.php");
    }

    $PAGE = isset( $_GET["page"] ) ? $_GET["page"] : 'home';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="images/logo.png?version=<?php echo VERSION; ?>">
    <title>SISO Clinic</title>
    <script>
    var PAGE = "<?php echo $PAGE; ?>";
    var USER = JSON.parse('<?php echo json_encode($USER); ?>');
    var GLOBAL = JSON.parse('<?php echo json_encode($GLOBAL); ?>');
    </script>
    <!-- jquery-->
    <script src="assets/jquery/jquery.min.js"></script>
    <!-- jquery-easing-->
    <script src="assets/jquery-easing/jquery.easing.min.js"></script>
    <!-- bootstrap -->
    <link href="assets/bootstrap-4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="assets/bootstrap-4.3.1/js/bootstrap.bundle.min.js"></script>
    <!-- sb-admin-2-->
    <link href="assets/sb-admin-2/css/sb-admin-2.css" rel="stylesheet">
    <script src="assets/sb-admin-2/js/sb-admin-2.js"></script>
    <!-- google font Sarabun -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">
    <!-- fontawesome -->
    <link rel="stylesheet" href="assets/fontawesome-free-6.1.1-web/css/all.css">
    <!-- moment -->
    <script src="assets/moment/moment.js"></script>
    <script src="assets/moment/locale/th.js"></script>
    <!-- inputmask -->
    <script src="assets/inputmask/jquery.inputmask.bundle.js"></script>
    <script src="assets/inputmask/inputmask/bindings/inputmask.binding.js"></script>
    <!-- sweetalert2 -->
    <script src='assets/sweetalert2/promise.min.js'></script>
    <script src='assets/sweetalert2/sweetalert.min.js'></script>
    <!-- fancybox -->
    <script type="text/javascript" src="assets/fancybox-2.1.7/source/jquery.fancybox.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/fancybox-2.1.7/source/jquery.fancybox.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="assets/fancybox-2.1.7/source/helpers/jquery.fancybox-buttons.css" />
    <script type="text/javascript" src="assets/fancybox-2.1.7/source/helpers/jquery.fancybox-buttons.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/fancybox-2.1.7/source/helpers/jquery.fancybox-thumbs.css" />
    <script type="text/javascript" src="assets/fancybox-2.1.7/source/helpers/jquery.fancybox-thumbs.js"></script>
    <script type="text/javascript" src="assets/fancybox-2.1.7/source/helpers/jquery.fancybox-media.js"></script>
    <!-- jBox -->
    <link href="assets/jBox-0.6.4/jBox.all.min.css" rel="stylesheet">
    <script src="assets/jBox-0.6.4/jBox.all.min.js"></script>
    <!-- PhotoSwipe -->
    <link rel="stylesheet" href="assets/PhotoSwipe/photoswipe.css">
    <link rel="stylesheet" href="assets/PhotoSwipe/default-skin/default-skin.css">
    <script src="assets/PhotoSwipe/photoswipe.min.js"></script>
    <script src="assets/PhotoSwipe/photoswipe-ui-default.min.js"></script>
    <!-- autocomplete -->
    <link href="assets/jquery-autocomplete/jquery.auto-complete.css" rel="stylesheet" />
    <script src="assets/jquery-autocomplete/jquery.auto-complete.min.js"></script>
    <!-- jquery.tablesorter -->
    <link rel="stylesheet" href="assets/jquery.tablesorter/jquery.tablesorter.css" />
    <script src="assets/jquery.tablesorter/jquery.tablesorter.min.js"></script>
    <!-- chartjs -->
    <script type="text/javascript" src="assets/chartjs/chart.js"></script>
    <script type="text/javascript" src="assets/chartjs/chart-utils.js"></script>
    <!-- index -->
    <link href="assets/index.css?version=<?php echo VERSION; ?>" rel="stylesheet">
    <script src="assets/index.js?version=<?php echo VERSION; ?>"></script>
    <!-- api -->
    <link href="api/api.css?version=<?php echo VERSION; ?>" rel="stylesheet">
    <script src="api/api.js?version=<?php echo VERSION; ?>"></script>
    <script>
    $(document).ready(function() {
        $('.logout').click(function(event) {
            ShowConfirm({
                html: "คุณต้องการออกจากระบบหรือไม่ ?",
                callback: function(status) {
                    if (status) {
                        LinkTo("./logout.php");
                    }
                }
            });
        });
    });
    </script>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include("master/side-menu.php"); ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include("master/navbar.php"); ?>
                <div class="container-fluid">
                    <?php
                        if( ChkPermit() ) {
                            echo '<link href="pages/'.$PAGE.'/view.css?version='.VERSION.'" rel="stylesheet">';
                            echo '<script src="pages/'.$PAGE.'/view.js?version='.VERSION.'"></script>';
                            include_once("pages/".$PAGE."/view.php");
                        } else {
                            echo '<link href="pages/pagenotfound/view.css?version='.VERSION.'" rel="stylesheet">';
                            echo '<script src="pages/pagenotfound/view.js?version='.VERSION.'"></script>';
                            include_once("pages/pagenotfound/view.php");
                        }
                        function chkPermit() {
                            global $STAFF, $PAGE;
                            $DENIED = array();
                            $PERMIT = array();
                            if( !file_exists("pages/".$PAGE."/permit.php") ) return false;
                            include_once("pages/".$PAGE."/permit.php");
                            foreach ($DENIED as $key => $value) {
                                if( isset($STAFF["permit"][$value]) && $STAFF["permit"][$value]=="Y" ) return false;
                            }
                            foreach ($PERMIT as $key => $value) {
                                if( $value=="all" ) return true;
                                if( isset($STAFF["permit"][$value]) && $STAFF["permit"][$value]=="Y" ) return true;
                            }
                            return false;
                        }
                    ?>
                </div>
            </div>
            <?php include("master/footer.php"); ?>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>
</body>

</html>