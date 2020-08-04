<?php
 
use backend\assets\AppAssetLayoutAll;
AppAssetLayoutAll::register($this);
 
use backend\assets\AppAsset;
AppAsset::register($this);
 
use yii\helpers\Html;
use yii\bootstrap\Button;
use yii\bootstrap\ActiveForm;
use common\components\datatables\DataTables;
$this->title = 'Users ';
$this->params['breadcrumbs'][] = $this->title;
?>
 
 
<div class="usuario">
    <h2><?= Html::encode($this->title)?></h2>
    <hr>
    <?= Html::a('<i class="fa fa-plus"></i> ADD New User', ['/usuario/createuser'], ['class'=>'btn btn-success']) ?>
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
                                      'attribute' => 'User Name',
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
                                        'class' => 'yii\grid\ActionColumn',
                                        'template' => '<div class="btn-group" > {update} {delete} </div>',
                                        'buttons' => [
                                            'delete' => function($url, $model){
                                                return Html::a('<span class="fa fa-trash"></span>', ["delete","id" => $model->AccountID], [
                                                    'id'=>$model->AccountID,
                                                    'class' => 'btn btn-danger click-confirm',
                                                    'tittle-alert'  => 'warning',
                                                     'text-alert' => 'Delete Information',
                                                     'text-alert'  => 'Are You Sure? When you delete the user ['.$model->account->userAccount->UserName.'], you will not be able to retrieve it later',
                                                ]);
                                            },
                                            'update' => function($url, $model){
                                                return Html::a('<span class="fa fa-edit"></span>',[ "update","id"=>$model->AccountID], [
                                                    'id'=>$model->AccountID,
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