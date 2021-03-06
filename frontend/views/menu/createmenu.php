<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\DinamycForm\DynamicFormWidget;
use frontend\assets\AppAssetLayoutAll;
    AppAssetLayoutAll::register($this);
    $this->title = 'Menú';
 ?>
<div class="container-fluid">
    
    <h1 style="color: var(--color-principal);"><?=($ModelsMenuByRole->isNewRecord)? 'Crear menú' : 'Actualizar menú'; ?> </h1>
     <div class="row-fluid">

            <div class="customer-form">

                <?php $form = ActiveForm::begin(['id' => 'dynamic-form-menu']); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($MenuModel, 'MenuName')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($MenuModel, 'ClassIcon')->textInput(['maxlength' => true,'placeholder'=>'fa-circle']) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($MenuModel, 'ControllerUse')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($MenuModel, 'Type')->dropDownList(['0' => 'Menu con sub menús', '1'=>'Menú simple' ],['class'=>'typemenu form-control']) ?>
                    </div>
                </div>
                <div class="row SingleMenu" style="<?=($ModelsMenuByRole->isNewRecord)? 'display:none;' : ($MenuModel->Type == 0)? 'display:none;' : '' ; ?>">
                    <div class="col-sm-6">
                        <?= $form->field($MenuModel, 'Path')->textInput(['maxlength' => true,'class'=>'form-control val-vaciar', 'placeholder'=>'controller/view']) ?>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading"><h4><i class="fa fa-cogs"></i>Menú de configuración</h4></div>
                    <div class="panel-body">

                        <div class="container-items-role"><!-- widgetContainer -->
                            <div class="item-role panel panel-default"><!-- widgetBody -->
                                <div class="panel-heading">
                                    <h3 class="panel-title pull-left">Selecccionar Rol</h3>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                        <?php 
                                            if(!$ModelsMenuByRole->isNewRecord) {

                                                 $ModelsMenuByRole->RoleID = $checkedList;
                                             }
                                         ?>
                                            <?= $form->field($ModelsMenuByRole, "RoleID")->checkboxList($items)->label(false) ?>
                                        </div>
                                    </div><!-- .row -->
                                   <!-- .row -->
                                </div>
                            </div>
                        </div>


                        <div class="NosingleMenu" style="<?=($ModelsMenuByRole->isNewRecord)? '' : ($MenuModel->Type == 1)? 'display:none;' : '' ; ?>">
                         <?php DynamicFormWidget::begin([
                            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                            'widgetBody' => '.container-items', // required: css class selector
                            'widgetItem' => '.item', // required: css class
                            'limit' => 10, // the maximum times, an element can be cloned (default 999)
                            'min' => 1, // 0 or 1 (default 1)
                            'insertButton' => '.add-item', // css class
                            'deleteButton' => '.remove-item', // css class
                            'model' => $PagesModel[0],
                            'formId' => 'dynamic-form-menu',
                            'formFields' => [
                                'PageName',
                                'PagePath',
                            ],
                        ]); ?>

                        <div class="container-items"><!-- widgetContainer -->
                        <?php foreach ($PagesModel as $i => $modelPages): ?>
                            <div class="item panel panel-default"><!-- widgetBody -->
                                <div class="panel-heading">
                                    <h3 class="panel-title pull-left">Páginas</h3>
                                    <div class="pull-right">
                                        <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                        <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="panel-body">
                                    <?php
                                        // necessary for update action.
                                        if (!$modelPages->isNewRecord) {
                                            echo Html::activeHiddenInput($modelPages, "[{$i}]PageID");
                                        }
                                    ?>
                                    <?= $form->field($modelPages, "[{$i}]PageName")->textInput(['maxlength' => true,'class'=>'form-control val-vaciar']) ?>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-6">
                                            <?= $form->field($modelPages, "[{$i}]PagePath")->textInput(['maxlength' => true,'class'=>'form-control val-vaciar','placeholder'=>'controller/view']) ?>
                                        </div>
                                    </div><!-- .row -->
                                   <!-- .row -->
                                </div>
                            </div>
                        <?php endforeach; ?>
                        </div>
                        <?php DynamicFormWidget::end(); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group" style="width: 85px;">
                    <?= Html::submitButton($ModelsMenuByRole->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-color-especial click-confirm', 'style'=>'width:100%;',
                            "tittle-alert" => $ModelsMenuByRole->isNewRecord ? 'Crear menú' : 'Actualizar menú',
                            "text-alert" => $ModelsMenuByRole->isNewRecord ? 'Crear un nuevo menú. ¿Desea continuar?' : 'Actualizar menú ['.$MenuModel->MenuName.'] ¿Desea continuar?',

                    ]) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
    </div>
</div>

<?php 
$this->registerJs("
$(function(){
	  $('.typemenu').change(function(){
	  	if($(this).val() == 1){
	  		$('.NosingleMenu').hide('slow');
	  		$('.SingleMenu').show('slow');
	  		$('.val-vaciar').val('');
	  	}
	  	if($(this).val() == 0){
	  		$('.NosingleMenu').show('slow');
	  		$('.SingleMenu').hide('slow');
	  	}

	  });

  });
");
 ?>
 <?php 
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