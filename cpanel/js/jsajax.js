$(document).ready(function() {
    //------------------------------------- Post Funciones
    //envio de el formulario post
    $('#btnform').click(function() {
        var data = new FormData($("#form-post")[0]);
        data.append("blog-editor", CKEDITOR.instances['blog-editor'].getData());
        $.ajax({
            type: 'post',
            url: 'guardarpost',
            data: data,
            contentType: false,
            processData: false
        }).done(function(rs) {
            data = JSON.parse(rs);
                swal({
                        title: data.msj,
                        text: data.msj2,
                        type: data.tipo,
                        confirmButtonText: "OK"
                    },
                    function() {
                        if (data.tipo == "success") {
                            window.location.href = "../post"
                        }
                    });
        });
    });

    //envio de el formulario post con las modificaciones
    $('#btnform-modi').click(function() {
        var data = new FormData($("#form-post-modi")[0]);
        data.append("blog-editor", CKEDITOR.instances['blog-editor'].getData());
        $.ajax({
            type: 'post',
            url: '../modificarpost',
            data: data,
            contentType: false,
            processData: false
        }).done(function(rs) {
            data = JSON.parse(rs);
                swal({
                        title: data.msj,
                        text: data.msj2,
                        type: data.tipo,
                        confirmButtonText: "OK"
                    },
                    function() {
                        if (data.tipo == "success") {
                            window.location.href = "../post"
                        }
                    });
        });
    });

    //------------------------------------------Tags Funciones
    //envio de el formulario tag
    $('#btnform-tag').click(function() {
        var data = new FormData($("#form-tag")[0]);
        if ($('.vali').val() != "") {
            $.ajax({
                type: 'post',
                url: 'guardartag',
                data: data,
                contentType: false,
                processData: false
            }).done(function(rs) {
                data = JSON.parse(rs);
                swal({
                        title: data.msj,
                        text: data.msj2,
                        type: data.tipo,
                        confirmButtonText: "OK"
                    },
                    function() {
                        if (data.tipo == "success") {
                            location.reload()
                        }
                    });
            });
        } else {
            $('#form-tag').submit()
        }


    });

    //envio de el formulario modificar tag
    $('#btnform-tag-modi').click(function() {
        var data = new FormData($("#form-tag-modi")[0]);
        if ($('.valiM').val() != "") {
            $.ajax({
                type: 'post',
                url: 'modificartag',
                data: data,
                contentType: false,
                processData: false
            }).done(function(rs) {
                data = JSON.parse(rs);
                swal({
                        title: data.msj,
                        text: data.msj2,
                        type: data.tipo,
                        confirmButtonText: "OK"
                    },
                    function() {
                        if (data.tipo == "success") {
                            location.reload()
                        }
                    });
            });
        } else {
            $('#form-tag-modi').submit()
        }
    });
});

//------------------------------------- Post Funciones
//funcion que permite traer los datos de los posts
function modificarPost(id) {
        window.location.href = "verpost/" + id
}
//funcion que permite eliminar los posts
function eliminarPost(a) {
    swal({
            title: "Warning",
            text: "Are you sure to delete this post?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: true
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type: 'post',
                    url: 'borrarpost',
                    data: { id: a },
                }).done(function(dato) {
                    data = JSON.parse(dato)
                    swal({
                            title: data.msj,
                            text: data.msj2,
                            type: data.tipo,
                            confirmButtonText: "OK"
                        },
                        function() {
                            location.reload()
                        });
                });
            }
        });
}
//------------------------------------------Tags Funciones
//funcion que permite traer los datos de los tags
function modificarTag(a) {
    $.ajax({
        type: 'post',
        url: 'vertag',
        data: { id: a.id },
    }).done(function(dato) {
        data = JSON.parse(dato);
        console.log(data)
        $('#tag-id').attr('value', data.id)
        $('#tag-name').attr('value', data.tagname)
    })
}
//funcion que permite eliminar los tags
function eliminarTag(a) {
    swal({
            title: "Warning",
            text: "Are you sure you want to delete this tag?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: true
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type: 'post',
                    url: 'borrartag',
                    data: { id: a.id },
                }).done(function(dato) {
                    data = JSON.parse(dato)
                    swal({
                            title: data.msj,
                            text: data.msj2,
                            type: data.tipo,
                            confirmButtonText: "OK"
                        },
                        function() {
                            location.reload()
                        });
                });
            }
        });
}