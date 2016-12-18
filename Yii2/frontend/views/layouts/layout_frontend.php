<!DOCTYPE html>
<html lang="zh-cn">
<head>
  <!-- Meta -->
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="keywords" content="MediaCenter, Template, eCommerce">
  <meta name="robots" content="all">

  <title>妞妈手工烘焙</title>
  <!-- Bootstrap Core CSS -->
  <link rel="stylesheet" href="statics/css/bootstrap.min.css">

  <!-- Customizable CSS -->
  <link rel="stylesheet" href="statics/css/main.css">
  <link rel="stylesheet" href="statics/css/red.css">
  <link rel="stylesheet" href="statics/css/owl.carousel.css">
  <link rel="stylesheet" href="statics/css/owl.transitions.css">
  <link rel="stylesheet" href="statics/css/animate.min.css">



  <!-- Icons/Glyphs -->
  <link rel="stylesheet" href="statics/css/font-awesome.min.css">

  <!-- Favicon -->
  <link rel="shortcut icon" href="statics/images/favicon.ico">




  <!-- HTML5 elements and media queries Support for IE8 : HTML5 shim and Respond.js -->
  <!--[if lt IE 9]>
  <script src="statics/js/html5shiv.js"></script>
  <script src="statics/js/respond.min.js"></script>
  <![endif]-->


</head>
<body>

<div class="wrapper">
  <!-- ============================================================= TOP NAVIGATION ============================================================= -->
  <nav class="top-bar animate-dropdown">
    <div class="container">
      <div class="col-xs-12 col-sm-6 no-margin">
        <ul>
          <li><a href="<?php echo yii\helpers\Url::to(['index/index']) ?>">首页</a></li>
          <?php if (\Yii::$app->session['is_login'] == 1): ?>
            <li><a href="<?php echo yii\helpers\Url::to(['cart/index']) ?>">我的购物车</a></li>
            <li><a href="<?php echo yii\helpers\Url::to(['order/index']) ?>">我的订单</a></li>
          <?php endif; ?>
        </ul>
      </div><!-- /.col -->

      <div class="col-xs-12 col-sm-6 no-margin">
        <ul class="right">
          <?php if (\Yii::$app->session['is_login'] == 1): ?>
            您好 , 欢迎您回来 <?php echo \Yii::$app->session['loginName']; ?> , <a href="<?php echo yii\helpers\Url::to(['member/logout']); ?>">退出</a>
          <?php else: ?>
            <li><a href="<?php echo yii\helpers\Url::to(['member/auth']); ?>">注册</a></li>
            <li><a href="<?php echo yii\helpers\Url::to(['member/auth']); ?>">登录</a></li>
          <?php endif; ?>
        </ul>
      </div><!-- /.col -->
    </div><!-- /.container -->
  </nav><!-- /.top-bar -->
  <!-- ============================================================= TOP NAVIGATION : END ============================================================= -->		<!-- ============================================================= HEADER ============================================================= -->
  <header>
    <div class="container no-padding">

      <div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
        <!-- ============================================================= LOGO ============================================================= -->
        <div class="logo">
          <a href="<?php echo yii\helpers\Url::to(['index/index']) ?>">
            <img alt="logo" src="statics/images/logo.PNG" width="160" height="80"/>
          </a>
        </div><!-- /.logo -->
        <!-- ============================================================= LOGO : END ============================================================= -->		</div><!-- /.logo-holder -->

      <div class="col-xs-12 col-sm-12 col-md-6 top-search-holder no-margin">
        <div class="contact-row">
          <div class="phone inline">
            <i class="fa fa-phone"></i> (+086) 400 800 6666
          </div>
          <div class="contact inline">
            <i class="fa fa-envelope"></i> 10242879@<span class="le-color">niuniuma.com</span>
          </div>
        </div><!-- /.contact-row -->
        <!-- ============================================================= SEARCH AREA ============================================================= -->
        <div class="search-area">
          <form>
            <div class="control-group">
              <input class="search-field" placeholder="吃点什么搜搜看" />

              <ul class="categories-filter animate-dropdown">
                <li class="dropdown">

                  <a class="dropdown-toggle"  data-toggle="dropdown" href="category-grid.html">所有分类</a>

                  <ul class="dropdown-menu" role="menu" >
                    <?php foreach ($this->params['menu'] as $top):?>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?=yii\helpers\Url::to(['product/index','cate_id'=>$top['cate_id']]);?>"><?=$top['title'];?></a></li>
                    <?php endforeach;?>
                  </ul>
                </li>
              </ul>

              <a style="padding:15px 15px 13px 12px" class="search-button" href="#" ></a>

            </div>
          </form>
        </div><!-- /.search-area -->
        <!-- ============================================================= SEARCH AREA : END ============================================================= -->		</div><!-- /.top-search-holder -->
