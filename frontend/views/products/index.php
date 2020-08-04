<?php 
use yii\helpers\Html;
use frontend\assets\AppAssetLayoutAll;
    AppAssetLayoutAll::register($this);
    use common\components\datatables\DataTables;
    $this->title = 'Productos';
 ?>

<div class="container-fluid">

    <h1 style="color: #9f871e;">Productos</h1>
    <hr>
    <?= Html::a('<i class="fa fa-plus"></i> Crear nuevo producto', ['/products/create'], ['class'=>'btn btn-color-especial']) ?>
    <br><br><br>
    <div class="row-fluid">
        <?php 

            echo DataTables::widget([
            'dataProvider' => $dataProvider,
            'columns' => [

                ['class' => 'yii\grid\SerialColumn'],
                    // Simple columns defined by the data contained in $dataProvider.
                    // Data from the model's column will be used.
                
                [
                    'attribute' => 'Name',
                    'format' => 'text',
                    'contentOptions'=>['style'=>'vertical-align:middle;'],
                ],
                [
                  'attribute' => 'Preview target',
                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                    'value' => function ($data) {
                      $htm = '<div class="row" style=" width: 80%; margin:0 auto;" >
                                    <div class="col-sm-12" id="prevtarg"">
                                        <img id="wrapper" align="left" src="'.Yii::getAlias('@web').'/images/Products/'.$data->ImageUrl.'" class="img-responsive" style="width: auto; height: 70px; margin-left: -20px; margin-right: 15px;">
                                        <b id="tittleprev" >'.$data->Name.'</b><br>
                                        '.substr(strip_tags($data->Description), 0, 70).'...
                                    </div>
                                </div>';
                        return $htm; // $data['name'] for array data, e.g. using SqlDataProvider.
                    },
                    'format' => 'html',
                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                ],
                [
                  'attribute' => 'Tamaño de producto',
                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                    'value' => function ($data) {
                      
                        return $data->Size; // $data['name'] for array data, e.g. using SqlDataProvider.
                    },
                    'format' => 'text',
                    'contentOptions'=>['style'=>'vertical-align:middle; width:5%;'],
                ],
                [
                    'attribute' => 'Description',
                    'format' => 'text',
                    'contentOptions'=>['style'=>'vertical-align:middle;'],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '<div class="btn-group" > {update} {delete} </div>',
                    'buttons' => [
                        'delete' => function($url, $model){
                            return Html::a('<span class="fa fa-trash"></span>', ['delete', 'id' => $model->ProductsID], [
                                'class' => 'btn btn-danger click-confirm',
                                'tittle-alert' => 'Eliminar información',
                                'text-alert'  => '¿Estás seguro? Cuando elimines el menú ['.$model->Name.'], no podrás recuperarlo más tarde.',
                            ]);
                        },
                        'update' => function($url, $model){
                            return Html::a('<span class="fa fa-edit"></span>', ['update', 'id' => $model->ProductsID,], [
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
