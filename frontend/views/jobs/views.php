<?php
 
use frontend\assets\AppAssetLayoutAll;
AppAssetLayoutAll::register($this);
 
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Button;
use yii\bootstrap\ActiveForm;
//use DateTime;

use common\components\chosen\Chosen;
use common\components\datatables\DataTables;
$this->title = 'Orden de Produccion';
$this->params['breadcrumbs'][] = $this->title;

function myFdateView($fdate){
             $DateDT = new DateTime($fdate);
             $AR = explode('T',$DateDT->format(DateTime::ISO8601));
             $HR = explode('-', $AR[1]);
             if(!isset($HR[1])){
                $HR = explode('+', $AR[1]);
             }
             $AR = explode('-', $AR[0]);
             $FH = $AR[2].'/'.$AR[1].'/'.$AR[0].' '.$HR[0];
             return $FH;
        }
?>
 
 
<div class="HomeRole">
    <div style="width: 100%; align-items: center; justify-content: center; display: flex;">
         <img src="<?= Yii::getAlias("@web"); ?>/images/logo.png" class="img-rounded" style=";width: auto; height: 150px;">
    </div>
    <br> 
    <span style="background: #ed008c;border-radius: 5px;padding: 4px;color: white; cursor: pointer;" onClick="history.back();"><i class="fa fa-arrow-circle-o-left
