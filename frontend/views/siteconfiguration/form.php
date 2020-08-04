<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\DinamycForm\DynamicFormWidget;
use frontend\assets\AppAssetLayoutAll;
    AppAssetLayoutAll::register($this);
    $this->title = 'Site Configuration';
 ?>
<div class="container-fluid">
    
    <h1><?=($ModelWebPageContent->isNewRecord)? 'Create New Content' : 'Update Content'; ?> </h1>
    <hr>
     <div class="row-fluid">

            <div class="customer-form">

                      <?php $form = ActiveForm::begin(['id'=>'form-setting', 'method'=>'post']) ?>
                            <div class="row">
                                <div class="col-sm-6">
                                    
                                    <?= $form->field($ModelWebPageContent,'Identify')->textInput(['maxlength' => true]); ?>
                                </div>
                               <div class="col-sm-6">
                                  
                                    <?= $form->field($ModelWebPageContent,'Description')->Textarea(); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    
                                     <?= $form->field($ModelWebPageContent,'TextShort')->TextInput(['maxlength' => true]);?>
                                </div>
                                <div class="col-sm-6">
                                    
                                     <?= $form->field($ModelWebPageContent,'TextLong')->Textarea(['maxlength' => true]);?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    
                                     <?= $form->field($ModelWebPageContent,'Tittle')->TextInput(['maxlength' => true]);?>
                                </div>
                                <div class="col-sm-6">
                                  
                                     <?= $form->field($ModelWebPageContent,'Url')->TextInput(['maxlength' => true]);?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <?= $form->field($ModelWebPageContent, 'UploadImage')->fileInput(['class'=>'imgpostchang']); ?>
                                </div>
                                <div class="col-sm-6">
                                    <?php $imgrute = ($ModelWebPageContent->ImageUrl)?  $ModelWebPageContent->ImageUrl : 'default.png'; ?>
                                   <img id="wrapper" align="left" src="<?= Yii::getAlias('@proyect').'/images/site/'.$imgrute ?>" class="img-responsive" style="width: auto; height: 90px; margin-left: 0 auto; margin-right: 15px;">
                                </div>
                            </div><br>
                            <div class="form-group">
                                <?= Html::submitButton($ModelWebPageContent->isNewRecord ? 'Create' : 'Update', ['style'=>'width:100%;','class' => 'btn btn-primary click-confirm', 
                            "tittle-alert" => $ModelWebPageContent->isNewRecord ? 'Create User' : 'Update User',
                            "text-alert" => $ModelWebPageContent->isNewRecord ? 'It´s a point to create a new user Do you want to continue?' : 'It´s a point to Update the user ['.$ModelWebPageContent->Identify.'] Do you want to continue?',

                    ]) ?>
                            </div>
                     <?php ActiveForm::end(); ?>

            </div>
    </div>
</div>

 <?php 
$JS = "
        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#wrapper').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        $(document).ready(function(){

            $('.imgpostchang').change(function(){
                readURL(this);
            });
        });

        ";
 $this->registerJS($JS);


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