<button id="reg_btn">Limpiar</button>
<table border="2">
	<tr>
		<td>Register Nº</td>
		<td>Machine Nº</td>
		<td>Status</td>
		<td>Date</td>
	</tr>
	<?php foreach ($Machines as $D):  ?>
		<tr>
			<td><?= $D->Id?></td>
			<td><?= $D->Num?></td>
			<td><?= $D->Status?></td>
			<td><?= $D->CreateAt?></td>
		</tr>
	<?php endforeach; ?>
</table>
 <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

<script type="text/javascript">
	$('#reg_btn').on('click',function(){

            $.get('delete',function(a){
            	console.log(a)
            	if(a == 1){
            		location.reload(true);
            	}
            });

        });
</script>