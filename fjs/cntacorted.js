$(document).ready(function() {



    
    var id, opcion;
    opcion = 4;

    tablaVis = $("#tablaV").DataTable({
        dom: "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

        buttons: [{
                extend: "excelHtml5",
                text: "<i class='fas fa-file-excel'> Excel</i>",
                titleAttr: "Exportar a Excel",
                title: "Cortes de Sucursales",
                className: "btn bg-success ",
                exportOptions: { columns: [ 1, 3, 4, 5,6,7,8,9,10,11,12,13,14,15] },
            },
            {
                extend: "pdfHtml5",
                text: "<i class='far fa-file-pdf'> PDF</i>",
                titleAttr: "Exportar a PDF",
                title: "Cortes de Sucursales",
                className: "btn bg-danger",
                orientation: "landscape",
                exportOptions: { columns: [ 1, 3, 4, 5,6,7,8,9,10,11,12,13,14,15] },
                customize: function(doc) {
                    // Cambiar tamaño de la fuente
                    doc.defaultStyle.fontSize = 8; // Tamaño de letra por defecto
                    doc.styles.tableHeader.fontSize = 10; // Tamaño de letra del encabezado
                    var body = doc.content[1].table.body; // Accede al cuerpo de la tabla
                    body.forEach(function(row, rowIndex) {
                        if (rowIndex > 0) { // Excluye la primera fila (encabezado)
                            for (var colIndex = 2; colIndex < row.length; colIndex++) { // Columna 3 en adelante (índice 2+)
                                row[colIndex].alignment = 'right'; // Alinear a la derecha
                            }
                        }
                    });
                }
            },
        ],
        stateSave: true,

        columnDefs: [/*{
            targets: -1,
            data: null,
            defaultContent: "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-primary btnEditar'><i class='fas fa-search'></i></button>\
            <button class='btn btn-sm bg-info btnResumen'><i class='fas fa-bars'></i></button>\
            <button class='btn btn-sm bg-orange btnEdo'><i class='fas fa-file-invoice-dollar text-light'></i></button>\
            <button class='btn btn-sm bg-danger btnCancelar'><i class='fas fa-ban'></i></button></div></div>",
        },*/
        { className: 'hide_column', targets: [0] },
        { className: 'hide_column', targets: [2] },
    
    ],
    rowCallback: function (row, data) {
        
        $($(row).find('td')['4']).addClass('text-right')
        $($(row).find('td')['5']).addClass('text-right')
        $($(row).find('td')['6']).addClass('text-right')
        $($(row).find('td')['7']).addClass('text-right')
        $($(row).find('td')['8']).addClass('text-right')
        $($(row).find('td')['9']).addClass('text-right')
        $($(row).find('td')['10']).addClass('text-right')
        $($(row).find('td')['11']).addClass('text-right')
        $($(row).find('td')['12']).addClass('text-right')
        $($(row).find('td')['13']).addClass('text-right')
        $($(row).find('td')['14']).addClass('text-right')
        $($(row).find('td')['15']).addClass('text-right')
       
      },
        //Para cambiar el lenguaje a español
        language: {
            lengthMenu: "Mostrar _MENU_ registros",
            zeroRecords: "No se encontraron resultados",
            info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            infoFiltered: "(filtrado de un total de _MAX_ registros)",
            sSearch: "Buscar:",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior",
            },
            sProcessing: "Procesando...",
        },
    });

    tablaResumen = $("#tablaResumen").DataTable({
        //Para cambiar el lenguaje a español
        language: {
            lengthMenu: "Mostrar _MENU_ registros",
            zeroRecords: "No se encontraron resultados",
            info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            infoFiltered: "(filtrado de un total de _MAX_ registros)",
            sSearch: "Buscar:",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior",
            },
            sProcessing: "Procesando...",
        },
    });
 

   

    $("#btnBuscar").click(function() {
        var inicio = $("#inicio").val();
        var final = $("#final").val();
        var sucursal =0;


      

     

        if (inicio != "" && final != "") {
         /*   tablaVis.clear();
            tablaVis.draw();
            $.ajax({
                type: "POST",
                url: "bd/buscarcorted.php",
                dataType: "json",
                data: { inicio: inicio, final: final, sucursal: sucursal },
                success: function(data) {

                    for (var i = 0; i < data.length; i++) {
                        tablaVis.row
                            .add([
                                data[i].id_caja,
                                data[i].fecha,
                                data[i].id_sucursal,
                                data[i].nom_suc,
                                data[i].inicial,
                                data[i].efectivo,
                                data[i].tcredito,
                                data[i].tdebito,
                                data[i].depositos,
                                data[i].transferencias,
                                data[i].amex,
                                data[i].otros,
                                data[i].gastos,
                                data[i].retiros,
                                data[i].final,
                            ])
                            .draw();

                        //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
                    }
                },
            });*/
            window.location.href="cntacorted.php?inicio="+inicio+"&fin="+final
        } else {
            alert("Selecciona ambas fechas");
        }
    });

    $(document).on("click", ".btnEdo", function() {
        fila = $(this).closest("tr");

        registro = fila.find("td:eq(0)").text();
        console.log(registro);
        var ancho = 1000;
        var alto = 800;
        var x = parseInt(window.screen.width / 2 - ancho / 2);
        var y = parseInt(window.screen.height / 2 - alto / 2);

        url = "formatos/pdfestado.php?folio=" + registro;

        window.open(
            url,
            "Estado de Cuenta",
            "left=" +
            x +
            ",top=" +
            y +
            ",height=" +
            alto +
            ",width=" +
            ancho +
            "scrollbar=si,location=no,resizable=si,menubar=no"
        );
    });

    $(document).on("click", ".btnResumen", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find("td:eq(0)").text());
        buscarpagos(id);
        $("#modalResumen").modal("show");
    });

    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR
    $(document).on("click", ".btnEditar", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find("td:eq(0)").text());

        window.location.href = "venta.php?folio=" + id;
    });

    function buscarpagos(folio) {
        tablaResumen.clear();
        tablaResumen.draw();

        $.ajax({
            type: "POST",
            url: "bd/buscarpagocxc.php",
            dataType: "json",

            data: { folio: folio },

            success: function(res) {
                for (var i = 0; i < res.length; i++) {
                    tablaResumen.row
                        .add([
                            res[i].folio_pagocxc,
                            res[i].fecha,
                            res[i].concepto,
                            res[i].monto,
                            res[i].metodo,
                        ])
                        .draw();

                    //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
                }
            },
        });
    }

    function startTime() {
        var today = new Date();
        var hr = today.getHours();
        var min = today.getMinutes();
        var sec = today.getSeconds();
        //Add a zero in front of numbers<10
        min = checkTime(min);
        sec = checkTime(sec);
        document.getElementById("clock").innerHTML = hr + " : " + min + " : " + sec;
        var time = setTimeout(function() {
            startTime();
        }, 500);
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }
});