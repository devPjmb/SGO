<?php
	use frontend\assets\AppAssetLayoutAll;
	AppAssetLayoutAll::register($this);
	 
	use frontend\assets\AppAsset;
	use yii\helpers\Html;
	use yii\bootstrap\Button;
	use yii\bootstrap\ActiveForm;
	use common\components\datatables\DataTables;
	use common\components\datepicker\DatePicker;

	$this->title = 'Posponer Orden';
	$this->params['breadcrumbs'][] = $this->title;

	function FechaEsp ($fecha)
	{
		$fecha = substr($fecha, 0, 10);
		$numeroDia = date('d', strtotime($fecha));
		$dia = date('l', strtotime($fecha));
		$mes = date('F', strtotime($fecha));
		$anio = date('Y', strtotime($fecha));
		$dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
		$dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
		$nombredia = str_replace($dias_EN, $dias_ES, $dia);
		$meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
		$meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		$nombreMes = str_replace($meses_EN, $meses_ES, $mes);
		return $nombredia." ".$numeroDia." de ".$nombreMes;
	}
?>

<div class="HomeRole">
    <br>
    <div class="container-fluid">
    	<div class="row">
    		<?php $form = ActiveForm::begin(['id' => 'stop-Order', 'method' => 'post']); ?>
    		<div class="panel panel-warning">
    			<div class="panel-heading" style="display: flex;justify-content: center;align-items: center;">
                    <h2 style="color: var(--color-principal);"><i class="fa fa-clock-o"></i> <?= Html::encode($this->title)?></h2>
                </div>
                <div class="panel-body">
                	<div class="container-data-user">
                		<div class="col-sm-12">
                			<textarea class="form-control" name="msgClient" id="msgClient" placeholder="Indique el motivo por el cual se va a detener la orden." maxlength="69"></textarea>
                			<small><strong>Nota: Este sera el mensaje que le llegara al cliente via SMS</strong></small> <br>
                			<span><strong>Cantidad de Caracteres Restantes: </strong></span><span id="contador">69</span>
                        </div>
                        <div class="col-sm-12" style="margin: 25px 0 0 0">
                        	<?= DatePicker::widget([
				                'name' => 'newDate',
				                    'options' => [
				                        'class' => 'form-control',
				                        'placeholder' => 'Nueva fecha para lo orden'
				                    ],
				                    'clientOptions' => [
				                        'format' => 'YYYY-MM-DD hh:mm A', 
				                        'stepping' => 30,
				                    ]
				                ]);
				            ?>
                        	<strong>La fecha actual de la orden es: <?php echo $modelOrder->DeliveryDate; ?></strong>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                        <?= Html::submitButton('Posponer Orden', ['class' => 'btn btn-color-especial btn-block click-confirm']) ?>
                    </div>
    		<?php ActiveForm::end(); ?>
    	</div>
    </div>
</div>

<?php 

	$this->registerJS("
		var max_chars = 69;

	    $('#max').html(max_chars);

	    $('#msgClient').keyup(function() {
	        var chars = $(this).val().length;
	        var diff = max_chars - chars;
	        $('#contador').html(diff);   
	    });
	");

?>