<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\DinamycForm\DynamicFormWidget;
use backend\assets\AppAssetLayoutAll;
use common\components\kartik\colorinput\ColorInput;
    AppAssetLayoutAll::register($this);
    $this->title = 'Line Products';
 ?>
<div class="container-fluid">
    
    <h1><?=($LineProductsModel->isNewRecord)? 'Create Line Products' : 'Update Line Products'; ?> </h1>
     <div class="row-fluid">

            <div class="customer-form">

                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','id' => 'dynamic-form-products',]]); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($LineProductsModel, 'Name')->textInput(['maxlength' => true,'id'=>'tittlechangeprev']) ?>
                    </div>
                    <div class="col-sm-6">
                         <?= $form->field($LineProductsModel, 'Description')->Textarea(['placeholder'=>'Description','id'=>'descriptionhangeprev']); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <?php $colorVlue = ($LineProductsModel->Color)? $LineProductsModel->Color : 'rgb(106, 168, 79)'; ?>
                        <?= $form->field($LineProductsModel, 'Color')->widget(ColorInput::classname(),
                            [
                                'options' => ['placeholder' => 'Select color ...','value'=>$colorVlue, 'readonly'=>true, 'class'=>'colorchange'],
                                'pluginOptions' => ['showInput' => false,'preferredFormat' => 'rgb']
                             ]) ?>
                    </div>
                    <div class="col-sm-6">
                       
                         <?= $form->field($LineProductsModel, 'PhotoLineProducts')->fileInput(['class'=>'imgpostchang','id'=>'wrapper-']); ?>
                        
                    </div>
                </div>
                <?php 
                    $imgrute = ($LineProductsModel->ImageUrl)?  $LineProductsModel->ImageUrl : 'default.png';
                ?>
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-8" id="prevtarg" style="color:white; background-color: <?= $colorVlue; ?>; height: 90px;">
                                <img id="wrapper" align="right" src="<?= Yii::getAlias('@proyect').'/images/Products/'.$imgrute ?>" class="img-responsive" style="width: auto; height: 90px; margin-right: -20px;">
                                <b id="tittleprev" ><?= $LineProductsModel->Name; ?></b><br>
                                <i id="prevdescription"><?= substr($LineProductsModel->Description,0,69); ?></i>

                            </div>
                        </div>
                    </div>
                </div><br>

                <div class="panel panel-default">
                    <div class="panel-heading"><h4><i class="fa fa-cogs"></i> Configure Products of the line</h4></div>
                    <div class="panel-body">


                        <div class="NosingleMenu" style="">
                         <?php DynamicFormWidget::begin([
                            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                            'widgetBody' => '.container-items', // required: css class selector
                            'widgetItem' => '.item', // required: css class
                            'limit' => 15, // the maximum times, an element can be cloned (default 999)
                            'min' => 1, // 0 or 1 (default 1)
                            'insertButton' => '.add-item', // css class
                            'deleteButton' => '.remove-item', // css class
                            'model' => $ProductsModel[0],
                            'formId' => 'dynamic-form-products',
                            'formFields' => [
                                'Description',
                                'PhotoProducts',
                            ],
                        ]); ?>

                        <div class="container-items"><!-- widgetContainer -->
                        <?php foreach ($ProductsModel as $i => $modelProducts): ?>
                            <div class="item panel panel-default"><!-- widgetBody -->
                                <div class="panel-heading">
                                    <h3 class="panel-title pull-left">Products</h3>
                                    <div class="pull-right">
                                        <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                        <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="panel-body">
                                    <?php
                                        // necessary for update action.
                                        if (!$modelProducts->isNewRecord){
                                            echo Html::activeHiddenInput($modelProducts, "[{$i}]ProductsID");
                                            echo Html::activeHiddenInput($modelProducts, "[{$i}]ImageUrl");
                                        }
                                    ?>
                                    <div class="row-fluid">
                                    <?= $form->field($modelProducts, "[{$i}]Description")->textarea(['maxlength' => true,'class'=>'form-control val-vaciar descriptionchangedup','placeholder'=>'Description','id'=>'-wrappe']) ?>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="col-sm-6">
                                             <?= $form->field($modelProducts, "[{$i}]PhotoProducts")->fileInput(['class'=>'imgpostchang','id'=>"wrappe-"]); ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <?php 
                                                    $imgruteP = ($modelProducts->ImageUrl)?  $modelProducts->ImageUrl : 'default.png';
                                                ?>
                                                <div class="col-sm-8" id="prevtarg" style="height: 90px; width: auto;">
                                                    <img id="wrappe" align="left" src="<?= Yii::getAlias('@proyect').'/images/Products/'.$imgruteP ?>" class="img-responsive" style="width: auto; height: 90px; margin-left: 0px;">
                                                    <span id="_wrappe" style="margin: auto; padding-left: 10px;"><?= substr($modelProducts->Description, 0, 149); ?></span>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- .row -->
                                    <!-- .row -->
                                </div>
                            </div>
                        <?php endforeach; ?>
                        </div>
                        <?php DynamicFormWidget::end(); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::submitButton($LineProductsModel->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary click-confirm', 'style'=>'width:100%;',
                            "tittle-alert" => $LineProductsModel->isNewRecord ? 'Create Target and Tips' : 'Update target an Tips',
                            "text-alert" => $LineProductsModel->isNewRecord ? 'It´s a point to create a new target and tip Do you want to continue?' : 'It´s a point to Update the target ['.$LineProductsModel->Name.'] Do you want to continue?',

                    ]) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
    </div>
</div>


 <?php 
$JS = "
        function readURL(input) {
            idinput = input.id;
            console.log('ID DE INPUT: ' + idinput);
            idwrapper = idinput.replace('-','');
            console.log('ID DE wrapper: ' + idwrapper);

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#' + idwrapper).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        $(document).ready(function(){
            $('.container-items').on('DOMNodeInserted',function(e){
                var contenedor = $(e.target);

                img = contenedor.find('img');
                srcimg = img.attr('src');
                nameimg = srcimg.split('/').pop();
                newsrc = srcimg.replace(nameimg,'default.png');
                img.attr('src',newsrc);
                idwrappwer = img.attr('id');
                inputfile = contenedor.find('.imgpostchang');

                console.log(idwrappwer);
                


                });

            $('.container-items').on('change','.imgpostchang',function(){
                readURL(this);
            });
            $('.container-items').on('keyup','.descriptionchangedup',function(){
                 idtext = this.id;
                 idprev = this.id.replace('-','_');
                 
                 if(this.value.length < 150){
                    $('#'+idprev).html(this.value.substr(0,149));
                }else{
                    $('#'+idprev).html(this.value.substr(0,149)+'...');
                }

            });
            $('.colorchange').change(function(){
                $('#prevtarg').css('background-color',this.value);
            });
            $('#tittlechangeprev').on('keyup',function(){
                $('#tittleprev').html(this.value);
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