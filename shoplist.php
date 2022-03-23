<?php 
    include('./include.php');
    $TotalPrice = 0 ;
?>
<!DOCTYPE html>
<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
<html lang="en">
<?php include('header.php')?>
<link href="css/shoplist.css" rel="stylesheet">
<style>
    .main_form .form_control
    {
        color:#495057; 
    }
.cart-img{width:50px;height:50px}

</style>
<iframe src="./getproduct.php?action=reload" style="display:none"></iframe>
<div class="container">
    <div class="row">
        <div style="width:100%">
            <section class="container my-5">
                <div class="h2 text-secondary text-center">金鼎膳 結帳流程</div>
                <div class="row mt-3">
                    <div class="col-lg-3">
                        <div class="alert alert-primary d-flex flex-column align-items-center alert-rounded ">
                            <small>STEP 1.</small>
                            <i class="fas fa-shopping-cart mb-1"></i>
                            <p class="h5">確認購物清單</p>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="alert alert-light d-flex flex-column align-items-center alert-rounded">
                            <small>STEP 2.</small>
                            <i class="fas fa-info mb-1"></i>
                            <p class="h5">輸入訂購人資料</p>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="alert alert-light d-flex flex-column align-items-center alert-rounded">
                            <small>STEP 3.</small>
                            <i class="fas fa-clipboard-list mb-1"></i>
                            <p class="h5">選擇付款方式</p>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="alert alert-light d-flex flex-column align-items-center alert-rounded">
                            <small>STEP 3.</small>
                            <i class="fas fa-check-circle mb-1"></i>
                            <p class="h5">完成購買</p>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="card mb-2">
                        <div class="card-header">
                            <div class="h4 text-primary text-center">請確認購物清單</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive my-3">
                                <form action="post" id="form1" >
                                    <table class="table">
                                        <?php foreach($_SESSION['product_item'] as $row) { ?>
                                        <tr>
                                            <td>
                                                <a href="#" class="far fa-trash-alt text-danger removeCart" data-price="<?=$row['price']?>" data-name="<?=$row['pname']?>" ></a>
                                            </td>
                                            <td class="cart-title" ><?=$row['pname']?></td>
                                            <td>
                                                <img src="<?=$row['images']?>" alt="商品圖" class="cart-img" />
                                            </td>
                                            <td class="d-flex align-items-center">
                                                <button type="button" class="btn" onclick="minusItem(<?=$row['id']?>)">
                                                    <i class="fas fa-minus text-primary"></i>
                                                </button>
                                                <p style="padding: 0 13px;"  class="count<?=$row['id']?>" id="count<?=$row['id']?>" > 1  </p>
                                                <button type="button" class="btn" onclick="plusItem(<?=$row['id']?>)">
                                                    <i class="fas fa-plus text-primary"></i>
                                                </button>
                                            </td>
                                            <td><?=$row['opts']?></td>
                                            <td class="text-right" id="productprice<?=$row['id']?>" data-price="<?=$row['price']?>">NT$:<?=$row['price']?></td>
                                        </tr>
                                        <?php 
                                            $TotalPrice += $row['price'];
                                            } 
                                        ?>
                                        <tr>
                                            <td class="text-right" colspan="5">總計</td>
                                            <td class="text-right TotalPrice">
                                                <p id="total"><?=$TotalPrice?></p>
                                                <input type="hidden" name="totalprice" value="<?=$TotalPrice?>"/>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                                <div class="text-right text-success mb-2">
                                    如有折扣碼可於確認購買後輸入
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="h4 text-center">訂購須知</div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-10">
                                <div class="card-body">
                                    <ul class="container list-style-none">
                                        <li>
                                            ※ 請確認所填寫的資料是否正確，下單後未提供修改付款方式服務。
                                        </li>
                                        <li>
                                            ※
                                            因家禽每隻肉質、大小不同，圖片僅供參考，實際請以收到商品為準。
                                        </li>
                                        <li>
                                            ※ 本店商品目前只供應台灣地區，只提供店內自取及宅配到府
                                        </li>
                                        <li>※ 若購買黃金畜牧產品，皆以低溫冷藏配送。</li>
                                        <li>※ 本店商品為統一會於付款後7個工作日內出貨(不含假日)。</li>
                                    </ul>
                                    <div class="d-flex justify-content-end">
                                        <input type="button" class="btn btn-primary" id="CarFrom" value="確認購買">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<?php include('footer.php') ?>
<script>
var total = <?=$TotalPrice?>;

function minusItem(item){
    var count = $('#count'+item).text();
    var price = $('#productprice'+item).data('price');
    var p = $('#productprice'+item).data('price');
    count = parseInt(count) - 1 ;
    if(count < 0)
    {
        $('#productprice'+item).empty();
        $('#productprice'+item).append("NT:$0");    
        $('#count'+item).empty();
        $('#count'+item).append(0);    
        $('#count'+item).val(0);
    }else{
        price = parseInt(price)*parseInt(count);
        total = parseInt(total) - p
        $('#productprice'+item).empty();
        $('#productprice'+item).append("NT:$"+price); 
        $('#count'+item).empty();
        $('#count'+item).append(count);
        $('#count'+item).val(count);
        $('#total').empty();
        $('#total').append(total);
        $.ajax({
            url:"./getproduct.php?action=update",
            method:"post",
            data:{
            id:item,
            count:count
            },success: function (response) {
                console.log(response)
        }
    });
    }
    
}
function plusItem(item){
    var count = $('#count'+item).text();
    var price = $('#productprice'+item).data('price');
    var p = $('#productprice'+item).data('price');
    count = parseInt(count)+1;
    price = parseInt(price)*parseInt(count);
    total = total + p;
    $('#productprice'+item).empty();
    $('#productprice'+item).append("NT:$"+price); 
    $('#count'+item).empty();
    $('#count'+item).append(count);
    $('#count'+item).val(count);
    $('#total').empty();
    $('#total').append(total);
    $.ajax({
        url:"./getproduct.php?action=update",
        method:"post",
        data:{
        id:item,
        count:count
        },success: function (response) {
            console.log(response)
        }
    });
}
$('#CarFrom').click(function(){
    location.href='./orderfrom.php';
});
</script>
</body>
</html>