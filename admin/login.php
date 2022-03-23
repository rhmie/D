<?php session_start(); ?>
<?php
    $_SESSION['bee_admin'] = NULL;
    $_SESSION['bee_admin_name'] = NULL;
?>

<!DOCTYPE html>
<html lang="en" class="full-height">

<head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>管理員登入</title>

    <!-- Font Awesome -->
    <link rel="shortcut icon" href="../images/logo.ico" type="img/x-icon">

    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/mdb.min.css" rel="stylesheet">

   <style>
        
        .intro-2 {
            background: url("../images/main.webp")no-repeat center center;
            background-size: cover;
            height: 100vh;
        }
        .top-nav-collapse {
            background-color: #3f51b5 !important; 
        }
        .navbar:not(.top-nav-collapse) {
            background: transparent !important;
        }
        @media (max-width: 768px) {
            .navbar:not(.top-nav-collapse) {
                background: #3f51b5 !important;
            } 
        }
 
        .card {
            background-color: rgba(154, 154, 154, 0.43);
            backdrop-filter: blur(10px);
        }
        
         .md-form .prefix {
            font-size: 1.5rem;
            margin-top: 1rem;
        }
        .md-form label {
            color: #ffffff;
        }
        h6 {
            line-height: 1.7;
        }
        @media (max-width: 740px) {
            .full-height,
            .full-height body,
            .full-height header,
            .full-height header .view {
                height: 1040px; 
            } 
        }

        @-webkit-keyframes autofill {
            to {
                color: #fff;
                background: transparent;
            }
        }

        input:-webkit-autofill {
            -webkit-animation-name: autofill;
            -webkit-animation-fill-mode: both;
        }
                
    </style>
</head>

<body>

    <!--Main Navigation-->
    <header>

        <!--Intro Section-->
        <section class="view intro-2 hm-gradient">
            <div class="full-bg-img">
                <div class="container m-auto">

                        <div class="row w-100 mx-auto pt-5 mt-5" style="max-width:600px">
                            
                            <div class="col-12">
                                <!--Form-->
                                <div class="card wow fadeInRight" data-wow-delay="0.3s">
                                    <div class="card-body">
                                        <form id="loginform" method="POST" action="admin_login.php">
                                        <!--Header-->
                                        <div class="text-center">
                                            <h4 class="white-text">管理員登入</h4>
                                            <hr class="hr-light">
                                        </div>

                                        <!--Body-->
                                        <div class="md-form px-3 px-lg-5">
                                            <i class="fa fa-user prefix white-text"></i>
                                            <input type="text" id="account" name="account" minlength="2" maxlength="12" class="form-control text-white" required>
                                        </div>

                                        <div class="md-form px-3 px-lg-5">
                                            <i class="fa fa-lock prefix white-text active"></i>
                                            <input type="password" id="password" name="password" minlength="6" maxlength="12" class="form-control text-white">
                                        </div>

                                        <div class="col-12 flex-center">
                                              <img id="captcha" class="img-fluid mx-auto" src="../securimage/securimage_show.php" alt="CAPTCHA Image" />
                                        </div>

                                        <div class="col-12 flex-center mt-3">

                                            <div class="input-group w-75">
                                              <div class="input-group-prepend">
                                                <label class="input-group-text"><i class="fas fa-shield-alt fa-fw"></i></label>
                                              </div>
                                                <input type="text" minlength="6" size="10" name="captcha_code" class="form-control" placeholder="圖形驗證碼" required>

                                              <div class="input-group-append">
                                                <a class="input-group-text" href="#" onclick="document.getElementById('captcha').src = '../securimage/securimage_show.php?' + Math.random(); return false"><i class="fas fa-sync-alt fa-fw"></i></a>
                                              </div>

                                            </div>
   
                                        </div>

                                        <div class="text-center mt-2">
                                            <button type="submit" id="login-btn" class="btn btn-indigo">登入</button>
                                             <hr class="hr-light mb-3 mt-4">
                                        </div>
                                    </form>
                                    </div>
                                </div>
                                <!--/.Form-->
                            </div>
                        </div>

                </div>
            </div>
        </section>
    
    </header>
    <!--Main Navigation-->



    <!-- SCRIPTS -->
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/mdb.min.js"></script>
<!--     <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer> -->
    </script>
<!--     <script>
        // new WOW().init();

        var onloadCallback = function() {
            widgetId = grecaptcha.render('recapt_box', {
                'sitekey': '6LfjUA8UAAAAAHWMG2QGe4wO9-hcBFkbvmyPbbki',
                'callback': loginCallback,
                'theme': 'light'
            });
        };

        var loginCallback = function(response) {
            $('#login-btn').prop('disabled', false);
        };
    </script> -->

</body>

</html>