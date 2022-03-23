<?php session_start(); ?>
<?php
    if (!isset($_SESSION['bee_admin'])){
        header('Location:login.php');
    } 

    include('./permis.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>後台管理</title>
    <!-- Font Awesome -->
    <link rel="shortcut icon" href="../images/logo.png" type="img/x-icon">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <!-- Bootstrap core CSS -->

    <link href="https://fonts.googleapis.com/css?family=Montserrat:700|Raleway:200|Paytone+One" rel="stylesheet">

    <!-- <link href="../css/typo.css" rel="stylesheet"> -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/mdb.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.18.0/ui/trumbowyg.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.18.0/plugins/colors/ui/trumbowyg.colors.min.css" integrity="sha256-ypD0K+UpKz5IICqlKKqKZmk/pxZ5qGMRXEBN4QNEwi8=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.18.0/plugins/emoji/ui/trumbowyg.emoji.min.css" integrity="sha256-NUAw86dCQ0ShSlUB4yTFr740c9uHjdF23+pPzmHsd+s=" crossorigin="anonymous" />

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/spectrum-colorpicker2/dist/spectrum.min.css">
</head>

<style>

    body {
        font-size:  .9rem;
    }
    
    .collapsible a {
        font-size: 1rem !important;
    }

    .collapsible i {
        font-size: 1.2rem !important;
    }

    .rounded-circle {
        object-fit: cover;
    }

    table td {
        vertical-align: middle !important;
    }

    #ocount {
        position: absolute;
        left: 120px;
        margin-top: -28px;
    }

    .btn.btn-md {
        padding: .63rem 1.6rem;
        font-size: .7rem;
    }

    .btn.btn-sm {
        padding: .43rem 1.6rem;
    }

</style>

<body class="fixed-sn white-skin bg-skin-lp" style="background-color:transparent">

