<?php
 
use frontend\assets\AppAssetLayoutAll;
AppAssetLayoutAll::register($this);

use common\assets\AppAssetFullCalendar;
AppAssetFullCalendar::register($this);
 
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Button;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

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
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="row">
                <div class="panel panel-info">
                    <div class="panel-heading" style="display: flex;justify-content: center;align-items: center; flex-direction: column; position: relative; ">
                        <h4 style="color: var(--color-principal);">
                            <i class="fa fa-user"></i> <?= Html::encode($this->title)." Numero "; ?>
                        </h4> 
                        <h1> <?= str_pad($OrderData->OrderID, 5, '0', STR_PAD_LEFT); ?> </h1>
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
                                            Identificacion : <?= $OrderData->clients->Identify.'-'.$OrderData->clients->IDP; ?>
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
                                            Monto Total : <?= $OrderData->TotalAmount; ?>
                                        </div>
                                        <div class="row">
                                            Monto Abonado : <?= $OrderData->PaymentAmount; ?>
                                        </div>
                                        <div class="row">
                                            Monto Restante : <?= $OrderData->RemainingAmount; ?>
                                        </div>
                                        <div class="row">
                                            Generada por : <?= isset($OrderData->account->agency->FirstName)? $OrderData->account->agency->FirstName .'( ' .$OrderData->account->userAccount->UserName . ' )' : '( ' .$OrderData->account->userAccount->UserName . ' )'; ?>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <!-- end data client -->

                            <?php   $BlockButtons = false;   $EventsASig = [];
                             foreach ( $OrderData->orderByPhase as $key => $d): ?>
                                <!-- data phases -->
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color:<?= $d->phases->UseColor; ?> ; ">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <h3><i class="fa <?= $d->phases->Icon; ?>"></i> Fase <b><?= $d->phases->Name; ?>.</b></h3>
                                                <?php if($d->phases->OnlyUser): ?>
                                                <h6><i class="fa fa-user"></i> Usuario asignado <b><?= isset($d->account->userAccount->UserName)? $d->account->userAccount->UserName : 'Usuario no definido' ?>.</b></h6>
                                                <?php 
                                                    //Armar listado de usuarios asignados a fases para el chosen
                                                        $UsersItems = ArrayHelper::map(
                                                                            $d->phases->usersThisPhase,
                                                                            'AccountID',
                                                                            function($model){
                                                                            if(!empty($model->account->agency)){
                                                                                return "[". $model->UserName . "]" . $model->account->agency->FirstName . " " . $model->account->agency->LastName;
                                                                            }else{
                                                                                return $model->UserName ;
                                                                            }
                                                                        });

                                                        $UsersAccountsID = array_keys($UsersItems);
                                                        $inList = in_array($d->AccountID, $UsersAccountsID);

                                                    ?>
                                                    <span class="span-chosen">
                                                    <?= Chosen::widget([
                                                                        'name'=>'SelectedPhases'.$d->OrderByPhaseID,
                                                                        //'oid'=> $d->OrderByPhaseID,
                                                                        'items' =>  $UsersItems,
                                                                        'id' => $d->OrderByPhaseID,
                                                                        'class'=>'selectorUs',
                                                                        'placeholder'=>'Buscar Usuario',
                                                                        'allowDeselect' => true,
                                                                        'ChosenDisabled' => ($d->Status < 2)? false : true,
                                                                        'value'=> ($inList)? $d->AccountID : '',
                                                                        'disableSearch' => false, // Search input will be disabled
                                                                        'clientOptions' => [
                                                                            'search_contains' => true,
                                                                            'max_selected_options' => 1,
                                                                        ],
                                                                ]); ?>
                                                    </span>
                                                
                                                <?php endif; ?>

                                                <h5><button value="<?= $d->OrderByPhaseID; ?>" st="<?= empty($d->OrderDate)? '0':'1'; ?>" class="showhidecalendar"><?= empty($d->OrderDate)? 'Mostrar Calendario?':'Ocultar Calendaio?'; ?></button></h5>
                                                <?php if(!empty($d->OrderDate)){ 
                                                    $var =myFdateView($d->OrderDate);
                                                   echo  '<h6> <i>Tiene fecha de entrega establecida para el : <b>'.$var.'</b></i> </h6>';} ?>
                                            </div>
                                            <div class="col-sm-6" style="display: flex; justify-content: flex-end;">
                                                <div class="box-button" id="clbox-<?= $key; ?>" oid="<?= $d->OrderByPhaseID; ?>">
                                                    <?php if(!$BlockButtons): $BlockButtons = true; ?>
                                                            <?php switch (TRUE) {
                                                                 case ($d->Status =='0'): ?>
                                                                        <div class="row" style="display: flex; justify-content: flex-end;">
                                                                        <button st="1" idcl="<?= $key; ?>" class=" btn btn-info advance">Iniciar</button></div>
                                                            <?php break;
                                                                     case ($d->Status == '1'):  ?>
                                                                        <div class="row" style="display: flex; justify-content: flex-end;">
                                                                        <button st="0" vsbl="1" idcl="<?= $key; ?>" class="btn btn-warning advance">Cancelar</button></div><div class="row" style="display: flex; justify-content: flex-end;"> <button st="4" idcl="<?= $key; ?>" class="btn btn-success ">La fase aun no ha sido iniciada por los encargados.</button></div>
                                                            <?php break;
                                                                     case ($d->Status == '2'): ?>
                                                                     <div class="row" style="display: flex; justify-content: flex-end;">
                                                                        <button class="btn btn-info">Lafase se ha iniciado.</button></div>
                                                            <?php break;
                                                                    case ($d->Status == '3'): ?>
                                                                    <div class="row" style="display: flex; justify-content: flex-end;">
                                                                        <button class="btn btn-danger">Lafase se encuentra detenida.</button></div>
                                                            <?php break;
                                                                    default: ?>
                                                                    <div class="row" style="display: flex; justify-content: flex-end;">
                                                                    <button class="btn btn-success advance">Fase Terminada.</button></div>
                                                            <?php break; } ?>
                                                    <?php else: ?>
                                                            <?php switch (TRUE) {
                                                                 case ($d->Status =='0'): ?>
                                                                 <div class="row" style="display: flex; justify-content: flex-end;">
                                                                        <button class="btn btn-info"> Esta fase aun no puede iniciar</button></div>
                                                            <?php break;
                                                                     case ($d->Status == '1'):  ?>
                                                                     <div class="row" style="display: flex; justify-content: flex-end;">
                                                                            <button class="btn btn-info"> La fase aun no ha sido iniciada por los encargados.</button></div>
                                                            <?php break;
                                                                     case ($d->Status == '2'): ?>
                                                                     <div class="row" style="display: flex; justify-content: flex-end;">
                                                                         <button class="btn btn-info"> Lafase se ha iniciado.</button></div>
                                                            <?php break;
                                                                    case ($d->Status == '3'): ?>
                                                                    <div class="row" style="display: flex; justify-content: flex-end;">
                                                                         <button class="btn btn-danger">Lafase se encuentra detenida.</button></div>
                                                            <?php break;
                                                                    default: ?>
                                                                    <div class="row" style="display: flex; justify-content: flex-end;">
                                                                    <button class="btn btn-success advance">Fase Terminada.</button></div>
                                                            <?php break; } ?>
                                                    <?php endif; ?>
                                                </div>  
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="panel-body" style="display: flex;justify-content: center;align-items: center; flex-direction: column;">
                                        <!-- cuando establescas el calendario deberas bloquearlo si la faseesta terminada asi como bloqueoel textarea -->
                                        <!-- <textarea placeholder="Calendario" cols="100" rows="5"<?= ($d->Status > 3 )? 'disabled' : '' ?> > --><?php 
                                        $EventsASig['id'.$d->OrderByPhaseID] = [];
                                        if(!$d->phases->OnlyUser){
                                            $FaseData = $d->phases->orderByPhaseRsvGroup; 
                                            foreach ($FaseData as $Fases):
                                                   // echo "[ Fecha: ".$Fases->OrderDate." Cantidad: ".$Fases->Amount."] ";
                                                    $Var['start'] = $Fases->OrderDate;
                                                    $Var['title'] = '('.$Fases->Amount.') Entregas Para este dia';
                                                    switch (true) {
                                                        case ($Fases->Amount >=  $ConfigEventsRange->free->min && $Fases->Amount <= $ConfigEventsRange->free->max):
                                                            $Var['color'] = '#257e4a';
                                                          break;

                                                        case ($Fases->Amount >=  $ConfigEventsRange->medium->min && $Fases->Amount <= $ConfigEventsRange->medium->max):
                                                            $Var['color'] = '#ffbd29';
                                                          break;
                                                        case ($Fases->Amount >=  $ConfigEventsRange->full->min && $Fases->Amount <= $ConfigEventsRange->full->max):
                                                            $Var['color'] = '#ff0000';
                                                          break;
                                                    }

                                                    array_push($EventsASig['id'.$d->OrderByPhaseID], (Object)$Var);

                                            endforeach;
                                        }else{
                                            $SpecificPhase = $OrderData->getOrdersSpecificPhaseAndUserForGroup($d->phases->PhaseID,$d->AccountID);
                                            foreach ($SpecificPhase as $Fases):
                                                   // echo "[ Fecha: ".$Fases->OrderDate." Cantidad: ".$Fases->Amount."] ";
                                                    $Var['start'] = $Fases->OrderDate;
                                                    $Var['title'] = '('.$Fases->Amount.') Entregas Para este dia';
                                                    switch (true) {
                                                        case ($Fases->Amount >=  $ConfigEventsRange->free->min && $Fases->Amount <= $ConfigEventsRange->free->max):
                                                            $Var['color'] = '#257e4a';
                                                          break;

                                                        case ($Fases->Amount >=  $ConfigEventsRange->medium->min && $Fases->Amount <= $ConfigEventsRange->medium->max):
                                                            $Var['color'] = '#ffbd29';
                                                          break;
                                                        case ($Fases->Amount >=  $ConfigEventsRange->full->min && $Fases->Amount <= $ConfigEventsRange->full->max):
                                                            $Var['color'] = '#ff0000';
                                                          break;
                                                    }

                                                    array_push($EventsASig['id'.$d->OrderByPhaseID], (Object)$Var);
                                            endforeach;
                                        }
                                        ?><!-- </textarea> -->
                                       <!--  <div>
                                        <button class="selectDay" date="20-5-2019" oid="<?= $d->OrderByPhaseID; ?>"> Dia 1 [20-5-2019]</button>
                                        <button class="selectDay" date="21-5-2019" oid="<?= $d->OrderByPhaseID; ?>"> Dia 2 [21-5-2019]</button>
                                        <button class="selectDay" date="22-5-2019" oid="<?= $d->OrderByPhaseID; ?>"> Dia 3 [22-5-2019]</button>
                                        <button class="selectDay" date="23-5-2019" oid="<?= $d->OrderByPhaseID; ?>"> Dia 4 [23-5-2019]</button>
                                        <button class="selectDay" date="24-5-2019" oid="<?= $d->OrderByPhaseID; ?>"> Dia 5 [24-5-2019]</button>
                                        </div> -->
                                        <div id='calendar-<?= $d->OrderByPhaseID; ?>'></div>
                                    </div>
                                </div> 
                                <!-- end data phases -->
                        <?php endforeach; ?>
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
    $('.span-chosen').on('change','select',function(){
        console.log('cambio el select');
        let ids = $(this).attr('id');

        if(Form['index-'+ids] == undefined){
            Form['index-'+ids] = {};
       }
       if($(this).val() != undefined && $(this).val() != ''){
            Form['index-'+ids].AccountID = $(this).val();
            $.get('".$urlHom."/orders/opa',{o:ids,a:$(this).val()},function(c){
                    console.log(c);
                    let d = JSON.parse(c);

                    let LastEvents = Calendaris['c'+ids].getEvents();

                     $.each(LastEvents,function(k,v){
                         v.remove();
                     });
                     console.log(d.data);
                     $.each(d.data,function(k,v){
                        console.log('add '+k);
                            Calendaris['c'+ids].addEvent(v);
                      });
                });
       }else{
           delete Form['index-'+ids].AccountID; 

            let LastEvents = Calendaris['c'+ids].getEvents();

            $.each(LastEvents,function(k,v){
                 v.remove();
             });

           let arrtmp = Object.keys(Form); 
           if(arrtmp.length > 0){
               $.each(arrtmp,function(e,v){
                console.log(Object.keys(Form[v]).length);
                            if(Object.keys(Form[v]).length <= 0){
                                delete Form[v];
                            }

                    });
            }
       }
        
    });

   $('.box-button').on('click','.advance',function(){

        // console.log('advance');
       let st = $(this).attr('st');
       let vsbl = $(this).attr('vsbl');
       let idcl = $(this).attr('idcl');
       let oid = $('#clbox-'+idcl).attr('oid');
       if(Form['index-'+oid] == undefined){
        Form['index-'+oid] = {};
        // console.log('undefined');
       }
       Form['index-'+oid].Status = st;
       // console.log(Form);

       switch(st){
        case '1':
        // console.log('swich2');

            if(vsbl == 1){
                $('#clbox-'+idcl).fadeOut('slow',function(){
                    $('#clbox-'+idcl).html('<div class=\"row\" style=\"display: flex; justify-content: flex-end;\"><button st=\"1\" vsbl=\"1\" idcl=\"'+idcl+'\" class=\"btn btn-warning advance\">Cancelar</button></div>');
                    $('#clbox-'+idcl).append('<div class=\"row\" style=\"display: flex; justify-content: flex-end;\"><button idcl=\"'+idcl+'\" class=\"btn btn-success \">La fase aun no ha sido iniciada por los encargados.</button></div>');
                 });

            }else{
                $('#clbox-'+idcl).fadeOut('slow',function(){
                        $('#clbox-'+idcl).html('');
                        $('#clbox-'+idcl).append('<div class=\"row\" style=\"display: flex; justify-content: flex-end;\"><button st=\"0\" idcl=\"'+idcl+'\" class=\"btn btn-warning advance\">Cancelar</button></div>');
                        $('#clbox-'+idcl).append('<div class=\"row\" style=\"display: flex; justify-content: flex-end;\"><button idcl=\"'+idcl+'\" class=\"btn btn-success \">La fase sera visible para los encargados al aplicar los cambios.</button></div>');
                });
            }

            $('#clbox-'+idcl).fadeIn('slow');
        break;
            case '0':
            if(vsbl == 1){
                 $('#clbox-'+idcl).fadeOut('slow',function(){
                    $('#clbox-'+idcl).html('<div class=\"row\" style=\"display: flex; justify-content: flex-end;\"><button st=\"1\" vsbl=\"1\" idcl=\"'+idcl+'\" class=\"btn btn-info advance\">Iniciar</button></div>');
                    $('#clbox-'+idcl).append('<div class=\"row\" style=\"display: flex; justify-content: flex-end;\"><button idcl=\"'+idcl+'\" class=\"btn btn-warning \">La fase actualmente se encuentra visible para los encargados si aplica los cambios dejara de estarlo.</button></div>');
                 });
                }else{
                // console.log('swich3');
                     $('#clbox-'+idcl).fadeOut('slow',function(){
                            $('#clbox-'+idcl).html('<div class=\"row\" style=\"display: flex; justify-content: flex-end;\"><button st=\"1\" idcl=\"'+idcl+'\" class=\"btn btn-info advance\">Iniciar</button></div>');
                     });
                 }
            $('#clbox-'+idcl).fadeIn('slow');
        break;

       }


    });

    // $('.selectDay').click(function(){
    //     // console.log('selectday');
    //     let oid = $(this).attr('oid');
    //     let st = $(this).attr('Date');
    //     if(Form['index-'+oid] == undefined){
    //         Form['index-'+oid] = {};
    //         // console.log('undefined');
    //    }
    //    Form['index-'+oid].OrderDate = st;
    //    // console.log(Form);
    //     });

    $('.ctest').click(function(){
       console.log(Form);
    });


    $('.showhidecalendar').click(function(){
        let st = $(this).attr('st');
        if(st == '1'){
            let validp = $(this).val();
            $('#calendar-'+validp).hide();
            $(this).attr('st','0');
            $(this).html('Mostrar Calendario?');
        }
        if(st == '0'){
            let validp = $(this).val();
            $('#calendar-'+validp).show();
            $(this).attr('st','1');
            $(this).html('Ocultar Calendaio?');
        }
    });
