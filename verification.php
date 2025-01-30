<?php
require_once('config.php');
session_start();
if (!isset($_SESSION['user_email'])) {
    header('location:login.php');
}

$stm = $connection->prepare("SELECT * FROM users WHERE id =? AND email = ? AND mobile = ?");
$stm->execute(array($_SESSION['user_id'], $_SESSION['user_email'], $_SESSION['user_mobile']));
$user_data = $stm->fetch(PDO::FETCH_ASSOC);

$verify_code = $connection->prepare("SELECT email_code FROM users WHERE email=?");
$verify_code->execute(array($_SESSION['user_email']));
$user_email_code = $verify_code->fetch(PDO::FETCH_ASSOC);

// if (isset($_POST['mobile_verify_btn'])) {
//     $mobile_code = $_POST['mobile_code'];

//     if(empty($mobile_code)){
//         $error = 'Verification code must not be empty';
//     } else{

//     }

//     // if ($mobile_code === $user_data['mobile_code']) {
//     //     $success = 'Verified Successfully';

//     //     // $mobile_status = 1;
//     //     // $stm = $connection->prepare("UPDATE user SET mobile_status = $mobile_status  WHERE id=?");
//     //     // $stm->execute(array())
//     // } else {
//     //     $error = 'Verification Failed';
//     // }
// }
if (isset($_POST['email_verify_btn'])) {
    $email_code = $_POST['email_code'];

    if (empty($email_code)) {
        $error = "Email verification must not be empty";
    } elseif ($user_email_code['email_code'] != $email_code) {
        $error = "Email verification code is wrong";
    }
}



?>

<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Our Store - User Verification</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="h-100">

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">
                                <a class="text-center" href="index.php">
                                    <h2>User Verification</h2>
                                </a>
                                <?php if (isset($error)) : ?>
                                    <div class="alert alert-danger">
                                        <?php echo $error; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (isset($success)) : ?>
                                    <div class="alert alert-success">
                                        <?php echo $success; ?>
                                    </div>
                                <?php endif; ?>
                                <form method="POST" action="" class="mt-5 mb-5 login-input">
                                    <div class="form-group">
                                        <?php if (!isset($_POST['email_verify_btn'])): ?>
                                            <div class="alert alert-success">
                                                Check Your Email: <?php echo $_SESSION['user_email']; ?>
                                            </div>
                                        <?php endif; ?>
                                        <input type="text" name="mobile_code" class="form-control" placeholder="Mobile Code">
                                        <input type="submit" class="btn login-form__btn submit w-100" name="mobile_verify_btn" value="Mobile Verification">
                                    </div>
                                </form>

                                <form method="POST" action="" class="mt-5 mb-5 login-input">
                                    <div class="form-group">

                                        <?php if (!isset($_POST['email_verify_btn'])): ?>
                                            <div class="alert alert-success">
                                                Check Your Email: <?php echo $_SESSION['user_mobile']; ?>
                                            </div>
                                        <?php endif; ?>
                                        <input type="text" name="email_code" class="form-control" placeholder="Email Code">
                                        <input type="submit" class="btn login-form__btn submit w-100" name="email_verify_btn" value="Email Verification">
                                    </div>
                                </form>
                                <p class="mt-5 login-form__footer">Dont have account? <a href="registration.php" class="text-primary">Registration</a> now</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>
</body>

</html>