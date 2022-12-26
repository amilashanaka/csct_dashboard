<div class="content-wrapper">

    <?php
  $title = "Product Demad Dashboard";
     $t1 = "Home";
          $t2 = "Dash Board";
   
   
   include_once './page_header.php';?>
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <?php include_once './info_box.php';?>

            <div class="row">

                <div class="col-md-12">

                    <div style="width:full; height:400px;" id="chart1"></div>

                </div>

                <div class="col-4 col-md-4">

                    <div style="width:full; height:400px;" id="chart2"></div>
                </div>

                <div class="col-8 col-md-8">

                    <div style="width:full; height:400px;" id="chart3"></div>
                </div>

            </div>



            <script src="dist/js/chart1.js" type="text/javascript"> </script>
            <script src="dist/js/chart2.js" type="text/javascript"> </script>
            <script src="dist/js/chart3.js" type="text/javascript"> </script>




            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->