";

$JSHead = "

    var Form = {};
    var Calendaris = {};

    var SendChanges = function(){
        let data = JSON.stringify(Form);
        let Order = ".$OrderID."
        $.post('".$urlHom."/orders/processorder',{OrderProcess: data, Order:Order},function(r){
                location.reload();
            });
    }

";
$this->registerJS($JSHead, \yii\web\View::POS_HEAD);
$this->registerJS($JS);



foreach ( $OrderData->orderByPhase as $key => $d):
            $FullCalendar = "
                var calendarEl".$d->OrderByPhaseID." = document.getElementById('calendar-".$d->OrderByPhaseID."');
                var oderphaseid".$d->OrderByPhaseID." = ".$d->OrderByPhaseID.";

                 Calendaris['c".$d->OrderByPhaseID."'] = new FullCalendar.Calendar(calendarEl".$d->OrderByPhaseID.", {
                  plugins: [ 'interaction', 'dayGrid','timeGrid'],
                  header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                  },
                  defaultDate: '".date("Y-m-d")."',
                  navLinks: true, // can click day/week names to navigate views
                  selectable: true,
                  selectMirror: true,
                  ";
            $FullCalendar .= ($d->Status < '2')? "
                  select: function(arg) {
                    console.log(arg);
                    var title".$d->OrderByPhaseID." = 'Dia de entrega';

                    if(Form['index-".$d->OrderByPhaseID."'] == undefined){
                            Form['index-".$d->OrderByPhaseID."'] = {};
                       }


                    if ( Form['index-".$d->OrderByPhaseID."'].OrderDate == undefined) {
                        console.log(arg.startStr);
                        Form['index-".$d->OrderByPhaseID."'].OrderDate =arg.startStr;
                      Calendaris['c".$d->OrderByPhaseID."'].addEvent({
                        title: title".$d->OrderByPhaseID.",
                        start: arg.start,
                        allDay: arg.allDay
                      })
                    }
                    Calendaris['c".$d->OrderByPhaseID."'].unselect()
                  },
                  " : "";

            $FullCalendar .= "
                  editable: false,
                  eventLimit: true, // allow more link when too many events
                  events: ".json_encode($EventsASig['id'.$d->OrderByPhaseID]).",";

            $FullCalendar .= ($d->Status < '2')? "
                            eventClick: function(arg) {
                                console.log(arg.event.title);
                                if('Dia de entrega' == arg.event.title){
                                    if (confirm('Eliminar seleccion?')) {
                                        arg.event.remove();
                                       delete Form['index-".$d->OrderByPhaseID."'];
                                    }
                                }
                              }" : "";
            $FullCalendar .= "
                });
                Calendaris['c".$d->OrderByPhaseID."'].render();
            ";

            if(!empty($d->OrderDate)){
                $FullCalendar .= "
                         Form['index-".$d->OrderByPhaseID."'] = {};
                         Form['index-".$d->OrderByPhaseID."'].OrderDate = '".$d->OrderDate."';


                         Calendaris['c".$d->OrderByPhaseID."'].addEvent({
                            title: 'Dia de entrega',
                            start: '".$d->OrderDate."',
                          });
                      

                ";
             }else{
                 $FullCalendar .= " $('#calendar-".$d->OrderByPhaseID."').hide();";
             }


        $this->registerJS($FullCalendar);
endforeach;


?>