<?php
 
use frontend\assets\AppAssetLayoutAll;
AppAssetLayoutAll::register($this);
 
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Button;
use yii\bootstrap\ActiveForm;
use common\components\datatables\DataTables;
$this->title = 'Ordenes de Produccion';
$this->params['breadcrumbs'][] = $this->title;


function FechaEsp ($fecha) {
  $fecha = substr($fecha, 0, 10);
  $numeroDia = date('d', strtotime($fecha));
  $dia = date('l', strtotime($fecha));
  $mes = date('F', strtotime($fecha));
  $anio = date('Y', strtotime($fecha));
  $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
  $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
  $nombredia = str_replace($dias_EN, $dias_ES, $dia);
  $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
  $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
  $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
  // return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
  return $nombredia." ".$numeroDia." de ".$nombreMes;

}


?>
 
 
<div class="HomeRole">

    <div class="container-fluid">
        <div class="row-fluid">
            <div class="row"> <h3>Sin Iniciar</h3> </div>
            <div class="row">
                <?php   
                    echo DataTables::widget([
                            'dataProvider' => $NoInitPhases,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                // Simple columns defined by the data contained in $dataProvider.
                                // Data from the model's column will be used.
                                [
                                  'attribute' => 'Numero de Orden',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->orders->OrderID; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],

                                [
                                  'attribute' => 'Fecha de entrega',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return (!empty($data->OrderDate))? FechaEsp($data->OrderDate) : FechaEsp($data->orders->DeliveryDate); // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                
                                [
                                  'attribute' => 'Cliente',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->orders->clients->FullName; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                [
                                  'attribute' => 'Descripcion de la orden',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->orders->Description; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                [
                                  'attribute' => 'Archivo',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return "<a href='".Yii::getAlias('@web')."/Files/".$data->orders->clients->ClientID."/".$data->orders->File."' download >".$data->orders->File."</a>"; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'html',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '<div class="btn-group" > {view} </div>',
                                    'buttons' => [
                                        // 'delete' => function($url, $model){
                                        //     return Html::a('<span class="fa fa-trash"></span>', ['deleteclient', 'id' => $model->OrderID], [
                                        //         'class' => 'btn btn-danger click-confirm',
                                        //         'tittle-alert' => 'Eliminar información',
                                        //         'text-alert'  => '¿Estás seguro? Cuando elimines el rol, no podrás recuperarlo más tarde.',
                                        //     ]);
                                        // },
                                        'view' => function($url, $model){
                                            return Html::a('<span class="fa fa-eye"></span>', ['views', 'id' => $model->OrderByPhaseID], [
                                                'class' => 'btn btn-info',
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
        </div>




        <div class="row-fluid">
            <div class="row"> <h3>Iniciados</h3> </div>
            <div class="row">
                <?php   
                    echo DataTables::widget([
                            'dataProvider' => $InitPhases,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                // Simple columns defined by the data contained in $dataProvider.
                                // Data from the model's column will be used.
                                [
                                  'attribute' => 'Numero de Orden',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->orders->OrderID; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],

                                [
                                  'attribute' => 'Fecha de entrega',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return (!empty($data->OrderDate))? FechaEsp($data->OrderDate) : FechaEsp($data->orders->DeliveryDate); // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                
                                [
                                  'attribute' => 'Cliente',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->orders->clients->FullName; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                [
                                  'attribute' => 'Descripcion de la orden',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->orders->Description; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                [
                                  'attribute' => 'Archivo',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return "<a href='".Yii::getAlias('@web')."/Files/".$data->orders->clients->ClientID."/".$data->orders->File."' download >".$data->orders->File."</a>"; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'html',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '<div class="btn-group" > {view} </div>',
                                    'buttons' => [
                                        // 'delete' => function($url, $model){
                                        //     return Html::a('<span class="fa fa-trash"></span>', ['deleteclient', 'id' => $model->OrderID], [
                                        //         'class' => 'btn btn-danger click-confirm',
                                        //         'tittle-alert' => 'Eliminar información',
                                        //         'text-alert'  => '¿Estás seguro? Cuando elimines el rol, no podrás recuperarlo más tarde.',
                                        //     ]);
                                        // },
                                        'view' => function($url, $model){
                                            return Html::a('<span class="fa fa-eye"></span>', ['views', 'id' => $model->OrderByPhaseID], [
                                                'class' => 'btn btn-info',
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
        </div>




        <div class="row-fluid">
            <div class="row"><h3>Detenidos</h3></div>
            <div class="row">
                <?php   
                    echo DataTables::widget([
                            'dataProvider' => $StopPhases,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                // Simple columns defined by the data contained in $dataProvider.
                                // Data from the model's column will be used.
                                [
                                  'attribute' => 'Numero de Orden',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->orders->OrderID; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                
                                [
                                  'attribute' => 'Fecha de entrega',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return (!empty($data->OrderDate))? FechaEsp($data->OrderDate) : FechaEsp($data->orders->DeliveryDate); // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],

                                [
                                  'attribute' => 'Cliente',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->orders->clients->FullName; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                [
                                  'attribute' => 'Descripcion de la orden',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->orders->Description; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                [
                                  'attribute' => 'Archivo',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return "<a href='".Yii::getAlias('@web')."/Files/".$data->orders->clients->ClientID."/".$data->orders->File."' download >".$data->orders->File."</a>"; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'html',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '<div class="btn-group" > {view} </div>',
                                    'buttons' => [
                                        // 'delete' => function($url, $model){
                                        //     return Html::a('<span class="fa fa-trash"></span>', ['deleteclient', 'id' => $model->OrderID], [
                                        //         'class' => 'btn btn-danger click-confirm',
                                        //         'tittle-alert' => 'Eliminar información',
                                        //         'text-alert'  => '¿Estás seguro? Cuando elimines el rol, no podrás recuperarlo más tarde.',
                                        //     ]);
                                        // },
                                        'view' => function($url, $model){
                                            return Html::a('<span class="fa fa-eye"></span>', ['views', 'id' => $model->OrderByPhaseID], [
                                                'class' => 'btn btn-info',
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
        </div>
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