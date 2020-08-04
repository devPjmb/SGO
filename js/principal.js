var loc = window.location.search;
var cadena = loc.split("=")

$('document').ready(function(){
	// verifica si la pagina viene del blog
	if (loc != "") {
		recibirurl(cadena[1])
	}
    colores();
    if (window.location.pathname.length > 26) {
        moverproduct();  
    }
 	$('.carousel').carousel();
    setInterval(function(){$('.carousel').carousel('next')}, 2000);
	$(".button-collapse").sideNav();
	$('.slider').slider();
 	// $('ul.tabs').tabs('select_tab', 'tab_id');
 	$('.cardfd_').fadeOut();
    $('#card-tabs-h0').fadeIn();
    $('#card-tabs-h1').addClass('hide');
    $('#card-tabs-h2').addClass('hide');
    $('#card-tabs-h3').addClass('hide');
    $('#card-tabs-h4').addClass('hide');
    $('#card-tabs-h5').addClass('hide');
    //boton seccion home
    $('.btnhome').click(function(){
        $('html,body').animate({
            scrollTop: $("#home").offset().top 
        }, 2000);
    });
    //boton seccion produmoverproduct
    $('.btnproductos').click(function(){
       $('html,body').animate({
            scrollTop: $("#productos").offset().top - $(".menu").height()
        }, 2000);
    });
    //boton seccion certificaciones
    $('.btninocali').click(function(){
       $('html,body').animate({
            scrollTop: $("#certificaciones").offset().top - $(".menu").height()
        }, 2000);
    });
    //boton seccion  inocuidad y calidad
    $('.btnresponsabilidad').click(function(){
       $('html,body').animate({
            scrollTop: $("#inocali").offset().top - $(".menu").height()
        }, 2000);
    });
    //boton seccion contactanos
    $('.btncontactanos').click(function(){
       $('html,body').animate({
            scrollTop: $("#contactanos").offset().top - $(".menu").height()
        }, 2000);
    });
});
function cambioimg(a)
{
    $('.btncm').hide();
	switch(a){
		case 'm':
			$('#img4').removeClass('hide');
			$('#img5').addClass('hide');
			$('#img6').addClass('hide');
			$('#m').addClass('activess');
			$('#v').removeClass('activess');
			$('#vs').removeClass('activess');
            $('#btn0').show();
			break;
		case 'v':
			$('#img5').removeClass('hide');
			$('#img4').addClass('hide');
			$('#img6').addClass('hide');
			$('#v').addClass('activess');
			$('#m').removeClass('activess');
			$('#vs').removeClass('activess');
            $('#btn1').show();
			break;
		case 'vs':
			$('#img6').removeClass('hide');
			$('#img4').addClass('hide');
			$('#img5').addClass('hide');
			$('#vs').addClass('activess');
			$('#v').removeClass('activess');
			$('#m').removeClass('activess');
            $('#btn2').show();
			break;
	}
}
function cambiocard(b)
{
    $('#card-tabs-'+b).removeClass('hide');
    $('#card-tabs-h0').addClass('hide');
	$('.cardfd_').fadeOut();
	setTimeout(function(){ $('#card-tabs-'+b).fadeIn(); }, 500);

}

function recibirurl(id){
	var idsection = "#"+id
	$('html,body').animate({
            scrollTop: $(idsection).offset().top - tam
        }, 2000);
}
function colores()
{
    $('.vinculo').each(function(key, valor){
        if ($(this).text()==1) {
            $(this).css('background','#40Bf00')
        }else if ($(this).text()==2) {
            $(this).css('background','#FFFF27')
        }else if ($(this).text()==3) {
            $(this).css('background','#FF2B27')
        }

    })
}
function redireccion(b){
    switch(b){
        case '_fresh':
            window.location = "http://dev.mydesk.digital/sitioagroexport/producto/retail" ;
            break;
        case '_spMark':

            break;
        case '_mark':
            break;
    }
}

function funredirect(id, retail, food, market) {
    if (retail) {
       window.location.href = "/sitioagroexport/producto/retail/"+id;
    } else if (food) {
        window.location.href = "/sitioagroexport/producto/food/"+id;
    } else {
        window.location.href = "/sitioagroexport/producto/market/"+id;
    }
}

function moverproduct() {
    var id = window.location.pathname.substr(26).split("/");
    if (!isNaN(id[1]) && id[1] != '' && id[0] != 'index') {
        $('html,body').animate({
            scrollTop: $('#'+id[1]).offset().top - $(".menu").height()
        }, 2000);
    }
}

function enviarurl(id) {
    var server = window.location.href.substr(0, 26);
    if (id == "nuestrasmarcas") {
        var ruta = server + "sitioagroexport/distribucion/";
    }else if (id == "nosotros") {
        var ruta = server + "sitioagroexport/nosotros/index/1";
    }else {
        var ruta = server + "sitioagroexport/#" + id;
    }
    window.location.href = ruta
}


	





// 
// display: block;
// width: 95px;
// overflow: hidden;
// word-wrap: break-word;
// word-break: break-all;
// height: 100px;
// margin: 0px;
// text-align: center;
// 
// 
// 