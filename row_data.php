<?php
include_once './data/data_list.php';
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
            $title = "Row Data Set";
            $t1="Data";
            $t2= "  List";
            
          
            
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
                                        onclick="location.href = 'new_record.php';">Add New Record</button>

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
                                            <th>Product Code</th>
                                            <th>WareHouse</th>
                                            <th>Category</th>
                                            <th>Date</th>
                                            <th>Order Demand</th>

                                           
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                        <th>#</th>
                                            <th>Product Code</th>
                                            <th>WareHouse</th>
                                            <th>Category</th>
                                            <th>Date</th>
                                            <th>Order Demand</th>
                                           
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            
                                            
                                            ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><a
                                                    href="product.php?gpid=<?php echo base64_encode($row['Product_Code']); ?>"><?php echo $row['Product_Code']; ?></a>
                                            </td>
                                            <td><?= $row['Warehouse'] ?></td>
                                            <td><?= $row['Product_Category']?></td>
                                            <td><?= $row['Date'] ?></td>
                                            <td><?= $row['Order_Demand'] ?></td>
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