<?php if(Yii::$app->session['is_login']==1):?>
      <div class="col-xs-12 col-sm-12 col-md-3 top-cart-row no-margin">
        <div class="top-cart-row-container">

          <!-- ============================================================= SHOPPING CART DROPDOWN ============================================================= -->
          <div class="top-cart-holder dropdown animate-dropdown">

            <div class="basket">

              <a id="dropdown-toggle" class="dropdown-toggle" data-toggle="dropdown" href="#">
                <div class="basket-item-count">
                  <span class="count" id="cart_count"><?=count($this->params['cart']['products']);?></span>
                  <img src="statics/images/icon-cart.png" alt="" />
                </div>

                <div class="total-price-basket">
                  <span class="lbl">您的购物车:</span>
                  <span class="total-price">
                    <span class="sign">￥</span><span class="value" id="cart_total"><?=$this->params['cart']['total'];?></span>
                    </span>
                </div>
              </a>

              <ul id="dropdown-menu" class="dropdown-menu">

                <li class="checkout">
                  <div class="basket-item">
                    <div class="row">
                      <div class="col-xs-12 col-sm-6">
                        <a href="<?php echo yii\helpers\Url::to(['cart/index']) ?>" class="le-button inverse">查看购物车</a>
                      </div>
                      <div class="col-xs-12 col-sm-6">
                        <a href="<?php echo yii\helpers\Url::to(['cart/index']) ?>" class="le-button">去往收银台</a>
                      </div>
                    </div>
                  </div>
                </li>

              </ul>
            </div><!-- /.basket -->
          </div><!-- /.top-cart-holder -->
        </div><!-- /.top-cart-row-container -->
        <!-- ============================================================= SHOPPING CART DROPDOWN : END ============================================================= -->		</div><!-- /.top-cart-row -->
      <?php endif;?>

    </div><!-- /.container -->
  </header>
  <?php echo $content; ?>
  <footer id="footer" class="color-bg">

    <div class="container">
      <div class="row no-margin widgets-row">
        <div class="col-xs-12  col-sm-4 no-margin-left">
          <!-- ============================================================= FEATURED PRODUCTS ============================================================= -->
          <div class="widget">
            <h2>推荐商品</h2>
            <div class="body">
              <ul>
                <?php foreach($this->params['tui'] as $pro): ?>
                  <li>
                    <div class="row">
                      <div class="col-xs-12 col-sm-9 no-margin">
                        <a href="<?php echo yii\helpers\Url::to(['product/detail', 'product_id' => $pro->product_id]); ?>"><?php echo $pro->title ?></a>
                        <div class="price">
                          <div class="price-prev">￥<?php echo $pro->price ?></div>
                          <div class="price-current">￥<?php echo $pro->sale_price ?></div>
                        </div>
                      </div>

                      <div class="col-xs-12 col-sm-3 no-margin">
                        <a href="<?php echo yii\helpers\Url::to(['product/detail', 'product_id' => $pro->product_id]) ?>" class="thumb-holder">
                          <img alt="" src="//<?php echo $pro->cover ?>-picsmall" data-echo="//<?php echo $pro->cover ?>-picsmall" />
                        </a>
                      </div>
                    </div>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div><!-- /.body -->
          </div> <!-- /.widget -->
          <!-- ============================================================= FEATURED PRODUCTS : END ============================================================= -->            </div><!-- /.col -->

        <div class="col-xs-12 col-sm-4 ">
          <!-- ============================================================= ON SALE PRODUCTS ============================================================= -->
          <div class="widget">
            <h2>热卖商品</h2>
            <div class="body">
              <ul>
                <?php foreach($this->params['hot'] as $pro): ?>
                  <li>
                    <div class="row">
                      <div class="col-xs-12 col-sm-9 no-margin">
                        <a href="<?php echo yii\helpers\Url::to(['product/detail', 'product_id' => $pro->product_id]); ?>"><?php echo $pro->title ?></a>
                        <div class="price">
                          <div class="price-prev">￥<?php echo $pro->price ?></div>
                          <div class="price-current">￥<?php echo $pro->sale_price ?></div>
                        </div>
                      </div>

                      <div class="col-xs-12 col-sm-3 no-margin">
                        <a href="<?php echo yii\helpers\Url::to(['product/detail', 'product_id' => $pro->product_id]) ?>" class="thumb-holder">
                          <img alt="" src="//<?php echo $pro->cover ?>-picsmall" data-echo="//<?php echo $pro->cover ?>-picsmall" />
                        </a>
                      </div>
                    </div>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div><!-- /.body -->
          </div> <!-- /.widget -->
          <!-- ============================================================= ON SALE PRODUCTS : END ============================================================= -->            </div><!-- /.col -->

        <div class="col-xs-12 col-sm-4 ">
          <!-- ============================================================= TOP RATED PRODUCTS ============================================================= -->
          <div class="widget">
            <h2>最新商品</h2>
            <div class="body">
              <ul>
                <?php foreach($this->params['new'] as $pro): ?>
                  <li>
                    <div class="row">
                      <div class="col-xs-12 col-sm-9 no-margin">
                        <a href="<?php echo yii\helpers\Url::to(['product/detail', 'product_id' => $pro->product_id]); ?>"><?php echo $pro->title ?></a>
                        <div class="price">
                          <div class="price-prev">￥<?php echo $pro->price ?></div>
                          <div class="price-current">￥<?php echo $pro->sale_price ?></div>
                        </div>
                      </div>

                      <div class="col-xs-12 col-sm-3 no-margin">
                        <a href="<?php echo yii\helpers\Url::to(['product/detail', 'product_id' => $pro->product_id]) ?>" class="thumb-holder">
                          <img alt="" src="//<?php echo $pro->cover ?>-picsmall" data-echo="//<?php echo $pro->cover ?>-picsmall" />
                        </a>
                      </div>
                    </div>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div><!-- /.body -->
          </div><!-- /.widget -->
          <!-- ============================================================= TOP RATED PRODUCTS : END ============================================================= -->            </div><!-- /.col -->

      </div><!-- /.widgets-row-->
    </div><!-- /.container --><!-- /.sub-form-row -->


    <div class="sub-form-row">
      <!--<div class="container">
          <div class="col-xs-12 col-sm-8 col-sm-offset-2 no-padding">
              <form role="form">
                  <input placeholder="Subscribe to our newsletter">
                  <button class="le-button">Subscribe</button>
              </form>
          </div>
      </div>--><!-- /.container -->
    </div><!-- /.sub-form-row -->

    <div class="link-list-row">
      <div class="container no-padding">
        <div class="col-xs-12 col-md-4 ">
          <!-- ============================================================= CONTACT INFO ============================================================= -->
          <div class="contact-info">
            <div class="footer-logo">
              <img alt="logo" src="statics/images/logo.PNG" width="240" height="139"/>
            </div><!-- /.footer-logo -->

            <p class="regular-bold"> 请通过电话，电子邮件随时联系我们</p>

            <p>
              陆家嘴金融贸易区，浦东新区, 上海市, 中国
              <br>妞妈在线 (QQ:10242879)
            </p>

            <div class="social-icons">
                <h3>Get in touch</h3>
                <ul>
                    <li><a href="http://facebook.com/transvelo" class="fa fa-facebook"></a></li>
                    <li><a href="#" class="fa fa-twitter"></a></li>
                    <li><a href="#" class="fa fa-pinterest"></a></li>
                    <li><a href="#" class="fa fa-linkedin"></a></li>
                    <li><a href="#" class="fa fa-stumbleupon"></a></li>
                    <li><a href="#" class="fa fa-dribbble"></a></li>
                    <li><a href="#" class="fa fa-vk"></a></li>
                </ul>
            </div><!-- /.social-icons -->

          </div>
          <!-- ============================================================= CONTACT INFO : END ============================================================= -->            </div>

        <div class="col-xs-12 col-md-8 no-margin">
          <!-- ============================================================= LINKS FOOTER ============================================================= -->
          <!-- /.link-widget -->

          <!-- /.link-widget -->
          <!-- ============================================================= LINKS FOOTER : END ============================================================= -->            </div>
      </div><!-- /.container -->
    </div><!-- /.link-list-row -->

    <div class="copyright-bar">
      <div class="container">
        <div class="col-xs-12 col-sm-6 no-margin">
          <div class="copyright">
            &copy; <a href="<?php echo yii\helpers\Url::to(['index/index']) ?>">Niuniuma.top</a> - all rights reserved
          </div><!-- /.copyright -->
        </div>
        <div class="col-xs-12 col-sm-6 no-margin">
          <div class="payment-methods ">
            <ul>
              <li><img alt="" src="statics/images/payments/payment-visa.png"></li>
              <li><img alt="" src="statics/images/payments/payment-master.png"></li>
              <li><img alt="" src="statics/images/payments/payment-paypal.png"></li>
              <li><img alt="" src="statics/images/payments/payment-skrill.png"></li>
            </ul>
          </div><!-- /.payment-methods -->
        </div>
      </div><!-- /.container -->
    </div><!-- /.copyright-bar -->

  </footer><!-- /#footer -->
  <!-- ============================================================= FOOTER : END ============================================================= -->	</div><!-- /.wrapper -->

