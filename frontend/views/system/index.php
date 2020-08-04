<?php
 
use frontend\assets\AppAssetLayoutAll;
AppAssetLayoutAll::register($this);
 
use frontend\assets\AppAsset;
AppAsset::register($this);
 
use yii\helpers\Html;
use yii\bootstrap\Button;
use yii\bootstrap\ActiveForm;
use common\components\datatables\DataTables;
$this->title = 'Usuarios ';
$this->params['breadcrumbs'][] = $this->title;
?>
 
 
<div class="usuario">
    <h2 style="color: var(--color-principal);"><?= Html::encode($this->title)?></h2>
    <hr>
    <?= Html::a('<i class="fa fa-plus"></i> Añadir nuevo usuario', ['/usuario/createuser'], ['class'=>'btn btn-color-especial']) ?>
    <!--   <button type="button" class="btn btn-success" data-toggle="modal" data-target="#usermodal"><i class="fa fa-plus"></i></button> -->
    <!-- Fin Formulario Modificar Modal -->
    <br><br>
    <div class="container-fluid">
      
    <?php 

        echo DataTables::widget([
            'dataProvider' => $AgencysDat,

            'columns' => [
                ['class' => 'yii\grid\SerialColumn',],

                [
                  'attribute' => 'Nombre de Usuario',
                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                    'value' => function ($data) {
                        return $data->account->userAccount->UserName; // $data['name'] for array data, e.g. using SqlDataProvider.
                    },
                    'format' => 'text',
                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                ],
                [
                    'attribute' => 'FirstName',
                    'format' => 'text',
                    'contentOptions'=>['style'=>'vertical-align:middle; min-width: 30%;'],
                ],
                [
                    'attribute' => 'LastName',
                    'format' => 'text',
                    'contentOptions'=>['style'=>'vertical-align:middle;'],
                ],
                [
                  'attribute' => 'Tipo de Usuario',
                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                    'value' => function ($data) {
                        return $data->account->userAccount->typeUsers->Name; // $data['name'] for array data, e.g. using SqlDataProvider.
                    },
                    'format' => 'text',
                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '<div class="btn-group" > {update} {delete} </div>',
                    'buttons' => [
                        'delete' => function($url, $model){
                            return Html::a('<span class="fa fa-trash"></span>', ["delete","id" => $model->AccountID], [
                                'id'=>$model->AccountID,
                                'class' => 'btn btn-danger click-confirm',
                                'tittle-alert'  => 'Eliminar información',
                                'text-alert'  => '¿Estás seguro? Cuando elimines el usuario ['.$model->account->userAccount->UserName.'],no podrás recuperarlo más tarde.',
                            ]);
                        },
                        'update' => function($url, $model){
                            return Html::a('<span class="fa fa-edit"></span>',[ "update","id"=>$model->AccountID], [
                                'id'=>$model->AccountID,
                                'class' => 'btn btn-color-especial',   
                            ]);
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