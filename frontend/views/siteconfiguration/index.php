<?php 
use yii\helpers\Html;
use frontend\assets\AppAssetLayoutAll;
    AppAssetLayoutAll::register($this);
    use common\components\datatables\DataTables;
    $this->title = 'Blog';
 ?>

<div class="container-fluid">

    <h1>Aditional Settings For Web Site</h1>
    <hr>
<?= Html::a('<i class="fa fa-plus"></i> Create New Content', ['/siteconfiguration/create'], ['class'=>'btn btn-success']) ?>
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
            'attribute' => 'Identify',
            'format' => 'text',
            'contentOptions'=>['style'=>'vertical-align:middle;'],
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
                    return Html::a('<span class="fa fa-trash"></span>', ['delete', 'id' => $model->Identify], [
                        'class' => 'btn btn-danger click-confirm',
                        'tittle-alert' => 'Delete Information',
                        'text-alert'  => 'Are You Sure? When you delete the Configuration in Site ['.$model->Identify.'], you will not be able to retrieve it later',
                    ]);
                },
                'update' => function($url, $model){
                    return Html::a('<span class="fa fa-edit"></span>', ['update', 'id' => $model->Identify,], [
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
    ]
],
]);
 ?>
</div>
</div>
<?php 
if (Yii::$app->session->hasFlash('success')):
		$this->registerJS('
			$(document).ready(function(){
				_Message("success","Success!","'.Yii::$app->session->getFlash('success').'");
			});

			');
	endif;

	if (Yii::$app->session->hasFlash('error')):

		$this->registerJS('
			$(document).ready(function(){
				_Message("error","Error!","'.Yii::$app->session->getFlash('error').'");
			});

			');
	endif;
 ?>