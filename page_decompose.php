<?php
include_once('inc/conn.php');
include_once('header.php');

?>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">



        <?php include_once('./nav_bar.php'); ?>
        <!-- Main Sidebar Container -->
        <?php include_once('./side_bar.php'); ?>

        <?php include_once('decompose.php');?>

        <?php include_once('control_side_bar.php');?>

        <?php include_once('footer.php');?>
    </div>

    <?php include_once('footer_script.php');?>
</body>

</html>