"></i> Regresar</span>
    <div class="container-fluid" style="margin-top: 5px;">
        <div class="row-fluid">
            <div class="row">
                <div class="panel panel-info">
                    <div class="panel-heading" style="display: flex;justify-content: center;align-items: center; flex-direction: column; position: relative; ">
                        <h4 style="color: var(--color-principal);">
                            <i class="fa fa-user"></i> <?= Html::encode($this->title)." Numero "; ?>
                        </h4> 
                        <h1>  <?= str_pad($OrderData->OrderID, 5, '0', STR_PAD_LEFT); ?> </h1>
                         <?= Html::submitButton('Aplicar Cambios', ['class' => 'btn btn-color-especial click-confirm', "style"=>'float:right; position:absolute; right: 5%; z-index: 2;', 'confirm-exec'=>'SendChanges();']) ?>
                         <!-- <button class="ctest">test</button> -->
                    </div>
                    <div class="panel-body">
                        <div class="container-data-user">
                            <!-- data client -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3><i class="fa fa-address-card-o"></i> Datos de Orden.</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            Fecha de entrega : <b><?= myFdateView($OrderData->DeliveryDate); ?></b>
                                        </div>
                                        <div class="row">
                                            Cliente : <?= $OrderData->clients->FullName; ?>
                                        </div>
                                        <div class="row">
                                            Telefonos : [ <?= $OrderData->clients->PhoneNumber; ?> ] <?= !empty($OrderData->clients->PhoneNumber2)? "[ ".$OrderData->clients->PhoneNumber2." ]" :'' ; ?>
                                        </div>
                                        <div class="row">
                                            Direcciones : [ <?= $OrderData->clients->Address; ?> ] <?= !empty($OrderData->clients->Address2)? "[ ".$OrderData->clients->Address2." ]": ''; ?>
                                        </div>
                                        <div class="row">
                                            Descripcion : <?= $OrderData->Description; ?>
                                        </div>
                                        <div class="row">
                                            Archivo : <?= $OrderData->File; ?>
                                        </div>
                                        <div class="row">
                                            Generada por : <?= isset($OrderData->account->agency->FirstName)? $OrderData->account->agency->FirstName .'( ' .$OrderData->account->userAccount->UserName . ' )' : '( ' .$OrderData->account->userAccount->UserName . ' )'; ?>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <!-- end data client -->
                                <!-- data phases -->
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color:<?= $Phase->UseColor; ?> ; ">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <h3><i class="fa <?= $Phase->Icon; ?>"></i> Fase <b><?= $Phase->Name; ?>.</b></h3>
                                                <?php if(!empty($OrderByPhase->account)): ?>
                                                <h6><i class="fa fa-user"></i> Usuario asignado <b><?= $OrderByPhase->account->userAccount->UserName; ?>.</b></h6>
                                                <?php endif; ?>
                                                <?php
                                                     $var = !empty($OrderByPhase->OrderDate)? myFdateView($OrderByPhase->OrderDate) : myFdateView($OrderData->DeliveryDate);
                                                ?>
                                                   <h6> <i>Tiene fecha de entrega establecida para el : <b><?= $var; ?></b></i> </h6>
                                            </div>
                                            <div class="col-sm-6" style="display: flex; flex-wrap: wrap; flex-direction: row-reverse;">
                                                <div class="box-button" id="clbox">
                                                            <?php switch (TRUE) {
                                                                 case ($OrderByPhase->Status =='1'): ?>
                                                                        <button" st="2" idcl="<?= $OrderByPhase->OrderByPhaseID; ?>" class=" btn btn-info advance">Iniciar</button>
                                                            <?php break;
                                                                     case ($OrderByPhase->Status == '2'):  ?>
                                                                            <button st="3" idcl="<?= $OrderByPhase->OrderByPhaseID; ?>" class="btn btn-danger advance">Detener</button> <button st="4" idcl="<?= $OrderByPhase->OrderByPhaseID; ?>" class="btn btn-success advance">Completar</button>
                                                            <?php break;
                                                                    case ($OrderByPhase->Status == '3'): ?>
                                                                         <button st="2"  idcl="<?= $OrderByPhase->OrderByPhaseID; ?>" class="btn btn-info advance">Continuar</button>
                                                            <?php break;
                                                                    default: $BlockButtons = false; ?>
                                                                    <button class="btn btn-info">Fase Terminada</button>
                                                            <?php break; } ?>
                                                </div>  
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div> 
                                <!-- end data phases -->
                        </div>
                    </div>
                     <div class="panel-footer" style="display: flex;justify-content: center;align-items: center;">
                       <?= Html::submitButton('Aplicar Cambios', ['class' => 'btn btn-color-especial click-confirm','confirm-exec'=>'SendChanges();']) ?>
                    </div>
                </div>
            </div>
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
   $('.box-button').on('click','.advance',function(){

         console.log('advance');
       let st = $(this).attr('st');
       let idcl = $(this).attr('idcl');
       if(Form['index-'+idcl] == undefined){
        Form['index-'+idcl] = {};
        console.log('undefined');
       }
       Form['index-'+idcl].Status = st;
        console.log(Form);

       switch(st){
        case '2':
         console.log('swich2');
            $('#clbox').fadeOut('slow',function(){
                    $('#clbox').html('');
                    $('#clbox').append('<button st=\"3\" idcl=\"'+idcl+'\" class=\"btn btn-danger advance\">Detener</button>');
                    $('#clbox').append('<button st=\"4\" idcl=\"'+idcl+'\" class=\"btn btn-success advance\">Completar</button>');
            });
            $('#clbox').fadeIn('slow');
        break;
        case '3':
         console.log('swich3');
             $('#clbox').fadeOut('slow',function(){
                    $('#clbox').html('<button st=\"2\" idcl=\"'+idcl+'\" class=\"btn btn-info advance\">Continuar</button>');
             });
             $('#clbox').fadeIn('slow');
        break;
        case '4':
         console.log('swich4');
            $('#clbox').fadeOut('slow',function(){
                $('#clbox').html('');
                $('#clbox').append('<button st=\"3\" idcl=\"'+idcl+'\" class=\"btn btn-danger advance\">Detener</button>');
                $('#clbox').append('<button class=\"btn btn-info advance\">Fase Terminada</button>');

                // console.log($('#clbox'sg))
            });
            $('#clbox').fadeIn('slow');
        break;

       }


    });

    $('.ctest').click(function(){
       console.log(Form);
       location.reload();
    });
";

$JSHead = "

    var Form = {};

    var SendChanges = function(){
        let data = JSON.stringify(Form);
        let Order = ".$OrderByPhase->OrderID."
        $.post('".$urlHom."/orders/processorder',{OrderProcess: data, Order: Order},function(r){
                location.reload();
            });
    }

";
$this->registerJS($JSHead, \yii\web\View::POS_HEAD);
$this->registerJS($JS);
?>