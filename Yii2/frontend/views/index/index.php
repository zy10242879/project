<!-- ============================================================= HEADER : END ============================================================= -->		<div id="top-banner-and-menu">
    <div class="container">

        <div class="col-xs-12 col-sm-4 col-md-3 sidemenu-holder">
            <!-- ================================== TOP NAVIGATION ================================== -->
            <div class="side-menu animate-dropdown">
                <div class="head"><i class="fa fa-list"></i> 所有分类 </div>
                <nav class="yamm megamenu-horizontal" role="navigation">
                    <ul class="nav">
                        <?php
                        foreach($this->params['menu'] as $top) :
                            ?>
                            <li class="dropdown menu-item">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $top['title'] ?></a>
                                <ul class="dropdown-menu mega-menu">
                                    <li class="yamm-content">
                                        <!-- ================================== MEGAMENU VERTICAL ================================== -->
                                        <div class="row">
                                            <div class="col-xs-12 col-lg-4">
                                                <ul>
                                                    <?php foreach($top['children'] as $child): ?>
                                                        <li><a href="<?php echo yii\helpers\Url::to(['product/index', 'cate_id' => $child['cate_id']]) ?>"><?php echo $child['title'] ?></a></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                            <div class="dropdown-banner-holder">
                                                <a href="#"><img alt="" src="/statics/images/banners/banner-side.png" />遍历图床照片</a>
                                            </div>
                                        </div>
                                        <!-- ================================== MEGAMENU VERTICAL ================================== -->
                                    </li>
                                </ul>
                            </li><!-- /.menu-item -->
                            <?php
                        endforeach;
                        ?>
                        <!--<li><a href="http://themeforest.net/item/media-center-electronic-ecommerce-html-template/8178892?ref=shaikrilwan">Buy this Theme</a></li>-->
                    </ul><!-- /.nav -->
                </nav><!-- /.megamenu-horizontal -->
            </div><!-- /.side-menu -->
            <!-- ================================== TOP NAVIGATION : END ================================== -->		</div><!-- /.sidemenu-holder -->

        <div class="col-xs-12 col-sm-8 col-md-9 homebanner-holder">
            <!-- ========================================== SECTION – HERO ========================================= -->

            <div id="hero">
                <div id="owl-main" class="owl-carousel owl-inner-nav owl-ui-sm">

                    <div class="item" style="background-image: url(/statics/images/sliders/slider01.jpg);">
                        <div class="container-fluid">
<!--                            <div class="caption vertical-center text-left">-->
<!--                                <div class="big-text fadeInDown-1">-->
<!--                                    最高优惠<span class="big"><span class="sign">￥</span>400</span>-->
<!--                                </div>-->
<!---->
<!--                                <div class="excerpt fadeInDown-2">-->
<!--                                    潮玩生活<br>-->
<!--                                    享受生活<br>-->
<!--                                    引领时尚-->
<!--                                </div>-->
<!--                                <div class="small fadeInDown-2">-->
<!--                                    最后 5 天限时抢购-->
<!--                                </div>-->
<!--                                <div class="button-holder fadeInDown-3">-->
<!--                                    <a href="#" class="big le-button ">去购买</a>-->
<!--                                </div>-->
<!--                            </div><!-- /.caption -->
                        </div><!-- /.container-fluid -->
                    </div><!-- /.item -->

                    <div class="item" style="background-image: url(/statics/images/sliders/slider02.jpg);">
                      <div class="container-fluid">
<!--                        <div class="caption vertical-center text-left">-->
<!--                          <div class="big-text fadeInDown-1">-->
<!--                            想获得<span class="big"><span class="sign">￥</span>200</span>的优惠？-->
<!--                          </div>-->
<!---->
<!--                          <div class="excerpt fadeInDown-2">-->
<!--                            速速前来 <br>快速抢购<br>-->
<!--                          </div>-->
<!--                          <div class="small fadeInDown-2">-->
<!--                            优惠等你拿-->
<!--                          </div>-->
<!--                          <div class="button-holder fadeInDown-3">-->
<!--                            <a href="#" class="big le-button ">去购买</a>-->
<!--                          </div>-->
<!--                        </div><!-- /.caption -->
                    </div><!-- /.container-fluid -->
                    <!--</div>--><!-- /.item -->

                </div><!-- /.owl-carousel -->
            </div>

            <!-- ========================================= SECTION – HERO : END ========================================= -->
        </div><!-- /.homebanner-holder -->

    </div><!-- /.container -->
