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

	use common\components\chosen\Chosen;
	use common\components\datatables\DataTables;
	$this->title = 'Todas Las Ordenes Pendientes y En Ejecucion';
	$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
	<div class="panel panel-info">
		<div class="panel-heading" style="display: flex;justify-content: center;align-items: center; flex-direction: column; position: relative; ">
			<i class="fa fa-calendar"></i> Todas las ordenes pendientes
		</div>
		<div class="panel-body">
			<div class="container-fluid">
				<div id="allorders-calendar"></div>
			</div>
		</div>
	</div>
</div>

<?php 
	$FullCalendar = 
	"
		var calendarPend = document.getElementById('allorders-calendar');
		Calendario = new FullCalendar.Calendar(calendarPend, {
			plugins: ['interaction', 'dayGrid','timeGrid'],
			defaultView: 'timeGridWeek',
			weekends: false,
			minTime: '08:00',
			maxTime: '18:00',
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'dayGridMonth,timeGridWeek,timeGridDay'
			},
			defaultDate: '".date("Y-m-d")."',
			navLinks: true,
			selectable: true,
			selectMirror: true,
			editable: false,
			eventLimit: true,
			events: ".json_encode($DataArrayOrders).",
		});
		Calendario.render();
	";
	$this->registerJS($FullCalendar);
?>