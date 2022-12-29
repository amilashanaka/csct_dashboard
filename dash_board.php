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

            <?php include_once './data/result_data_set.php';?>

            <?php if($date_validate!=''){?>

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

            <?php }?>



            <script type="text/javascript">
            var chartDom = document.getElementById('chart1');
            var myChart = echarts.init(chartDom);
            var option;
            var option;

            option = {
                title: {
                    text: 'Prediction Result'
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data: ['Validation', 'Prediction','Error']
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                toolbox: {
                    feature: {
                        saveAsImage: {}
                    }
                },
                xAxis: {
                    type: 'category',
                    boundaryGap: false,
                    data: [<?= $date_validate?>]
                },
                yAxis: {
                    type: 'value'
                },
                series: [{
                        name: 'Prediction',
                        type: 'line',
                        stack: 'Total',
                        data: [<?=$predection?>]
                    },
                    {
                        name: 'Validation',
                        type: 'line',
                        stack: 'Total',
                        data: [<?=$order_validate?>]
                    },{
                        name: 'Error',
                        type: 'line',
                        stack: 'Total',
                        data: [<?=$error?>]
                    }
                    
                ]
            };

            option && myChart.setOption(option);
            </script>
            <script src="dist/js/chart2.js" type="text/javascript"> </script>
            <script src="dist/js/chart3.js" type="text/javascript"> </script>




            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->