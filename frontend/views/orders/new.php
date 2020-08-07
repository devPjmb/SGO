<?php
 
use frontend\assets\AppAssetLayoutAll;
AppAssetLayoutAll::register($this);
 
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Button;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

use common\components\datepicker\DatePicker;

use common\components\chosen\Chosen;
use common\components\datatables\DataTables;
use common\components\PhoneInput\PhoneInput;
$this->title = 'Generar Nueva Orden';
$this->params['breadcrumbs'][] = $this->title;
?>
 
<div class="HomeRole">
    <div style="width: 100%; align-items: center; justify-content: center; display: flex;">
         <img src="<?= Yii::getAlias("@web"); ?>/images/logo.png" class="img-rounded" style=";width: auto; height: 150px;">
    </div>
    <br> 
    <div class="container-fluid">
        <div class="row-fluid">
            <?php $form = ActiveForm::begin(['action' =>['generate'], 'id' => 'create-Order', 'method' => 'post','enableClientValidation' => true,
     ]); ?> 
            <div class="row-fluid">
                <div class="panel panel-info">
                    <div class="panel-heading" style="display: flex;justify-content: center;align-items: center;">
                        <h2 style="color: var(--color-principal);"><i class="fa fa-user"></i> <?= Html::encode($this->title)?></h2>
                    </div>
                    <div class="panel-body">
                        <div class="container-data-user">
                            <!-- data client -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3><i class="fa fa-address-card-o"></i> Datos del cliente.</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row-fluid">
                                        <div class="form-group">
                                            <div class="col-sm-1">
                                                <?= $form->field($modelOrder, 'Identify')->textInput(['class' => 'form-control', 'id' => 'Cidentify']); ?>
                                            </div>
                                            <!-- <div class="col-sm-11">
                                                <?= $form->field($modelOrder, 'IDP')->textInput(['class' => 'form-control']); ?>
                                            </div> -->
                                            <div class="col-sm-11">
                                                <?= $form->field($modelOrder, 'IDP')->widget(
                                                    Chosen::className(), [
                                                    'items' => $listClients,
                                                    'id' => 'OrderIDP',
                                                    'placeholder'=>'Buscar Cliente',
                                                    'allowDeselect' => true,
                                                    'disableSearch' => false, // Search input will be disabled
                                                    'clientOptions' => [
                                                      'search_contains' => true,
                                                      'max_selected_options' => 1,
                                                    ],
                                                    ])->label('Nombre, Cedula, Razon Social o RIF'); 
                                                ?>
                                            </div>
                                            <div class="col-sm-12">
                                            <?= Html::activeLabel($modelClient, 'IDP'); ?>
                                            <?= Html::input('number','idppp','',['class' => 'form-control','id'=>'clientidp', 'type'=>'number', 'disabled'=>true]); ?>
                                            <?= $form->field($modelClient, 'IDP')->hiddenInput(['id'=>'clientidph'])->label(false); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <hr style="width: 100%;">
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <?= $form->field($modelClient, 'FullName')->textInput(['class' => 'form-control','id'=>'CfullName']); ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <?= $form->field($modelClient, 'Email')->textInput(['class' => 'form-control','id'=>'Cemail']); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?= $form->field($modelClient, 'PhoneNumber')->widget(PhoneInput::className(), ['jsOptions' => ['preferredCountries' => ['ve'],]]);?>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <?= $form->field($modelClient, 'PhoneNumber2')->widget(PhoneInput::className(), ['jsOptions' => ['preferredCountries' => ['ve'],]]);?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <?= $form->field($modelClient, 'Address')->textInput(['class' => 'form-control','id'=>'Caddress']); ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <?= $form->field($modelClient, 'Address2')->textInput(['class' => 'form-control','id'=>'Caddress2']); ?>
                                            </div>
                                        </div>
                                        <?= $form->field($modelClient, 'ClientID')->hiddenInput(['class' => 'form-control','id'=>'ClientIDdt'])->label(false); ?>
                                    </div>
                                    <div class="row">
                                        <p>nota: se actualizaran los datos personales en el sistema en caso sean modificados...</p>
                                    </div>
                                </div>
                            </div> 
                            <!-- end data client -->
                            <!-- data phases -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3><i class="fa fa-cubes"></i> Fases que tendra la orden.</h3>
                                </div>
                                <div class="panel-body" style="display: flex;justify-content: center;align-items: center; flex-wrap: wrap;">
                                    <?php foreach ($modelphases as $i => $D): ?>
                                        <div class="row" style="cursor:pointer; width: 210px;height: 150px;display: flex;justify-content: center;align-items: center;background-color: <?= $D->UseColor; ?>;margin:10px;    box-shadow: 2px 2px 2px 0px gray;">
                                            <div class="col-sm-12" style="display: flex; flex-direction: column; height: 100%; justify-content: flex-end;">
                                            <div class="row box-check" idclc="<?= $i; ?>" style="height: 100%; display: flex; justify-content: center; align-items: center;">
                                                <div class="col-sm-3" style="display: flex;justify-content: center;align-items: center;">
                                                    <?= Html::checkbox('SelectedPhases['.$i.'][ID]',false,['value'=>$D->PhaseID, "class"=>"box-check", 'idclc'=>$i,'disabled'=>false]);?>
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="row" style="padding-right: 5px;">
                                                       <b style="font-size: 1.5rem;"><?= $D->Name; ?></b>
                                                    </div>
                                                    <div class="row" style="padding-right: 5px;">
                                                         <?= $D->Description; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if($D->OnlyUser): ?>
                                                <div class="row" style="padding: 5px;">
                                                    <i style="font-size: 1rem;"> Asignar Usuario:</i>
                                                    <?php 
                                                    //Armar listado de usuarios asignados a fases para el chosen
                                                        $UsersItems = ArrayHelper::map(
                                                            $D->usersThisPhase,
                                                            'AccountID',
                                                            function($model){
                                                            if(!empty($model->account->agency)){
                                                                return "[". $model->UserName . "]" . $model->account->agency->FirstName . " " . $model->account->agency->LastName;
                                                            }else{
                                                                return $model->UserName ;
                                                            }
                                                        });

                                                        $UsersAccountsID = array_keys($UsersItems);
                                                        $inList = in_array($MyDataUser->AccountID, $UsersAccountsID);

                                                    ?>
                                                    <?= Chosen::widget([
                                                                'name'=>'SelectedPhases['.$i.'][User]',
                                                                'items' =>  $UsersItems,
                                                                'id' => 'ChosenUsers'.$i,
                                                                'placeholder'=>'Buscar Usuario',
                                                                'allowDeselect' => true,
                                                                'ChosenDisabled' => true,
                                                                'value'=> ($inList)? $MyDataUser->AccountID : '',
                                                                'disableSearch' => false, // Search input will be disabled
                                                                'clientOptions' => [
                                                                    'search_contains' => true,
                                                                    'max_selected_options' => 1,
                                                                ],
                                                        ]);
                                                    ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div> 
                            <!-- end data phases -->

                            <!-- data Order -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3><i class="fa fa-folder-open-o"></i> Datos de la Orden.</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?= $form->field($modelOrder, 'DeliveryDate')->widget(DatePicker::className(),['options' => ['class' => 'form-control'], 'clientOptions' => ['format' => 'YYYY-MM-DD hh:mm A', 'stepping' => 30]]); ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <?= $form->field($modelOrder, 'TotalAmount')->textInput(['class'=>'form-control cRestAmount','id'=>'tAmount'])?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?= $form->field($modelOrder, 'PaymentAmount')->textInput(['class'=>'form-control cRestAmount','id'=>'pAmount'])?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?= $form->field($modelOrder, 'RemainingAmount')->textInput(['readonly'=>true,'class'=>'form-control','id'=>'rAmount'])?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <?= $form->field($modelOrder, 'Description')->textarea(['class' => 'form-control IDPchos']); ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6" hidden>
                                            <div class="form-group">
                                                <?= $form->field($modelOrder, 'FileTemp')->fileInput(['class' => 'form-control IDPchos']); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <!-- end data Order -->
                        </div>
                    </div>
                     <div class="panel-footer" style="display: flex;justify-content: center;align-items: center;">
                        <?= Html::submitButton('Generar', ['class' => 'btn btn-color-especial click-confirm', "style"=>'width:30%']) ?>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?> 
        </div>
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
$urlHom = Yii::getAlias('@web');
$JS = "
    $(document).on('click','.phaseupdate', function(e){
        let idphase = $(this).attr('idphase');
        $.post('ajaxphase',{ id: idphase },function(dt){
            obj = JSON.parse(dt);
            $('#UpdatePhaseID').val(obj.PhaseID);
            $('#UpdatePhase').val(obj.Name);
            $('#UpdatePriority').val(obj.Priority);
            $('#UpdateDescription').val(obj.Description);
        });
    });

    $(document).on('click','.box-check', function(e){
        console.log('click')
        let idclc = $(this).attr('idclc');
        if($(this).attr('type') == 'checkbox'){

            if(!$(this).is(':checked')){
                    $(this).prop('checked', true);
                    $('#ChosenUsers'+idclc).prop('disabled',false).trigger('chosen:updated');
                }else{
                    $(this).prop('checked', false);
                    $('#ChosenUsers'+idclc).prop('disabled',true).trigger('chosen:updated');
                }

        }else{
            let inputch = $(this).find('input:checkbox').each(function() {
                if(!$(this).is(':checked')){
                        $(this).prop('checked', true);
                        $('#ChosenUsers'+idclc).prop('disabled',false).trigger('chosen:updated');
                    }else{
                        $(this).prop('checked', false);
                        $('#ChosenUsers'+idclc).prop('disabled',true).trigger('chosen:updated');
                    }
            });
        }

    });

    $('#CfullName').change(function(){
        let selectch = $('#CfullName').val();
        if(selectch != ''){
            $.post('".$urlHom."/system/dataclient',{fname : selectch},function(e){
                let obj = JSON.parse(e);
                if(obj.error == false){
                    $('#Cidentify').val(obj.Identify);
                    $('#ClientIDdt').val(obj.ClientID);
                    $('#clientidp').val(obj.IDP);
                    $('#clientidph').val(obj.IDP);
                    $('#CfullName').val(obj.FullName);
                    $('#Cemail').val(obj.Email);
                    $('#clients-phonenumber').val(obj.PhoneNumber);
                    $('#clients-phonenumber2').val(obj.PhoneNumber2);
                    $('#Caddress').val(obj.Address);
                    $('#Caddress2').val(obj.Address2);
                }else{
                    console.log('Buscando por nombre: '+selectch)
                    $('#CfullName').val();
                    $('#Cemail').val();
                    $('#clients-phonenumber').val();
                    $('#clients-phonenumber2').val();
                    $('#Caddress').val();
                    $('#Caddress2').val();
                    $('#ClientIDdt').val();
                    $('#clientidp').val();
                    $('#clientidph').val();
                }
            })
        }else{
            console.log('sin datos '+selectch);
            $('#CfullName').val();
            $('#Cemail').val();
            $('#clients-phonenumber').val();
            $('#clients-phonenumber2').val();
            $('#Caddress').val();
            $('#Caddress2').val();
            $('#ClientIDdt').val();
            $('#clientidp').val();
            $('#clientidph').val();
            $.fn.yiiactiveform.validate($('#create-Order'));
        }
    })

    $('#orders-idp').change(function(){
            let selectch = $('#orders-idp').val();
            if(selectch != ''){
                $.post('".$urlHom."/system/dataclient',{id : selectch},function(e){
                        let obj = JSON.parse(e);
                        if(obj.error == false){
                            $('#Cidentify').val(obj.Identify);
                            $('#ClientIDdt').val(obj.ClientID);
                            $('#clientidp').val(obj.IDP);
                            $('#clientidph').val(obj.IDP);
                            $('#CfullName').val(obj.FullName);
                            $('#Cemail').val(obj.Email);
                            $('#clients-phonenumber').val(obj.PhoneNumber);
                            $('#clients-phonenumber2').val(obj.PhoneNumber2);
                            $('#Caddress').val(obj.Address);
                            $('#Caddress2').val(obj.Address2);
                        }else{
                            console.log(selectch)
                            $('#CfullName').val();
                            $('#Cemail').val();
                            $('#clients-phonenumber').val();
                            $('#clients-phonenumber2').val();
                            $('#Caddress').val();
                            $('#Caddress2').val();
                            $('#ClientIDdt').val();
                            $('#clientidp').val(selectch);
                            $('#clientidph').val(selectch);
                            
                        }
                       
                        $.fn.yiiactiveform.validate($('#create-Order'));
                    });

                }else{
                    console.log('sin datos '+selectch);
                    $('#CfullName').val();
                    $('#Cemail').val();
                    $('#clients-phonenumber').val();
                    $('#clients-phonenumber2').val();
                    $('#Caddress').val();
                    $('#Caddress2').val();
                    $('#ClientIDdt').val();
                    $('#clientidp').val();
                    $('#clientidph').val();
                   $.fn.yiiactiveform.validate($('#create-Order'));
                }
        });

    $('#orders-idp').on('chosen:no_results', function(event, data){
            $('#clientidp').val(data.chosen.get_search_text());
            $('#clientidph').val(data.chosen.get_search_text());
              console.log(data.chosen.get_search_text());
            // $('#orders-idp').trigger('chosen:updated');
            $('#CfullName').val('');
            $('#Cemail').val('');
            $('#clients-phonenumber').val('');
            $('#clients-phonenumber2').val('');
            $('#Caddress').val('');
            $('#Caddress2').val('');
            $('#ClientIDdt').val('');
            $.fn.yiiactiveform.validate($('#create-Order'));
            });
    $('.cRestAmount').keyup(function(event){
        console.log('hole');

        if(  isNaN($('#tAmount').val())  ){
            console.log('nantAmount');
            var ta = 0;
        }else{
             console.log($('#tAmount').val());
            var ta = $('#tAmount').val();
        }

        if(  isNaN($('#pAmount').val())  ){
            console.log('nanPAmount');

            var pa = 0;
        }else{
            console.log($('#pAmount').val());

            var pa = $('#pAmount').val();
        }
        $('#rAmount').val(ta - pa)
    })
";
$this->registerJS($JS);
?>