<?php
 
use frontend\assets\AppAssetLayoutAll;
AppAssetLayoutAll::register($this);
 
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Button;
use yii\bootstrap\ActiveForm;
use common\components\datatables\DataTables;
$this->title = 'Mis Ordenes';
$this->params['breadcrumbs'][] = $this->title;

function CalculateHoras($secons){


    $d = floor($secons / 86400);
    $h = floor(($secons - ($d * 86400)) / 3600);
    $m = floor(($secons - ($d * 86400) - ($h * 3600)) / 60);
    $s = $secons % 60;
    $R = ['time' => $secons,'text' => "$d:$h:$m:$s"];

    return $R;




    // $H = floor($secons / 3600);
    // $m = floor(($secons - ( $H * 3600)) / 60);
    // $s = $secons - ($H * 3600) - ($m * 60);

    // $m = ($s < 10)? '0'.$s : $s;
    // $s = ($s < 10)? '0'.$s : $s;
    // return $H . ":" . $m . ":" .$s;
}

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
            <div class="row"> <h3>Iniciados</h3></div>
            <div class="row">
                <?php   
                    echo DataTables::widget([
                            'dataProvider' => $Started,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                // Simple columns defined by the data contained in $dataProvider.
                                // Data from the model's column will be used.
                                [
                                  'attribute' => 'Orden',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return str_pad($data->OrderID, 5, '0', STR_PAD_LEFT); // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                
                                [
                                  'attribute' => 'Cliente',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->clients->FullName; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                [
                                    'attribute' => 'Orden',
                                    'label' => 'Usuario',
                                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->userAccount->UserName; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                [
                                    'attribute' => 'Generacion',
                                    'class' => 'yii\grid\DataColumn',
                                    'value' => function ($data) {
                                        return FechaEsp($data->DateCreate);

                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>'vertical-align:middle;'],
                                ],
                                 [
                                    'attribute' => 'Entrega',
                                    'class' => 'yii\grid\DataColumn',
                                    'value' => function ($data) {
                                        return FechaEsp($data->DeliveryDate);
                                        
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>'vertical-align:middle; width:200px'],
                                ],
                                [
                                  'attribute' => 'Tiempo',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        $dtA = time();
                                        $dtE = strtotime($data->DeliveryDate);
                                        $totalsec = $dtE - $dtA;
                                        $restante = CalculateHoras($totalsec);
                                        return Html::tag('span',$restante['text'],['class'=>'time-rest-realt','timesec' => $restante['time']]);
                                        // return "<span class='time-rest-realt ".$restante['time']."' data='123'>".$restante['text']."<time></time></span>"; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'raw',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                [
                                    'attribute' => 'Description',
                                    'format' => 'html',
                                    'value' => function($data){
                                        if(strlen($data->Description) >= 45){
                                            $text = substr($data->Description, 0, -40);
                                        }else{
                                            $text = substr($data->Description, 0, -5);
                                        }
                                        return Html::tag('span',$text);
                                    },
                                    'contentOptions'=>['style'=>'vertical-align:middle;'],
                                ],
                                [
                                  'attribute' => 'Total',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->TotalAmount;
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                [
                                  'attribute' => 'Abonado',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->PaymentAmount;
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                [
                                  'attribute' => 'Restante',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->RemainingAmount;
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '<div class="btn-group" > {view}{stop}{delete} </div>',
                                    'buttons' => [
                                        'stop' => function($url, $model){
                                            return Html::a('<span class="fa fa-clock-o"></span>', ['stoporder', 'id' => $model->OrderID], [
                                                'class' => 'btn btn-warning',
                                            ]);
                                        },
                                        'view' => function($url, $model){
                                            return Html::a('<span class="fa fa-eye"></span>', ['views', 'id' => $model->OrderID], [
                                                'class' => 'btn btn-info',
                                            ]);
                                        },
                                        'delete' => function($url, $model){
                                            return Html::a('<span class="fa fa-trash"></span>', ['deleteorder', 'id' => $model->OrderID], [
                                                'class' => 'btn btn-danger click-confirm',
                                                'tittle-alert' => 'Eliminar Orden',
                                                'text-alert'  => '¿Estás seguro? Cuando elimines la orden, no podrás recuperarla más tarde.',
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
            <div class="row"><h3>Completados</h3></div>
            <div class="row">
                <?php   
                    echo DataTables::widget([
                            'dataProvider' => $Complete,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                // Simple columns defined by the data contained in $dataProvider.
                                // Data from the model's column will be used.
                                [
                                  'attribute' => 'Orden',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return str_pad($data->OrderID, 5, '0', STR_PAD_LEFT); // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                
                                [
                                  'attribute' => 'Cliente',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->clients->FullName; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                [
                                    'attribute' => 'Orden',
                                    'label' => 'Usuario',
                                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->userAccount->UserName; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                [
                                    'attribute' => 'Generacion',
                                    'class' => 'yii\grid\DataColumn',
                                    'value' => function ($data) {
                                        return FechaEsp($data->DateCreate);

                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>'vertical-align:middle;'],
                                ],
                                 [
                                    'attribute' => 'Entrega',
                                    'class' => 'yii\grid\DataColumn',
                                    'value' => function ($data) {
                                        return FechaEsp($data->DeliveryDate);

                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>'vertical-align:middle; width:200px'],
                                ],
                                [
                                    'attribute' => 'Description',
                                    'format' => 'html',
                                    'value' => function($data){
                                        if(strlen($data->Description) >= 45){
                                            $text = substr($data->Description, 0, -40);
                                        }else{
                                            $text = substr($data->Description, 0, -5);
                                        }
                                        return Html::tag('span',$text);
                                    },
                                    'contentOptions'=>['style'=>'vertical-align:middle;'],
                                ],
                                [
                                  'attribute' => 'Total',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->TotalAmount;
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                [
                                  'attribute' => 'Abonado',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->PaymentAmount;
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                [
                                  'attribute' => 'Restante',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->RemainingAmount;
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '<div class="btn-group" > {view} {update}</div>',
                                    'buttons' => [
                                        // 'delete' => function($url, $model){
                                        //     return Html::a('<span class="fa fa-trash"></span>', ['deleteclient', 'id' => $model->OrderID], [
                                        //         'class' => 'btn btn-danger click-confirm',
                                        //         'tittle-alert' => 'Eliminar información',
                                        //         'text-alert'  => '¿Estás seguro? Cuando elimines el rol, no podrás recuperarlo más tarde.',
                                        //     ]);
                                        // },
                                        'view' => function($url, $model){
                                            return Html::a('<span class="fa fa-eye"></span>', ['views', 'id' => $model->OrderID], [
                                                'class' => 'btn btn-info',
                                            ]);
                                        },
                                        'update' => function($url, $model){
                                            return '<button type="button" class="btn btn-color-especial update updateOrder " idOrder="'.$model->OrderID.'" data-toggle="modal" data-target="#modal-update"><i class="fa fa-edit"></i></button>';
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
            <div class="row"><h3>Entregados</h3></div>
            <div class="row">
                <?php   
                    echo DataTables::widget([
                            'dataProvider' => $Delivered,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                // Simple columns defined by the data contained in $dataProvider.
                                // Data from the model's column will be used.
                                [
                                  'attribute' => 'Orden',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return str_pad($data->OrderID, 5, '0', STR_PAD_LEFT); // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                
                                [
                                  'attribute' => 'Cliente',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->clients->FullName; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                [
                                    'attribute' => 'Orden',
                                    'label' => 'Usuario',
                                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->userAccount->UserName; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                [
                                    'attribute' => 'Generacion',
                                    'class' => 'yii\grid\DataColumn',
                                    'value' => function ($data) {
                                        return FechaEsp($data->DateCreate);

                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>'vertical-align:middle;'],
                                ],
                                 [
                                    'attribute' => 'Entrega',
                                    'class' => 'yii\grid\DataColumn',
                                    'value' => function ($data) {
                                        return FechaEsp($data->DeliveryDate);

                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>'vertical-align:middle; width:200px'],
                                ],
                                [
                                    'attribute' => 'Description',
                                    'format' => 'html',
                                    'value' => function($data){
                                        if(strlen($data->Description) >= 45){
                                            $text = substr($data->Description, 0, -40);
                                        }else{
                                            $text = substr($data->Description, 0, -5);
                                        }
                                        return Html::tag('span',$text);
                                    },
                                    'contentOptions'=>['style'=>'vertical-align:middle;'],
                                ],
                                [
                                  'attribute' => 'Total',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->TotalAmount;
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                [
                                  'attribute' => 'Abonado',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->PaymentAmount;
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                                ],
                                [
                                  'attribute' => 'Restante',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->RemainingAmount;
                                    },
                                    'format' => 'text',
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
                                            return Html::a('<span class="fa fa-eye"></span>', ['views', 'id' => $model->OrderID], [
                                                'class' => 'btn btn-info',
                                            ]);
                                        },

                                       
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

<div id="modal-update" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <?php $form = ActiveForm::begin(['action' => ['addremaining'], 'id' => 'update-add-remaining', 'method' => 'post']); ?>
    <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 style="color: var(--color-principal);" class="modal-title">Agregar abono</h4>
          </div>
          <div class="modal-body">
            <div class="row-fluid">
                Order Generada por : <span id="GenerateOrderby"></span>
            </div>
            <div class="row">
                <div class="col-md-6">
                    Numero de Orden : <span id="OrderNumberid"></span>
                </div>
                <div class="col-md-6">
                    Fecha de entrega : <span id="DateDelivered"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    Cliente : <span id="NameClient"></span>
                </div>
                <div class="col-md-6">
                    Telefonos : <span id="phoneClient"></span>
                </div>
                
            </div>
            <div class="row">
                <div class="col-md-6">
                    Direcciones : <span id="Direction"></span>
                </div>
                <div class="col-md-6">
                    Precio de pedido : <span id="AmountOrder"></span>
                </div>
                
            </div>
            <div class="row">
                <div class="col-md-6">
                    Abonado : <span id="AmountPayment"></span>
                </div>
                <div class="col-md-6">
                    Faltante : <span id="RemainingOrder"></span>
                </div>
                
            </div>
            <div class="row">
                <hr>
                <div class="row" style="text-align: center;">
                    <h4>Abonar</h4>
                </div>
                <div class="row">
                    <div class="col-sm-12">   
                        <input type="text" name="AddRemaining" id="inpRemaining" class="form-control" />
                        <input type="hidden" name="IdOrder" id="IdOrder" class="form-control" />
                    </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <?= Html::submitButton('Agregar', ['class' => 'btn btn-color-especial click-confirm']) ?>
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

var decon = function(){ 
            $(document).find('.time-rest-realt').each(function(){

                // let spl = $(this).text().split(':');
                // let HS = (spl[0] * 3600);
                // let MS = (spl[1] * 60);
                // let SS = spl[2] * 1;
                // let totalsec =  HS + MS + SS;

                let totalsec =  $(this).attr('timesec');

                let descuento = totalsec - 1;

                $(this).attr('timesec', descuento);

                let Day = Math.floor(descuento / 86400);
                let Hor = Math.floor((descuento - (Day * 86400)) / 3600);
                let Min = Math.floor((descuento - (Day * 86400) - (Hor * 3600) ) / 60);
                let Sec = descuento % 60;


                // if(Min < 10){
                //     Min = '0' + Min;
                // }

                // if(Sec < 10){
                //     Sec = '0' + Sec;
                // }

               // $(this).text(Day +' Dias, ' + Hor +' Horas, '+ Min +' Minutos y '+ Sec +' Segundos');
               $(this).text(Day +':' + Hor +':'+ Min +':'+ Sec);
            })
          };
setInterval(decon,1000);

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


$(document).on('click','.updateOrder',function(e){
    var id = $(this).attr('idOrder');

    console.log(id);
     $.post('dataorder',{ id: id },function(dt){
            obj = JSON.parse(dt);

            $('#GenerateOrderby').html(obj.GenerateOrderby);
            $('#OrderNumberid').html(obj.OrderNumberid);
            $('#DateDelivered').html(obj.DateDelivered);
            $('#NameClient').html(obj.NameClient);
            $('#phoneClient').html(obj.phoneClient);
            $('#Direction').html(obj.Direction);
            $('#AmountOrder').html(obj.AmountOrder);


            $('#AmountPayment').html(obj.AmountPayment);
            $('#RemainingOrder').html(obj.RemainingOrder);

            $('#inpRemaining').val(obj.RemainingOrder);
            $('#IdOrder').val(obj.OrderNumberid);
            console.log(obj);
        });

});

";
$this->registerJS($JS);
?>