<!-- JavaScripts placed at the end of the document so the pages load faster -->
<script src="statics/js/jquery-1.10.2.min.js"></script>
<script src="statics/js/jquery-migrate-1.2.1.js"></script>
<script src="statics/js/bootstrap.min.js"></script>
<script src="statics/js/gmap3.min.js"></script>
<script src="statics/js/bootstrap-hover-dropdown.min.js"></script>
<script src="statics/js/owl.carousel.min.js"></script>
<script src="statics/js/css_browser_selector.min.js"></script>
<script src="statics/js/echo.min.js"></script>
<script src="statics/js/jquery.easing-1.3.min.js"></script>
<script src="statics/js/bootstrap-slider.min.js"></script>
<script src="statics/js/jquery.raty.min.js"></script>
<script src="statics/js/jquery.prettyPhoto.min.js"></script>
<script src="statics/js/jquery.customSelect.min.js"></script>
<script src="statics/js/wow.min.js"></script>
<script src="statics/js/scripts.js"></script>
<!-- toastr--jQuery-->
<link href="statics/toastr/toastr.min.css" rel="stylesheet"/>
<script src="statics/toastr/toastr.min.js"></script>
<script type="text/javascript">
  toastr.options.positionClass = 'toast-center-center';
  toastr.options.timeOut = "2000";
