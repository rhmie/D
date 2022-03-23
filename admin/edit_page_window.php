<?php session_start(); ?>
<?php
    if (!isset($_SESSION['bee_admin'])){
        exit('<h1>登入逾時，請重新登入</h2>');
    } 
    

    include('../mysql.php');
    require_once ('../MysqliDb.php');
    $db = new MysqliDb($mysqli);

    $title  =   '新增頁面';

    $bid    =   (int)$_GET['id'];

    $page	=	Array();

    $page['pagename']			=	'';
    $page['content']			=	'';
    $page['linkname']			=	'';
    $page['sort']				=	0;
    $page['show_mode']			=	0;
    $page['nav_item']			=	0;
    $page['only_body']			=	0;

    if ($bid > 0){
    	$title 	=	'編輯頁面';
    	$page	=	$db->where('id', $bid)->getOne('pages');
    }

    $nav 	=	$db->orderBy('sort', 'asc')->get('nav_items');

    $nav_items = '';

    foreach ($nav as $item){
    	$sd = '';
    	if ($page['nav_item'] == $item['id']) $sd = 'selected';
    	$nav_items .= '<option value="'.$item['id'].'" '.$sd.'>'.$item['nav_name'].'</option>';
    }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?=$title?></title>
    <!-- Font Awesome -->
    <link rel="shortcut icon" href="../images/logo.png" type="img/x-icon">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <!-- Bootstrap core CSS -->

    <link href="https://fonts.googleapis.com/css?family=Montserrat:700|Raleway:200|Paytone+One" rel="stylesheet">

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/mdb.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.18.0/ui/trumbowyg.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.18.0/plugins/colors/ui/trumbowyg.colors.min.css" integrity="sha256-ypD0K+UpKz5IICqlKKqKZmk/pxZ5qGMRXEBN4QNEwi8=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.18.0/plugins/emoji/ui/trumbowyg.emoji.min.css" integrity="sha256-NUAw86dCQ0ShSlUB4yTFr740c9uHjdF23+pPzmHsd+s=" crossorigin="anonymous" />
</head>

