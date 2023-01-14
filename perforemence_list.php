<?php
include_once './data/data_mp.php';
include_once('header.php');


?>




<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->

        <?php include_once('./nav_bar.php'); ?>
        <!-- Main Sidebar Container -->
        <?php include_once('./side_bar.php'); ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <?php
            $title = "Model Settings List ";
            $t1="Model";
            $t2= "  Settings List";
            
          
            
            ?>

            <?php include_once('page_header.php')?>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-12">

                        <div class="card">

                            <div class="card-header">
                                <h3 class="card-title">
                                    <button type="button" class="btn btn-block  btn-outline-secondary"
                                        onclick="location.href = 'settings.php';">Add New Record</button>

                                </h3>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example23"
                                    class="display nowrap table table-hover table-striped table-bordered"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Input Nodes</th>
                                            <th>Hidden layer 1 nodes</th>
                                            <th>Hidden layer 2 nodes</th>
                                            <th>output nodes</th>
                                            <th>Epochs</th>
                                            <th>RMSE</th>
                                            <th>MAE</th>
                                            <th>MAPE</th>
                                            <th>Accurecy %</th>




                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Input Nodes</th>
                                            <th>Hidden layer 1 nodes</th>
                                            <th>Hidden layer 2 nodes</th>
                                            <th>output nodes</th>
                                            <th>Epochs</th>
                                            <th>RMSE</th>
                                            <th>MAE</th>
                                            <th>MAPE</th>
                                            <th>Accurecy %</th>

                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            
                                            
                                            ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>

                                            <td><?= $row['input_units'] ?></td>
                                            <td><?= $row['hidden_layer_1'] ?></td>
                                            <td><?= $row['hidden_layer_2'] ?></td>
                                            <td><?= $row['output_units'] ?></td>
                                            <td><?= $row['epochs'] ?></td>
                                            <td><?= round($row['rmse'],3) ?></td>
                                            <td><?= round($row['mae'],3) ?></td>
                                            <td><?= $row['mape'] ?></td>
                                            <td><?= $row['accurecy'] ?></td>

                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>

        <?php include_once('control_side_bar.php');?>
        <!-- /.content-wrapper -->
        <?php include_once('footer.php');?>

    </div>
    <?php include_once('footer_script.php');?>
</body>

</html>