$(document).ready(function(){

///alert Confirm Eliminar
	$(document).on("click",".click-confirm",function(e){
		var c = $(this);
		e.preventDefault();

		if(c.attr("tittle-alert") == undefined){
			var tittle = "Warning";
		}else{var tittle = c.attr("tittle-alert"); }

		if(c.attr("text-alert") == undefined){
			var text = "Are you absolutely sure ?";
		}else{var text = c.attr("text-alert"); }
					swal({
		          title: tittle,
		          text:text,
		          type: "warning",
		          showCancelButton: true,
		          confirmButtonColor: "#DD6B55",
		          confirmButtonText: "Yes",
		          cancelButtonText: "No",
		          closeOnConfirm: false,
		          closeOnCancel: true
		        },
		        function(isConfirm){
		          if (isConfirm) {
		          		if($(c).attr("href") != undefined){
		          			window.location.href =$(c).attr("href");
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
var _Message = function(type = "success",tittle = "Success!", message = "Process Successful!"){
	
							  swal({
					          title: tittle,
					          text:message,
					          type: type,
					          showCancelButton: false,
					          confirmButtonColor: "#DD6B55",
					          confirmButtonText: "Yes",
					          closeOnConfirm: true,
					          closeOnCancel: true
					        },
					        function(){
					        });
			}
	
			// _Message()