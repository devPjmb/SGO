<?php 
use yii\helpers\Html;
use frontend\assets\AppAssetLayoutAll;
    AppAssetLayoutAll::register($this);
    use common\components\datatables\DataTables;
    $this->title = 'Blog';
 ?>

<div class="container-fluid">

    <h1>Posts Blog Xtreme</h1>
    <hr>
<?= Html::a('<i class="fa fa-plus"></i> Create New Post', ['/blog/createpost'], ['class'=>'btn btn-success']) ?>
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
            'attribute' => 'Tittle',
            'format' => 'text',
            'contentOptions'=>['style'=>'vertical-align:middle;'],
        ],
        [
          'attribute' => 'Image',
           'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
            'value' => function ($data) {
              $htm = "<img src='".Yii::getAlias("@proyect")."/images/blog/".$data->ImageUrl."' style='margin: auto; width: auto; height: 30px;''></img>";
                return $htm; // $data['name'] for array data, e.g. using SqlDataProvider.
            },
            'format' => 'html',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
        ],
        [
            'attribute' => 'Publication Date',
            'value' => function ($data) {
              $htm = "<b><i>".$data->PubDate."</i></b>";
                return $htm; // $data['name'] for array data, e.g. using SqlDataProvider.
            },
            'format' => 'html',
            'contentOptions'=>['style'=>'vertical-align:middle;'],
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '<div class="btn-group" > {update} {delete} </div>',
            'buttons' => [
                'delete' => function($url, $model){
                    return Html::a('<span class="fa fa-trash"></span>', ['delete', 'id' => $model->PostID], [
                        'class' => 'btn btn-danger click-confirm',
                        'tittle-alert' => 'Delete Information',
                        'text-alert'  => 'Are You Sure? When you delete the Post ['.$model->Tittle.'], you will not be able to retrieve it later',
                    ]);
                },
                'update' => function($url, $model){
                    return Html::a('<span class="fa fa-edit"></span>', ['update', 'id' => $model->PostID,], [
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