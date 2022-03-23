<?php session_start(); ?>
<?php

	// include('../check_ref.php');
 //    if (!isset($_SESSION['bee_admin'])){
 //        exit('-1');
 //    } 

    include('./permis.php');

	if (!isset($_SESSION['bee_admin'])){
	   echo '<meta http-equiv=REFRESH CONTENT=1;url=login.php>';
	}

	$system	=	$db->getOne('system');

	$alert 	=	'';
	if ($system['weburl'] == 'https://faith.tw/'){
		$alert 	=	'<div class="col-12 text-left"><hr>
							<ol class="pink-text">
								<li>請勿修改或刪除已存在之資料</li>
								<li>登出前請記得刪除新增的資料</li>
								<li>感謝您的試用與合作~!</li>
							</ol></div>';
	}

?>


<style>
	.main_card {
		background: linear-gradient(to bottom, #ffffff, #37b5bb);
		border-radius: 12px;
		border: 12px solid white !important;
	}
</style>


<section class="section" id="welcome">

	<div class="row mb-4 text-center">
		 <h3 class="h3-responsive w-100 gray m-auto">歡迎使用<?=$system['wname']?>後台管理系統</h3>
		 <?=$alert?>
	</div>


	<div class="row mt-2">

		<div class="col-lg-4 col-md-6 col-sm-6 mb-4" <?php echo $auth_1 ?>>
			<!--Card Light-->
			<div class="card main_card">
			    <!--Card image-->
			    <div class="view overlay text-center p-4 hm-white-slight">
			    	<i class="fa fa-user fa-4x m-auto" aria-hidden="true"></i>
			        <!-- <img src="images/m1.png" class="img-fluid m-auto pt-2" alt=""> -->
			        <a>
			            <div data-sname="ident_settings" class="mask flink"></div>
			        </a>
			    </div>

			    <div class="card-body pt-0 text-center">
			        <h4 class="card-title">管理員設定</h4>			        
			    </div>
			    <!--/.Card content-->
			</div>
			<!--/.Card Light-->
		</div><!--/.End COL-->

		<div class="col-lg-4 col-md-6 col-sm-6 mb-4" <?php echo $auth_6 ?>>
			<!--Card Light-->
			<div class="card main_card">
			    <!--Card image-->
			    <div class="view overlay text-center p-4 hm-white-slight">
			    	<i class="fas fa-cog fa-4x m-auto" aria-hidden="true"></i>
			        <!-- <img src="images/m1.png" class="img-fluid m-auto pt-2" alt=""> -->
			        <a>
			            <div data-sname="system" class="mask flink"></div>
			        </a>
			    </div>

			    <div class="card-body pt-0 text-center">
			        <h4 class="card-title">系統管理</h4>			        
			    </div>
			    <!--/.Card content-->
			</div>
			<!--/.Card Light-->
		</div><!--/.End COL-->


		<div class="col-lg-4 col-md-6 col-sm-6 mb-4" <?php echo $auth_9 ?>>
			<!--Card Light-->
			<div class="card main_card">
			    <!--Card image-->
			    <div class="view overlay text-center p-4 hm-white-slight">
			    	<i class="fas fa-pager fa-4x m-auto" aria-hidden="true"></i>
			        <!-- <img src="images/m1.png" class="img-fluid m-auto pt-2" alt=""> -->
			        <a>
			            <div data-sname="main_index" class="mask flink"></div>
			        </a>
			    </div>

			    <div class="card-body pt-0 text-center">
			        <h4 class="card-title">首頁管理</h4>			        
			    </div>
			    <!--/.Card content-->
			</div>
			<!--/.Card Light-->
		</div><!--/.End COL-->


		<div class="col-lg-4 col-md-6 col-sm-6 mb-4" <?php echo $auth_2 ?>>
			<!--Card Light-->
			<div class="card main_card">
			    <!--Card image-->
			    <div class="view overlay text-center p-4 hm-white-slight">
			    	<i class="fa fa-users fa-4x m-auto" aria-hidden="true"></i>
			        <!-- <img src="images/m1.png" class="img-fluid m-auto pt-2" alt=""> -->
			        <a>
			            <div data-sname="members" class="mask flink"></div>
			        </a>
			    </div>

			    <div class="card-body pt-0 text-center">
			        <h4 class="card-title">會員管理</h4>			        
			    </div>
			    <!--/.Card content-->
			</div>
			<!--/.Card Light-->
		</div><!--/.End COL-->

		<div class="col-lg-4 col-md-6 col-sm-6 mb-4" <?php echo $auth_3 ?>>
			<!--Card Light-->
			<div class="card main_card">
			    <!--Card image-->
			    <div class="view overlay text-center p-4 hm-white-slight">
			    	<i class="far fa-list-alt fa-4x m-auto" aria-hidden="true"></i>
			        <!-- <img src="images/m1.png" class="img-fluid m-auto pt-2" alt=""> -->
			        <a>
			            <div data-sname="orders" class="mask flink"></div>
			        </a>
			    </div>

			    <div class="card-body pt-0 text-center">
			        <h4 class="card-title">訂單管理</h4>			        
			    </div>
			    <!--/.Card content-->
			</div>
			<!--/.Card Light-->
		</div><!--/.End COL-->


		<div class="col-lg-4 col-md-6 col-sm-6 mb-4" <?php echo $auth_10 ?>>
			<!--Card Light-->
			<div class="card main_card">
			    <!--Card image-->
			    <div class="view overlay text-center p-4 hm-white-slight">
			    	<i class="fas fa-cubes fa-4x m-auto" aria-hidden="true"></i>
			        <!-- <img src="images/m1.png" class="img-fluid m-auto pt-2" alt=""> -->
			        <a>
			            <div data-sname="group" class="mask flink"></div>
			        </a>
			    </div>

			    <div class="card-body pt-0 text-center">
			        <h4 class="card-title">類別管理</h4>			        
			    </div>
			    <!--/.Card content-->
			</div>
			<!--/.Card Light-->
		</div><!--/.End COL-->



		

		<div class="col-lg-4 col-md-6 col-sm-6 mb-4" <?php echo $auth_4 ?>>
			<!--Card Light-->
			<div class="card main_card">
			    <!--Card image-->
			    <div class="view overlay text-center p-4 hm-white-slight">
			    	<i class="fas fa-gift fa-5x m-auto" aria-hidden="true"></i>
			        <!-- <img src="images/m1.png" class="img-fluid m-auto pt-2" alt=""> -->
			        <a>
			            <div data-sname="products" class="mask flink"></div>
			        </a>
			    </div>

			    <div class="card-body pt-0 text-center">
			        <h4 class="card-title">商品管理</h4>			        
			    </div>
			    <!--/.Card content-->
			</div>
			<!--/.Card Light-->
		</div><!--/.End COL-->


		<div class="col-lg-4 col-md-6 col-sm-6 mb-4" <?php echo $auth_8 ?>>
			<!--Card Light-->
			<div class="card main_card">
			    <!--Card image-->
			    <div class="view overlay text-center p-4 hm-white-slight">
			    	<i class="fas fa-list fa-4x m-auto" aria-hidden="true"></i>
			        <!-- <img src="images/m1.png" class="img-fluid m-auto pt-2" alt=""> -->
			        <a>
			            <div data-sname="options" class="mask flink"></div>
			        </a>
			    </div>

			    <div class="card-body pt-0 text-center">
			        <h4 class="card-title">規格管理</h4>			        
			    </div>
			    <!--/.Card content-->
			</div>
			<!--/.Card Light-->
		</div><!--/.End COL-->

		<div class="col-lg-4 col-md-6 col-sm-6 mb-4" <?php echo $auth_11 ?>>
			<!--Card Light-->
			<div class="card main_card">
			    <!--Card image-->
			    <div class="view overlay text-center p-4 hm-white-slight">
			    	<i class="far fa-file-alt fa-4x m-auto" aria-hidden="true"></i>
			        <!-- <img src="images/m1.png" class="img-fluid m-auto pt-2" alt=""> -->
			        <a>
			            <div data-sname="single" class="mask flink"></div>
			        </a>
			    </div>

			    <div class="card-body pt-0 text-center">
			        <h4 class="card-title">單頁管理</h4>			        
			    </div>
			    <!--/.Card content-->
			</div>
			<!--/.Card Light-->
		</div><!--/.End COL-->



		<div class="col-lg-4 col-md-6 col-sm-6 mb-4" <?php echo $auth_12 ?>>
			<!--Card Light-->
			<div class="card main_card">
			    <!--Card image-->
			    <div class="view overlay text-center p-4 hm-white-slight">
			    	<i class="fab fa-wordpress-simple fa-4x m-auto" aria-hidden="true"></i>
			        <!-- <img src="images/m1.png" class="img-fluid m-auto pt-2" alt=""> -->
			        <a>
			            <div data-sname="blog" class="mask flink"></div>
			        </a>
			    </div>

			    <div class="card-body pt-0 text-center">
			        <h4 class="card-title">文章管理</h4>			        
			    </div>
			    <!--/.Card content-->
			</div>
			<!--/.Card Light-->
		</div><!--/.End COL-->


		


		<div class="col-lg-4 col-md-6 col-sm-6 mb-4" <?php echo $auth_5 ?>>
			<!--Card Light-->
			<div class="card main_card">
			    <!--Card image-->
			    <div class="view overlay text-center p-4 hm-white-slight">
			    	<i class="fas fa-th-large fa-4x m-auto" aria-hidden="true"></i>
			        <!-- <img src="images/m1.png" class="img-fluid m-auto pt-2" alt=""> -->
			        <a>
			            <div data-sname="sections" class="mask flink"></div>
			        </a>
			    </div>

			    <div class="card-body pt-0 text-center">
			        <h4 class="card-title">區塊管理</h4>			        
			    </div>
			    <!--/.Card content-->
			</div>
			<!--/.Card Light-->
		</div><!--/.End COL-->




		<div class="col-lg-4 col-md-6 col-sm-6 mb-4" <?php echo $auth_7 ?>>
			<!--Card Light-->
			<div class="card main_card">
			    <!--Card image-->
			    <div class="view overlay text-center p-4 hm-white-slight">
			    	<i class="fas fa-sms fa-4x m-auto" aria-hidden="true"></i>
			        <!-- <img src="images/m1.png" class="img-fluid m-auto pt-2" alt=""> -->
			        <a>
			            <div data-sname="sms" class="mask flink"></div>
			        </a>
			    </div>

			    <div class="card-body pt-0 text-center">
			        <h4 class="card-title">簡訊發送</h4>			        
			    </div>
			    <!--/.Card content-->
			</div>
			<!--/.Card Light-->
		</div><!--/.End COL-->

		<div class="col-lg-4 col-md-6 col-sm-6 mb-4" <?php echo $auth_13 ?>>
			<!--Card Light-->
			<div class="card main_card">
			    <!--Card image-->
			    <div class="view overlay text-center p-4 hm-white-slight">
			    	<i class="fas fa-globe fa-4x m-auto" aria-hidden="true"></i>
			        <!-- <img src="images/m1.png" class="img-fluid m-auto pt-2" alt=""> -->
			        <a>
			            <div data-sname="language" class="mask flink"></div>
			        </a>
			    </div>

			    <div class="card-body pt-0 text-center">
			        <h4 class="card-title">語系管理</h4>			        
			    </div>
			    <!--/.Card content-->
			</div>
			<!--/.Card Light-->
		</div><!--/.End COL-->


	</div><!--/.End ROW-->

</section>

<script>

</script>