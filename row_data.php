<?php
include_once('headder.php');
include_once './data/data_list.php';
?>


<body class="hold-transition sidebar-mini">


    <?php
    if (isset($_GET['error'])) {
        $error = base64_decode($_GET['error']);
        echo '<script>  error_by_code(' . $error . ');</script>';
    }
    ?>


    <div class="wrapper">
        <!-- Navbar -->
        <?php include_once './navbar.php'; ?>
        <?php include_once './sidebar.php'; ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <?php 
            
            $t1="Lotto";
            $t2= "  List";
            
            include_once './page_header.php';
            
            ?>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-12">

                        <div class="card">

                            <div class="card-header">
                                <h3 class="card-title">
                                    <button type="button" class="btn btn-block  btn-outline-secondary"
                                        onclick="location.href = 'game.php';">Add New Game</button>

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
                                            <th>Draw No </th>
                                            <th>Under Admin </th>
                                            <th>Lotto Amount </th>
                                            <th>Lotto Name</th>

                                            <th style="width:3%; text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Draw No </th>
                                            <th>Under Admin </th>
                                            <th>Lotto Amount </th>

                                            <th>Lotto Name </th>
                                            <th style="width:3%; text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        while ($row = mysqli_fetch_assoc($result_game_list)) {
                                            
                                            
                                            ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><a
                                                    href="game.php?g_id=<?php echo base64_encode($row['g_id']); ?>"><?php echo $row['g_drawno']; ?></a>
                                            </td>
                                            <td><?php echo getaAdminUserName($row['g_under'], $conn); ?></td>
                                            <td><?php  echo printAmount_by_currency_with_symbol($row['g_currency'],$row['g_amount'],$conn); ?>
                                            </td>
                                            <td><?php echo $row['g_name']; ?></td>
                                            <td>
                                                <?php if ($row['g_status'] == '1') { ?><button type="button"
                                                    id="btnm<?php echo $row['g_id']; ?>"
                                                    class="btn btn-block btn-outline-danger btn-flat"
                                                    onclick="delete_record('<?php echo $row['g_id']; ?>', 'game', 'g_id', '0');"><i
                                                        class="fa fa-times" aria-hidden="true"></i></button>
                                                <?php } else { ?>
                                                <button type="button" id="btnm<?php echo $row['g_id']; ?>"
                                                    class="btn btn-block btn-outline-success btn-flat"
                                                    onclick="activate_record('<?php echo $row['g_id']; ?>', 'game', 'g_id', '0');"><i
                                                        class="fa fa-check "></i></button>
                                                <?php
                                                    }
                                                    ?>
                                            </td>
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

        <?php include_once './control-sidebar.php'; ?>
        <!-- /.content-wrapper -->
        <?php include_once './footer.php'; ?>

    </div>
    <!-- ./wrapper -->
</body>

</html>