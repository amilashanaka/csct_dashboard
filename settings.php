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
       
       $t1 = "Home";
            $t2 = "Model Settings";

            $title = "Model Settings";
     
     
     include_once './page_header.php';?>
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">

                            <div class="card">

                                <div class="card-header">
                                    <p>Current Settings</p>
                                </div>

                                <div class="card-body">

                                    <form action="data/update_settings.php" method="post">

                                        <div class="form-row">

                                            <div class="col-lg-6 col-md-6 form-group">
                                                <lable>Feature Length:</lable>

                                                <input type="text" class="form-control" name="feture_length"
                                                    placeholder="0">
                                            </div>
                                            <div class="col-lg-6 col-md-6 form-group">
                                                <lable>Batch Size:</lable>

                                                <input type="text" class="form-control" name="batch_size"
                                                    placeholder="0">

                                            </div>

                                            <div class="col-lg-6 col-md-6 form-group">
                                                <lable>Epochs:</lable>

                                                <input type="text" class="form-control" name="epochs"
                                                    placeholder="0">

                                            </div>

                                            <div class="col-lg-6 col-md-6 form-group">
                                                <lable>Input Layer:</lable>

                                                <input type="text" class="form-control" name="input_units"
                                                    placeholder="0">

                                            </div>


                                            <div class="col-lg-6 col-md-6 form-group">
                                                <lable>Hidden Layer 1:</lable>

                                                <input type="text" class="form-control" name="hidden_layer_1"
                                                    placeholder="0">
                                            </div>
                                            <div class="col-lg-6 col-md-6 form-group">
                                                <lable>Hidden Layer 2:</lable>

                                                <input type="text" class="form-control" name="hidden_layer_2"
                                                    placeholder="0">

                                            </div>

                                            <div class="col-lg-6 col-md-6 form-group">
                                                <lable>Output Layer:</lable>

                                                <input type="text" class="form-control" name="output_layer"
                                                    placeholder="0">

                                            </div>





                                        </div>

                                        <div class="form-row">

                                        <div class="col-md-6">
                                       
                                        </div>

                                        <div class="col-md-6 ">
                                        <input type="submit" class="btn btn-outline-success float-right" value="Add New">
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