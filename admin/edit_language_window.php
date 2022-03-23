<?php session_start(); ?>
<?php
    if (!isset($_SESSION['bee_admin'])){
        exit('<h1>登入逾時，請重新登入</h2>');
    } 
    

    include('../mysql.php');
    require_once ('../MysqliDb.php');
    $db = new MysqliDb($mysqli);

    $title  =   '新增語系';

    $sid    =   (int)$_GET['id'];

    $lan 	=	Array();
    $lan['gname']	=	'';

    $items = NULL;

    if ($sid > 0){
    	$title 	=	'編輯語系';
    	$lan	=	$db->where('id', $sid)->getOne('language');

    	if ($db->count == 0){
    		exit('<h1>語系不存在，請重新載入</h2>');
    	}

    	$items = json_decode($lan['content'], true);
    }

    $file = new SplFileObject("./language.txt");

    $i 			=	1;
    $fields 	=	'';
    
    while (!$file->eof()) {
        // Echo one line from the file.
        $pname = $file->fgets();

        $pvalue = '';
        if (!is_null($items)){
        	$pvalue = $items['lan'.$i];
        }

        $fields .= '<div class="col-lg-3 col-md-4 col-sm-6">
	        			<div class="input-group input-group-sm mt-3">
					  	  <div class="input-group-prepend">
					  	    <div class="input-group-text">'.$i.'</div>
					  	  </div>
					  	  <input type="text" class="form-control py-0 lang" value="'.$pvalue.'" id="lan'.$i.'" placeholder="'.$pname.'">
				  		</div>
				  	</div>';
        $i++;
    }

    // Unset the file to call __destruct(), closing the file handle.
    $file = null;

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

</head>

	<body>

		<div class="container-fluid">

		    <div class="row m-4">
		        <div class="col-12 pl-0">
		            <h2 class="grey-text font-weight-bold"><i class="far fa-file-alt fa-lg fa-fw mr-2"></i><?=$title?></h2>
		            <hr>
		        </div>

		        <div class="col-12">
		            <div class="input-group mb-2">
		              <div class="input-group-prepend">
		                <div class="input-group-text">語系名稱</div>
		              </div>
		              <input type="text" class="form-control py-0" id="gname" value="<?=$lan['gname']?>">
		            </div>
		        </div>

		        <input type="hidden" id="sid" value="<?=$sid?>">

		        <?=$fields?>

		        	<div class="col-12 text-center mb-5">
		        	    <hr>
		        	    <div class="btn-group">
		        	    	<button id="save" class="btn btn-blue-grey"><i class="far fa-save fa-lg mr-2"></i>儲存</button>
		        	    </div>
		        	</div>



		    </div>

		</div>


		<script type="text/javascript" src="../js/jquery.min.js"></script>
		<script type="text/javascript" src="../js/popper.js"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../js/mdb.min.js"></script>

		<script>
			$('#save').on('click', function(){
				var lan_obj = {};
				var gname = $('#gname').val();

				if ($.trim(gname) === ''){
					toastr.error('請輸入語系名稱~!');
					return false;
				}


				$('.lang').each(function(key, item){
					var gvalue = $(this).val();
					var gid = $(this).prop('id');

					if ($.trim(gvalue) === ''){
						toastr.error('尚有欄位未輸入~!');
						return false;
					}
					lan_obj[gid] = gvalue

				});

				var content = JSON.stringify(lan_obj);

				var sid = $('#sid').val();

				$.post('lang_update.php', {sid: sid, gname: gname, content: content}, function(data){
					var result = JSON.parse(data);

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

					toastr.success('語系已儲存~!');

					setTimeout(function(){
					    window.close();
					}, 1000);


				})
			})

		</script>

	</body>

</html>