$(document).ready(function(){

///alert Confirm Eliminar
	$(document).on("click",".click-confirm",function(e){
		var c = $(this);
		e.preventDefault();

		if(c.attr("tittle-alert") == undefined){
			var tittle = "¡ Advertencia !";
		}else{var tittle = c.attr("tittle-alert"); }

		if(c.attr("text-alert") == undefined){
			var text = "¿ Esta completamente seguro ?";
		}else{var text = c.attr("text-alert"); }
					swal({
		          title: tittle,
		          text:text,
		          type: "warning",
		          showCancelButton: true,
		          confirmButtonColor: "#DD6B55",
		          confirmButtonText: "Ok",
		          cancelButtonText: "No",
		          closeOnConfirm: false,
		          closeOnCancel: true
		        },
		        function(isConfirm){
		          if (isConfirm) {
		          		if($(c).attr("href") != undefined){
		          			window.location.href =$(c).attr("href");
		          			$(".cancel").click();
		          		}else if($(c).attr("confirm-exec") != undefined){
		          			// parafunciones creadas en lavista usar >>> $this->registerJS($JSHead, \yii\web\View::POS_HEAD);
		          			eval($(c).attr("confirm-exec"));
		          			$(".cancel").click();
		          		}else{
		          			$(c).submit();
		          			$(".cancel").click();
		          		}
		            	return false;
		          }else{
		          	return false;
		          }
		        });
	});

});


	///alert Confirm Eliminar
var _Message = function(type = "success",tittle = "¡Exito!", message = "¡Proceso Completado!"){
	
							  swal({
					          title: tittle,
					          text:message,
					          type: type,
					          showCancelButton: false,
					          confirmButtonColor: "#DD6B55",
					          confirmButtonText: "Ok",
					          closeOnConfirm: true,
					          closeOnCancel: true
					        },
					        function(){
					        });
			}
	
			// _Message()