<?php
 
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Button;
use yii\bootstrap\ActiveForm;
use common\components\datatables\DataTables;
use common\components\kartik\colorinput\ColorInput;
use common\components\chosen\Chosen;
$this->title = 'Fases';
$this->params['breadcrumbs'][] = $this->title;
?>
 
 
<div class="HomeRole">
    <h2 style="color: var(--color-principal);"><?= Html::encode($this->title)?></h2>
    <div>
        <button type="button" class="btn btn-color-especial" data-toggle="modal" data-target="#modal-create"><i class="fa fa-plus"></i> Añadir fase</button>
    </div>
    <br> 
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="row">
                <?php   
                    echo DataTables::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                // Simple columns defined by the data contained in $dataProvider.
                                // Data from the model's column will be used.
                                [
                                  'attribute' => 'Nombre de la fase',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        $color = $data->UseColor;
                                        return "<div style = 'background : ".$data->UseColor." ; height:100%; width:100%;'><i class='fa ".$data->Icon."'></i> ".$data->Name."</div>"; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'html',
                                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle; '],
                                ],
                                [
                                  'attribute' => 'Descripcion',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->Description; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                                ],
                                [
                                  'attribute' => 'Prioridad de fase',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->Priority; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                                ],

                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '<div class="btn-group" > {update} {delete} </div>',
                                    'buttons' => [
                                        'delete' => function($url, $model){
                                            return Html::a('<span class="fa fa-trash"></span>', ['deletephase', 'id' => $model->PhaseID], [
                                                'class' => 'btn btn-danger click-confirm',
                                                'tittle-alert' => 'Eliminar información',
                                                'text-alert'  => '¿Estás seguro? Cuando elimines el rol, no podrás recuperarlo más tarde.',
                                            ]);
                                        },
                                        'update' => function($url, $model){
                                            return '<button type="button" class="btn btn-color-especial update phaseupdate" idphase="'.$model->PhaseID.'" data-toggle="modal" data-target="#modal-update"><i class="fa fa-edit"></i></button>';
                                        }
                                       
                                    ],
                                    'contentOptions'=>['style'=>'min-width: 100px; text-align: center; vertical-align:middle;'],
                                ],
                                
                            ],
                            'clientOptions' => [
                            "lengthMenu"=> [[10,20,-1], [10,20,Yii::t('app',"All")]],
                            "info"=>false,
                            "retrieve" => true,
                            "responsive"=>'true', 
                            "dom"=> 'lfTrtip',
                            "tableTools"=>[
                                "aButtons"=> [  
                                ]
                            ],
                            'language'=>[
                                'processing'    => Yii::t('app', 'Procesando...'),
                                'search'        => Yii::t('app', 'Buscar:'),
                                'lengthMenu'    => Yii::t('app','Mostrar _MENU_ Entradas'),
                                'info'        => Yii::t('app','Mostrando del _START_ al _END_ de _TOTAL_ entradas'),
                                'infoEmpty'  => Yii::t('app','Mostrando del 0 al 0 de 0 entradas'),
                                'infoFiltered'  => Yii::t('app','(Filtrado de _MAX_ entradas totales)'),
                                'infoPostFix'   => '',
                                'loadingRecords'=> Yii::t('app','Cargando...'),
                                'zeroRecords'   => Yii::t('app','No se encontraron registros coincidentes'),
                                'emptyTable'    => Yii::t('app','No hay datos disponibles en la tabla'),
                                'paginate' => [
                                    'first'  => Yii::t('app','Primero'),
                                    'previous'  => Yii::t('app','Anterior'),
                                    'next'    => Yii::t('app','Siguiente'),
                                    'last'    => Yii::t('app','Último'),
                                ],
                                'aria' => [
                                    'sortAscending' => Yii::t('app',': activate to sort column ascending'),
                                    'sortDescending'=> Yii::t('app',': activate to sort column descending'),
                                ]
                            ],
                        ],
                    ]);
                ?>
            </div>    
        </div>
    </div>
</div>

