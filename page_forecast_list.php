<?php
include_once './data/forecast_data _list.php';
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
            $title = "Forecast Oder Demand List ";
            $t1="Model";
            $t2= "  Forecast List";
            
          
            
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
                                            <th>Date</th>
                                            <th>Forecast</th>
                                            


                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Forecast</th>
                                           
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach($result as $key=>$value) {
                                            
                                            
                                            ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                        
                                            <td><?= $key ?></td>
                                            <td><?= $value ?></td>
                             
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