<!-- 	<style>

	    .container {
	        max-width: 900px;
	        border-left: #b5b5b5 dotted 15px;
	    }


	</style> -->

	<body>

		<div class="container-fluid">

		    <div class="row m-4">
		        <div class="col-12 pl-0">
		            <h2 class="grey-text font-weight-bold"><i class="far fa-file-alt fa-lg fa-fw mr-2"></i><?=$title?></h2>
		            <hr>
		        </div>

		        <form id="pageform" class="form-row">

		        	<input type="hidden" name="sid" value="<?=$bid?>">

		        	<div class="col-12">
		        	    <div class="input-group mb-2">
		        	      <div class="input-group-prepend">
		        	        <div class="input-group-text">頁面名稱</div>
		        	      </div>
		        	      <input type="text" placeholder="頁面檔名，請使用英文或數字命名" class="form-control py-0" name="pagename" value="<?=$page['pagename']?>" required>
		        	    </div>
		        	</div>

		        	<div class="col-6">
		        	    <div class="input-group mb-2">
		        	      <div class="input-group-prepend">
		        	        <div class="input-group-text">連結名稱</div>
		        	      </div>
		        	      <input type="text" placeholder="顯示於導覽列的名稱" minlength="2" maxlength="12" class="form-control py-0" name="linkname" value="<?=$page['linkname']?>">
		        	    </div>
		        	</div>

		        	<div class="col-6">
		        	    <div class="input-group mb-2">
		        	      <div class="input-group-prepend">
		        	        <div class="input-group-text">連結排序</div>
		        	      </div>
		        	      <input type="number" min="0" placeholder="顯示於導覽列的排序" class="form-control py-0" name="sort" value="<?=$page['sort']?>">
		        	    </div>
		        	</div>

		        	<div class="col-6 my-auto">
		        		<div class="form-group my-auto">
		        			<span class="mr-3">模式</span>

		        			<div class="custom-control custom-radio custom-control-inline">
		        			  <input type="radio" class="custom-control-input" id="mod0" value="0" name="show_mode" <?php if ($page['show_mode'] == 0) echo 'checked';?>>
		        			  <label class="custom-control-label" for="mod0">不顯示</label>
		        			</div>

		        			<div class="custom-control custom-radio custom-control-inline">
		        			  <input type="radio" class="custom-control-input" id="mod1" value="1" name="show_mode" <?php if ($page['show_mode'] == 1) echo 'checked';?>>
		        			  <label class="custom-control-label" for="mod1">導覽列</label>
		        			</div>

		        			<div class="custom-control custom-radio custom-control-inline">
		        			  <input type="radio" class="custom-control-input" id="mod2" value="2" name="show_mode" <?php if ($page['show_mode'] == 2) echo 'checked';?>>
		        			  <label class="custom-control-label" for="mod2">導覽項目</label>
		        			</div>

		        		</div>

		        	</div>

		        	<div id="navblock" class="col-6 <?php if ($page['show_mode'] < 2) echo 'd-none';?>">

		        		<div class="input-group">
		        		  <div class="input-group-prepend">
		        		    <label class="input-group-text" for="nav_items">導覽項目</label>
		        		  </div>
		        		  <select class="browser-default custom-select" id="nav_items" name="nav_item">
		        		    <?=$nav_items?>
		        		  </select>
		        		</div>

		        	</div>


		        	<div class="col-12">
		        	    <textarea id="content" row="5" name="content" required><?=htmlspecialchars($page['content'])?></textarea>
		        	</div>

		        	<div class="col-12">
			        	<div class="custom-control custom-checkbox mt-3">
			        	  <input type="checkbox" class="custom-control-input" name="block" id="block" <?php if ($page['only_body'] == 1) echo 'checked';?>>
			        	  <label class="custom-control-label" for="block">僅編輯body內容</label>
			        	</div>
			        </div>

			        <div class="col-12">
			        	<p class="note note-primary mt-2">
			        		如勾選此處，請勿使用html, header, body等標籤，系統將為您套用主頁基本元素。
			        	</p>
		        	</div>


		        	<div class="col-12 text-center mb-5">
		        	    <hr>
		        	    <div class="btn-group">
		        	    	<button id="save" type="submit" class="btn btn-blue-grey"><i class="far fa-save fa-lg mr-2"></i>儲存</button>
		        	    </div>
		        	</div>


		        </form>
		    </div>

		</div>


		<script type="text/javascript" src="../js/jquery.min.js"></script>
		<script type="text/javascript" src="../js/popper.js"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../js/mdb.min.js"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.18.0/trumbowyg.min.js" integrity="sha256-9fPnxiyJ+MnhUKSPthB3qEIkImjaWGEJpEOk2bsoXPE=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.18.0/plugins/base64/trumbowyg.base64.min.js" integrity="sha256-oSbMq1h4jLg+Mmtu9DxrooTyUuzfoAZNeJwc/1amrCU=" crossorigin="anonymous"></script>
		<script src="../js/zh_tw.min.js" type="text/javascript"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.18.0/plugins/colors/trumbowyg.colors.min.js" integrity="sha256-3DiuDRovUwLrD1TJs3VElRTLQvh3F4qMU58Gfpsmpog=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.18.0/plugins/emoji/trumbowyg.emoji.min.js" integrity="sha256-yCnyfZblcEvAl3JW5YVfI9s88GLUMcWSizgRneuVIdQ=" crossorigin="anonymous"></script>


		<script>

			 $(document).ready(function() {
			    $('#content')
			    .trumbowyg({
			      lang: 'zh_tw',
			      autogrow: true,
			      semantic: false,
			        btnsDef: {
			            image: {
			                dropdown: ['insertImage', 'base64'],
			                ico: 'insertImage'
			            }
			        },

			        btns: [
			            ['viewHTML'],
			            ['formatting'],              
			            ['foreColor'],
			            ['emoji'],
			            ['link'],
			            ['image'], 
			            ['strong'],
			            ['justifyLeft', 'justifyCenter', 'justifyFull'],
			            ['horizontalRule'],
			            ['fullscreen']
			        ]
			    });

			});



			 $('#pageform').on('submit', (function (e) {
			 	e.preventDefault();

			 	$('#save').addClass('disabled');

			 	$.ajax({
			 		url: 'edit_page.php',
			 		type: "POST",
			 		data:  new FormData(this),
			 		contentType: false,
			 		cache: false,
			 		processData:false,
			 		success: function(data){
			 			var result = JSON.parse(data);

			 			//console.log(data);

			 			$('#save').removeClass('disabled');

			 			if (result.err_msg === '-1'){
			 				alert('登入逾時，請重新登入~!');
			 				setTimeout(function(){
			 				    window.close();
			 				}, 1000);
			 				return;
			 			}

			 			if (result['err_msg'] !== 'OK'){
			 			    toastr.error(result.err_msg);
			 			    return false;
			 			}

			 			toastr.success('頁面已儲存~!');

			 			setTimeout(function(){
			 			    window.close();
			 			}, 1000);
			 		}
			 	});

			 }));

			 $('input[name=show_mode]').on('click', function(){
			 	$('#navblock').addClass('d-none');
			 	var mode = $(this).val();
			 	
			 	if (mode === '2'){
			 	 	$('#navblock').removeClass('d-none');
			 	}
			 })

		</script>

	</body>

</html>