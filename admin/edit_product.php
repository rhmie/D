<?php session_start(); ?>
<?php
    if (!isset($_SESSION['bee_admin'])){
        exit('<h1>登入逾時，請重新登入</h2>');
    } 
    

    include('../mysql.php');
    require_once ('../MysqliDb.php');
    $db = new MysqliDb($mysqli);

    $title  =   '新增商品';

    $pid    =   (int)$_GET['id'];

    $prod   =   Array();
    $prod['pname']              =   '';
    $prod['pnum']               =   '';
    $prod['price']              =   0;
    $prod['sprice']             =   0;
    $prod['cost']               =   0;
    $prod['opts']               =   '';
    $prod['main_id']            =   0;
    $prod['sub_id']             =   0;
    $prod['images']             =   '';
    $images                     =   '';
    $info_images                =   '';
    $y_movies                   =   '';
    $prod['info_images']        =   '';
    $prod['youtube']            =   '';
    $prod['info']               =   '';
    $prod['stock']              =   10000;
    $prod['buy_limited']        =   0;
    $prod['volume']             =   0;
    $prod['sdate']              =   '';
    $prod['related_items']      =   '';
    $prod['status']             =   0;
    $prod['opt_asign']          =   0;

    $opstr                      =   '';
    $imgstr                     =   '';
    $infostr                    =   '';
    $ystr                       =   '';


    if ($pid > 0){
        $title  =   '編輯商品';
        $prod   =   $db->where('id', $pid)->getOne('products');

        $imgs   =   $infos  =   $movs   =   $opts   =   Array();

        if (!empty($prod['images'])) $imgs    =      explode(',', $prod['images']);

        if (!empty($prod['info_images'])) $infos    =     explode(',', $prod['info_images']);

        if (!empty($prod['youtube'])) $movs     =     explode(',', $prod['youtube']);

        if (!empty($prod['opts']))   $opts   =   json_decode($prod['opts'], true);


        if (count($opts) > 0){
            foreach ($opts as $opt){

                $opstr .= '<div class="input-group mb-2 opts">
                            <div class="input-group-prepend">
                                <div class="input-group-text">'.$opt['oname'].'</div>
                            </div>';

                $items  =   '';

                foreach ($opt['opts'] as $key=>$item){
                    if ($key > 0){
                        $items .= ','.$item;
                    } else {
                        $items .= $item;
                    }
                }

                $opstr .= '<input type="text" class="form-control py-0" value="'.$items.'" required>';

                $opstr .= '<div class="input-group-append">
                                <button class="btn btn-md btn-pink m-0 px-3 py-2 z-depth-0 waves-effect del_opt" type="button"><i class="fas fa-trash-alt fa-lg"></i></button></div>';

                $opstr .= '</div>';

            }

        }


        if (count($imgs) > 0){

            foreach ($imgs as $img){
                $images .=  '<div class="col-lg-3 col-md-4 col-sm-6 text-center mt-2">
                    <img class="img-fluid" src="'.$img.'">
                    </div>';

                $imgstr .= '<div class="input-group mb-2 main_imgs">
                            <div class="input-group-prepend">
                                <div class="input-group-text">URL</div>
                            </div>
                            <input type="text" class="form-control py-0 img_path" value="'.$img.'" required>

                            <div class="input-group-append">
                                <button class="btn btn-md btn-pink m-0 px-3 py-2 z-depth-0 waves-effect del_img" type="button"><i class="fas fa-trash-alt fa-lg"></i></button>
                            </div>

                            <div class="input-group-append">
                                <div class="file-field">
                                    <button class="btn btn-md btn-primary m-0 z-depth-0 waves-effect" type="button">
                                      <span class="upbtn"><i class="fas fa-upload mr-1"></i>上傳檔案</span>
                                      <input class="up_img" type="file" accept="image/png, image/jpeg">
                                    </button>
                                </div>
                            </div>

                        </div>';
            }
        }



        if (count($infos) > 0){

            foreach ($infos as $info){
                $info_images .=  '<div class="col-lg-3 col-md-4 col-sm-6 text-center mt-2">
                    <img class="img-fluid" src="'.$info.'">
                    </div>';

                $infostr .= '<div class="input-group mb-2 info_imgs">
                            <div class="input-group-prepend">
                                <div class="input-group-text">URL</div>
                            </div>
                            <input type="text" class="form-control py-0 img_path" value="'.$info.'" required>

                            <div class="input-group-append">
                                <button class="btn btn-md btn-pink m-0 px-3 py-2 z-depth-0 waves-effect del_info" type="button"><i class="fas fa-trash-alt fa-lg"></i></button>
                                </div>

                                <div class="input-group-append">
                                    <div class="file-field">
                                        <button class="btn btn-md btn-primary m-0 z-depth-0 waves-effect" type="button">
                                          <span class="upbtn"><i class="fas fa-upload mr-1"></i>上傳檔案</span>
                                          <input class="up_img" type="file" accept="image/png, image/jpeg">
                                        </button>
                                    </div>
                                </div>

                            </div>';
            }
        }



        if (count($movs) > 0){

            foreach ($movs as $mov){
                $y_movies .=  '<div class="col-md-6 mt-2 text-center">
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <iframe width="560" height="315" class="embed-responsive-item" src="'.$mov.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                    </div>';

                $ystr .= '<div class="input-group mb-2 info_movs">
                            <div class="input-group-prepend">
                                <div class="input-group-text">URL</div>
                            </div>
                            <input type="text" class="form-control py-0" value="'.$mov.'" required>

                            <div class="input-group-append">
                                <button class="btn btn-md btn-pink m-0 px-3 py-2 z-depth-0 waves-effect del_mov" type="button"><i class="fas fa-trash-alt fa-lg"></i></button></div></div>';
            }

        }

    }


    $mains  =   $db->orderBy('sort', 'asc')->get('main_class');

    $main_items =   $sub_items  =    '';

    foreach ($mains as $main){

        if ($pid > 0){
            if ($prod['main_id'] == $main['id']){
                $main_items .= '<option value="'.$main['id'].'" selected>'.$main['cname'].'</option>';
                continue;
            }
        }

        $main_items .= '<option value="'.$main['id'].'">'.$main['cname'].'</option>';

    }

    if ($pid > 0){
        $subs   =   $db->orderBy('sort', 'asc')->where('mid', $prod['main_id'])->get('sub_class');
    } else {
        $subs   =   $db->orderBy('sort', 'asc')->where('mid', $mains[0]['id'])->get('sub_class');
    }

    foreach ($subs as $sub){

        if ($pid > 0){
            if ($prod['sub_id'] == $sub['id']){
                $sub_items .= '<option value="'.$sub['id'].'" selected>'.$sub['cname'].'</option>';
                continue;
            }
        }

        $sub_items .= '<option value="'.$sub['id'].'">'.$sub['cname'].'</option>';
    }


    $ditems =   '';
    $opts   =   $db->get('options');

    foreach ($opts as $opt){
        $ditems .= '<a data-oname="'.$opt['oname'].'" data-opts="'.$opt['opts'].'" class="dropdown-item opt-item">'.$opt['onick'].'</a>';
    }

    $oitems     =   '';
    $infos  =   $db->get('product_info');

    foreach ($infos as $info){
        $oitems .= '<a data-iname="'.$info['iname'].'" data-info="'.htmlspecialchars($info['info']).'" class="dropdown-item info-item">'.$info['iname'].'</a>';
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

    <!-- <link href="../css/typo.css" rel="stylesheet"> -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/mdb.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

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
            <div class="col-12">
                <h2 class="grey-text font-weight-bold"><i class="fas fa-edit fa-lg fa-fw mr-2"></i><?=$title?></h2>
                <hr>
            </div>

            <form id="prodform" class="form-row">

                <input type="hidden" value="<?=$pid?>" name="pid">
                <input type="hidden" id="optjson" name="optjson">
                <input type="hidden" id="main_imgs" name="main_imgs">
                <input type="hidden" id="info_imgs" name="info_imgs">
                <input type="hidden" id="info_movs" name="info_movs">

                <div class="col-lg-4 mb-2">

                    <div class="input-group">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="main_id">主類別</label>
                      </div>
                      <select class="browser-default custom-select" name="main_id" id="main_id">
                        <?=$main_items?>
                      </select>
                    </div>

                </div>

                <div class="col-lg-4 mb-2">

                    <div class="input-group">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="sub_items">次類別</label>
                      </div>
                      <select class="browser-default custom-select" name="sub_id" id="sub_id">
                        <?=$sub_items?>
                      </select>
                    </div>

                </div>


                <div class="col-12">
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text">商品編號</div>
                      </div>
                      <input type="text" class="form-control py-0" name="pnum" value="<?=$prod['pnum']?>" required>
                    </div>
                </div>


                <div class="col-12">
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text">商品名稱</div>
                      </div>
                      <input type="text" class="form-control py-0" name="pname" value="<?=$prod['pname']?>" required>
                    </div>
                </div>

                <div class="col-12">
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text">價格</div>
                      </div>
                      <input type="text" class="form-control py-0" name="price" value="<?=$prod['price']?>" required>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text">優惠價(無優惠請輸入0)</div>
                      </div>
                      <input type="text" class="form-control py-0" id="sprice" name="sprice" value="<?=$prod['sprice']?>" required>
                    </div>
                </div>


                <div class="col-12 col-md-6">
                    <div class="md-form mb-2 mt-0">
                        <i class="far fa-calendar-alt prefix"></i>
                        <input placeholder="優惠到期日" type="text" id="sdate" name="sdate" value="<?=$prod['sdate']?>" class="form-control datepicker dpicker">
                    </div>
                </div>

                <div class="col-12 mb-2">
                    <p class="note note-primary">
                        當日期超過到期日時，優惠價將自動歸零，以原價顯示，如不輸入日期，則優惠價將一直持續
                    </p>
                </div>

                <div class="col-12">
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text">成本價</div>
                      </div>
                      <input type="text" class="form-control py-0" id="cost" name="cost" value="<?=$prod['cost']?>" required>
                    </div>
                </div>

                <div class="col-12 mb-2">
                    <p class="note note-primary">
                        在此輸入商品成本價，後台將為您計算出營業額及純利
                    </p>
                </div>

                <div class="col-12">
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text">庫存</div>
                      </div>
                      <input min="0" type="text" class="form-control py-0" name="stock" value="<?=$prod['stock']?>" required>
                    </div>
                </div>

                <div class="col-12 mb-2">
                    <p class="note note-primary">
                        當訂單標示為已出貨時，庫存將自動減少，當庫存為0時則商品顯示為售完補貨中，若要永遠顯示此商品，請輸入一個極大值例如 10000
                    </p>
                </div>

                <div class="col-12">
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text">購買量限制</div>
                      </div>
                      <input min="0" type="num" class="form-control py-0" name="buy_limited" value="<?=$prod['buy_limited']?>" required>
                    </div>
                </div>

                <div class="col-12 mb-2">
                    <p class="note note-primary">
                        在此輸入數值來限制買家在一份訂單內能購買的最多數量，如不限制請輸入 0, 如庫存量低於此處數值，以庫存量為主
                    </p>
                </div>

                <div class="col-12">
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text">關聯商品</div>
                      </div>
                      <input min="0" type="text" class="form-control py-0" name="related_items" value="<?=$prod['related_items']?>">
                    </div>
                </div>

                <div class="col-12 mb-2">
                    <p class="note note-primary">
                        請在此輸入此商品之關聯商品編號，使用逗號進行分隔，離如 A123,A233...
                    </p>
                </div>

                <div class="col-12">
                    <div class="custom-control custom-checkbox mb-3 text-right">
                      <input type="checkbox" class="custom-control-input" id="google_cloud">
                      <label class="custom-control-label" for="google_cloud">使用Google雲端圖片(按下新增時將轉換Google連結)</label>
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <h4 class="grey-text font-weight-bold"><i class="fas fa-list fa-lg fa-fw mr-2"></i>商品規格</h4>
                    <hr>

                    <div class="custom-control custom-checkbox mb-3">
                      <input type="checkbox" class="custom-control-input" id="opt_asign" name="opt_asign" <?php if ($prod['opt_asign']) echo 'checked'?>>
                      <label class="custom-control-label" for="opt_asign">規格搭配商品圖</label>
                    </div>

                    <p class="note note-primary">
                        如開啟此功能，商品圖請依規格順序排序，假設規格為 紅色,黑色<br>
                        當用戶選擇紅色時，跳至第一張圖片，選擇黑色時，跳至第二張圖片，依此類推，請注意此功能僅作用於第一個規格上。
                    </p>

                    <div id="options">
                        <?=$opstr?>
                    </div>
                </div>

                <div class="col-12 text-right">
                    <div class="btn-group">
                        <button id="new_opt" type="button" class="btn btn-blue-grey">新增規格</button>
                        <button type="button" class="btn btn-blue-grey dropdown-toggle" data-toggle="dropdown"
  aria-haspopup="true" aria-expanded="false">選擇規格</button>
                        <div class="dropdown-menu">
                            <?=$ditems?>
                        </div>
                    </div>
                    <hr>
                </div>

                <div class="col-12 mt-4">
                    <h4 class="grey-text font-weight-bold"><i class="far fa-images fa-lg fa-fw mr-2"></i>商品圖片</h4>
                    <hr>
                </div>

                <div id="main_images" class="form-row">
                    <?=$images?>
                </div>

                <div id="img_field" class="col-12 mt-3">
                    <?=$imgstr?>
                </div>

                <div class="col-12">
                    <p class="note note-primary">
                        若圖片存放於外部(雲端硬碟等)，複製圖片網址後再按下新增圖片即可<br>
                        請勿多種商品共用一張商品圖，否則刪除商品或圖片時，會導致其他商品缺圖<br>
                        圖片請勿使用中文檔名~!
                    </p>
                </div>

                <div class="col-12 text-right">
                    <button id="new_img" type="button" class="btn btn-blue-grey">新增圖片</button>
                </div>



                <div class="col-12 mt-4">
                    <h4 class="grey-text font-weight-bold"><i class="far fa-id-card fa-lg fa-fw mr-2"></i>商品說明</h4>
                    <hr>
                </div>

                <div id="info_images" class="form-row">
                    <?=$info_images?>
                </div>

                <div id="info_field" class="col-12 mt-3">
                    <?=$infostr?>
                </div>

                <div class="col-12">
                    <p class="note note-primary">
                        若圖片存放於外部(雲端硬碟等)，複製圖片網址後再按下新增圖片即可<br>
                        請勿多種商品共用一張商品圖，否則刪除商品或圖片時，會導致其他商品缺圖<br>
                        圖片請勿使用中文檔名~!
                    </p>
                </div>

                <div class="col-12 text-right">
                    <button id="new_info" type="button" class="btn btn-blue-grey">新增圖片</button>
                </div>



                <div class="col-12 mt-4">
                    <h4 class="grey-text font-weight-bold"><i class="fab fa-youtube fa-lg fa-fw mr-2"></i>商品影片</h4>
                    <hr>
                </div>

                <div id="info_movies" class="w-100 form-row">
                    <?=$y_movies?>
                </div>

                <div id="info_mov_field" class="col-12 mt-3">
                    <?=$ystr?>
                </div>

                <div class="col-12">
                    <p class="note note-primary">
                        請使用Youtube影片嵌入網址，例如 https://www.youtube.com/embed/lN-vrgsAk9A
                    </p>
                </div>

                <div class="col-12 text-right">
                    <button id="new_movie" type="button" class="btn btn-blue-grey">新增影片</button>
                </div>



                <div class="col-12 mt-4">
                    <h4 class="grey-text font-weight-bold"><i class="fab fa-wordpress-simple fa-lg fa-fw mr-2"></i>文字說明</h4>
                    <hr>
                    <p class="note note-primary">
                        請在此編排文字說明及外部連結
                    </p>

                    <button type="button" class="btn btn-blue-grey dropdown-toggle float-right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">選擇資訊</button>
                        <div class="dropdown-menu">
                            <?=$oitems?>
                        </div>
                </div>

                <div class="col-12">
                    
                    <textarea id="info" row="5" name="info"><?=htmlspecialchars($prod['info'])?></textarea>

                    <div class="custom-control custom-checkbox mb-3">
                      <input type="checkbox" class="custom-control-input" id="status" name="status" <?php if ($prod['status'] == 1) echo 'checked'?>>
                      <label class="custom-control-label" for="status">隱藏商品</label>
                    </div>

                    <p class="note note-primary">
                        勾選此處，將於主官網隱藏此商品，但保持獨立頁面顯示（如果有的話），同時不影響會員訂單記錄與金額
                    </p>

                </div>


                <div class="col-12 text-center mb-5">
                    <hr>
                    <button id="update_btn" type="submit" class="btn btn-blue-grey w-50"><i class="fas fa-paper-plane fa-lg mr-2"></i>提交</button>
                </div>


            </form>



        </div>



    </div>


    <div class="modal fade" id="new_option" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header text-center">
            <h4 class="modal-title w-100 font-weight-bold">新增規格</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body pt-0 mx-3">

              <div class="modal-body">

                <div class="input-group my-3">
                  <div class="input-group-prepend">
                    <div class="input-group-text">規格名稱</div>
                  </div>
                  <input type="text" class="form-control py-0" id="oname">
                </div>

                <div class="form-group purple-border mt-3">
                  <label for="opt_items">規格項目</label>
                  <textarea class="form-control" id="opt_items" rows="2"></textarea>
                </div>

                <p class="note note-primary">
                    請使用逗號區分項目，例如 S,M,L,XL,XXL
                </p>

              </div>
              <!--Footer-->
              <div class="modal-footer py-4">
                <div class="btn-group m-auto">
                  <button type="button" class="btn btn-blue-grey" data-dismiss="modal"><i class="fas fa-times fa-lg mr-1"></i>關閉</button>
                  <button type="button" id="add_opt" class="btn btn-blue-grey">確認<i class="fas fa-paper-plane fa-lg ml-1"></i></button>           
                </div>
              </div>

          </div>

        </div>
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
            min: 1
            }
        )

        $('#options').on('click', '.del_opt', function(){
            var msg = "確定要刪除這個規格？"; 
            if (confirm(msg)==true){ 
                $(this).parent().parent().remove();
            }
        });

        $('#img_field').on('click', '.del_img', function(){
            var msg = "確定要刪除這張圖片？"; 
            if (confirm(msg)==true){ 
                var parent = $(this).closest('.input-group');
                var url = $('input', parent).val();

                if ($.trim(url) !== ''){
                    del_img(url);
                }

                $(this).parent().parent().remove();
                reset_main_img();
            }
        });

        function del_img(url){
            $.post('del_img.php', {url: url, dir: 'products'}, function(data){
                if (result.err_msg === '-1'){
                    alert('登入逾時，請重新登入~!');
                    setTimeout(function(){
                        window.close();
                    }, 1000);
                }

            });
        }


        $('#info_field').on('click', '.del_info', function(){
            var msg = "確定要刪除這張圖片？"; 
            if (confirm(msg)==true){ 
                var parent = $(this).closest('.input-group');
                var url = $('input', parent).val();

                if ($.trim(url) !== ''){
                    del_img(url);
                }

                $(this).parent().parent().remove();
                reset_info_img();
            }
        });


        $('#info_mov_field').on('click', '.del_mov', function(){
            var msg = "確定要刪除這支影片？"; 
            if (confirm(msg)==true){ 
                $(this).parent().parent().remove();
                reset_info_mov();
            }
        });


        function validURL(str) {
          var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
            '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
            '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
            '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
            '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
            '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
          return !!pattern.test(str);
        }


        function create_field(cname, caction, content){
            return `<div class="input-group mb-2 `+cname+`">
                <div class="input-group-prepend">
                <div class="input-group-text">URL</div>
                </div>
                <input type="text" value="`+content+`" class="form-control py-0 img_path" required>
                <div class="input-group-append">
                    <button class="btn btn-md btn-pink m-0 px-3 py-2 z-depth-0 waves-effect `+caction+`" type="button"><i class="fas fa-trash-alt fa-lg"></i></button>
                </div>
                <div class="input-group-append">
                    <div class="file-field">
                        <button class="btn btn-md btn-primary m-0 z-depth-0 waves-effect" type="button">
                          <span class="upbtn"><i class="fas fa-upload mr-1"></i>上傳檔案</span>
                          <input class="up_img" type="file" accept="image/png, image/jpeg">
                        </button>
                    </div>
                </div>
                </div>`;
        }


        $('#new_img').on('click', function(){

            if (typeof(navigator.clipboard)=='undefined') {
                $('#img_field').append(create_field('main_imgs', 'del_img', ''));
                return;
            }

            navigator.clipboard.readText().then(text => {

                var url = text.split('/');

                if (url[0] !== 'https:' && url[0] !== 'http:'){
                    text = '';
                }

                if ($('#google_cloud').is(':checked')){
                    if (url[2] !== 'drive.google.com' || url.length < 5){
                        toastr.error('請複製正確的Google的雲端連結~!');
                        return;
                    }

                    text = 'https://drive.google.com/uc?export=download&id='+url[5];
                }

                $('#img_field').append(create_field('main_imgs', 'del_img', text));
                if (text !== '') reset_main_img();

            })
            .catch(err => {
                  $('#img_field').append(create_field('main_imgs', 'del_img', ''));
            });

        });



        $('body').on('blur', '.img_path', function(e){
            var parent = $(this).closest('.input-group');

            if ($(parent).hasClass('main_imgs')){
                reset_main_img();
            }

            if ($(parent).hasClass('info_imgs')){
                reset_info_img();
            }
        });



        $('#new_info').on('click', function(){

            if (typeof(navigator.clipboard)=='undefined') {
                $('#info_field').append(create_field('info_imgs', 'del_info', ''));
                return;
            }

            navigator.clipboard.readText().then(text => {
                    
                    var url = text.split('/');

                    if (url[0] !== 'https:' && url[0] !== 'http:'){
                        text = '';
                    }

                    if ($('#google_cloud').is(':checked')){
                        if (url[2] !== 'drive.google.com' || url.length < 5){
                            toastr.error('請複製正確的Google的雲端連結~!');
                            return;
                        }

                        text = 'https://drive.google.com/uc?export=download&id='+url[5];
                    }

                    //console.log(text);
                    $('#info_field').append(create_field('info_imgs', 'del_info', text));
                    if (text !== '') reset_info_img();
                })
                .catch(err => {
                    console.log(err);
                      $('#info_field').append(create_field('info_imgs', 'del_info', ''));
                });

        });


        $('#new_movie').on('click', function(){

            if (typeof(navigator.clipboard)=='undefined') {
                var blankfield =    '<div class="input-group mb-2 info_movs"><div class="input-group-prepend"><div class="input-group-text">URL</div></div><input type="text" class="form-control py-0" value="" required><div class="input-group-append"><button class="btn btn-md btn-pink m-0 px-3 py-2 z-depth-0 waves-effect del_mov" type="button"><i class="fas fa-trash-alt fa-lg"></i></button></div></div>';
                $('#info_mov_field').append(blankfield);

                return;
            }

            navigator.clipboard.readText().then(text => {
                    if (!validURL(text)){
                        toastr.error('網址錯誤~!');
                        return;
                    }

                    var imgfield =    '<div class="input-group mb-2 info_movs"><div class="input-group-prepend"><div class="input-group-text">URL</div></div><input type="text" class="form-control py-0" value="'+text+'" required><div class="input-group-append"><button class="btn btn-md btn-pink m-0 px-3 py-2 z-depth-0 waves-effect del_mov" type="button"><i class="fas fa-trash-alt fa-lg"></i></button></div></div>';

                    $('#info_mov_field').append(imgfield);

                    reset_info_mov();
                });
        });




        function reset_main_img(){
            var imgstr =    '';
            $('.main_imgs').each(function(){
                var img = $('input', this).val();
                imgstr += '<div class="col-lg-3 col-md-4 col-sm-6 text-center mt-2"><img onerror="imgError();" class="img-fluid" src="'+img+'"></div>';
            });

            $('#main_images').html(imgstr);
        }


        function imgError(){
            // toastr.error('圖片網址錯誤~!');
        }


        function reset_info_img(){
            var imgstr =    '';
            $('.info_imgs').each(function(){
                var img = $('input', this).val();
                imgstr += '<div class="col-lg-3 col-md-4 col-sm-6 text-center mt-2"><img onerror="imgError();" class="img-fluid" src="'+img+'"></div>';
            });

            $('#info_images').html(imgstr);
        }


        function reset_info_mov(){
            var imgstr =    '';
            $('.info_movs').each(function(){
                var img = $('input', this).val();
                imgstr += '<div class="col-md-6 text-center mt-2"><div class="embed-responsive embed-responsive-16by9"><iframe width="560" height="315" class="embed-responsive-item" src="'+img+'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div></div>';
            });



            $('#info_movies').html(imgstr);
        }



        $('#main_id').on('change', function(){
            var mid = $(this).val();

            $.post('get_sub_class.php', {mid: mid}, function(data){

                var result = JSON.parse(data);

                if (result['err_msg'] === '-1'){
                    alert('登入逾時，請重新登入~!');
                    window.location = 'login.php';
                }

                if (result['err_msg'] !== 'OK'){
                    toastr.error(result.err_msg);
                    return false;
                }

                $('#sub_id').html(result.sub_items);

            })
        });


        $('.opt-item').on('click', function(){
            var oname = $(this).data('oname');
            var opts = $(this).data('opts');

            var ofield =    '<div class="input-group mb-2 opts"><div class="input-group-prepend"><div class="input-group-text">'+oname+'</div></div><input type="text" class="form-control py-0" value="'+opts+'" required><div class="input-group-append"><button class="btn btn-md btn-pink m-0 px-3 py-2 z-depth-0 waves-effect del_opt" type="button"><i class="fas fa-trash-alt fa-lg"></i></button></div></div>';

            $('#options').append(ofield);

        });

        $('.info-item').on('click', function(){
            $('#info').trumbowyg('html', $(this).data('info'));
        });


        $('#new_opt').on('click', function(){
            $('#oname, #opt_items').val('');
            $('#new_option').modal();
        });


        $('#add_opt').on('click', function(){
            var oname = $('#oname').val();
            var opts = $('#opt_items').val();

            if ($.trim(oname) === '' || $.trim(opts) === ''){
                toastr.error('請填入必要欄位~!');
                return;
            }

            var ofield =    '<div class="input-group mb-2 opts"><div class="input-group-prepend"><div class="input-group-text">'+oname+'</div></div><input type="text" class="form-control py-0" value="'+opts+'" required><div class="input-group-append"><button class="btn btn-md btn-pink m-0 px-3 py-2 z-depth-0 waves-effect del_opt" type="button"><i class="fas fa-trash-alt fa-lg"></i></button></div></div>';

            $('#options').append(ofield);

            $('#new_option').modal('hide');
        });


        $('.main_imgs').on('blur', 'input', function(){
            reset_main_img();
        });


        $('.info_imgs').on('blur', 'input', function(){
            reset_info_img();
        });


        $('.info_movs').on('blur', 'input', function(){
            reset_info_mov();
        });



        $(document).ready(function() {
           $('#info')
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
                   // ['image'], 
                   ['strong'],
                   ['justifyLeft', 'justifyCenter', 'justifyFull'],
                   ['horizontalRule'],
                   ['fullscreen']
               ]
           });

       });



        $('#prodform').on('submit', (function (e) {
            e.preventDefault();

            // var sprice = parseInt($('#sprice').val());

            // if (sprice > 0){
            //     var sdate = $('#sdate').val();
            //     if ($.trim(sdate) === ''){
            //         toastr.error('請選擇優惠到期日~!');
            //         return false;
            //     }
            // }

            var opts = [];

            $('.opts').each(function(){
                var oname = $('.input-group-text', this).text();
                var options = $('input', this).val().split(',');
                var obj = {'oname': oname, 'opts': options};

                opts.push(obj);

            });

            $('#optjson').val(JSON.stringify(opts));

            var main_imgs = '';

            $('.main_imgs').each(function(key, value){
                if (key > 0){
                    main_imgs += ','+$('input', this).val();
                } else {
                    main_imgs += $('input', this).val();
                }
            });


            $('#main_imgs').val(main_imgs);

            var info_imgs = '';

            $('.info_imgs').each(function(key, value){
                if (key > 0){
                    info_imgs += ','+$('input', this).val();
                } else {
                    info_imgs += $('input', this).val();
                }
            });


            $('#info_imgs').val(info_imgs);


            var info_movs = '';

            $('.info_movs').each(function(key, value){
                if (key > 0){
                    info_movs += ','+$('input', this).val();
                } else {
                    info_movs += $('input', this).val();
                }
            });


            $('#info_movs').val(info_movs);

            $('#update_btn').html('傳送中<i class="fas fa-circle-notch fa-spin fa-lg ml-2"></i>').parent().addClass('disabled');
            
            $.ajax({
                url: 'prod_update.php',
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(data){
                    var result = JSON.parse(data);

                    $('#update_btn').html('<i class="fas fa-paper-plane fa-lg mr-2"></i>提交').parent().removeClass('disabled');

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

                    toastr.success('更新完成~!');

                    setTimeout(function(){
                        window.close();
                    }, 1000);

                    
                }
            });

        }));

        function getFileName(path) {
            return path.match(/[-_\w]+[.][\w]+$/i)[0];
        }

        $('body').on('change', '.up_img', function(e){
            var fname = getFileName($(this).val());
            var oname = fname.split('.');

            var parent = $(this).closest('.input-group');
            $('.img_path', parent).val(fname);
            $('.upbtn', parent).html('<i class="fas fa-circle-notch fa-spin fa-lg ml-1"></i>上傳中');

            var formData = new FormData;

            formData.append('img', $(this)[0].files[0]);
            formData.append('oname', oname[0]);
            formData.append('dir', 'products');

            $.ajax({
                url: 'upload_img.php',
                enctype: 'multipart/form-data',
                type: "POST",
                data:  formData,
                contentType: false,
                cache: false,
                processData:false,
                error: function (xhr, status, error) {
                    console.log(xhr);
                },
                success: function(data){

                    $('.upbtn', parent).html('<i class="fas fa-upload mr-1"></i>上傳檔案');

                    var result = JSON.parse(data);
                    // console.log(result);
                    // return;
                    if (result['err_msg'] === '-1'){
                        alert('登入逾時，請重新登入~!');
                        setTimeout(function(){
                            window.close();
                        }, 1000);
                        return;
                    }

                    if (result.err_msg !== 'OK'){
                        toastr.error(result.err_msg);
                        return;
                    }

                    $('.img_path', parent).val(result.img);

                    if ($(parent).hasClass('main_imgs')){
                        reset_main_img();
                    }

                    if ($(parent).hasClass('info_imgs')){
                        reset_info_img();
                    }


                }
            });

        });

    </script>
</body>

</html>