</script>
<script>
  $("#createlink").click(function(){
    $(".billing-address").slideDown();
  });
  $(".minus").click(function(){
    var cart_id = $("input[name=productnum]").attr('id');
    var num = parseInt($("input[name=productnum]").val()) - 1;
    if (parseInt($("input[name=productnum]").val()) <= 1) {
      var num = 1;
    }
    var total = parseFloat($(".value.pull-right span").html());
    var price = parseFloat($(".price span").html());
    changeNum(cart_id, num);
    var p = total - price;
    if (p < 0) {
      var p = "0";
    }
    $(".value.pull-right span").html(p + "");
    $(".value.pull-right.ordertotal span").html(p + "");
  });
  $(".plus").click(function(){
    var cart_id = $("input[name=productnum]").attr('id');
    var num = parseInt($("input[name=productnum]").val()) + 1;
    var total = parseFloat($(".value.pull-right span").html());
    var price = parseFloat($(".price span").html());
    changeNum(cart_id, num);
    var p = total + price;
    $(".value.pull-right span").html(p + "");
    $(".value.pull-right.ordertotal span").html(p + "");
  });
  function changeNum(cart_id, num)
  {
    $.get('<?php echo yii\helpers\Url::to(['cart/mod']) ?>', {'product_num':num, 'cart_id':cart_id}, function(data){
      location.reload();
    });
  }
  var total = parseFloat($("#total span").html());
  $(".le-radio.express").click(function(){
    var ototal = parseFloat($(this).attr('data')) + total;
    $("#ototal span").html(ototal);
  });
  $("input.address").click(function(){
    var addressid = $(this).val();
    $("input[name=addressid]").val(addressid);
  });
  //ajax修改点击加入购物车后弹出商品已加入到购物车，并写入数据库
  function addCart(pid) {
    $.get('<?php echo yii\helpers\Url::to(['cart/add']) ?>', {'product_id':pid}, function(data) {
      toastr.success("成功加入购物车!"); //此处在php页中需要加入判断添加情况
      var total = parseFloat($("#cart_total").html());
      var price = parseFloat($("#price"+pid).html());
      var p = total + price;
      $("#cart_total").html(p+ "");
      if(data==1){
        var cartCount = parseInt($("#cart_count").html())+1;
        $("#cart_count").html(cartCount);
      }
      //location.reload(); //此处不用重新载入，而是通过上面判断后来更新顶端购物车的数量及价格 此处省略　                                     通过json返回1或0来更新购物车的商品数量，得到更好的用户体验
    });
  }
