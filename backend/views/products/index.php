<?php 
use yii\helpers\Html;
use backend\assets\AppAssetLayoutAll;
    AppAssetLayoutAll::register($this);
    use common\components\datatables\DataTables;
    $this->title = 'Tips And Style';
 ?>

<div class="container-fluid">

    <h1>Tips And Style</h1>
    <hr>
<?= Html::a('<i class="fa fa-plus"></i> Create New Line Products', ['/products/create'], ['class'=>'btn btn-success']) ?>
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
                            <div class="col-sm-12" id="prevtarg" style="color:white; background-color: '.$data->Color.';">
                                <img id="wrapper" align="left" src="'.Yii::getAlias('@proyect').'/images/Products/'.$data->ImageUrl.'" class="img-responsive" style="width: auto; height: 70px; margin-left: -20px; margin-right: 15px;">
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
          'attribute' => 'Amount Products',
           'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
            'value' => function ($data) {
              
                return count($data->products); // $data['name'] for array data, e.g. using SqlDataProvider.
            },
            'format' => 'text',
            'contentOptions'=>['style'=>'vertical-align:middle; width:5%;'],
        ],

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '<div class="btn-group" > {update} {delete} </div>',
            'buttons' => [
                'delete' => function($url, $model){
                    return Html::a('<span class="fa fa-trash"></span>', ['delete', 'id' => $model->LineProductsID], [
                        'class' => 'btn btn-danger click-confirm',
                        'tittle-alert' => 'Delete Information',
                        'text-alert'  => 'Are You Sure? When you delete the menu ['.$model->Name.'], you will not be able to retrieve it later',
                    ]);
                },
                'update' => function($url, $model){
                    return Html::a('<span class="fa fa-edit"></span>', ['update', 'id' => $model->LineProductsID,], [
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