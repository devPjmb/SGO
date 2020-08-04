<?php
 
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Button;
use yii\bootstrap\ActiveForm;
use common\components\datatables\DataTables;
use common\components\PhoneInput\PhoneInput;
$this->title = 'Clientes';
$this->params['breadcrumbs'][] = $this->title;
?>
 
 
<div class="HomeRole">
    <h2 style="color: var(--color-principal);"><?= Html::encode($this->title)?></h2>
    <div>
        <button type="button" class="btn btn-color-especial" data-toggle="modal" data-target="#modal-create"><i class="fa fa-plus"></i> Añadir cliente</button>
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
                                    'attribute' => 'FullName',
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>'vertical-align:middle;'],
                                ],
                                [
                                    'attribute' => 'IDP',
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>'vertical-align:middle;'],
                                    'value' => function($data){
                                        return $data->Identify.' '.$data->IDP;
                                    }
                                ],
                                [
                                    'attribute' => 'Email',
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>'vertical-align:middle;'],
                                ],
                                [
                                    'attribute' => 'Address',
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>'vertical-align:middle;'],
                                ],
                                [
                                    'attribute' => 'Address2',
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>'vertical-align:middle;'],
                                ],
                                [
                                    'attribute' => 'PhoneNumber',
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>'vertical-align:middle;'],
                                ],
                                [
                                    'attribute' => 'PhoneNumber2',
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>'vertical-align:middle;'],
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '<div class="btn-group" > {update} {delete} </div>',
                                    'buttons' => [
                                        'delete' => function($url, $model){
                                            return Html::a('<span class="fa fa-trash"></span>', ['deleteclient', 'id' => $model->ClientID], [
                                                'class' => 'btn btn-danger click-confirm',
                                                'tittle-alert' => 'Eliminar información',
                                                'text-alert'  => '¿Estás seguro? Cuando elimines el rol, no podrás recuperarlo más tarde.',
                                            ]);
                                        },
                                        'update' => function($url, $model){
                                            return '<button type="button" class="btn btn-color-especial update clickupdate" idclient="'.$model->ClientID.'" data-toggle="modal" data-target="#modal-update"><i class="fa fa-edit"></i></button>';
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
        <?php $form = ActiveForm::begin(['action' =>['saveclient'], 'id' => 'create-phase-modal', 'method' => 'post']); ?>
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 style="color: var(--color-principal);" class="modal-title">Crear Cliente</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">   
                        <?= $form->field($model, 'Identify')->textInput(); ?>
                    </div>
                    <div class="col-sm-4">   
                        <?= $form->field($model, 'IDP')->textInput(['maxlength' => true,'type'=>'number']); ?>
                    </div>
                    <div class="col-sm-6">   
                        <?= $form->field($model, 'FullName')->textInput(['maxlength' => true]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">   
                        <?= $form->field($model, 'Email')->textInput(['maxlength' => true,'type'=>'Email']); ?>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-sm-6">   
                        <!-- <?= $form->field($model, 'PhoneNumber')->textInput(['maxlength' => true,'type'=>'number']); ?> -->
                        <?= $form->field($model, 'PhoneNumber')->widget(PhoneInput::className(), ['id'=>'create-number','jsOptions' => ['preferredCountries' => ['ve'],]]);?>
                    </div>
                    <div class="col-sm-6">   
                        <!-- <?= $form->field($model, 'PhoneNumber2')->textInput(['maxlength' => true,'type'=>'number']); ?> -->
                        <?= $form->field($model, 'PhoneNumber2')->widget(PhoneInput::className(), ['jsOptions' => ['preferredCountries' => ['ve'],]]);?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">   
                        <?= $form->field($model, 'Address')->textarea([]); ?>
                    </div>
                    <div class="col-sm-6">   
                        <?= $form->field($model, 'Address2')->textarea([]); ?>
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
    <?php $form = ActiveForm::begin(['action' =>['saveclient'], 'id' => 'update-phase-modal', 'method' => 'post']); ?>
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 style="color: var(--color-principal);" class="modal-title">Actualizar datos de cliente</h4>
      </div>
      <div class="modal-body">
                <div class="row">
                    <div class="col-sm-5">   
                        <?= $form->field($model, 'FullName')->textInput(['maxlength' => true,'id'=>'fullname']); ?>
                    </div>
                    <div class="col-sm-2">   
                        <?= $form->field($model, 'Identify')->textInput(['maxlength' => true,'id'=>'iden']); ?>
                    </div>
                    <div class="col-sm-5">   
                        <?= $form->field($model, 'IDP')->textInput(['maxlength' => true,'type'=>'number','id'=>'idp']); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">   
                        <?= $form->field($model, 'Email')->textInput(['maxlength' => true,'type'=>'Email','id'=>'email']); ?>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-sm-6">   
                        <!-- <?= $form->field($model, 'PhoneNumber')->textInput(['maxlength' => true,'type'=>'number','id'=>'pnumber']); ?> -->
                        <?= $form->field($model, 'PhoneNumber')->widget(PhoneInput::className(), ['jsOptions' => ['preferredCountries' => ['ve'],],'options' =>['id'=>'pnumber']]);?>
                    </div>
                    <div class="col-sm-6">   
                      <!--   <?= $form->field($model, 'PhoneNumber2')->textInput(['maxlength' => true,'type'=>'number','id'=>'pnumber2']); ?> -->
                        <?= $form->field($model, 'PhoneNumber2')->widget(PhoneInput::className(), ['jsOptions' => ['preferredCountries' => ['ve'],],'options' =>['id'=>'pnumber2']]);?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">   
                        <?= $form->field($model, 'Address')->textarea(['id'=>'address']); ?>
                    </div>
                    <div class="col-sm-6">   
                        <?= $form->field($model, 'Address2')->textarea(['id'=>'address2']); ?>
                        <?= $form->field($model, 'ClientID')->hiddenInput(['id'=>'client-id'])->label(false); ?>
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
    $(document).on('click','.clickupdate', function(e){
        var id = $(this).attr('idclient');
        $.post('dataclient',{ id: id },function(dt){
            obj = JSON.parse(dt);
            $('#client-id').val(obj.ClientID);
            $('#fullname').val(obj.FullName);
            $('#iden').val(obj.Identify)
            $('#idp').val(obj.IDP);
            $('#email').val(obj.Email);
            $('#pnumber').val(obj.PhoneNumber);
            $('#pnumber2').val(obj.PhoneNumber2);
            $('#address').val(obj.Address);
            $('#address2').val(obj.Address2);
        });
    });
";
$this->registerJS($JS);
?>