</div><!-- /#top-banner-and-menu -->

<!-- ========================================= HOME BANNERS ========================================= -->
<section id="banner-holder" class="wow fadeInUp">
    <div class="container">
        <div class="col-xs-12 col-lg-6 no-margin banner">
            <a href="<?=yii\helpers\Url::to(['product/index']);?>">
                <div class="banner-text theblue">
                    <h1 style="font-family:'Microsoft Yahei';">尝尝鲜</h1>
<!--                    <span class="tagline">查看最新分类</span>-->
                </div>
                <img class="banner-image" alt="" src="/statics/images/blank.gif" data-echo="/statics/images/banners/banner-narrow-01.jpg" />
            </a>
        </div>
        <div class="col-xs-12 col-lg-6 no-margin text-right banner">
            <a href="<?=yii\helpers\Url::to(['product/index']);?>">
                <div class="banner-text right">
                    <h1 style="font-family:'Microsoft Yahei';">半价</h1>
<!--                    <span class="tagline">查看最新上架</span>-->
                </div>
                <img class="banner-image" alt="" src="/statics/images/blank.gif" data-echo="/statics/images/banners/banner-narrow-02.jpg" />
            </a>
        </div>
    </div><!-- /.container -->
</section><!-- /#banner-holder -->
<!-- ========================================= HOME BANNERS : END ========================================= -->
<div id="products-tab" class="wow fadeInUp">
    <div class="container">
        <div class="tab-holder">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" >
                <li class="active"><a href="#featured" data-toggle="tab">推荐商品</a></li>
                <li><a href="#new-arrivals" data-toggle="tab">最新上架</a></li>
                <li><a href="#top-sales" data-toggle="tab">最佳热卖</a></li>
              <li>
                <a class="btn" href="#">
                  <i class="fa fa-plus"></i>
                  查看更多</a>
              </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="featured">
                    <div class="product-grid-holder">
                        <?php foreach ($this->params['tui'] as $pro): ?>
                            <div class="col-sm-4 col-md-3  no-margin product-item-holder hover">
                                <div class="product-item">
                                    <?php if ($pro->is_hot): ?>
                                        <div class="ribbon red"><span>HOT</span></div>
                                    <?php endif; ?>
                                    <?php if ($pro->is_sale): ?>
                                        <div class="ribbon green"><span>sale</span></div>
                                    <?php endif; ?>
                                    <?php if ($pro['is_tui']): ?>
                                        <div class="ribbon blue"><span>recommond</span></div>
                                    <?php endif; ?>
                                    <div class="image">
                                        <a href="<?=yii\helpers\Url::to(['product/detail','product_id'=>$pro->product_id]);?>">
                                        <img alt="<?php echo $pro->title ?>" src="" data-echo="//<?php echo $pro->cover ?>-covermiddle" />
                                        </a>
                                    </div>
                                    <div class="body">
                                        <?php if($pro['is_sale']): ?>
                                            <div class="label-discount green"><?php echo round($pro['sale_price']/$pro['price']*100, 0) ?>% sale</div>
                                        <?php endif; ?>
                                        <div class="title">
                                            <a href="<?php echo yii\helpers\Url::to(['product/detail', 'product_id' => $pro->product_id]) ?>"><?php echo $pro->title ?></a>
                                        </div>
                                    </div>
                                    <div class="prices">
                                        <div class="price-prev">￥<?php echo $pro->price;?></div>
                                        <div class="price-current pull-right"  >￥<span id="price<?=$pro->product_id;?>"><?php echo $pro->sale_price ?></span></div>
                                    </div>

                                    <div class="hover-area">
                                        <div class="add-cart-button">
                                            <a href="javascript:addCart(<?=$pro->product_id;?>)" class="le-button">加入购物车</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>


                </div>
                <div class="tab-pane" id="new-arrivals">
                    <div class="product-grid-holder">
                        <?php foreach ($this->params['new'] as $pro): ?>
                            <div class="col-sm-4 col-md-3  no-margin product-item-holder hover">
                                <div class="product-item">
                                    <?php if ($pro->is_hot): ?>
                                        <div class="ribbon blue"><span>new</span></div>
                                        <div class="ribbon red"><span>HOT</span></div>
                                    <?php endif; ?>
                                    <?php if ($pro->is_sale): ?>
                                        <div class="ribbon green"><span>sale</span></div>
                                    <?php endif; ?>
                                    <div class="image">
                                        <a href="<?=yii\helpers\Url::to(['product/detail','product_id'=>$pro->product_id]);?>">
                                        <img alt="<?php echo $pro->title ?>" src="" data-echo="//<?php echo $pro->cover ?>-covermiddle" />
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="title">
                                            <a href="<?php echo yii\helpers\Url::to(['product/detail', 'product_id' => $pro->product_id]) ?>"><?php echo $pro->title ?></a>
                                        </div>
                                    </div>
                                    <div class="prices">
                                        <div class="price-prev">￥<?php echo $pro->price ?></div>
                                        <div class="price-current pull-right">￥<span id="price<?=$pro->product_id;?>"><?php echo $pro->sale_price ?></span></div>
                                    </div>

                                    <div class="hover-area">
                                        <div class="add-cart-button">
                                            <a href="javascript:addCart(<?=$pro->product_id;?>)" class="le-button">加入购物车</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>


                </div>

                <div class="tab-pane" id="top-sales">
                    <div class="product-grid-holder">
                        <?php foreach ($this->params['hot'] as $pro): ?>
                            <div class="col-sm-4 col-md-3  no-margin product-item-holder hover">
                                <div class="product-item">
                                    <?php if ($pro->is_hot): ?>
                                        <div class="ribbon red"><span>HOT</span></div>
                                    <?php endif; ?>
                                    <?php if ($pro->is_sale): ?>
                                        <div class="ribbon green"><span>sale</span></div>
                                    <?php endif; ?>

                                    <div class="image">
                                        <a href="<?=yii\helpers\Url::to(['product/detail','product_id'=>$pro->product_id]);?>">
                                        <img alt="<?php echo $pro->title ?>" src="" data-echo="//<?php echo $pro->cover ?>-covermiddle" />
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="title">
                                            <a href="<?php echo yii\helpers\Url::to(['product/detail', 'product_id' => $pro->product_id]) ?>"><?php echo $pro->title ?></a>
                                        </div>
                                    </div>
                                    <div class="prices">
                                        <div class="price-prev">￥<?php echo $pro->price ?></div>
                                        <div class="price-current pull-right">￥<span id="price<?=$pro->product_id;?>"><?php echo $pro->sale_price ?></span></div>
                                    </div>

                                    <div class="hover-area">
                                        <div class="add-cart-button">
                                            <a href="javascript:addCart(<?=$pro->product_id;?>)" class="le-button">加入购物车</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>


                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- ========================================= BEST SELLERS ========================================= -->
