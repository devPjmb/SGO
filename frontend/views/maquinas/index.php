<?php 
use yii\helpers\Html;
use frontend\assets\AppAssetLayoutAll;
AppAssetLayoutAll::register($this);
use common\components\datatables\DataTables;
use yii\bootstrap\ActiveForm;
$this->title = 'Máquinas';
?>

<div class="container-fluid">
    <h1 style="color: #9f871e;">Máquinas</h1>
    <hr>
    <?= Html::a('<i class="fa fa-plus"></i> Crear nueva máquina', ['/maquinas/create'], ['class'=>'btn btn-color-especial']) ?>
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
                                            <img id="wrapper" align="left" src="'.Yii::getAlias('@web').'/images/Maquinas/'.$data->ImageUrl.'" class="img-responsive" style="width: auto; height: 70px; margin-left: -20px; margin-right: 15px;">
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
                      'attribute' => 'Numero de maquinas',
                       'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                        'value' => function ($data) {
                          
                            return $data->Numero; // $data['name'] for array data, e.g. using SqlDataProvider.
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
                        'template' => '<div class="btn-group" > {update} {delete} {assign} </div>',
                        'buttons' => [
                            'delete' => function($url, $model){
                                return Html::a('<span class="fa fa-trash"></span>', ['delete', 'id' => $model->MaquinasID], [
                                    'class' => 'btn btn-danger click-confirm',
                                    'tittle-alert' => 'Eliminar  información',
                                    'text-alert'  => '¿Estas seguro? cuando elimines el menú ['.$model->Name.'], no podrás recuperarlo más tarde.',
                                ]);
                            },
                            'update' => function($url, $model){
                                return Html::a('<span class="fa fa-edit"></span>', ['update', 'id' => $model->MaquinasID,], [
                                    'class' => 'btn btn-color-especial',                        
                                ]);
                            },
                            'assign' => function($url, $model){
                                return '<button type="button" class="btn btn-info update assignmaquinas" idmaquinas="'.$model->MaquinasID.'" data-toggle="modal" data-target="#modal-assign"><i class="fa fa-gears"></i></button>';
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
<!-- Modal asignar-->
<div id="modal-assign" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <?php $form = ActiveForm::begin(['action' =>['assign'], 'id' => 'assign-maquinas-modal', 'method' => 'post']); ?>
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="color: #9f871e;">Asignar producto</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <h4>Nombre </h4>  
                <p id='AssignMaquinas' style="border: solid 1px #9f871e;color: black;padding: 5px;border-radius: 5px;"></p>
            </div>
            <div class="col-md-6 col-sm-12"> 
                <h4>Descripción</h4>  
                <p id='DescriptionMaquinas' style="border: solid 1px #9f871e;color: black;padding: 5px;border-radius: 5px;"></p>
            </div>
            <div class="col-sm-12">
                <?= $form->field($MbPModel, 'MaquinasID')->hiddenInput(['id'=>'AssignMaquinasID'])->label(false); ?>
                <?= $form->field($MbPModel, 'MBproductsID')->hiddenInput(['id'=>'MbPassingID'])->label(false); ?>
                <?= $form->field($MbPModel, 'ProductsID')->dropDownList($modelProducts); ?>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <?= Html::submitButton('Asignar', ['class' => 'btn btn-color-especial click-confirm']) ?>
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
    $(document).on('click','.assignmaquinas', function(e){
        var idmaquinas = $(this).attr('idmaquinas');
        $.post('maquinas/ajaxassign',{ id: idmaquinas },function(dt){
            obj = JSON.parse(dt);
            console.log(obj);
            $('#AssignMaquinasID').val(obj.MaquinasID);
            $('#AssignMaquinas').html(obj.Name);
            $('#DescriptionMaquinas').html(obj.Description);
            $('#mbproducts-productsid').val(obj.ProductsID);
            console.log(obj.ProductsID)
            $('#MbPassingID').val(obj.MbPID)
        });
    });
";
$this->registerJS($JS);
?>