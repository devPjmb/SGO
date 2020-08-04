<?php 

/*use backend\assets\AppAssetLayoutSingle;*/
/*
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;*/
/*use yii\widgets\Breadcrumbs;
use common\widgets\Alert;*/
use yii\helpers\Html;

/*AppAssetLayoutSingle::register($this);*/
$this->beginPage()
?>

<html lang="es-la">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Preview page of Metronic Admin Theme #1 for blank page layout" name="description" />
        <meta content="" name="author" />
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
       <?php $this->beginBody() ?>
        <div class="page-wrapper">
            <div class="page-header navbar navbar-fixed-top">
                <div class="page-header-inner ">
                    <div class="page-logo">
                        <a href="/agencyclient">
                            <img src="http://via.placeholder.com/150x40" alt="logo" class="img-rounded logo-default" style="margin: 4px 0 0 !important;" />
                        </a>
                        <div class="menu-toggler sidebar-toggler">
                            <!--<span></span>-->
                            <i class="fa fa-bars fa-2x" aria-hidden="true" style="color: aliceblue !important;"></i>
                        </div>
                    </div>
                    <a href="#" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                        <!--<span></span>-->
                        <i class="fa fa-bars fa-2x" aria-hidden="true" style="color: aliceblue !important;"></i>
                    </a>
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            <li class="dropdown dropdown-user">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <img alt="" class="img-circle" src="http://via.placeholder.com/30x30" />
                                    <span class="username username-hide-on-mobile">  </span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <li>
                                        <a href="">
                                            <i class="fa fa-user"></i> Mi Perfil </a>
                                    </li>
                                    <li class="divider"> </li>
                                    <li>
                                        <a href="page_user_lock_1.html">
                                            <i class="fa fa-lock"></i> Bloquear Sesi&oacute;n </a>
                                    </li>
                                    <li>
                                        <a href="<?= Yii::$app->urlManager->createUrl('/site/logout')?>">
                                            <i class="fa fa-key"></i> Cerrar Sesi&oacute;n </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="clearfix"> </div>
            <div class="page-container">
                <div class="page-sidebar-wrapper">
                    <div class="page-sidebar navbar-collapse collapse">
                        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                            <li class="nav-item" id="myimageDiv">
                                <a href="#">
                                    <img src="http://via.placeholder.com/180x180" alt="Imagen de Perfil" class="img-responsive img-circle" style="margin: 0 auto 10px;">
                                </a>   
                            </li>
                            <li class="nav-item">
                               <a href="#" class="nav-link nav-toggle">
                                   <i class="fa fa-gears"></i>
                                   <span class="title">Demo Menu</span>
                                   <span class="arrow "></span>
                               </a>
                                <ul class="sub-menu">
                                    <li class="nav-item start">
                                        <a href="#" class="nav-link">
                                            <i class="fa fa-gear"></i> Demo Sub-Menu
                                        </a>
                                        <a href="#" class="nav-link">
                                            <i class="fa fa-gear"></i> Demo Sub-Menu
                                        </a>
                                        </li>
                                </ul>
                           </li>
                        </ul>
                    </div>
                </div>
                <div class="page-content-wrapper">
                    <div class="page-content">
                        <?= $content?>
                    </div>
                </div>
                <a href="javascript:;" class="page-quick-sidebar-toggler">
                    <i class="icon-login"></i>
                </a>
            </div>
            <div class="page-footer">
                <div class="page-footer-inner"> 2017 &copy; <a target="_blank" href="http://mydesk.digital/">Mydesk.Digital</a>
                </div>
                <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>
            </div>
        </div>
        <script src="https://use.fontawesome.com/eb6f212b29.js"></script>
        <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>