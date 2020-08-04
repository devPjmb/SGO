$(document).ready(function() {
	// motrara el input para agregar una nueva foto al post
	$('.ocultal').fadeOut()
	$('#blog-yes').click(function(){
		$('.ocultal').fadeIn(2000)
		$('#blog-repuesta').val('true')
	});
	$('#blog-no').click(function(){
		$('.ocultal').fadeOut(2000)
		$('#blog-repuesta').val('false')
	});

	//abrira una modal para selecionar los tags
	$('#blog-tags').focus(function(){
		$(this).attr('readonly', true)
		$('#modaltags').modal('show')
		var input = $('#blog-tags')
		var input2 = $('.input-tag')
		input2.tagsinput('add', input.val())
		var arretag = input.val().split(",")
		$.each(arretag, function (key, valor) {
			$('.chkbox').each(function(){
				if ($(this).val() == valor) {
					$(this).prop("checked", true)
				}
			});
		});
	});

	// cierra la modal y pasa los tag selecionado al input que sera enviado a la bd
	$('#modaltags').on('hide.bs.modal', function(){
		var input = $('#blog-tags')
		var input2 = $('.input-tag')
		input.attr('readonly', false)
		input.val(input2.tagsinput('items'))
	});
	 $('.bootstrap-tagsinput input').attr('readonly', true)
});

//linea que llama al CKEditor
CKEDITOR.replace("blog-editor");
//fin linea que llama el CKeditor

// agregara tags al formulario de tags
function obtenertag(i) {
	var chkbox = $('#' + i)
	var valor = $('#' + i).val()
	var input2 = $('.input-tag')
	chkbox.on('change', function(){
		if ($(this).is(':checked')) {
			input2.tagsinput('add', valor)
		}else {
			input2.tagsinput('remove', valor)
		}
	});
}

