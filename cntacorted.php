<?php
$pagina = "venta";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$fecha = date('Y-m-d');
$inicio = (isset($_GET['inicio'])) ? $_GET['inicio'] : $fecha;
$fin = (isset($_GET['fin'])) ? $_GET['fin'] : $fecha;
$consulta = "SELECT * FROM vcaja WHERE fecha between '$inicio' and '$fin' ORDER BY fecha,id_sucursal";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);


$consulta = "SELECT nom_suc,SUM(efectivo) AS efectivo,SUM(tcredito) AS tcredito, SUM(tdebito) AS tdebito, SUM(depositos) AS depositos, SUM(transferencias) AS transferencias, SUM(amex) AS amex,
SUM(otros) AS otros,
SUM(efectivo+tcredito+tdebito+depositos+transferencias+amex+otros) AS ingresos
FROM vcaja WHERE fecha BETWEEN '$inicio' AND '$fin' GROUP BY id_sucursal ORDER BY id_sucursal";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$datacon = $resultado->fetchAll(PDO::FETCH_ASSOC);

$message = "";



?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card ">
            <div class="card-header bg-gradient-green">
                <h4 class="card-title text-center">CORTE DE SUCURSALES</h4>
            </div>

            <div class="card-body">

                <div class="card">
                    <div class="card-header bg-gradient-green">
                        Filtro por rango de Fecha
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-lg-2">
                                <div class="form-group input-group-sm">
                                    <label for="fecha" class="col-form-label">Desde:</label>
                                    <input type="date" class="form-control" name="inicio" id="inicio" value="<?php echo $inicio ?>">
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group input-group-sm">
                                    <label for="fecha" class="col-form-label">Hasta:</label>
                                    <input type="date" class="form-control" name="final" id="final" value="<?php echo $fin ?>">

                                </div>
                            </div>

                            <div class="col-lg-1 align-self-end text-center">
                                <div class="form-group input-group-sm">
                                    <button id="btnBuscar" name="btnBuscar" type="button" class="btn bg-gradient-green btn-ms"><i class="fas fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">

                        <!--<button id="btnNuevo" type="button" class="btn bg-gradient-succes btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>-->
                    </div>
                </div>
                <br>

                <div class="container-fluid">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card ">
                                <div class="card-header bg-gradient-green color-palette border-0">
                                    <h3 class="card-title">
                                        <i class="fas fa-th mr-1"></i>
                                        INGRESOS
                                    </h3>


                                </div>
                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-12">
                                            <canvas class="chart " id="ingresos-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-sm-12 my-auto">
                                                <div class="table-responsive">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <!-- /.card-footer -->
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card ">
                                <div class="card-header bg-gradient-green color-palette border-0">
                                    <h3 class="card-title">
                                        <i class="fas fa-th mr-1"></i>
                                        DETALLE DE INGRESOS
                                    </h3>


                                </div>
                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-12">
                                            <canvas class="chart " id="resultados-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-sm-12 my-auto">
                                                <div class="table-responsive">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <!-- /.card-footer -->
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                                    <thead class="text-center bg-gradient-green">
                                        <tr>
                                            <th>ID CAJA</th>
                                            <th>FECHA</th>
                                            <th>ID SUC</th>
                                            <th>SUCURSAL</th>
                                            <th>INICIO</th>
                                            <th>EFECTIVO</th>
                                            <th>T. CREDITO</th>
                                            <th>T. DEBITO</th>
                                            <th>DEPOSITOS</th>
                                            <th>TRANSFERENCIAS</th>
                                            <th>AMEX</th>
                                            <th>OTROS</th>
                                            <th>GASTOS</th>
                                            <th>RETIROS</th>
                                            <th>CIERRE</th>
                                            <th>INGRESOS</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $dat) {
                                        ?>
                                            <tr>
                                                <td><?php echo $dat['id_caja'] ?></td>
                                                <td><?php echo $dat['fecha'] ?></td>
                                                <td><?php echo $dat['id_sucursal'] ?></td>
                                                <td><?php echo $dat['nom_suc'] ?></td>
                                                <td class="text-right"><?php echo number_format($dat['inicial'], 2) ?></td>
                                                <td class="text-right"><?php echo number_format($dat['efectivo'], 2) ?></td>
                                                <td class="text-right"><?php echo number_format($dat['tcredito'], 2) ?></td>
                                                <td class="text-right"><?php echo number_format($dat['tdebito'], 2) ?></td>
                                                <td class="text-right"><?php echo number_format($dat['depositos'], 2) ?></td>
                                                <td class="text-right"><?php echo number_format($dat['transferencias'], 2) ?></td>
                                                <td class="text-right"><?php echo number_format($dat['amex'], 2) ?></td>
                                                <td class="text-right"><?php echo number_format($dat['otros'], 2) ?></td>
                                                <td class="text-right"><?php echo number_format($dat['gastos'], 2) ?></td>
                                                <td class="text-right"><?php echo number_format($dat['retiros'], 2) ?></td>
                                                <td class="text-right"><?php echo number_format($dat['final'], 2) ?></td>
                                                <td class="text-right"><?php echo number_format($dat['ingresos'], 2) ?></td>
                                                <td></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.card-body -->

        </div>
        <!-- /.card -->

    </section>

    <section>
        <div class="container">


            <!-- Default box -->
            <div class="modal fade" id="modalResumen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-primary">
                            <h5 class="modal-title" id="exampleModalLabel">Resumen de Pagos</h5>

                        </div>
                        <br>
                        <div class="table-hover responsive w-auto " style="padding:10px">
                            <table name="tablaResumen" id="tablaResumen" class="table table-sm table-striped table-bordered table-condensed display compact" style="width:100%">
                                <thead class="text-center">
                                    <tr>
                                        <th>Folio</th>
                                        <th>Fecha</th>
                                        <th>Concepto</th>
                                        <th>Monto</th>
                                        <th>Metodo</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>


                    </div>

                </div>
                <!-- /.card-body -->

                <!-- /.card-footer-->
            </div>
            <!-- /.card -->

        </div>
    </section>


    <section>
        <div class="modal fade" id="modalcan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-danger">
                        <h5 class="modal-title" id="exampleModalLabel">CANCELAR VENTA</h5>
                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formcan" action="" method="POST">
                            <div class="modal-body row">
                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="motivo" class="col-form-label">Motivo de Cancelacioón:</label>
                                        <textarea rows="3" class="form-control" name="motivo" id="motivo" placeholder="Motivo de Cancelación"></textarea>
                                        <input type="hidden" id="fecha" name="fecha" value="<?php echo $fecha ?>">
                                    </div>
                                </div>
                            </div>
                    </div>
                    <?php
                    if ($message != "") {
                    ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <span class="badge "><?php echo ($message); ?></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                        <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


    <!-- /.content -->
</div>
<!-- Resumen de Pagos -->



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntacorted.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="http://cdn.datatables.net/plug-ins/1.10.21/sorting/formatted-numbers.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>

<script>
    $(function() {


        var ingresoschartCanvas = $('#ingresos-chart').get(0).getContext('2d')
        var ingresoschartData = {
            labels: [<?php foreach ($datacon as $d) : ?> "<?php echo $d['nom_suc'] ?>",
                <?php endforeach; ?>
            ],
            datasets: [{
                label: 'INGRESOS',
                fill: true,
                borderWidth: 1,
                lineTension: 0,
                spanGaps: true,
                borderColor: '#000000',
                pointRadius: 3,
                pointHoverRadius: 7,
                pointColor: '#A248FA',
                pointBackgroundColor: '#A248FA',
                data: [
                    <?php foreach ($datacon as $d) : ?>
                        <?php echo $d['ingresos']; ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: [

                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)'
                ],
                borderColor: [

                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)'
                ],
                borderWidth: 1

            }, ]
        }

        var ingresosChartOptions = {
            animationEnabled: true,
            theme: "light2",
            maintainAspectRatio: false,
            responsive: true,
            aspectRatio:1,
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    fontColor: '#000000'
                }
            },
            scales: {
                xAxes: [{
                    ticks: {
                        fontColor: '#000000',
                    },
                    gridLines: {
                        display: false,
                        color: '#A248FA',
                        drawBorder: true,
                    }
                }],
                yAxes: [{
                    ticks: {

                        beginAtZero: true
                    },
                    gridLines: {
                        display: true,
                        color: '#A248FA',
                        drawBorder: true,
                        zeroLineColor: '#000000'
                    }
                }]
            }
        }
        var ingresosChart = new Chart(ingresoschartCanvas, {

            type: 'bar',
            data: ingresoschartData,
            options: ingresosChartOptions
        })
        /*INGRESO DETALLADOS */


        var salesGraphChartCanvas = $('#resultados-chart').get(0).getContext('2d')
        //$('#revenue-chart').get(0).getContext('2d');



        var salesGraphChartData = {
            labels: [<?php foreach ($datacon as $d) : ?> "<?php echo $d['nom_suc'] ?>",
                <?php endforeach; ?>
            ],
            datasets: [{
                label: 'Efectivo',
                fill: true,
                borderWidth: 1,
                lineTension: 0,
                spanGaps: true,
                borderColor: '#000000',
                pointRadius: 3,
                pointHoverRadius: 7,
                pointColor: '#A248FA',
                pointBackgroundColor: '#A248FA',
                data: [
                    <?php foreach ($datacon as $d) : ?>
                        <?php echo $d['efectivo']; ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: [

                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)'
                ],
                borderColor: [

                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)',
                    'rgba(110,182,241)'
                ],
                borderWidth: 1

            }, {
                label: 'T. Credito',
                fill: true,
                borderWidth: 1,
                lineTension: 0,
                spanGaps: true,
                borderColor: '#000000',
                pointRadius: 3,
                pointHoverRadius: 7,
                pointColor: '#A248FA',
                pointBackgroundColor: '#A248FA',
                data: [
                    <?php foreach ($datacon as $d) : ?>
                        <?php echo $d['tcredito']; ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: [

                    'rgba(153, 102, 255)',
                    'rgba(153, 102, 255)',
                    'rgba(153, 102, 255)',
                    'rgba(153, 102, 255)',
                    'rgba(153, 102, 255)',
                    'rgba(153, 102, 255)',
                    'rgba(153, 102, 255)',
                    'rgba(153, 102, 255)',
                    'rgba(153, 102, 255)',
                    'rgba(153, 102, 255)',
                    'rgba(153, 102, 255)',
                    'rgba(153, 102, 255)'
                ],
                borderColor: [

                    'rgba(153, 102, 255)',
                    'rgba(153, 102, 255)',
                    'rgba(153, 102, 255)',
                    'rgba(153, 102, 255)',
                    'rgba(153, 102, 255)',
                    'rgba(153, 102, 255)',
                    'rgba(153, 102, 255)',
                    'rgba(153, 102, 255)',
                    'rgba(153, 102, 255)',
                    'rgba(153, 102, 255)',
                    'rgba(153, 102, 255)',
                    'rgba(153, 102, 255)'
                ],
                borderWidth: 1

            }, {
                label: 'T. Debito',
                fill: true,
                borderWidth: 1,
                lineTension: 0,
                spanGaps: true,
                borderColor: '#000000',
                pointRadius: 3,
                pointHoverRadius: 7,
                pointColor: '#A248FA',
                pointBackgroundColor: '#A248FA',
                data: [
                    <?php foreach ($datacon as $d) : ?>
                        <?php echo $d['tdebito']; ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: [

                    'rgba(135,241,222)',
                    'rgba(135,241,222)',
                    'rgba(135,241,222)',
                    'rgba(135,241,222)',
                    'rgba(135,241,222)',
                    'rgba(135,241,222)',
                    'rgba(135,241,222)',
                    'rgba(135,241,222)',
                    'rgba(135,241,222)',
                    'rgba(135,241,222)',
                    'rgba(135,241,222)',
                    'rgba(135,241,222)'
                ],
                borderColor: [

                    'rgba(135,241,222)',
                    'rgba(135,241,222)',
                    'rgba(135,241,222)',
                    'rgba(135,241,222)',
                    'rgba(135,241,222)',
                    'rgba(135,241,222)',
                    'rgba(135,241,222)',
                    'rgba(135,241,222)',
                    'rgba(135,241,222)',
                    'rgba(135,241,222)',
                    'rgba(135,241,222)',
                    'rgba(135,241,222)'
                ],
                borderWidth: 1

            }, {
                label: 'Depositos',
                fill: true,
                borderWidth: 1,
                lineTension: 0,
                spanGaps: true,
                borderColor: '#000000',
                pointRadius: 3,
                pointHoverRadius: 7,
                pointColor: '#A248FA',
                pointBackgroundColor: '#A248FA',
                data: [
                    <?php foreach ($datacon as $d) : ?>
                        <?php echo $d['depositos']; ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: [

                    'rgba(34,55,160)',
                    'rgba(34,55,160)',
                    'rgba(34,55,160)',
                    'rgba(34,55,160)',
                    'rgba(34,55,160)',
                    'rgba(34,55,160)',
                    'rgba(34,55,160)',
                    'rgba(34,55,160)',
                    'rgba(34,55,160)',
                    'rgba(34,55,160)',
                    'rgba(34,55,160)',
                    'rgba(34,55,160)'
                ],
                borderColor: [

                    'rgba(34,55,160)',
                    'rgba(34,55,160)',
                    'rgba(34,55,160)',
                    'rgba(34,55,160)',
                    'rgba(34,55,160)',
                    'rgba(34,55,160)',
                    'rgba(34,55,160)',
                    'rgba(34,55,160)',
                    'rgba(34,55,160)',
                    'rgba(34,55,160)',
                    'rgba(34,55,160)',
                    'rgba(34,55,160)'
                ],
                borderWidth: 1

            }, {
                label: 'Transferencias',
                fill: true,
                borderWidth: 1,
                lineTension: 0,
                spanGaps: true,
                borderColor: '#000000',
                pointRadius: 3,
                pointHoverRadius: 7,
                pointColor: '#A248FA',
                pointBackgroundColor: '#A248FA',
                data: [
                    <?php foreach ($datacon as $d) : ?>
                        <?php echo $d['transferencias']; ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: [

                    'rgba(243,167,34)',
                    'rgba(243,167,34)',
                    'rgba(243,167,34)',
                    'rgba(243,167,34)',
                    'rgba(243,167,34)',
                    'rgba(243,167,34)',
                    'rgba(243,167,34)',
                    'rgba(243,167,34)',
                    'rgba(243,167,34)',
                    'rgba(243,167,34)',
                    'rgba(243,167,34)',
                    'rgba(243,167,34)'
                ],
                borderColor: [

                    'rgba(243,167,34)',
                    'rgba(243,167,34)',
                    'rgba(243,167,34)',
                    'rgba(243,167,34)',
                    'rgba(243,167,34)',
                    'rgba(243,167,34)',
                    'rgba(243,167,34)',
                    'rgba(243,167,34)',
                    'rgba(243,167,34)',
                    'rgba(243,167,34)',
                    'rgba(243,167,34)',
                    'rgba(243,167,34)'
                ],
                borderWidth: 1

            }, {
                label: 'AMEX',
                fill: true,
                borderWidth: 1,
                lineTension: 0,
                spanGaps: true,
                borderColor: '#000000',
                pointRadius: 3,
                pointHoverRadius: 7,
                pointColor: '#A248FA',
                pointBackgroundColor: '#A248FA',
                data: [
                    <?php foreach ($datacon as $d) : ?>
                        <?php echo $d['amex']; ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: [

                    'rgba(243,34,104)',
                    'rgba(243,34,104)',
                    'rgba(243,34,104)',
                    'rgba(243,34,104)',
                    'rgba(243,34,104)',
                    'rgba(243,34,104)',
                    'rgba(243,34,104)',
                    'rgba(243,34,104)',
                    'rgba(243,34,104)',
                    'rgba(243,34,104)',
                    'rgba(243,34,104)',
                    'rgba(243,34,104)'
                ],
                borderColor: [

                    'rgba(243,34,104)',
                    'rgba(243,34,104)',
                    'rgba(243,34,104)',
                    'rgba(243,34,104)',
                    'rgba(243,34,104)',
                    'rgba(243,34,104)',
                    'rgba(243,34,104)',
                    'rgba(243,34,104)',
                    'rgba(243,34,104)',
                    'rgba(243,34,104)',
                    'rgba(243,34,104)',
                    'rgba(243,34,104)'
                ],
                borderWidth: 1

            }, {
                label: 'Otros',
                fill: true,
                borderWidth: 1,
                lineTension: 0,
                spanGaps: true,
                borderColor: '#000000',
                pointRadius: 3,
                pointHoverRadius: 7,
                pointColor: '#A248FA',
                pointBackgroundColor: '#A248FA',
                data: [
                    <?php foreach ($datacon as $d) : ?>
                        <?php echo $d['otros']; ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: [

                    'rgba(8,148,52)',
                    'rgba(8,148,52)',
                    'rgba(8,148,52)',
                    'rgba(8,148,52)',
                    'rgba(8,148,52)',
                    'rgba(8,148,52)',
                    'rgba(8,148,52)',
                    'rgba(8,148,52)',
                    'rgba(8,148,52)',
                    'rgba(8,148,52)',
                    'rgba(8,148,52)',
                    'rgba(8,148,52)'
                ],
                borderColor: [

                    'rgba(8,148,52)',
                    'rgba(8,148,52)',
                    'rgba(8,148,52)',
                    'rgba(8,148,52)',
                    'rgba(8,148,52)',
                    'rgba(8,148,52)',
                    'rgba(8,148,52)',
                    'rgba(8,148,52)',
                    'rgba(8,148,52)',
                    'rgba(8,148,52)',
                    'rgba(8,148,52)',
                    'rgba(8,148,52)'
                ],
                borderWidth: 1

            }, ]
        }

        var salesGraphChartOptions = {
            animationEnabled: true,
            theme: "light2",
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    fontColor: '#000000'
                }
            },
            scales: {
                xAxes: [{
                    ticks: {
                        fontColor: '#000000',
                    },
                    gridLines: {
                        display: false,
                        color: '#A248FA',
                        drawBorder: true,
                    }
                }],
                yAxes: [{
                    ticks: {

                        beginAtZero: true
                    },
                    gridLines: {
                        display: true,
                        color: '#A248FA',
                        drawBorder: true,
                        zeroLineColor: '#000000'
                    }
                }]
            }
        }

        // This will get the first returned node in the jQuery collection.
        var salesGraphChart = new Chart(salesGraphChartCanvas, {

            type: 'bar',
            data: salesGraphChartData,
            options: salesGraphChartOptions
        })

    });
</script>