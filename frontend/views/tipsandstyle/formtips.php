<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\DinamycForm\DynamicFormWidget;
use frontend\assets\AppAssetLayoutAll;
use common\components\kartik\colorinput\ColorInput;
    AppAssetLayoutAll::register($this);
    $this->title = 'Tips And Style';
 ?>
<div class="container-fluid">
    
    <h1><?=($TargetsModel->isNewRecord)? 'Create Target and Tips' : 'Update Target and Tips'; ?> </h1>
     <div class="row-fluid">

            <div class="customer-form">

                <?php $form = ActiveForm::begin(['id' => 'dynamic-form-menu']); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($TargetsModel, 'Tittle')->textInput(['maxlength' => true,'id'=>'tittlechangeprev']) ?>
                    </div>
                    <div class="col-sm-6">
                         <?= $form->field($TargetsModel, 'PhotoTarget')->fileInput(['class'=>'imgpostchang']); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <?php $colorVlue = ($TargetsModel->Color)? $TargetsModel->Color : 'rgb(106, 168, 79)'; ?>
                        <?= $form->field($TargetsModel, 'Color')->widget(ColorInput::classname(),
                            [

                                'options' => ['placeholder' => 'Select color ...','value'=>$colorVlue, 'readonly'=>true, 'class'=>'colorchange'],
                                'pluginOptions' => ['showInput' => false,'preferredFormat' => 'rgb']
                             ]) ?>
                    </div>
                    <div class="col-sm-6">
                        <?php $imgrute = ($TargetsModel->ImageUrl)?  $TargetsModel->ImageUrl : 'default.png';
                                $tittletext = ($TargetsModel->Tittle)? $TargetsModel->Tittle : 'Tittle';
                         ?>
                        <div class="row">
                            <div class="col-sm-12" id="prevtarg" style="color:white; background-color: <?= $colorVlue; ?>;">
                                <img id="wrapper" align="left" src="<?= Yii::getAlias('@proyect').'/images/TargetTips/'.$imgrute ?>" class="img-responsive" style="width: auto; height: 70px; margin-left: -20px; margin-right: 15px;">
                                <b id="tittleprev" ><?= $tittletext; ?></b><br>
                                1. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading"><h4><i class="fa fa-cogs"></i> Configure Menu</h4></div>
                    <div class="panel-body">


                        <div class="NosingleMenu" style="">
                         <?php DynamicFormWidget::begin([
                            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                            'widgetBody' => '.container-items', // required: css class selector
                            'widgetItem' => '.item', // required: css class
                            'limit' => 10, // the maximum times, an element can be cloned (default 999)
                            'min' => 1, // 0 or 1 (default 1)
                            'insertButton' => '.add-item', // css class
                            'deleteButton' => '.remove-item', // css class
                            'model' => $TipsModel[0],
                            'formId' => 'dynamic-form-menu',
                            'formFields' => [
                                'Content',
                            ],
                        ]); ?>

                        <div class="container-items"><!-- widgetContainer -->
                        <?php foreach ($TipsModel as $i => $modelTips): ?>
                            <div class="item panel panel-default"><!-- widgetBody -->
                                <div class="panel-heading">
                                    <h3 class="panel-title pull-left">Tip</h3>
                                    <div class="pull-right">
                                        <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                        <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="panel-body">
                                    <?php
                                        // necessary for update action.
                                        if (!$modelTips->isNewRecord) {
                                            echo Html::activeHiddenInput($modelTips, "[{$i}]TipsID");
                                        }
                                    ?>
                                    <?= $form->field($modelTips, "[{$i}]Content")->textarea(['maxlength' => true,'class'=>'form-control val-vaciar']) ?>
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
                    <?= Html::submitButton($TargetsModel->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary click-confirm', 'style'=>'width:100%;',
                            "tittle-alert" => $TargetsModel->isNewRecord ? 'Create Target and Tips' : 'Update target an Tips',
                            "text-alert" => $TargetsModel->isNewRecord ? 'It´s a point to create a new target and tip Do you want to continue?' : 'It´s a point to Update the target ['.$TargetsModel->Tittle.'] Do you want to continue?',

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
            $('.colorchange').change(function(){
                $('#prevtarg').css('background-color',this.value);
            });
            $('#tittlechangeprev').on('keyup',function(){
                $('#tittleprev').html(this.value);
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