<section id="bestsellers" class="color-bg wow fadeInUp">
    <div class="container">
        <h1 class="section-title">最新商品</h1>

        <div class="product-grid-holder medium">
            <div class="col-xs-12 col-md-7 no-margin">

                <div class="row no-margin">
                    <?php for ($i = 0;$i < 3;$i++): ?>
                        <?php if (empty($this->params['all'][$i])) continue; ?>
                        <div class="col-xs-12 col-sm-4 no-margin product-item-holder size-medium hover">
                            <div class="product-item">
                                <div class="image">
                                    <a href="<?=yii\helpers\Url::to(['product/detail','product_id'=>$this->params['all'][$i]->product_id]);?>">
                                    <img alt="<?php echo $this->params['all'][$i]->title ?>" src="" data-echo="//<?php echo $this->params['all'][$i]->cover ?>-covermiddle" />
                                    </a>
                                </div>
                                <div class="body">
                                    <div class="label-discount clear"></div>
                                    <div class="title">
                                        <a href="<?php echo yii\helpers\Url::to(['product/detail', 'product_id' => $this->params['all'][$i]->product_id]); ?>"><?php echo $this->params['all'][$i]->title ?></a>
                                    </div>
                                </div>
                                <div class="prices">
                                    <div class="price-current text-right">￥<span id="price<?=$this->params['all'][$i]->product_id;?>"><?php echo $this->params['all'][$i]->sale_price ?></span></div>
                                </div>
                                <div class="hover-area">
                                    <div class="add-cart-button">
                                        <a href="javascript:addCart(<?=$this->params['all'][$i]->product_id;?>)" class="le-button">加入购物车</a>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.product-item-holder -->
                    <?php endfor; ?>
                </div><!-- /.row -->

                <div class="row no-margin">
                    <?php for ($i = 3;$i < 6;$i++): ?>
                        <?php if (empty($this->params['all'][$i])) continue; ?>
                        <div class="col-xs-12 col-sm-4 no-margin product-item-holder size-medium hover">
                            <div class="product-item">
                                <div class="image">
                                    <a href="<?=yii\helpers\Url::to(['product/detail','product_id'=>$this->params['all'][$i]->product_id]);?>">
                                    <img alt="<?php echo $this->params['all'][$i]->title ?>" src="" data-echo="//<?php echo $this->params['all'][$i]->cover ?>-covermiddle" />
                                        </a>
                                </div>
                                <div class="body">
                                    <div class="label-discount clear"></div>
                                    <div class="title">
                                        <a href="<?php echo yii\helpers\Url::to(['product/detail', 'product_id' => $this->params['all'][$i]->product_id]); ?>"><?php echo $this->params['all'][$i]->title ?></a>
                                    </div>
                                </div>
                                <div class="prices">
                                    <div class="price-current text-right">￥<span id="price<?=$this->params['all'][$i]->product_id;?>"><?php echo $this->params['all'][$i]->sale_price ?></span></div>
                                </div>
                                <div class="hover-area">
                                    <div class="add-cart-button">
                                        <a href="javascript:addCart(<?=$this->params['all'][$i]->product_id;?>)" class="le-button">加入购物车</a>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.product-item-holder -->
                    <?php endfor; ?>
                </div><!-- /.row -->
            </div><!-- /.col -->
            <div class="col-xs-12 col-md-5 no-margin">
                <div class="product-item-holder size-big single-product-gallery small-gallery">
                    <?php $last = $this->params['all'][count($this->params['all'])-1];?>
                    <div id="best-seller-single-product-slider" class="single-product-slider owl-carousel">
                        <div class="single-product-gallery-item" id="slide1">
                            <a data-rel="prettyphoto" href="<?=yii\helpers\Url::to(['product/detail','product_id'=>$last->product_id]);?>">
                                <img alt="<?php echo $last->title ?>" src="" data-echo="//<?php echo $last->cover ?>-coverbig" />
                            </a>
                        </div><!-- /.single-product-gallery-item -->
                        <?php $i=1;?>
                        <?php foreach((array)json_decode($last->pics, true) as $key => $pic): ?>
                            <div class="single-product-gallery-item" id="slide<?php echo $i+2; ?>">
                                <a data-rel="prettyphoto" href="<?=yii\helpers\Url::to(['product/detail','product_id'=>$last->product_id]);?>">
                                    <img alt="" src="//<?php echo $pic ?>-picbig" data-echo="//<?php echo $pic ?>-picbig" />
                                </a>
                            </div><!-- /.single-product-gallery-item -->
                            <?php $i++;?>
                        <?php endforeach; ?>
                    </div><!-- /.single-product-slider -->

                    <div class="gallery-thumbs clearfix">
                        <ul>
                            <li><a class="horizontal-thumb active" data-target="#best-seller-single-product-slider" data-slide="0" href="#slide1"><img alt="<?php echo $last->title ?>" src="" data-echo="//<?php echo $last->cover ?>-picsmall" /></a></li>
                            <?php $i=0;?>
                            <?php foreach ((array)json_decode($last->pics, true) as $key => $pic): ?>

                                <li><a class="horizontal-thumb" data-target="#best-seller-single-product-slider" data-slide="<?php echo $i+1; ?>" href="#slide<?php echo $i+2; ?>"><img alt="<?php echo $last->title ?>" src="" data-echo="//<?php echo $pic ?>-picsmall" /></a></li>
                            <?php $i++;?>
                            <?php endforeach; ?>
                        </ul>
                    </div><!-- /.gallery-thumbs -->

                    <div class="body">
                        <div class="label-discount clear"></div>
                        <div class="title">
                            <a href="<?php echo yii\helpers\Url::to(['product/detail', 'product_id' => $last->product_id]) ?>"><?php echo $last->title ?></a>
                        </div>
                    </div>
                    <div class="prices text-right">
                        <div class="price-current inline">￥<span id="price<?=$last->product_id;?>"><?php echo $last->sale_price ?></span></div>
                        <a href="javascript:addCart(<?=$last->product_id;?>)" class="le-button big inline">加入购物车</a>
                    </div>
                </div><!-- /.product-item-holder -->
            </div><!-- /.col -->

        </div><!-- /.product-grid-holder -->
    </div><!-- /.container -->
