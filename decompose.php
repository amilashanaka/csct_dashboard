<div class="content-wrapper">

    <?php
  $title = "Analysis Result";
     $t1 = "Home";
          $t2 = "Decomposition";
   
   
   include_once './page_header.php';?>
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <?php include_once './data/decompose_data.php';?>



            <div class="row" style="padding: 10px;">

                <div class="col-md-12">

                    <div style="width:full; height:400px;" id="chart1"></div>

                </div>

                <div class="col-md-12">

                    <div style="width:full; height:400px;" id="chart2"></div>

                </div>

                <div class="col-md-12">

                    <div style="width:full; height:400px;" id="chart3"></div>

                </div>


            </div>

            <script>
            var chartDom = document.getElementById('chart1');
            var myChart = echarts.init(chartDom);
            var option;

            option = {
                title: {
                    text: 'Trend'
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data: ['Trend']
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
                    data: [<?=$trend?>],
                    type: 'line',
                    smooth: true
                }]
            };

            option && myChart.setOption(option);
            </script>

            <script>
            var chartDom = document.getElementById('chart2');
            var myChart2 = echarts.init(chartDom);
            var option2;

            option2 = {
                title: {
                    text: 'Sesonal'
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data: ['Sesonal']
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
                    data: [<?=$sesonal?>],
                    type: 'line',
                    smooth: true
                }]
            };

            option2 && myChart2.setOption(option2);
            </script>


<script>
            var chartDom = document.getElementById('chart3');
            var myChart3 = echarts.init(chartDom);
            var option3;

            option3 = {
                title: {
                    text: 'Resid'
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data: ['Resid']
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
                    data: [<?=$resid?>],
                    type: 'line',
                    smooth: true
                }]
            };

            option3 && myChart3.setOption(option3);
            </script>


            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->