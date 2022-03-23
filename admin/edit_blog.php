<?php session_start(); ?>
<?php
    if (!isset($_SESSION['bee_admin'])){
        exit('<h1>登入逾時，請重新登入</h2>');
    } 
    

    include('../mysql.php');
    require_once ('../MysqliDb.php');
    $db = new MysqliDb($mysqli);

    $title  =   '新增文章';

    $bid    =   (int)$_GET['id'];

    $blog	=	Array();

    $blog['title']			=	'';
    $blog['sub_title']		=	'';
    $blog['main_img']		=	'';
    $blog['content']		=	'';
    $blog['related']		=	'';
    $main_img				=	'';

    if ($bid > 0){
    	$title 	=	'編輯文章';
    	$blog	=	$db->where('id', $bid)->getOne('blog');
    	$main_img	=	'<img onerror="imgError();" alt="" src="'.$blog['main_img'].'" class="img-fluid mb-2">';
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

	<style>
		.btn.btn-md {
		    padding: .63rem 1.6rem;
		    font-size: .7rem;
		}
	</style>

	<body>

		<div class="container-fluid">

		    <div class="row m-4">
		        <div class="col-12 pl-0">
		            <h2 class="grey-text font-weight-bold"><i class="fab fa-wordpress-simple fa-lg fa-fw mr-2"></i><?=$title?></h2>
		            <hr>
		        </div>

		        <form id="blogform" class="form-row">

		        	<input type="hidden" name="bid" value="<?=$bid?>">
		        	<input type="hidden" name="status" value="0">

		        	<div class="col-12">
		        	    <div class="input-group mb-2">
		        	      <div class="input-group-prepend">
		        	        <div class="input-group-text">標題</div>
		        	      </div>
		        	      <input type="text" class="form-control py-0" name="title" value="<?=$blog['title']?>" required>
		        	    </div>
		        	</div>

		        	<div class="col-12">
		        	    <div class="input-group mb-2">
		        	      <div class="input-group-prepend">
		        	        <div class="input-group-text">副標題</div>
		        	      </div>
		        	      <input type="text" class="form-control py-0" name="sub_title" value="<?=$blog['sub_title']?>" required>
		        	    </div>
		        	</div>

		        	<div class="col-12">
		        	    <!-- <div class="input-group mb-2">
		        	      <div class="input-group-prepend">
		        	        <div class="input-group-text">主圖URL</div>
		        	      </div>
		        	      <input type="text" class="form-control py-0" id="mimg" name="main_img" value="<?=$blog['main_img']?>" required>
		        	    </div> -->

		        	    <div class="input-group mb-2">
		        	      <div class="input-group-prepend">
		        	        <div class="input-group-text">主圖URL</div>
		        	      </div>
		        	      <input type="text" class="form-control py-0" name="main_img" id="mimg" value="<?=$blog['main_img']?>">
		        	      <div class="input-group-append">
		        	          <div class="file-field">
		        	              <button class="btn btn-md btn-primary m-0 z-depth-0 waves-effect" type="button">
		        	                <span class="upbtn"><i class="fas fa-upload mr-1"></i>選擇檔案</span>
		        	                <input id="main_upimg" name="main_upimg" type="file" accept="image/png, image/jpeg">
		        	              </button>
		        	          </div>
		        	      </div>

		        	    </div>
		        	</div>

		        	<div class="col-12">
		        		<img id="main_img" alt="" src="<?=$blog['main_img']?>" class="img-fluid mb-2">
		        	</div>

		        	<div class="col-12">
		        	    
		        	    <textarea id="content" row="5" name="content" required><?=htmlspecialchars($blog['content'])?></textarea>

		        	</div>

		        	<div class="col-12">
		        	    <div class="input-group mb-2">
		        	      <div class="input-group-prepend">
		        	        <div class="input-group-text">關聯商品</div>
		        	      </div>
		        	      <input type="text" class="form-control py-0" name="related" value="<?=$blog['related']?>">
		        	    </div>

		        	    <p class="note note-primary mt-2">
		        	        輸入此篇文章的關聯商品，請用逗號分隔
		        	    </p>
		        	</div>


		        	<div class="col-12 text-center mb-5">
		        	    <hr>
		        	    <div class="btn-group">
		        	    	<button id="save" type="submit" class="btn btn-blue-grey"><i class="far fa-save fa-lg mr-2"></i>儲存草稿</button>
		        	    	<button id="publish" type="button" class="btn btn-blue-grey"><i class="fas fa-paper-plane fa-lg mr-2"></i>儲存並發布</button>
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

			 $('#mimg').on('blur', function(){
			 	var img 	=	$('#mimg').val();
			 	if ($.trim(img) === '') return;

			 	$('#main_img').prop('src', img);

			 	$//('#main_img').html('<img onerror="imgError();" alt="" src="'+img+'" class="img-fluid mb-2">');
			 });


			 function imgError(){
			 	$('#main_img').html('');
			     toastr.error('圖片網址錯誤~!');
			 }

			 $('#publish').on('click', function(){
			 	$('input[name=status]').val('1');
			 	$('#blogform').submit();
			 });



			 $('#blogform').on('submit', (function (e) {
			 	e.preventDefault();

			 	$('#save, #publish').addClass('disabled');

			 	$.ajax({
			 		url: 'blog_update.php',
			 		type: "POST",
			 		enctype: 'multipart/form-data',
			 		data:  new FormData(this),
			 		contentType: false,
			 		cache: false,
			 		processData:false,
			 		success: function(data){
			 			var result = JSON.parse(data);

			 			//console.log(data);

			 			$('#save, #publish').removeClass('disabled');

			 			if (result.err_msg === '-1'){
			 				alert('登入逾時，請重新登入~!');
			 				window.location = 'login.php';
			 			}

			 			if (result['err_msg'] !== 'OK'){
			 			    toastr.error(result.err_msg);
			 			    return false;
			 			}

			 			toastr.success('文章已儲存~!');

			 			setTimeout(function(){
			 			    window.close();
			 			}, 1000);
			 		}
			 	});

			 }));

			 function getFileName(path) {
			     return path.match(/[-_\w]+[.][\w]+$/i)[0];
			 }

			 $('#main_upimg').on('change', function(e){
			     var fname = getFileName($(this).val());
			     var oname = fname.split('.');

			     $('#mimg').val(fname);

			     if (this.files && this.files[0]) {
			         var FR= new FileReader();

			         FR.addEventListener("load", function(e) {

			         	$('#main_img').prop('src', e.target.result);

			         }); 

			         FR.readAsDataURL( this.files[0] );

			     }
			     
			 })



		</script>

	</body>

</html>