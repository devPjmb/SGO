<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
<head>
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css" />
        <link href="<?= Yii::getAlias('@web')?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="../assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?= Yii::getAlias('@web')?>/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?= Yii::getAlias('@web')?>/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="<?= Yii::getAlias('@web')?>/css/login.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> 
        <title>Login</title>
        </head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo">
           <!--  <a href="index.html">
                <img src="../assets/pages/img/logo-big.png" alt="" /> </a> -->
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <h3 class="form-title font-green">Sign In</h3>
                <div class="alert alert-danger <?= $model->getErrors()? 'display-block' :'display-hide' ; ?> ">
                    <button class="close" data-close="alert"></button>
                    <span><?= $model->getErrors()? $model->getErrors('error')[0] :'' ; ?> </span>
                </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Username</label>
                   <!--  <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" /> -->
                    <?= $form->field($model, 'username')->textInput(['autofocus' => true,'class'=>'form-control form-control-solid placeholder-no-fix', 'placeholder'=>'Username'])->label(false); ?>
                     </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <!-- <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" /> -->
                    <?= $form->field($model, 'password')->passwordInput(['class'=>'form-control form-control-solid placeholder-no-fix','placeholder'=>'Password'])->label(false); ?>
                     </div>
                <div class="form-actions">
                    <!-- <button type="submit" class="btn green uppercase">Login</button> -->
                     <?= Html::submitButton('Enviar', ['class' => 'btn green uppercase', 'name' => 'login-button']); ?>
                    <label class="rememberme check mt-checkbox mt-checkbox-outline">
                        <!-- <input type="checkbox" name="rememberMe" value="1" />Remember -->
                         <?= $form->field($model, 'rememberMe')->checkbox()->label(false); ?>Remember
                        <!-- <span></span> -->
                    </label>
                    <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a>
                </div>
                <div class="login-options">
                    <!-- <h4>Or login with</h4> -->
                  <!--   <ul class="social-icons">
                        <li>
                            <a class="social-icon-color facebook" data-original-title="facebook" href="javascript:;"></a>
                        </li>
                        <li>
                            <a class="social-icon-color twitter" data-original-title="Twitter" href="javascript:;"></a>
                        </li>
                        <li>
                            <a class="social-icon-color googleplus" data-original-title="Goole Plus" href="javascript:;"></a>
                        </li>
                        <li>
                            <a class="social-icon-color linkedin" data-original-title="Linkedin" href="javascript:;"></a>
                        </li>
                    </ul> -->
                </div>

                <?php ActiveForm::end(); ?>
        </div>
        <div class="copyright"> 2017 © Copyright. </div>
        <!-- BEGIN CORE PLUGINS -->
        <script src="<?= Yii::getAlias('@web')?>/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?= Yii::getAlias('@web')?>/js/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?= Yii::getAlias('@web')?>/js/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?= Yii::getAlias('@web')?>/js/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?= Yii::getAlias('@web')?>/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?= Yii::getAlias('@web')?>/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="<?= Yii::getAlias('@web')?>/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="<?= Yii::getAlias('@web')?>/js/select2.full.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?= Yii::getAlias('@web')?>/js/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?= Yii::getAlias('@web')?>/js/login.min.js" type="text/javascript"></script>
</body>
</html>