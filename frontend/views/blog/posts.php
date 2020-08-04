<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\assets\AppAssetLayoutAll;
    AppAssetLayoutAll::register($this);
use frontend\assets\AppAsset;
    AppAsset::register($this);
    $this->title = 'New Post Blog';
 ?>
<div class="container-fluid">
    
    <h1><?=($ModelPost->isNewRecord)? 'Create Post' : 'Update Post'; ?> </h1>
     <div class="row-fluid">

            <div class="customer-form">

                <?php $form = ActiveForm::begin(['id' => 'dynamic-form-Post']); ?>
                <div class="row">
                    <div class="col-sm-12">
                        <?= $form->field($ModelPost, 'Tittle')->textInput(['maxlength' => true,'id'=>'tittleid','required'=>true]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($ModelPost, 'PhotoBlog')->fileInput(['class'=>'imgpostchang']); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?= $form->field($ModelPost, 'Content')->textarea(['maxlength' => true,'style'=>'height:150;','id'=>'res-editor']); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::submitButton($ModelPost->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary click-confirm', 'style'=>'width:100%;',
                            "tittle-alert" => $ModelPost->isNewRecord ? 'Create Post' : 'Update Post',
                            "text-alert" => $ModelPost->isNewRecord ? 'It´s a point to create a new post Do you want to continue?' : 'It´s a point to Update the Post ['.$ModelPost->Tittle.'] Do you want to continue?',

                    ]) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?php $imgrute = ($ModelPost->ImageUrl)?  $ModelPost->ImageUrl : 'default.png'; ?>
                     <img id="wrapper" src="<?= Yii::getAlias('@proyect').'/images/blog/'.$imgrute ?>" class="img-responsive" style="margin: auto; width: auto; height: 200px;">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="row-fluid">
                        <h1 id="prevTitle"><?= $ModelPost->Tittle; ?></h1>
                    </div>
                    <div class="row-fluid">
                        <span id="prevText">
                             <?= $ModelPost->Content; ?>
                        </span>
                    </div>
                </div>
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
        CKEDITOR.replace('res-editor');
        $(document).ready(function(){

            $('.imgpostchang').change(function(){
                readURL(this);
            });

            $('#tittleid').on('keyup',function(){
                    $('#prevTitle').html(this.value);
            });

            CKEDITOR.instances['res-editor'].on('instanceReady',function(){
                this.document.on('keyup', function(){
                     $('#prevText').html(CKEDITOR.instances['res-editor'].getData());
                });
            });
        });

    ";
    $this->registerJS($JS);
 ?>