<!-- Modal  CREATE-->
<div id="modal-create" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <?php $form = ActiveForm::begin(['action' =>['savephase'], 'id' => 'create-phase-modal', 'method' => 'post']); ?>
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 style="color: var(--color-principal);" class="modal-title">Crear Fase</h4>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <?= $form->field($model, 'PhaseRoles')->widget(
                                                                Chosen::className(), [
                                                                    'items' => $ItemsRole,
                                                                    'id' => 'RolesForPhase',
                                                                    'placeholder'=>'Buscar Rol',
                                                                   'allowDeselect' => true,
                                                                   'multiple' => true,
                                                                    'disableSearch' => false, // Search input will be disabled
                                                                    'clientOptions' => [
                                                                        'search_contains' => false,
                                                                        'max_selected_options' => 10,
                                                                    ],
                                                            ]);?>
                </div>
                <div class="row">
                    <div class="col-sm-6">   
                        <?= $form->field($model, 'Name')->textInput(['maxlength' => true]); ?>
                    </div>
                    <div class="col-sm-6">   
                        <?= $form->field($model, 'Priority')->textInput(['maxlength' => true,'type' => 'number']); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'UseColor')->widget(ColorInput::classname(),
                                    [
                                        'options' => ['placeholder' => 'Selecciona un  color ...','value'=>'#f5f5f5', 'readonly'=>true, 'class'=>'colorchange'],
                                        'pluginOptions' => ['showInput' => false,'preferredFormat' => 'rgb']
                                     ]) ?>
                        <?= $form->field($model, 'Icon')->textInput(['maxlength' => true,'placeholder'=>'fa-file-o']); ?>
                    </div>
                    <div class="col-sm-6">   
                        <?= $form->field($model, 'Description')->textarea(['rows'=>5]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6" style="display: flex;justify-content: center;align-items: center;">
                        <?= $form->field($model, 'OnlyUser')->checkbox(); ?>
                    </div>
                    <div class="col-sm-6" style="display: flex;justify-content: center;align-items: center;">
                        
                        <?= $form->field($model, 'Notification')->checkbox(); ?>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <?= Html::submitButton('Crear', ['class' => 'btn btn-color-especial click-confirm']) ?>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<!-- Modal UPDATE-->
<div id="modal-update" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <?php $form = ActiveForm::begin(['action' =>['savephase'], 'id' => 'update-phase-modal', 'method' => 'post']); ?>
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 style="color: var(--color-principal);" class="modal-title">Actualizar Fase</h4>
      </div>
      <div class="modal-body">
        <div class="row-fluid">
                    <?= $form->field($model, 'PhaseRolesud')->widget(
                                                                Chosen::className(), [
                                                                    'items' => $ItemsRole,
                                                                    'id' => 'RolesForPhaseUd',
                                                                    'placeholder'=>'Buscar Rol',
                                                                    'allowDeselect' => true,
                                                                    'multiple' => true,
                                                                    'disableSearch' => false, // Search input will be disabled
                                                                    'clientOptions' => [
                                                                        'search_contains' => false,
                                                                        'max_selected_options' => 10,
                                                                    ],
                                                            ]);?>
                </div>
                
        <div class="row">
            <div class="col-sm-6">   
                <?= $form->field($model, 'Name')->textInput(['maxlength' => true ,'id'=>'UpdatePhase']); ?>
                <?= $form->field($model, 'PhaseID')->hiddenInput(['id'=>'UpdatePhaseID'])->label(false); ?>
            </div>
            <div class="col-sm-6">   
                <?= $form->field($model, 'Priority')->textInput(['maxlength' => true,'type' => 'number','id'=>'UpdatePriority']); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'UseColor')->widget(ColorInput::classname(),
                            [
                                'options' => ['placeholder' => 'Selecciona un  color ...','value'=>'#f5f5f5', 'readonly'=>true, 'class'=>'colorchange','id'=>'UpdateColor'],
                                'pluginOptions' => ['showInput' => false,'preferredFormat' => 'rgb']
                             ]) ?>
                             <?= $form->field($model, 'Icon')->textInput(['id'=>'iconphase','maxlength' => true,'placeholder'=>'fa-file-o']); ?>
            </div>
            <div class="col-sm-6">   
                <?= $form->field($model, 'Description')->textarea(['id'=>'UpdateDescription','rows'=>5]); ?>
            </div>
        </div>
        <div class="row">
                    <div class="col-sm-6" style="display: flex;justify-content: center;align-items: center;">
                        <?= $form->field($model, 'OnlyUser')->checkbox(['id'=>'checkonlyu']); ?>
                    </div>
                    <div class="col-sm-6" style="display: flex;justify-content: center;align-items: center;">
                        
                        <?= $form->field($model, 'Notification')->checkbox(['id'=>'notificationu']); ?>
                    </div>
                </div>
        
      </div>
      <div class="modal-footer">
        <?= Html::submitButton('Actualizar', ['class' => 'btn btn-color-especial click-confirm']) ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
    <?php ActiveForm::end(); ?>
  </div>
</div>

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

$JS = "
    $(document).on('click','.phaseupdate', function(e){
        var idphase = $(this).attr('idphase');
        $.post('ajaxphase',{ id: idphase },function(dt){
            obj = JSON.parse(dt);
            $('#UpdatePhaseID').val(obj.PhaseID);
            $('#UpdatePhase').val(obj.Name);
            $('#UpdatePriority').val(obj.Priority);
            $('#UpdateDescription').val(obj.Description);
            $('.sp-preview-inner').css('background',obj.UseColor);
            $('#UpdateColor').val(obj.UseColor);
            $('#iconphase').val(obj.Icon);
            console.log(obj.Roles)
            $('#phases-phaserolesud').val(obj.Roles).trigger('chosen:updated');


            if(obj.OnlyUser){
                $('#checkonlyu').prop('checked', true);
            }else{
                $('#checkonlyu').prop('checked', false);
            }

            if(obj.Notification){
                $('#notificationu').prop('checked', true);
            }else{
                $('#notificationu').prop('checked', false);
            }
        });
    });
";
$this->registerJS($JS);
?>