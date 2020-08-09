<?php 
use frontend\assets\AppAssetLayoutAll;
    AppAssetLayoutAll::register($this);

    use common\assets\AppAssetFullCalendar;
    AppAssetFullCalendar::register($this);
    
    use frontend\assets\AppAsset;
    use yii\helpers\Html;
    use yii\bootstrap\Button;
    use yii\bootstrap\ActiveForm;
    use yii\helpers\ArrayHelper;

    use common\components\chosen\Chosen;
    use common\components\datatables\DataTables;
    $this->title = 'Todos Los Pago Pendients';
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

<div class="container-fluid">

    <h1>Pagos Pendientes</h1>
    <hr>
    <div class="row-fluid">
    <?= DataTables::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
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
                'attribute' => 'Email',
                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                'value' => function ($data) {
                    return $data->clients->Email; // $data['name'] for array data, e.g. using SqlDataProvider.
                },
                'format' => 'text',
                'contentOptions'=>['style'=>' vertical-align:middle;'],
            ],
            [
                'attribute' => 'Telefono',
                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                'value' => function ($data) {
                    return $data->clients->PhoneNumber; // $data['name'] for array data, e.g. using SqlDataProvider.
                },
                'format' => 'text',
                'contentOptions'=>['style'=>' vertical-align:middle;'],
            ],
            [
                'attribute' => 'TotalAmount',
                'format' => 'text',
                'contentOptions'=>['style'=>'vertical-align:middle;'],
                'label'=>'Total'
            ],
            [
                'attribute' => 'RemainingAmount',
                'format' => 'text',
                'contentOptions'=>['style'=>'vertical-align:middle;'],
                'label'=>'Restante'
            ],
            [
                'attribute' => 'PaymentAmount',
                'format' => 'text',
                'contentOptions'=>['style'=>'vertical-align:middle;'],
                'label'=>'Abonado'
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
                // [
                // "sExtends"=> "copy",
                // "sButtonText"=> Yii::t('app',"Copy to clipboard")
                // ],
                // [
                // "sExtends"=> "csv",
                // "sButtonText"=> Yii::t('app',"Save to CSV")
                // ],
                // [
                // "sExtends"=> "xls",
                // "oSelectorOpts"=> ["page"=> 'current'],
                // ],[
                // "sExtends"=> "pdf",
                // "sButtonText"=> Yii::t('app',"Save to PDF")
                // ],[
                // "sExtends"=> "print",
                // "sButtonText"=> Yii::t('app',"Print")
                // ],
            ]
        ]
    ],
    ]);
    ?>
    </div>
</div>