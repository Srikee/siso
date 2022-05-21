<?php
    include_once("php/autoload.php");
    $redirect = isset($_GET["rd"]) ? Decoder($_GET["rd"]) : "./";
    if( $USER!=null ) {
        LinkTo($redirect);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="images/logo.png?version=<?php echo VERSION; ?>">
    <title>เข้าสู่ระบบ</title>
    <!-- jquery-->
    <script src="assets/jquery/jquery.min.js"></script>
    <!-- bootstrap-->
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- sb-admin-2-->
    <link href="assets/sb-admin-2/css/sb-admin-2.css" rel="stylesheet">
    <script src="assets/sb-admin-2/js/sb-admin-2.js"></script>
    <!-- fontawesome -->
    <link rel="stylesheet" href="assets/fontawesome-free-6.1.1-web/css/all.css">
    <!-- moment -->
    <script src="assets/moment/moment.js"></script>
    <script src="assets/moment/locale/th.js"></script>
    <!-- sweetalert2 -->
    <script src='assets/sweetalert2/promise.min.js'></script>
    <script src='assets/sweetalert2/sweetalert.min.js'></script>
    <!-- index -->
    <link href="assets/index.css?version=<?php echo VERSION; ?>" rel="stylesheet">
    <script src="assets/index.js?version=<?php echo VERSION; ?>"></script>
    <!-- login -->
    <link rel="stylesheet" href="assets/login.css?version=<?php echo VERSION; ?>">
    <script src="assets/login.js?version=<?php echo VERSION; ?>"></script>
</head>

<body>
    <?php
        $username = "siso";
        $password = "1234";
        if( isset($_POST["btn-login"]) ) {
            login($redirect);
        }
        function login($redirect="./") {
            if( $redirect=="" ) $redirect = "./";
            global $DB, $username, $password;
            $username = @$_POST["username"];
            $password = @$_POST["password"];
            if( trim($username)=='' || trim($password)=='' ) {
                ShowAlert("", "ชื่อบัญชีผู้ใช้ หรือรหัสผ่านมีค่าว่าง", "error");
                return;
            }
            $sql = "SELECT * FROM user WHERE status='Y' AND username='".$username."' AND password='".$password."'";
            $obj = $DB->QueryObj($sql);
            if( sizeof($obj)==1 ) {
                $_SESSION["username"] = $username;
                $_SESSION["password"] = $password;
                LinkTo($redirect);
            } else {
                ShowAlert("", "คุณไม่ได้รับสิทธิ์ใช้งานระบบ", "error");
            }
        }
    ?>
    <form class="form-signin" autocomplete="off" method="post">
        <input type="hidden" name="json_ip">
        <input type="hidden" name="btn-login">
        <div class="text-center mb-4">
            <!-- <img class="mb-4" src="images/passport.png" alt="" width="300"> -->
            <img class="mb-4" src="images/logo.png?version=<?php echo VERSION; ?>" alt="" width="170"
                style="border-radius: 35px;">
            <h1 class="h3 mb-3 font-weight-normal">เข้าสู่ระบบ ชิงโชคคลีนิค</h1>
            <!-- <p class="text-info">
                สำหรับเจ้าหน้าที่ เข้าสู่ระบบด้วย PSU Passport
            </p> -->
        </div>
        <div class="form-group text-left">
            <label for="username">ชื่อบัญชีผู้ใช้</label>
            <input type="text" class="form-control form-control-lg" id="username" name="username"
                value="<?php echo $username; ?>" required autofocus>
        </div>
        <div class="form-group text-left">
            <label for="password">รหัสผ่าน</label>
            <input type="password" class="form-control form-control-lg" id="password" name="password"
                value="<?php echo $password; ?>" required>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">เข้าสู่ระบบ</button>
        <p class="mt-5 mb-3 text-muted text-center">Copyright &copy; 2022 SISO Clinic</p>
    </form>
</body>

</html>