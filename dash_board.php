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

            <div style="width:full; height:300px;" id="chart1"></div>

            </div>

          </div>
          

           
            <script src="dist/js/chart1.js" type="text/javascript"> </script>




            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->