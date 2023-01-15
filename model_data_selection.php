<?php
include_once('inc/conn.php');
include_once('header.php');


?>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">



        <?php include_once('./nav_bar.php'); ?>
        <!-- Main Sidebar Container -->
        <?php include_once('./side_bar.php'); ?>



        <div class="content-wrapper">

            <?php 
       
       $t1 = "Model";
            $t2 = "Data Selection";

            $title = "Product Selection";
     
     
     include_once './page_header.php';?>
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">

                            <div class="card">

                                <div class="card-header">
                                    <p>Product selection for Model</p>
                                </div>

                                <div class="card-body">

                                    <form action="data/data_run_selected.php" method="post">

                                        <div class="form-row">

                                            <div class="col-lg-6 col-md-6 form-group">
                                                <label>Select Product</label>
                                                <select class="form-control" name="product_code">

                                                    <option value="EO-01">EO-01</option>
                                                    <option value="OBCW-01">OBCW-01</option>
                                                    <option value="AWHBL-01">AWHBL-01</option>
                                                    <option value="RDEO-01">RDEO-01</option>

                                                </select>

                                            </div>


                                        </div>

                                        <div class="form-row">

                                            <div class="col-md-6">

                                            </div>

                                            <div class="col-md-6 ">
                                                <input type="submit" class="btn btn-outline-success float-right"
                                                    value="Run for selected product">
                                            </div>


                                        </div>


                                    </form>

                                </div>




                            </div>


                        </div>


                    </div>


                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->






        <?php include_once('control_side_bar.php');?>

        <?php include_once('footer.php');?>
    </div>

    <?php include_once('footer_script.php');?>
</body>

</html>