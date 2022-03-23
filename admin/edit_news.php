<?php session_start(); ?>
<?php
    if (!isset($_SESSION['bee_admin'])){
        exit('<h1>登入逾時，請重新登入</h2>');
    } 
    

    include('../mysql.php');
    require_once ('../MysqliDb.php');
    $db = new MysqliDb($mysqli);

    $title  =   '新增電子報';

    $bid    =   (int)$_GET['id'];

    $blog	=	Array();

    $blog['title']			=	'';
    $blog['content']		=	'';
    $blog['pdate']			=	'';
    $blog['ptime']			=	'';

    if ($bid > 0){
    	$title 	=	'編輯電子報';
    	$blog	=	$db->where('id', $bid)->getOne('news_letters');
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

	    .container {
	        max-width: 900px;
	        border-left: #b5b5b5 dotted 15px;
	    }


	</style>

	<body>

		<div class="container-fluid">

		    <div class="row m-4">
		        <div class="col-12">
		            <h2 class="grey-text font-weight-bold"><i class="far fa-envelope fa-lg fa-fw mr-2"></i><?=$title?></h2>
		            <hr>
		        </div>

		        <form id="newsform" class="form-row">

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
		        	    <textarea id="content" row="5" name="content" required><?=htmlspecialchars($blog['content'])?></textarea>
		        	</div>

    				<div class="col-6">
    	        		<div class="md-form mt-4">
    	        		    <i class="far fa-calendar-alt prefix"></i>
    	        		    <input placeholder="發送日期" type="text" id="pdate" name="pdate" value="<?=$blog['pdate']?>" class="form-control datepicker dpicker" required>
    	        		</div>
    				</div>
    				<div class="col-6">
    	        		<div class="md-form mt-4">
    	        		    <i class="far fa-clock prefix"></i>
    	        		    <input placeholder="發送時間" type="text" id="ptime" name="ptime" value="<?=$blog['ptime']?>" class="form-control timepicker" required>
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

			$('.dpicker').pickadate({
			    monthsShort: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
			    weekdaysShort: ['日', '一', '二', '三', '四', '五', '六'],
			    format: 'yyyy-mm-dd',
			    today: '今日',
			    clear: '清除',
			    close: '關閉',
			    formatSubmit: 'yyyy-mm-dd',
			    showMonthsShort: true,
			    firstDay: 1,
			    min: 0
			    }
			);



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

			    $('.timepicker').pickatime();

			});



			 $('#newsform').on('submit', (function (e) {
			 	e.preventDefault();

			 	$('#save, #publish').addClass('disabled');

			 	$.ajax({
			 		url: 'newsletter_update.php',
			 		type: "POST",
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

			 			toastr.success('電子報已儲存~!');

			 			setTimeout(function(){
			 			    window.close();
			 			}, 1000);
			 		}
			 	});

			 }));



		</script>

	</body>

</html>