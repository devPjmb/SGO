<?php 
    use yii\helpers\Html;
    use common\models\MenuByRole;
    use yii\helpers\ArrayHelper;
    use frontend\assets\AppAssetLayoutAll;
    AppAssetLayoutAll::register($this);
    
    $userInfo = Yii::$app->AccessControl->Verify();
    $MenusOp =  MenuByRole::find()->where(["RoleID" => ArrayHelper::map($userInfo->userByRole,'RoleID','RoleID')])->all();
    $this->beginPage();
    
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
    <link rel="shortcut icon" href="<?= Yii::getAlias('@web').'/favicon.ico'?>" /> 
    <!-- <link href="<?= Yii::getAlias('@web').'/css/FontAwesome/css/font-awesome.min.css'?>" media="all" rel="stylesheet"> -->
</head>

<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
    <?php $this->beginBody() ?>
        <div class="page-wrapper">
            <div class="page-header navbar navbar-fixed-top">
                <div class="page-header-inner ">
                    <div class="page-logo">
                        <a href="<?= Yii::$app->urlManager->createUrl('/home'); ?>">
                            <img src="<?= Yii::getAlias('@web').'/images/logo.png'?>" alt="logo" class="img-rounded logo-default" style="height: 40px;  margin: 10px 0 0 20px !important;width: auto;" />
                        </a>
                        <div class="menu-toggler sidebar-toggler">
                            <!--<span></span>-->
                            <i class="fa fa-bars fa-2x" aria-hidden="true" style="color: white !important;"></i>
                        </div>
                    </div>
                    <a href="#" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                        <i class="fa fa-bars fa-2x" aria-hidden="true" style="color: white !important;"></i>
                    </a>
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            <li class="dropdown dropdown-user">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <img alt="" class="img-circle" src="<?= $userInfo->PhotoUrl? Yii::getAlias('@web').'/images/profile/'.$userInfo->PhotoUrl : Yii::getAlias('@web').'/images/profile/UserDefault.png';?>" />
                                    <span class="username username-hide-on-mobile"> <?= $userInfo->UserName ?> </span>
                                    <i class="fa fa-angle-down username"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <li>
                                        <a href="<?= Yii::$app->urlManager->createUrl('/profile'); ?>">
                                        <i class="fa fa-user"></i> Mi Perfil </a>
                                    </li>
                                    <li class="divider"> 
                                    </li>
                                    <!--bloquear Sesion
                                        <li>
                                            <a href="#">
                                            <i class="fa fa-lock"></i> Bloquear Sesi&oacute;n </a>
                                        </li>
                                    -->
                                    <li>
                                        <a href="<?= Yii::$app->urlManager->createUrl('/site/logout')?>">
                                        <i class="fa fa-key"></i> Cerrar Sesi&oacute;n </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav pull-right">
                            <li class="dropdown dropdown-user">
                                <!-- <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <i class="fa fa-bell username" style="font-size: 25px; position: relative;">
                                        <p style="    background-color: #ed008c;position: absolute;margin: -20px 0 0 -10px;color: #ffffff;font-weight: bold;padding: 3px 6px;border-radius: 50%;font-size: 12px;">0</p>
                                    </i>
                                    <i class="fa fa-angle-down username"></i>
                                </a> -->
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <li>
                                        <a href="javascript::void(0);">
                                        <i class="fa fa-user"></i> Notificacion </a>
                                    </li>
                                    <li class="divider"> 
                                    </li>
                                    <!--bloquear Sesion
                                        <li>
                                            <a href="#">
                                            <i class="fa fa-lock"></i> Bloquear Sesi&oacute;n </a>
                                        </li>
                                    -->
                                    <li>
                                        <a href="javascript::void(0);">
                                        <i class="fa fa-key"></i> Notificacion </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="clearfix"> 
            </div>
            <div class="page-container">
                <div class="page-sidebar-wrapper">
                    <div class="page-sidebar navbar-collapse collapse">
                        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="background: black;">
                            <li class="nav-item" id="myimageDiv">
                                <a href="<?= Yii::$app->urlManager->createUrl('/profile'); ?>">
                                    <img src="<?= $userInfo->PhotoUrl? Yii::getAlias('@web').'/images/profile/'.$userInfo->PhotoUrl : Yii::getAlias('@web').'/images/profile/UserDefault.png'.$userInfo->PhotoUrl;?>" alt="Imagen de Perfil" class="img-responsive img-circle">
                                </a>   
                            </li>

                            <!-- MENU -->

                            <?php
                                if(Yii::$app->controller->action->id == "index") {$pageAction = '';}else{$pageAction = Yii::$app->controller->action->id;}
                                 $ActionUse = false;
                                    foreach ($MenusOp as $MenuFind){
                                    if($MenuFind->menu->Type == 0){
                                        foreach ($MenuFind->menu->page as $pagfind){

                                            if($pagfind->PagePath == $pageAction){
                                                $ActionUse = true;
                                                break 2;
                                            }
                                                 
                                        }
                                    }
                                }
                                
                                if(!$ActionUse){
                                    if(Yii::$app->session->get("MenuPage") === NULL){
                                        Yii::$app->session->set('MenuPage', $pageAction);
                                        $pageAction = Yii::$app->session->get("MenuPage");
                                    }else{
                                        $pageAction = Yii::$app->session->get("MenuPage");
                                    }
                                }

                                $MenuPrints = [];

                                foreach ($MenusOp as $Menu): 
                                    if(in_array($Menu->MenuID, $MenuPrints)){ continue; }else{ array_push($MenuPrints, $Menu->MenuID); } ?>

                                    <?php if($Menu->menu->Type == 0): ?>
                                        <li class="nav-item <?= $Menu->menu->ControllerUse == Yii::$app->controller->id? 'Active' : ''; ?>">
                                           <a href="#" class="nav-link nav-toggle" style="background: black;">
                                               <i class="fa <?= $Menu->menu->ClassIcon? $Menu->menu->ClassIcon : 'fa fa-circle' ; ?>"></i>
                                               <span class="title"><?= $Menu->menu->MenuName; ?></span>
                                               <span class="arrow "></span>
                                           </a>
                                            <ul class="sub-menu">
                                            <?php foreach ($Menu->menu->page as $pag): ?>
                                                    <li class="nav-item <?=( $Menu->menu->ControllerUse == Yii::$app->controller->id  && $pag->PagePath == $pageAction)? 'Active' : ''; ?> ">
                                                        <a href="<?= Yii::$app->urlManager->createUrl('/'.$Menu->menu->ControllerUse."/".$pag->PagePath); ?>" class="nav-link">
                                                            <i class="fa fa-file"></i> <?= $pag->PageName; ?> 
                                                        </a>
                                                    </li>
                                            <?php  endforeach; ?>
                                            </ul>
                                       </li>
                                    <?php else: ?>
                                    <li class="nav-item <?= $Menu->menu->ControllerUse == Yii::$app->controller->id? 'Active' : ''; ?>">
                                       <a href="<?= Yii::$app->urlManager->createUrl('/'.$Menu->menu->ControllerUse."/".$Menu->menu->Path); ?>" class="nav-link nav-toggle">
                                           <i class="fa <?= $Menu->menu->ClassIcon? $Menu->menu->ClassIcon : 'fa fa-circle' ; ?>"></i>
                                           <span class="title"><?= $Menu->menu->MenuName; ?></span>
                                       </a>
                                    </li>
                               <?php endif; ?>
                            <?php endforeach;
                            Yii::$app->session->set('MenuPage', $pageAction);
                            ?>
                           <!-- END MENU -->
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
                <div class="page-footer-inner"> 2019 &copy; <a target="_blank" href="https://pablomarcano.connecticusdev.com/">Pablo Marcano</a>
                </div>
                <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>
            </div>
        </div>
        <!-- <script src="https://use.fontawesome.com/eb6f212b29.js"></script> -->
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage(); ?>