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

            option = {
                title: {
                    text: 'Order Deamands'
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data: ['Order Demand', 'Predictions', 'Error']
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

                    data: [<?=$date_validate?>]
                },
                yAxis: {
                    type: 'value'
                },
                series: [{
                        name: 'Order Deamand',
                        type: 'line',

                        data: [<?=$order_validate?>]
                    },
                    {
                        name: 'Predections',
                        type: 'line',

                        data: [<?=$predection?>]
                    },
                    {
                        name: 'Error',
                        type: 'line',

                        data: [<?=$error?>]
                    }
                ]
            };
            option && myChart.setOption(option);
            </script>


            <script type="text/javascript">
                var dom = document.getElementById('chart2');
            var myChart = echarts.init(dom, null, {
                renderer: 'canvas',
                useDirtyRect: false
            });
            var app = {};

            var option2;

            option2 = {
                tooltip: {
                  trigger: 'item'
                },
                legend: {
                  bottom: '5%',
                  left: 'center'
                },
                series: [
                  {
                    name: 'Access From',
                    type: 'pie',
                    radius: ['40%', '70%'],
                    avoidLabelOverlap: false,
                    itemStyle: {
                      borderRadius: 10,
                      borderColor: '#fff',
                      borderWidth: 2
                    },
                    label: {
                      show: false,
                      position: 'center'
                    },
                    emphasis: {
                      label: {
                        show: true,
                        fontSize: 40,
                        fontWeight: 'bold'
                      }
                    },
                    labelLine: {
                      show: false
                    },
                    data: [
                      { value: <?=$total_order_demands?>, name: 'Order demands' },
                      { value:  <?=$total_predection?>, name: 'Predictions' },
                      { value: <?=$total_error?>, name: 'Error' },
                    ]
                  }
                ]
              };


            if (option2 && typeof option2 === 'object') {
                myChart.setOption(option2);
            }

            window.addEventListener('resize', myChart.resize);

            </script>


          
            <script src="dist/js/chart3.js" type="text/javascript"> </script>




            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->