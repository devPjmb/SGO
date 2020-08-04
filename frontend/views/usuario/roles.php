<?php
 
use frontend\assets\AppAssetLayoutAll;
AppAssetLayoutAll::register($this);
 
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Button;
use yii\bootstrap\ActiveForm;
use common\components\datatables\DataTables;
$this->title = 'Roles';
$this->params['breadcrumbs'][] = $this->title;
?>
 
 
<div class="HomeRole">
    <h2 style="color: var(--color-principal);"><?= Html::encode($this->title)?></h2>
    <div>
        <button type="button" class="btn btn-color-especial" data-toggle="modal" data-target="#modal-create"><i class="fa fa-plus"></i> Añadir rol</button>
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
                                  'attribute' => 'Nombre del Rol',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->RoleName; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                                ],

                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '<div class="btn-group" > {update} {delete} </div>',
                                    'buttons' => [
                                        'delete' => function($url, $model){
                                            return Html::a('<span class="fa fa-trash"></span>', ['deleterole', 'id' => $model->RoleID], [
                                                'class' => 'btn btn-danger click-confirm',
                                                'tittle-alert' => 'Eliminar información',
                                                'text-alert'  => '¿Estás seguro? Cuando elimines el rol, no podrás recuperarlo más tarde.',
                                            ]);
                                        },
                                        'update' => function($url, $model){
                                            return '<button type="button" class="btn btn-color-especial update roleupdate" idrole="'.$model->RoleID.'" data-toggle="modal" data-target="#modal-update"><i class="fa fa-edit"></i></button>';
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
        <?php $form = ActiveForm::begin(['action' =>['createrole'], 'id' => 'create-role-modal', 'method' => 'post']); ?>
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 style="color: var(--color-principal);" class="modal-title">Crear rol</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">   
                        <?= $form->field($model, 'RoleName')->textInput(['maxlength' => true]); ?>
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
    <?php $form = ActiveForm::begin(['action' =>['updaterole'], 'id' => 'update-role-modal', 'method' => 'post']); ?>
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 style="color: var(--color-principal);" class="modal-title">Actualizar rol</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-12">   
                <?= $form->field($model, 'RoleName')->textInput(['maxlength' => true ,'id'=>'UpdateRole']); ?>
                <?= $form->field($model, 'RoleID')->hiddenInput(['id'=>'UpdateRoleID'])->label(false); ?>
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
    $(document).on('click','.roleupdate', function(e){
        var idrole = $(this).attr('idrole');
        $.post('ajaxrole',{ id: idrole },function(dt){
            obj = JSON.parse(dt);
            $('#UpdateRoleID').val(obj.RoleID);
            $('#UpdateRole').val(obj.RoleName);
        });
    });
";
$this->registerJS($JS);
?>