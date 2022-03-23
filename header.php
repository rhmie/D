<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="viewport" content="initial-scale=1, maximum-scale=1">
   <title>金鼎膳 - 滴雞精</title>
   <meta name="keywords" content="">
   <meta name="description" content="">
   <meta name="author" content="">
   <link rel="stylesheet" href="css/bootstrap.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/responsive.css">
   <link rel="icon" href="images/fevicon.png" type="image/gif" />
   <link rel="stylesheet" href="css/owl.carousel.min.css">
   <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
   <link rel="stylesheet" href="css/bootstrap-datepicker.min.css">
   <link rel="stylesheet" href="js/st/dist/sweetalert2.css">
</head>
<body class="main-layout">
   <div class="loader_bg">
      <div class="loader"><img src="images/loading.gif" alt="#"/></div>
   </div>
   <div class="full_bg">
      <header class="header-area">
         <div class="container">
            <div class="row d_flex">
               <div class=" col-md-3 col-sm-3">
                  <div class="logo">
                     <a href="index.php"><img src="images/logo.svg"></a>
                  </div>
               </div>
               <div class="col-md-9 col-sm-9">
                  <div class="navbar-area">
                     <nav class="site-navbar">
                        <ul>
                           <li>
                              <a <?php if(strpos($_SERVER['REQUEST_URI'],'index') !== false) echo "class='active'" ?> href="index.php">首頁
                              </a>
                           </li>
                           <li>
                              <a <?php if(strpos($_SERVER['REQUEST_URI'],'about') !== false) echo "class='active'" ?> href="about.php">關於我們
                              </a>
                           </li>
                          <!--  <li>
                              <a <?php if(strpos($_SERVER['REQUEST_URI'],'service') !== false) echo "class='active'" ?> href="service.php">產品
                              </a>
                           </li> -->
                           <li>
                              <a <?php if(strpos($_SERVER['REQUEST_URI'],'qa') !== false) echo "class='active'" ?> href="qa.php">Q&A
                              </a>
                           </li>
                           <li>
                              <a <?php if(strpos($_SERVER['REQUEST_URI'],'contact') !== false) echo "class='active'" ?> href="contact.php">聯絡我們
                              </a>
                           </li>
                           <li>
                              <button type="button" class="btn" style="background: transparent;" data-toggle="modal" data-target="#cart">(<span class="total-count"></span>)
                              <i class="fa fa-shopping-cart indexbnt style='font-size: 1.4rem;' aria-hidden='true'"></i></button>
                           </li>
                           <?php if(!isset($_SESSION['bee_member']) AND !isset($_SESSION['bee_name'])){ ?>
                           <li>
                              <a <?php if(strpos($_SERVER['REQUEST_URI'],'register') !== false) echo "class='active'" ?> href="register.php">註冊
                              </a>
                           </li>
                           <li>
                              <a <?php if(strpos($_SERVER['REQUEST_URI'],'login') !== false) echo "class='active'" ?> href="login.php">登入
                              </a>
                           </li>
                           <?php }else{ ?>
                           <li>
                              <a <?php if(strpos($_SERVER['REQUEST_URI'],'account') !== false) echo "class='active'" ?> href="account.php?name=<?=$_SESSION['bee_name']?>"><?=$_SESSION['bee_name']?>
                              </a>
                           </li>
                           
                           <li>
                              <input type="button" style="background-color: rgba(255,255,255,0.2)" class="btn indexbnt" id="Logout" value="登出">
                           </li>
                           <?php } ?>
                        </ul>
                        <button class="nav-toggler">
                        <span></span>
                        </button>
                     </nav>
                  </div>
               </div>
            </div>
         </div>
      </header>