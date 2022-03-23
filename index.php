<?php include('./include.php');?>
<?php 
$product = $db->get('products');
$_SESSION['product_item'] = array();
?>
<!DOCTYPE html>
<html lang="en">
   <?php include('header.php')?>
         <!-- end header inner -->
         <!-- top -->
         <div class="slider_main">
            <!-- carousel code -->
            <div id="banner1" class="carousel slide">
               <ol class="carousel-indicators">
                  <li data-target="#banner1" data-slide-to="0" class="active"></li>
                  <li data-target="#banner1" data-slide-to="1"></li>
                  <li data-target="#banner1" data-slide-to="2"></li>
               </ol>
               <div class="carousel-inner">
                  <!-- first slide -->
                  <div class="carousel-item active">
                     <div class="container">
                        <div class="carousel-caption relative">
                           <div class="row d_flex">
                              <div class="col-md-5">
                                 <div class="creative">
                                    <h1>滴雞精</h1>
                                    <p>我們的雞隻皆飼養85天後，開始餵食酒糟、玉米、牧草至180天才能送屠宰場屠殺，洗淨、切塊才放入專業鍋爐(鍋爐完全密封，絕無任何一滴水)，提煉15小時，再將油過濾，絕望任何添加物，經過層層把關才製造出最優質最濃醇的滴雞精。</p>
                                 </div>
                              </div>
                              <div class="col-md-7">
                                 <div class="row mar_right">
                                    <div class="col-md-6">
                                       <div class="agency">
                                          <figure><img class="index_img"src="images/S__65060914.jpg" alt="#"/></figure>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="agency">
                                          <figure><img class="index_img"src="images/S__65060916.jpg" alt="#"/></figure>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- second slide -->
               <!--    <div class="carousel-item">
                     <div class="container">
                        <div class="carousel-caption relative">
                                                      <div class="row d_flex">
                              <div class="col-md-5">
                                 <div class="creative">
                                    <h1>滴雞精</h1>
                                    <p>金鼎膳一般市售雞，我們為了與市場有所間格，使用大型鬥雞。於好山好水的南投以放牧方式飼養，儘管成本較高，我們也有責人提供消費者最優良的品質。</p>
                                 </div>
                              </div>
                              <div class="col-md-7">
                                 <div class="row mar_right">
                                    <div class="col-md-6">
                                       <div class="agency">
                                          <figure><img class="index_img"src="images/S__65060914.jpg" alt="#"/></figure>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="agency">
                                          <figure><img class="index_img"src="images/S__65060916.jpg" alt="#"/></figure>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                   third slide
                  <div class="carousel-item">
                     <div class="container">
                        <div class="carousel-caption relative">
                                                      <div class="row d_flex">
                              <div class="col-md-5">
                                 <div class="creative">
                                    <h1>滴雞精</h1>
                                    <p>金鼎膳一般市售雞，我們為了與市場有所間格，使用大型鬥雞。於好山好水的南投以放牧方式飼養，儘管成本較高，我們也有責人提供消費者最優良的品質。</p>
                                 </div>
                              </div>
                              <div class="col-md-7">
                                 <div class="row mar_right">
                                    <div class="col-md-6">
                                       <div class="agency">
                                          <figure><img class="index_img"src="images/S__65060914.jpg" alt="#"/></figure>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="agency">
                                          <figure><img class="index_img"src="images/S__65060916.jpg" alt="#"/></figure>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div> -->
               </div>
               <!-- controls -->
               <a class="carousel-control-prev" href="#banner1" role="button" data-slide="prev">
               <i class="fa fa-angle-left" aria-hidden="true"></i>
               <span class="sr-only">Previous</span>
               </a>
               <a class="carousel-control-next" href="#banner1" role="button" data-slide="next">
               <i class="fa fa-angle-right" aria-hidden="true"></i>
               <span class="sr-only">Next</span>
               </a>
            </div>
         </div>
      </div>
      <!-- end banner -->
      
      <!-- services -->
      <div class="services">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage text_align_center ">
                     <h2>滴雞精 - 達人推薦</h2>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4">
                  <div id="ho_shad" class="services_box text_align_left">
                     <h3>Ayurveda Spa</h3>
                     <figure><img src="images/service1.jpg" alt="#"/></figure>
                     <p>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip</p>
                     <a class="read_more" href="service.html">Read More</a>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="ho_shad" class="services_box text_align_left">
                     <h3>Massage Spa</h3>
                     <figure><img src="images/service2.jpg" alt="#"/></figure>
                     <p>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip</p>
                     <a class="read_more" href="service.html">Read More</a>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="ho_shad" class="services_box text_align_left">
                     <h3>Luxury Spa</h3>
                     <figure><img src="images/service3.jpg" alt="#"/></figure>
                     <p>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip</p>
                     <a class="read_more" href="service.html">Read More</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end services -->
      <!-- priceing -->
      <div class="priceing">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage text_align_center">
                     <h2>產品價格</h2>
                     <p>本司產品皆通過國家SGSS認證 請安心食用</p>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-10 offset-md-1">
                  <div class="row">
                     <?php foreach($product as $row){ ?>
                     <div class="col-md-6">
                        <div class="our_priceing text_align_center">
                           <div class="our_pri">
                              <h4 class="card-title"><?=$row['pname']?></h4>
                              <figure><img src="<?=$row['images']?>" alt="<?=$row['pname']?>"/></figure>
                              <p class="card-text">$<strong><?=$row['price']?></strong></p>
                              <a href="#" data-id="<?=$row['id']?>" data-name="<?=$row['pname']?>" data-price="<?=$row['price']?>" class="add-to-cart btn btn-primary">添加購物車</a>
                           </div>
                        </div>
                     </div>
                     <?php }?>
                    <!--  <div class="col-md-6">
                        <div class="our_priceing text_align_center">
                           <div class="our_pri">
                              <h3>Special Price</h3>
                              <span>$<strong>100</strong></span>
                              <p>sed do eiusmod <br>tempor incididunt ut <br>labore et dolore<br> magna aliqua. Utenim <br> ad minim aliquip</p>
                           </div>
                           <a class="read_more" href="javascript:void(0)">Read More</a>
                        </div>
                     </div> -->
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end priceing -->
      <!-- blog -->