</section><!-- /#bestsellers -->
<!-- ========================================= BEST SELLERS : END ========================================= -->
<!-- ========================================= RECENTLY VIEWED ========================================= -->
<section id="recently-reviewd" class="wow fadeInUp">
    <div class="container">
        <div class="carousel-holder hover">

            <div class="title-nav">
                <h2 class="h1">所有商品</h2>
                <div class="nav-holder">
                    <a href="#prev" data-target="#owl-recently-viewed" class="slider-prev btn-prev fa fa-angle-left"></a>
                    <a href="#next" data-target="#owl-recently-viewed" class="slider-next btn-next fa fa-angle-right"></a>
                </div>
            </div><!-- /.title-nav -->

            <div id="owl-recently-viewed" class="owl-carousel product-grid-holder">
                <?php foreach($this->params['all'] as $pro): ?>
                    <div class="no-margin carousel-item product-item-holder size-small hover">
                        <div class="product-item">
                            <?php if ($pro->is_hot): ?>
                                <div class="ribbon red"><span>HOT</span></div>
                            <?php endif; ?>
                            <?php if ($pro->is_sale): ?>
                                <div class="ribbon green"><span>sale</span></div>
                            <?php endif; ?>

                            <div class="image">
                                <img alt="<?php echo $pro->title ?>" src="//<?php echo $pro->cover ?>-covermiddle" data-echo="//<?php echo $pro->cover ?>-covermiddle" />
                            </div>
                            <div class="body">
                                <div class="title">
                                    <a href="<?php echo yii\helpers\Url::to(['product/detail', 'product_id' => $pro->product_id]) ?>"><?php echo $pro->title ?></a>
                                </div>
                            </div>
                            <div class="prices">
                                <div class="price-current text-right">￥<span id="price<?=$pro->product_id;?>"><?php echo $pro->sale_price ?></span></div>
                            </div>
                            <div class="hover-area">
                                <div class="add-cart-button">
                                    <a href="javascript:addCart(<?=$pro->product_id;?>)" class="le-button">加入购物车</a>
                                </div>
                            </div>
                        </div><!-- /.product-item -->
                    </div><!-- /.product-item-holder -->
                <?php endforeach; ?>
            </div><!-- /#recently-carousel -->

        </div><!-- /.carousel-holder -->
    </div><!-- /.container -->
