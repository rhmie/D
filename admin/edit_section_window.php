<?php session_start(); ?>
<?php
    if (!isset($_SESSION['bee_admin'])){
        exit('<h1>登入逾時，請重新登入</h2>');
    } 
    

    include('../mysql.php');
    require_once ('../MysqliDb.php');
    $db = new MysqliDb($mysqli);

    $title  =   '新增區塊';

    $bid    =   (int)$_GET['id'];

    $blog	=	Array();

    $blog['sname']			=	'';
    $blog['content']		=	'';
    $blog['sort']			=	'';
    $blog['shown']			=	1;

    if ($bid > 0){
    	$title 	=	'編輯區塊';
    	$blog	=	$db->where('id', $bid)->getOne('sections');
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

	<body>

		<div class="container-fluid">

		    <div class="row m-4">
		        <div class="col-12 pl-0">
		            <h2 class="grey-text font-weight-bold"><i class="fas fa-columns fa-lg fa-fw mr-2"></i><?=$title?></h2>
		            <hr>
		        </div>

		        <form id="sectionform" class="form-row">

		        	<input type="hidden" name="sid" value="<?=$bid?>">

		        	<div class="col-12">
		        	    <div class="input-group mb-2">
		        	      <div class="input-group-prepend">
		        	        <div class="input-group-text">標題</div>
		        	      </div>
		        	      <input type="text" class="form-control py-0" name="sname" value="<?=$blog['sname']?>" required>
		        	    </div>
		        	</div>

		        	<div class="col-12">
		        	    <textarea id="content" row="5" name="content" required><?=htmlspecialchars($blog['content'])?></textarea>
		        	</div>

    				<div class="col-6">
    	        		<div class="md-form mt-0">
    	        		    <i class="fas fa-chart-line prefix"></i>
    	        		    <input placeholder="排序" type="number" id="sort" name="sort" value="<?=$blog['sort']?>" class="form-control" required>
    	        		</div>
    				</div>

    				<div class="col-6 text-right">
    					<div class="form-group">
    						<span class="mr-3">狀態</span>

    						<div class="custom-control custom-radio custom-control-inline">
    						  <input type="radio" class="custom-control-input" id="st0" value="1" name="shown" <?php if ($blog['shown'] == 1) echo 'checked';?>>
    						  <label class="custom-control-label" for="st0">顯示</label>
    						</div>

    						<div class="custom-control custom-radio custom-control-inline">
    						  <input type="radio" class="custom-control-input" id="st1" value="0" name="shown" <?php if ($blog['shown'] == 0) echo 'checked';?>>
    						  <label class="custom-control-label" for="st1">隱藏</label>
    						</div>

    					</div>
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
			      semantic: false,
			      lang: 'zh_tw',
			      autogrow: true,
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



			 $('#sectionform').on('submit', (function (e) {
			 	e.preventDefault();

			 	$('#save').addClass('disabled');

			 	$.ajax({
			 		url: 'edit_section.php',
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
			 				window.location = 'login.php';
			 			}

			 			if (result['err_msg'] !== 'OK'){
			 			    toastr.error(result.err_msg);
			 			    return false;
			 			}

			 			toastr.success('區塊已儲存~!');

			 			setTimeout(function(){
			 			    window.close();
			 			}, 1000);
			 		}
			 	});

			 }));



		</script>

	</body>

</html>