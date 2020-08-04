<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\assets\AppAssetLayoutAll;
    AppAssetLayoutAll::register($this);
    $this->title = 'Productos';
 ?>
<div class="container-fluid">
    
    <h1 style="color:  #9f871e;"><?=($LineProductsModel->isNewRecord)? 'Crear productos' : 'Actualizar productos'; ?> </h1>
        <div class="row-fluid" style="color: black;">

            <div class="customer-form">

                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','id' => 'dynamic-form-products',]]); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                            <?= $form->field($LineProductsModel, 'Name')->textInput(['maxlength' => true,'id'=>'tittlechangeprev']); ?>
                        </div>  
                        <div class="row">
                            <?= $form->field($LineProductsModel, 'Size')->textInput(['maxlength' => true,'id'=>'sizeprodu']); ?>
                        </div>
                        <div class="row">
                            <?= $form->field($LineProductsModel, 'Description')->Textarea(['placeholder'=>'Description','id'=>'descriptionhangeprev']); ?>
                        </div>
                        <div class="row">
                            <?= $form->field($LineProductsModel, 'PhotoProducts')->fileInput(['class'=>'imgpostchang','id'=>'wrapper_view']); ?>
                                <?php $imgrute = ($LineProductsModel->ImageUrl)?  $LineProductsModel->ImageUrl : 'default.png';?>
                        </div>
                    </div>
                    <div class="col-sm-6" style="display: flex;flex-direction: column;align-items: center;">
                        <div class="row">
                            <div id="prevtarg" style="height: 90px;">
                                <b id="tittleprev" ><?= $LineProductsModel->Name; ?></b><br>
                                <i id="prevsize"><?= $LineProductsModel->Size; ?></i><br>
                                <i id="prevdescription"><?= substr($LineProductsModel->Description,0,69); ?></i>
                            </div>
                        </div>
                        <div class="row">
                            <img id="wrapper" align="right" src="<?= Yii::getAlias('@web').'/images/Products/'.$imgrute ?>" class="img-responsive" style="width: auto; height: 90px; margin-right: -20px;">
                        </div>
                    </div>  
                </div>
                <br>
                <div class="form-group" style="width: 85px;">
                    <?= Html::submitButton($LineProductsModel->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-color-especial click-confirm', 'style'=>'width:100%;',
                            "tittle-alert" => $LineProductsModel->isNewRecord ? 'Crear producto' : 'Actualizar producto',
                            "text-alert" => $LineProductsModel->isNewRecord ? ' Crear un nuevo producto. ¿Desea continuar?' : 'Actualizar producto ['.$LineProductsModel->Name.'] , ¿Desea continuar?',

                    ]) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
    </div>
</div>


 <?php 
$JS = "
        function readURL(input) {
            idwrapper = input.id;

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    console.log(idwrapper)
                    $('#wrapper').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        $(document).ready(function(){

            $('.customer-form').on('change','.imgpostchang',function(){
                console.log('cambio img')
                readURL(this);
            });
            $('#tittlechangeprev').on('keyup',function(){
                console.log(this.value)
                $('#tittleprev').html(this.value);
            });
             $('#sizeprodu').on('keyup',function(){
                console.log(this.value)
                $('#prevsize').html(this.value);
            });
            $('#descriptionhangeprev').on('keyup',function(){
                if(this.value.length < 70){
                 $('#prevdescription').html(this.value.substr(0,69));
                }else{
                    $('#prevdescription').html(this.value.substr(0,69)+'...');
                }
            });
            
        });

        ";
 $this->registerJS($JS);

if (Yii::$app->session->hasFlash('success')):
        $this->registerJS('
            $(document).ready(function(){
                _Message("success","¡Exito!","'.Yii::$app->session->getFlash('success').'");
            });

            ');
    endif;

    if (Yii::$app->session->hasFlash('error')):

        $this->registerJS('
            $(document).ready(function(){
                _Message("error","¡Error!","'.Yii::$app->session->getFlash('error').'");
            });

            ');
    endif;
 ?>
