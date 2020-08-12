<?php 
    use frontend\assets\AppAssetLayoutAll;
    AppAssetLayoutAll::register($this);
    
    use frontend\assets\AppAsset;
    use yii\helpers\Html;
    use yii\bootstrap\Button;
    use yii\bootstrap\ActiveForm;
    use yii\helpers\ArrayHelper;

    use common\components\chosen\Chosen;
    use common\components\datepicker\DatePicker;

    use common\components\datatables\DataTables;

    date_default_timezone_set('America/Caracas');

    $this->title = 'Generacion de Reportes';
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

    <h1><?= $this->title; ?></h1>
    <hr>
    <div class="row-fluid">
    <?php $form = ActiveForm::begin(['id' => 'generate', 'method' => 'post','enableClientValidation' => true,
     ]); ?> 
        <div class="form-group col-lg-3">
            <?= Chosen::widget([
                'name' => 'userID',
                'items' => $listUser,
                'id' => 'OrderIDP',
                'placeholder'=>'Buscar Usuario',
                'allowDeselect' => true,
                'disableSearch' => false,
                'clientOptions' => [
                  'search_contains' => true,
                  'max_selected_options' => 1,
                ],
                ]); 
            ?>
        </div>
        <div class="col-lg-3">
            <select class="form-control" name="status">
                <option selected disabled> Estado de las Ordenes </option>
                <option value="0">Todas Las Ordenes</option>
                <option value="1">Ordenes Iniciadas</option>
                <option value="2">Ordenes Completadas</option>
                <option value="3">Ordenes Entregadas</option>
            </select>
        </div>
        <div class="form-group col-lg-3">
            <?= DatePicker::widget([
                'name' => 'startDate',
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => 'Fecha de Inicio'
                    ],
                    'clientOptions' => [
                        'format' => 'YYYY-MM-DD', 
                        'stepping' => 30,
                    ]
                ]);
            ?>
        </div>
        <div class="form-group col-lg-3">
            <?= DatePicker::widget([
                'name' => 'endDate',
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => 'Fecha Final'
                    ],
                    'clientOptions' => [
                        'format' => 'YYYY-MM-DD', 
                        'stepping' => 30,
                    ]
                ]);
            ?>
        </div>
        <div class="col-lg-12" style="display: flex;justify-content: center;align-items: center;">
            <?= Html::submitButton('Generar', ['class' => 'btn btn-color-especial', "style"=>'width:25%']) ?>
        </div>
        <?php if(isset($dataReport) && !empty($dataReport)): ?>
        <?= DataTables::widget([
            'dataProvider' => $dataReport,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'Orden',
                    'class' => 'yii\grid\DataColumn',
                    'value' => function ($data) {
                        return str_pad($data->OrderID, 5, '0', STR_PAD_LEFT);
                    },
                    'format' => 'text',
                    'label' => 'Orden',
                    'contentOptions'=>['style'=>'vertical-align:middle;'],
                ],
                [
                    'attribute' => 'Cliente',
                    'class' => 'yii\grid\DataColumn',
                    'value' => function ($data) {
                        return $data->clients->FullName;
                    },
                    'format' => 'text',
                    'label' => 'Cliente',
                    'contentOptions'=>['style'=>'vertical-align:middle;'],
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
                    'attribute' => 'Description',
                    'format' => 'html',
                    'value' => function($data){
                        if(strlen($data->Description) >= 45)
                            $text = substr($data->Description, 0, -40);
                        else
                            $text = substr($data->Description, 0, -5);
                        return Html::tag('span',$text);
                    },
                    'contentOptions'=>['style'=>'vertical-align:middle;'],
                ],
                [
                    'attribute' => 'Status',
                    'class' => 'yii\grid\DataColumn',
                    'value' => function ($data) {
                        switch ($data->Status) {
                            case '1':
                                $html = "<span class='badge badge-warning'> <i class='fa fa-check'></i> Iniciada</span>";
                                break;
                            case '2':
                                $html = "<span class='badge badge-primary'> <i class='fa fa-circle'></i> Completada</span>";
                                break;
                            case '3':
                                $html = "<span class='badge badge-success'> <i class='fa fa-circle'></i> Entregada</span>";
                                break;
                        }
                        return $html;
                    },
                    'format' => 'html',
                    'contentOptions'=>['style'=>'vertical-align:middle;text-align:center'],
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
        ]); ?>
        <?php endif ?>
    <?php ActiveForm::end(); ?>
    </div>

</div>