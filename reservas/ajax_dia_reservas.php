<?php  
	setlocale(LC_ALL, 'pt_BR');
	$data_extenso = date('d M  Y');
	echo $data_extenso;
?>
	<table class="table">
	<tr>
		<th>Hora</th>
		<th>sala</th>
		<th>usuario</th>		
	</tr>
	<?php  $inicio= $reservas->horario_inicio;
			$fim =  $reservas->horario_fim;

			for($i=$inicio; $i<=$fim; $i++){ ?>
			<tr>
				<td><?php echo $i; ?></td>
				<td></td>
				<td></td>
			</tr>
				
	<?php }	 ?>
	 </table>