<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/popper.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/mdb.min.js"></script>
<script type="text/javascript" src="../js/jquery.twbsPagination.js"></script>
<script type="text/javascript" src="../js/fileinput.min.js"></script>
<script src="../js/clipboard.min.js" type="text/javascript"></script>
<script src="../js/zh-TW.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.18.0/trumbowyg.min.js" integrity="sha256-9fPnxiyJ+MnhUKSPthB3qEIkImjaWGEJpEOk2bsoXPE=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.18.0/plugins/base64/trumbowyg.base64.min.js" integrity="sha256-oSbMq1h4jLg+Mmtu9DxrooTyUuzfoAZNeJwc/1amrCU=" crossorigin="anonymous"></script>
<script src="../js/zh_tw.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.18.0/plugins/colors/trumbowyg.colors.min.js" integrity="sha256-3DiuDRovUwLrD1TJs3VElRTLQvh3F4qMU58Gfpsmpog=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.18.0/plugins/emoji/trumbowyg.emoji.min.js" integrity="sha256-yCnyfZblcEvAl3JW5YVfI9s88GLUMcWSizgRneuVIdQ=" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/spectrum-colorpicker2/dist/spectrum.min.js"></script>
    <!--Double navigation-->
    <header>
    <!-- Sidebar navigation -->
    <ul id="slide-out" class="side-nav fixed sn-bg-1 custom-scrollbar" style="overflow-x:hidden">
        <!-- Logo -->
        <li class="py-2 text-center">
            <a data-sname="welcome" class="navbar-brand flink" style="height:auto">
                <img alt="logo" src="<?=$system['logo_url']?>" style="width:150px">
            </a>
        </li>
        <hr>
        <!--/. Logo -->

        <!-- Side navigation links -->
        <li>
            <ul class="collapsible collapsible-accordion">

                <li <?php echo $auth_1 ?>><a data-sname="ident_settings" id="ident_settings" class="collapsible-header waves-effect arrow-r flink"><i class="fa fa-user fa-fw mr-2"></i>管理員設定</a></li>

                <li <?php echo $auth_6 ?>><a data-sname="system" class="collapsible-header waves-effect arrow-r flink"><i class="fas fa-cog fa-fw mr-2"></i>系統管理</a></li>

                <li <?php echo $auth_9 ?>><a data-sname="main_index" class="collapsible-header waves-effect arrow-r flink"><i class="fas fa-pager fa-fw mr-2"></i>首頁管理</a></li>

                <li <?php echo $auth_2 ?>><a data-sname="members" class="collapsible-header waves-effect arrow-r flink"><i class="fa fa-users fa-fw mr-2"></i>會員管理</a></li>


                <li <?php echo $auth_3 ?>><a data-sname="orders" class="collapsible-header waves-effect arrow-r flink"><i class="far fa-list-alt fa-fw mr-2"></i>訂單管理</a>
                    <span id="ocount" class="badge badge-pill blue cart_count"><?php echo $system['new_ocount'] ?></span>
                </li>

                <li <?php echo $auth_10 ?>><a data-sname="group" class="collapsible-header waves-effect arrow-r flink"><i class="fas fa-cubes fa-fw mr-2"></i>類別管理</a></li>

                <li <?php echo $auth_4 ?>><a data-sname="products" class="collapsible-header waves-effect arrow-r flink"><i class="fas fa-gift fa-fw mr-2"></i>商品管理</a></li>

                <li <?php echo $auth_8 ?>><a data-sname="options" class="collapsible-header waves-effect arrow-r flink"><i class="fas fa-list fa-fw mr-2"></i>規格管理</a></li>

                <li <?php echo $auth_11 ?>><a data-sname="single" class="collapsible-header waves-effect arrow-r flink"><i class="far fa-file-alt fa-fw mr-2"></i>單頁管理</a></li>

                <li <?php echo $auth_12 ?>><a data-sname="blog" class="collapsible-header waves-effect arrow-r flink"><i class="fab fa-wordpress-simple fa-fw mr-2"></i>文章管理</a></li>

                <li <?php echo $auth_5 ?>><a data-sname="sections" class="collapsible-header waves-effect arrow-r flink"><i class="fas fa-th-large fa-fw mr-2"></i>區塊管理</a></li>

                <li <?php echo $auth_7 ?>><a data-sname="sms" class="collapsible-header waves-effect arrow-r flink"><i class="fas fa-sms fa-fw mr-2"></i>簡訊發送</a></li>

                <li <?php echo $auth_13 ?>><a data-sname="language" class="collapsible-header waves-effect arrow-r flink"><i class="fas fa-globe fa-fw mr-2"></i>語系管理</a></li>

                <li><a data-sname="tutorial" class="collapsible-header waves-effect arrow-r flink"><i class="fas fa-film fa-fw mr-2"></i>系統教學</a></li>



            </ul>
        </li>
        <!--/. Side navigation links -->
        <div class="sidenav-bg mask-strong"></div>
    </ul>
    <!--/. Sidebar navigation -->
 <!-- Navbar -->
    <nav class="navbar fixed-top navbar-toggleable-md navbar-expand-lg scrolling-navbar double-nav">
        <!-- SideNav slide-out button -->
        <div class="float-left">
            <a style="margin-top:-2px" href="#" data-activates="slide-out" class="button-collapse mr-4"><i class="fa fa-bars stdcolor"></i></a>
        </div>
        <!-- Breadcrumb-->
        <div class="breadcrumb-dn mr-auto">
            <p id="section_label d-inline">
                Version 1.2.41 Build 3
            </p>
            
        </div>
        <ul class="nav navbar-nav nav-flex-icons ml-auto">

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="skin-color" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-user"></i> <span class="hidden-sm-down d-sm-inline-block"><?php echo $admin_name; ?></span>
                </a>
                <div class="dropdown-menu" id="skin_color" aria-labelledby="navbarDropdownMenuLink">
                    <a href="login.php" class="dropdown-item"><i class="fa fa-power-off mr-1"></i>登出</a>
                </div>
            </li>

        </ul>
    </nav>
    <!-- /.Navbar -->
    </header>
    <!--/.Double navigation-->
    
    <!--Main Layout-->
    <main>
        <div id="main_page" class="container-fluid">        

        </div>
    </main>
    <!--Main Layout-->

    <script>

        $(document).ready(function() {
          // SideNav Button Initialization
          $(".button-collapse").sideNav();
            // SideNav Scrollbar Initialization
            var sideNavScrollbar = document.querySelector('.custom-scrollbar');
            var ps = new PerfectScrollbar(sideNavScrollbar);
        });
        
        

        $('body').on('click', '.flink', function(){
            var sname = $(this).data('sname');
            //$('#section_label').text($(this).text());
            $('#main_page').load(sname+'.php', function(){
                current = $('#'+sname);
            });

        })


        // function get_page(icount, ele, url){
        //     $.post(url, {icount: icount}, function(data){
        //         data = $.trim(data);
        //         //console.log(data);
        //         if (data === '-1'){
        //             alert('登入逾時，請重新登入~!');
        //             window.location = 'login.php';
        //         }

        //         ele.html(data);
                                            
        //     });
        // }

        $('#main_page').load('welcome.php');

        setInterval(function(){ 
            $.post('get_ocount.php', function(data){
                var result = JSON.parse(data);
                if (result.err_msg === '-1') return;
                $('#ocount').text(result.ocount);
            });
        }, 10000);
       

    </script>
</body>
</html>