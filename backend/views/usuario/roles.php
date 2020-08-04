<?php
 
use backend\assets\AppAssetLayoutAll;
AppAssetLayoutAll::register($this);
 
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Button;
use yii\bootstrap\ActiveForm;
use common\components\datatables\DataTables;
$this->title = 'Roles';
$this->params['breadcrumbs'][] = $this->title;
?>
 
 
<div class="HomeRole">
    <h2><?= Html::encode($this->title)?></h2>
    <div><button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-create"><i class="fa fa-plus"></i> Add Role</button></div>
    <br> 
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="row">
                <?php   
                    echo DataTables::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                // Simple columns defined by the data contained in $dataProvider.
                                // Data from the model's column will be used.
                                'RoleName',
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '<div class="btn-group" > {update} {delete} </div>',
                                    'buttons' => [
                                        'delete' => function($url, $model){
                                            return Html::a('<span class="fa fa-trash"></span>', ['deleterole', 'id' => $model->RoleID], [
                                                'class' => 'btn btn-danger click-confirm',
                                                'tittle-alert' => 'Delete Information',
                                                'text-alert'  => 'Are You Sure? When you delete the role , you will not be able to retrieve it later',
                                            ]);
                                        },
                                        'update' => function($url, $model){
                                            return '<button type="button" class="btn btn-info update roleupdate" idrole="'.$model->RoleID.'" data-toggle="modal" data-target="#modal-update"><i class="fa fa-edit"></i></button>';
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
    </div>
</div>

<!-- Modal  CREATE-->
<div id="modal-create" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <?php $form = ActiveForm::begin(['action' =>['createrole'], 'id' => 'create-role-modal', 'method' => 'post']); ?>
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create Role</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">   
                        <?= $form->field($model, 'RoleName')->textInput(['maxlength' => true]); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?= Html::submitButton('Create', ['class' => 'btn btn-primary click-confirm']) ?>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<!-- Modal UPDATE-->
<div id="modal-update" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <?php $form = ActiveForm::begin(['action' =>['updaterole'], 'id' => 'update-role-modal', 'method' => 'post']); ?>
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Role</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-12">   
                <?= $form->field($model, 'RoleName')->textInput(['maxlength' => true ,'id'=>'UpdateRole']); ?>
                <?= $form->field($model, 'RoleID')->hiddenInput(['id'=>'UpdateRoleID'])->label(false); ?>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary click-confirm']) ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    <?php ActiveForm::end(); ?>
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

$JS = "
    $(document).on('click','.roleupdate', function(e){
        var idrole = $(this).attr('idrole');
        $.post('ajaxrole',{ id: idrole },function(dt){
            obj = JSON.parse(dt);
            $('#UpdateRoleID').val(obj.RoleID);
            $('#UpdateRole').val(obj.RoleName);
        });
    });
";
$this->registerJS($JS);
?>