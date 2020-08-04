<?php
 
use frontend\assets\AppAssetLayoutAll;
AppAssetLayoutAll::register($this);

use common\assets\AppAssetFullCalendar;
AppAssetFullCalendar::register($this);
 
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Button;
use yii\bootstrap\ActiveForm;
//use DateTime;

use common\components\chosen\Chosen;
use common\components\datatables\DataTables;
$this->title = 'Fases asignadas';
$this->params['breadcrumbs'][] = $this->title;
?>
 
 
<div class="HomeRole">
    <div style="width: 100%; align-items: center; justify-content: center; display: flex;">
         <img src="<?= Yii::getAlias("@web"); ?>/images/logo.png" class="img-rounded" style=";width: auto; height: 150px;">
    </div>
    <br> 
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="row">
                <div class="panel panel-info">
                     <div class="panel-heading" style="display: flex;justify-content: center;align-items: center; flex-direction: column; position: relative; ">
                        <i class="fa fa-calendar"></i> Mis pendientes del mes
                     </div>
                     <div class="panel-body">
                         <div class="container-fluid">
                             <div id="calendarPendientes"></div>
                         </div>
                     </div>
                </div>
            </div>
            <div class="row">
                <div class="panel panel-info">
                    <div class="panel-heading" style="display: flex;justify-content: center;align-items: center; flex-direction: column; position: relative; ">
                        <h1 style="color: var(--color-principal);">
                            <i class="fa fa-address-card-o"></i> Fases de trabajo asignadas.
                        </h1> 
                    </div>
                    <div class="panel-body">
                        <div class="container-data-user">
                         <?php foreach ($MyPhases as $Phase): ?>
                                <!-- data client -->
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: <?= $Phase->UseColor; ?>; display: flex;">
                                        <h3><i class="fa <?= $Phase->Icon; ?>"></i> <?= $Phase->Name; ?></h3>

                                        <?= Html::submitButton('<i class="fa fa-sign-in"></i> Entrar en esta fase', ['class' => 'btn btn-color-especial', "style"=>'float:right; position:absolute; right: 5%; z-index: 2;', 'onclick'=>"location.href = '".Yii::getAlias('@web')."/jobs/phase/".$Phase->PhaseID."'"]) ?>
                                    </div>
                                    <div class="panel-body">
                                        <div class="container-fluid">
                                            <div class="row">Descripcion : <?= $Phase->Description; ?> </div>
                                            <div class="row">
                                                Esta fase tiene <b> prioridad <?= $Phase->Priority; ?> </b>
                                            </div>
                                            <div class="row">
                                                <?= ($Phase->Notification)? 'Al finalizar ordenes de produccion en esta fase <b>el sistema notificara al cliente de manera automatica</b>.' : 'Esta fase no envia notificaciones de manera automatica al finalizar ordenes de produccion.' ?>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <!-- end data client -->
                         <?php endforeach; ?>
                        </div>
                    </div>
                     <div class="panel-footer" style="display: flex;justify-content: center;align-items: center;">
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

        // console.log('advance');
       let st = $(this).attr('st');
       let idcl = $(this).attr('idcl');
       let oid = $('#clbox-'+idcl).attr('oid');
       if(Form['index-'+oid] == undefined){
        Form['index-'+oid] = {};
        // console.log('undefined');
       }
       Form['index-'+oid].Status = st;
       // console.log(Form);

       switch(st){
        case '2':
        // console.log('swich2');
            $('#clbox-'+idcl).fadeOut('slow',function(){
                    $('#clbox-'+idcl).html('');
                    $('#clbox-'+idcl).append('<button st=\"3\" idcl=\"'+idcl+'\" class=\"btn btn-warning advance\">Detener</button>');
                    $('#clbox-'+idcl).append('<button st=\"4\" idcl=\"'+idcl+'\" class=\"btn btn-success advance\">Completar</button>');
            });
            $('#clbox-'+idcl).fadeIn('slow');
        break;
        case '3':
        // console.log('swich3');
             $('#clbox-'+idcl).fadeOut('slow',function(){
                    $('#clbox-'+idcl).html('<button st=\"2\" idcl=\"'+idcl+'\" class=\"btn btn-info advance\">Continuar</button>');
             });
             $('#clbox-'+idcl).fadeIn('slow');
        break;
        case '4':
        // console.log('swich4');
            $('#clbox-'+idcl).fadeOut('slow',function(){
                let idclsg = parseInt(idcl) + 1;
                $('#clbox-'+idcl).html('');
                $('#clbox-'+idcl).append('<button class=\"btn btn-success advance\">Terminado</button>');
                // console.log($('#clbox-'+idclsg))
                if($('#clbox-'+idclsg) != undefined){
                    $('#clbox-'+idclsg).html('<button st=\"2\" idcl=\"'+idclsg+'\" class=\"btn btn-info advance\">Iniciar</button>');
                }
            });
            $('#clbox-'+idcl).fadeIn('slow');
        break;

       }


    });

    $('.selectDay').click(function(){
        // console.log('selectday');
        let oid = $(this).attr('oid');
        let st = $(this).attr('Date');
        if(Form['index-'+oid] == undefined){
            Form['index-'+oid] = {};
            // console.log('undefined');
       }
       Form['index-'+oid].OrderDate = st;
       // console.log(Form);
        });

    $('.ctest').click(function(){
       console.log(Form);
    });
";

$JSHead = "

    var Form = {};

    var SendChanges = function(){
        let data = JSON.stringify(Form);
        let Order = 0;
        $.post('".$urlHom."/orders/processorder',{OrderProcess: data, Order:Order},function(r){
                obj = JSON.parse(r);
                if(obj.Status == true){
                    // console.log(obj.Mensaje);
                    _Message(\"success\",\"¡Exito!\",obj.Mensaje)
                }else{
                    // console.log(obj.Mensaje);
                    _Message(\"error\",\"¡Error!\",obj.Mensaje)
                }
            });
    }

";
$this->registerJS($JSHead, \yii\web\View::POS_HEAD);
$this->registerJS($JS);

$FullCalendar = 
    "
        var calendarPend = document.getElementById('calendarPendientes');
         Calendario = new FullCalendar.Calendar(calendarPend, {
              plugins: ['interaction', 'dayGrid','timeGrid'],
              header: {
                left: 'prev,next today',
                center: 'title',
                defaultView: 'timeGridWeek',
        		weekends: false,
        		minTime: '08:00',
        		maxTime: '18:00',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
              },
              defaultDate: '".date("Y-m-d")."',
              navLinks: true,
              selectable: true,
              selectMirror: true,
              editable: false,
              eventLimit: true,
              events: ".json_encode($Events).",
          });
        Calendario.render();
    ";
$this->registerJS($FullCalendar);
?>