//  $("a.le-button:contains(加入购物车)").click(function () {
//
//    toastr.success("成功加入购物车!");
//
//  });
  //点击公共页购物车，ajax异步刷新点选页
  $('#dropdown-toggle').click(function () {
    $('.cart_list').remove();
    $('#dropdown-menu').prepend('<li class="cart_list"><img class="img-responsive center-block" src="statics/images/AjaxLoader.gif"></li>');
    $.ajax({
      url:'<?=yii\helpers\Url::to(['cart/ajax-cart-list']);?>',
      dataType:'json',
      type:'get',
      success : function (data) {
        var html ='';
        $(data).each(function (k,v) {
          html+='<li class="cart_list">';
          html+='<div class="basket-item">';
          html+='<div class="row">';
          html+='<div class="col-xs-4 col-sm-4 no-margin text-center">';
          html+='<div class="thumb">';
          html+='<img alt="" src="//'+v.cover+'-coversmall" />';
          html+='</div>';
          html+='</div>';
          html+='<div class="col-xs-8 col-sm-8 no-margin">';
          html+='<a href="<?=yii\helpers\Url::to(["product/detail","product_id"=>""]);?>'+v.product_id+'">';
          html+='<div class="title" style="color:#1A1A1A">'+v.title+'</div>';
          html+='</a>';
          html+='<div class="price">￥<span id="price'+v.cart_id+'">'+ v.price+'</span>   X <span id="cart_id'+v.cart_id+'"> '+v.num+'</span></div>';
          html+='</div></div>';
          html+='<a class="close-btn" href="javascript:del_cart('+v.cart_id+')"></a>';
          html+='</div>';
          html+='</li>';
        });
        $('.cart_list').remove();
        $('#dropdown-menu').prepend(html);
      }
    });
  });
  //ajax删除购物车商品
  function del_cart(cart_id) {
    var url = '<?=yii\helpers\Url::to(['cart/del']) ?>';
    var data = {'cart_id':cart_id};
    $.get(url,data,function ($e) {
      if($e==1){
        toastr.success("商品删除成功!");
        //修改购物车总价，定单总价
        var price = parseFloat($('#price'+cart_id).html());
        var num = parseInt($('#cart_id'+cart_id).html());
        var total = parseFloat($("#cart_total").html());
        var p = total-price*num;
        var cartCount = parseInt($("#cart_count").html())-1;
        $(".value.pull-right span").html(p + "");
        $(".value.pull-right.ordertotal span").html(p + "");
        $("#cart_total").html(p+ "");
        $("#cart_count").html(cartCount);
        //删除节点
        $('#del_cart'+cart_id).remove();
      }else if($e==0){
        toastr.warning("**删除失败请重试**");
      }else{
        toastr.error("**参数错误请与管理员联系**");
      }
    });
  }
</script>

</body>
</html>
