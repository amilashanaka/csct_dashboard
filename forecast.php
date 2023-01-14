<div class="content-wrapper">

    <?php
  $title = "Forecast Result";
     $t1 = "Home";
          $t2 = "Forecast";
   
   
   include_once './page_header.php';?>
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <?php include_once './data/forecast_data.php';?>



            <div class="row" style="padding: 10px;">

                <div class="col-md-12">

                    <div style="width:full; height:400px;" id="chart1"></div>

                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-8">
                            <label for=""> Number of Days Predicted: <?=$steps?></label>
                        </div>
                        <div class="col-md-4">
                            <button type="button" onclick="location.reload()" class="btn btn-success float-right">
                                Forecast to next Day</button>
                        </div>


                    </div>



                </div>

            </div>

            <script>
            var chartDom = document.getElementById('chart1');
            var myChart = echarts.init(chartDom);
            var option;

            option = {
                title: {
                    text: 'Order Demad'
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data: ['Order Demand']
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
                    data: [<?=$dates?>]
                },
                yAxis: {
                    type: 'value'
                },
                series: [{
                    data: [<?=$predection?>],
                    type: 'line',
                    smooth: true
                }]
            };

            option && myChart.setOption(option);
            </script>




            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->