<!--       <div class="blog">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage text_align_center ">
                     <h2>Latest Blog</h2>
                     <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu</p>
                  </div>
               </div>
            </div>
            <div class="row d_flex">
               <div class=" col-md-4">
                  <div class="latest">
                     <figure><img src="images/blog1.jpg" alt="#"/></figure>
                     <span>16 March</span>
                     <div class="nostrud">
                        <h3>Quis Nostrud </h3>
                        <p>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip</p>
                        <a class="read_more" href="blog.html">Read More</a>
                     </div>
                  </div>
               </div>
               <div class=" col-md-4">
                  <div class="latest">
                     <figure><img src="images/blog2.jpg" alt="#"/></figure>
                     <span class="yellow">17 March</span>
                     <div class="nostrud">
                        <h3>Veniam, Quis </h3>
                        <p>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip</p>
                        <a class="read_more" href="blog.html">Read More</a>
                     </div>
                  </div>
               </div>
               <div class=" col-md-4">
                  <div class="latest">
                     <figure><img src="images/blog3.jpg" alt="#"/></figure>
                     <span>18 March</span>
                     <div class="nostrud">
                        <h3>Tempor incididunt </h3>
                        <p>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip</p>
                        <a class="read_more" href="blog.html">Read More</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div> -->
      <!-- end blog -->
      <!-- about -->
      <div class="about">
         <div class="container_width">
            <div class="row d_flex grig">
               <div class="col-md-6">
                  <div class="about_img">
                     <figure><img src="images/S__65060914.jpg" alt="#"/>
                     </figure>
                  </div>
               </div>
               <div class="col-md-6 order">
                  <div class="titlepage text_align_left">
                     <h2>鬥雞放牧場所</h2>
                     <p>我們的雞隻皆飼養85天，開始放牧，給他們好山好水的環境，喝天然山泉水，餵食天然牧草、玉米、小麥至180天才能送進屠宰場屠殺、洗淨切塊，放入專業鍋爐(鍋爐完全密封絕無任何一滴水)，提煉15小時候再將油過濾絕無任何添加物。</p>
                     <a class="read_more" href="about.html">查看更多環境</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end about -->
      <!-- appointment -->
      <div class="appointment">
         <div class="container">
            <div class="row">
               <div class="col-md-12 ">
                  <div class="titlepage text_align_center">
                     <h2>回饋專區</h2>
                     <p>有任何問題歡迎詢問</p>
                  </div>
               </div>
               <div class="col-md-12">
                  <form id="request" class="main_form">
                     <div class="row">
                        <div class="col-md-6 ">
                           <input class="form_control" placeholder="名字" type="type" name=" Name"> 
                        </div>
                        <div class="col-md-6">
                           <input class="form_control" placeholder="Email" type="type" name="Email"> 
                        </div>
                        <div class="col-md-6">
                           <input class="form_control" placeholder="手機號碼" type="type" name="Phone Number">                          
                        </div>
                        <div class="col-md-6">
                           <input class="form_control" placeholder="詢問類型" type="type" name="Select">                          
                        </div>
                        <div class="col-md-12">
                           <textarea style=" color: #d0d0cf;" class="textarea" placeholder="問題內容" type="type" name="message">message </textarea>
                        </div>
                        <div class="col-md-12">
                           <button class="send_btn">寄送</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <!-- end appointment -->
      <!-- customers -->
      <div class="customers">
         <div class="clients_bg">
            <div class="container">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="titlepage text_align_center">
                        <h2>客戶回饋</h2>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- start slider section -->
         <div id="myCarousel" class="carousel slide clients_banner" data-ride="carousel">
            <ol class="carousel-indicators">
               <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
               <li data-target="#myCarousel" data-slide-to="1"></li>
               <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
               <div class="carousel-item active">
                  <div class="container">
                     <div class="carousel-caption relative">
                        <div class="row d_flex">
                           <div class="col-md-2 col-sm-8">
                              <div class="pro_file">
                                 <i><img src="images/test1.png" alt="#"/></i>
                                 <h4>洪先生</h4>
                              </div>
                           </div>
                           <div class="col-md-10">
                              <div class="test_box text_align_left">
                                 <p>老婆懷孕開始喝你們家的滴雞精，生出來的小孩頭好壯壯，目前一歲多沒感冒過</p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="carousel-item">
                  <div class="container">
                     <div class="carousel-caption relative">
                        <div class="row d_flex">
                           <div class="col-md-2 col-sm-8">
                              <div class="pro_file">
                                 <i><img src="images/test1.png" alt="#"/></i>
                                 <h4>洪先生</h4>
                              </div>
                           </div>
                           <div class="col-md-10">
                              <div class="test_box text_align_left">
                                 <p>老婆懷孕開始喝你們家的滴雞精，生出來的小孩頭好壯壯，目前一歲多沒感冒過</p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="carousel-item">
                  <div class="container">
                     <div class="carousel-caption relative">
                        <div class="row d_flex">
                           <div class="col-md-2 col-sm-8">
                              <div class="pro_file">
                                 <i><img src="images/test1.png" alt="#"/></i>
                                 <h4>洪先生</h4>
                              </div>
                           </div>
                           <div class="col-md-10">
                              <div class="test_box text_align_left">
                                 <p>老婆懷孕開始喝你們家的滴雞精，生出來的小孩頭好壯壯，目前一歲多沒感冒過</p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
            <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <i class="fa fa-angle-right" aria-hidden="true"></i>
            <span class="sr-only">Next</span>
            </a>
         </div>
      </div>
      <!-- end customers -->
      <!--  footer -->
      <?php include('footer.php') ?>
   </body>
</html>