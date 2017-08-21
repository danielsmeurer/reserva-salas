$('document').ready(function(){

//função clique para exclusão de usuario
	$('.user_excluir').on('click',function(){
		var id = $(this).attr('data-target');
		$('#delete-modal-usuario').modal();
		$("#confirm").attr('onclick','excluirUsuario('+id+')');	
				
	})	
//função clique para exclusão de sala
	$('.sala_excluir').on('click',function(){
		var id = $(this).attr('data-target');
		$('#delete-modal-sala').modal();
		$("#confirm").attr('onclick','excluirSala('+id+')');	
				
	})	

	//função clique para exclusão de reserva
	$('.reserva_excluir').on('click',function(){
		var id = $(this).attr('data-target');
		$('#delete-modal-reserva').modal();
		$("#confirm").attr('onclick','excluirReserva('+id+')');	
				
	})	

	$( "#data" ).datepicker({
		changeMonth: true,
      	changeYear: true,
		minDate: -0, 
		maxDate: "+24M +0D",
		dateFormat: 'dd/mm/yy',
		dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
		dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
		dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
		monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
		monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
		nextText: 'Próximo',
		prevText: 'Anterior',
	      showOn: "button",
	      buttonImage: "../template/imgs/calendar-ico.gif",
	      buttonImageOnly: false,
	      buttonText: "Selecione a data"
	 })
	

	 //dataFormatada( );


});

function dataFormatada() {
  var data = new Date(),
    dia = data.getDate(),
    mes = data.getMonth() + 1,
    ano = data.getFullYear();
  return [dia, mes, ano].join('/');
}



//Função para exclusao de usuario
function excluirUsuario(id){
	$.post( "ajax_excluir_usuario", {id_user : id},function( data ) {
		if(data=='true'){
			$('.retorno_delete_usuario').html("<div class='alert alert-success'><a data-dismiss='alert' class='close'>×</a>Usuário excluido com sucesso!</div>");
			$.post( "ajax_lista_usuarios", function( data ) {
			  	$('tbody').html(data);
			  });
		}
		else{
			$('.retorno_delete_usuario').html("<div class='alert alert-warning'><a data-dismiss='alert' class='close'>×</a>Ocorreu um erro . Usuário não foi excluido!</div>");
		}
		setTimeout(function(){
		$('#delete-modal-usuario').modal("hide");		 
		}, 100);	  	
	})
}

//Função para exclusao de sala
function excluirSala(id){
	$.post( "ajax_excluir_sala", {id_sala : id},function( data ) {
		if(data=='true'){
			$('.retorno_delete_sala').html("<div class='alert alert-success'><a data-dismiss='alert' class='close'>×</a>Sala excluida com sucesso!</div>");
			$.post( "ajax_lista_salas", function( data ) {
			  	$('tbody').html(data);
			  });
		}
		else{
			$('.retorno_delete_usuario').html("<div class='alert alert-warning'><a data-dismiss='alert' class='close'>×</a>Ocorreu um erro . Sala não foi excluida!</div>");
		}
		setTimeout(function(){
		$('#delete-modal-sala').modal("hide");		 
		}, 100);	  	
	})
}

//Função para exclusao de reserva
function excluirReserva(id){
	$.post( "ajax_excluir_reserva", {id_reserva : id},function( data ) {
		if(data=='true'){
			$('.retorno_delete_reserva').html("<div class='alert alert-success'><a data-dismiss='alert' class='close'>×</a>Reserva excluida com sucesso!</div>");
			$.post( "ajax_lista_reserva", function( data ) {
			  	$('tbody').html(data);
			  });
		}
		else{
			$('.retorno_delete_reserva').html("<div class='alert alert-warning'><a data-dismiss='alert' class='close'>×</a>Ocorreu um erro . Reserva não foi excluida!</div>");
		}
		setTimeout(function(){
		$('#delete-modal-reserva').modal("hide");		 
		}, 100);	  	
	})
}