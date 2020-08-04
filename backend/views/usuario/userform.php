<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\DinamycForm\DynamicFormWidget;
use backend\assets\AppAssetLayoutAll;
    AppAssetLayoutAll::register($this);
    $this->title = 'Menu';
 ?>
<div class="container-fluid">
    
    <h1><?=($ModelAccount->isNewRecord)? 'Create User' : 'Update User'; ?> </h1>
    <hr>
     <div class="row-fluid">

            <div class="customer-form">

                      <?php $form = ActiveForm::begin(['id'=>'form-user', 'method'=>'post']) ?>
                            <div class="row">
                                <div class="col-sm-6">
                                    
                                    <?= $form->field($ModelUserAccount,'UserName')->textInput(['maxlength' => true]); ?>
                                </div>
                               <div class="col-sm-4">
                                  
                                    <?= $form->field($ModelUserAccount,'UserPassword')->passwordInput(['maxlength' => true]); ?>
                                </div>
                                <div class="col-sm-2">
                                  
                                    <?= $form->field($ModelUserAccount, 'TypeUser')->dropDownList(['1' => 'Admin', '2'=>'Moderator' ],['class'=>'typemenu form-control']) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    
                                     <?= $form->field($ModelAgency,'FirstName')->TextInput(['maxlength' => true]);?>
                                </div>
                                <div class="col-sm-6">
                                    
                                     <?= $form->field($ModelAgency,'LastName')->TextInput(['maxlength' => true]);?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    
                                     <?= $form->field($ModelAgency,'Address1')->TextInput(['maxlength' => true]);?>
                                </div>
                                <div class="col-sm-6">
                                  
                                     <?= $form->field($ModelAgency,'Address2')->TextInput(['maxlength' => true]);?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    
                                     <?= $form->field($ModelAgency,'BusinessPhone')->TextInput(['maxlength' => true]);?>
                                </div>
                                 <div class="col-sm-6">
                                     <?= $form->field($ModelAgency, 'ZipCode')->TextInput(['maxlength' => true]); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                     <?= $form->field($ModelAgency, 'Country')->dropDownList($ItemsCountry); ?>
                                </div>
                                <div class="col-sm-4">
                                    <?= $form->field($ModelAgency,'City')->TextInput(['maxlength' => true]);?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <?= $form->field($ModelAgency,'State')->TextInput(['maxlength' => true]);?>
                                </div>
                                <div class="col-sm-6">
                                    <?= $form->field($ModelAgency,'CompanyName')->TextInput(['maxlength' => true]);?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <?= $form->field($ModelAgency,'CompanyWebSite')->TextInput(['maxlength' => true]);?>
                                </div>
                                <div class="col-sm-6">
                                    <?= $form->field($ModelByRole,'RoleID')->dropDownList($ItemsRole);?>
                                </div>
                            </div>
                            <div class="row">
                                <?= Html::submitButton($ModelAccount->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary click-confirm', 
                            "tittle-alert" => $ModelAccount->isNewRecord ? 'Create User' : 'Update User',
                            "text-alert" => $ModelAccount->isNewRecord ? 'It´s a point to create a new user Do you want to continue?' : 'It´s a point to Update the user ['.$ModelUserAccount->UserName.'] Do you want to continue?',

                    ]) ?>
                            </div>
                     <?php ActiveForm::end(); ?>

            </div>
    </div>
</div>

 <?php 
if (Yii::$app->session->hasFlash('success')):
        $this->registerJS('
            $(document).ready(function(){
                _Message("success","Success!","'.Yii::$app->session->getFlash('success').'");
            });

            ');
    endif;

    if (Yii::$app->session->hasFlash('error')):

        $this->registerJS('
            $(document).ready(function(){
                _Message("error","Error!","'.Yii::$app->session->getFlash('error').'");
            });

            ');
    endif;
 ?>