</section><!-- /#recently-reviewd -->
<!-- ========================================= RECENTLY VIEWED : END ========================================= -->
<!-- ========================================= TOP BRANDS ========================================= -->
<section id="top-brands" class="wow fadeInUp">
    <div class="container">
        <div class="carousel-holder" >

            <div class="title-nav">
                <h1>热门品牌</h1>
                <div class="nav-holder">
                    <a href="#prev" data-target="#owl-brands" class="slider-prev btn-prev fa fa-angle-left"></a>
                    <a href="#next" data-target="#owl-brands" class="slider-next btn-next fa fa-angle-right"></a>
                </div>
            </div><!-- /.title-nav -->

            <div id="owl-brands" class="owl-carousel brands-carousel">

                <div class="carousel-item">
                    <a href="#">
                        <img alt="" src="/statics/images/brands/brand-01.jpg" />
                    </a>
                </div><!-- /.carousel-item -->

                <div class="carousel-item">
                    <a href="#">
                        <img alt="" src="/statics/images/brands/brand-02.jpg" />
                    </a>
                </div><!-- /.carousel-item -->

                <div class="carousel-item">
                    <a href="#">
                        <img alt="" src="/statics/images/brands/brand-03.jpg" />
                    </a>
                </div><!-- /.carousel-item -->

                <div class="carousel-item">
                    <a href="#">
                        <img alt="" src="/statics/images/brands/brand-04.jpg" />
                    </a>
                </div><!-- /.carousel-item -->

                <div class="carousel-item">
                    <a href="#">
                        <img alt="" src="/statics/images/brands/brand-01.jpg" />
                    </a>
                </div><!-- /.carousel-item -->

                <div class="carousel-item">
                    <a href="#">
                        <img alt="" src="/statics/images/brands/brand-02.jpg" />
                    </a>
                </div><!-- /.carousel-item -->

                <div class="carousel-item">
                    <a href="#">
                        <img alt="" src="/statics/images/brands/brand-03.jpg" />
                    </a>
                </div><!-- /.carousel-item -->

                <div class="carousel-item">
                    <a href="#">
                        <img alt="" src="/statics/images/brands/brand-04.jpg" />
                    </a>
                </div><!-- /.carousel-item -->

            </div><!-- /.brands-caresoul -->

        </div><!-- /.carousel-holder -->
    </div><!-- /.container -->
</section><!-- /#top-brands -->
<!-- ========================================= TOP BRANDS : END ========================================= -->		<!-- ============================================================= FOOTER ============================================================= -->

