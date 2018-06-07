@extends('layouts.master')

@section('content')
<div class="row">
	<div id="chart-1" class="col-md-6 col-xs-12">

	</div>
	<div id="chart-2" class="col-md-6 col-xs-12">

    </div>
</div>




    <script src="/airbus_web/public/vendor/jquery/jquery.min.js"></script>
    <script src="/airbus_web/public/js/echarts.js"></script>
    <script src="/airbus_web/public/js/dataTool.min.js"></script>
    <script src="/airbus_web/public/js/echarts-gl.min.js"></script>
    <script src="/airbus_web/public/js/ecStat.min.js"></script>
    <script type="text/javascript">
        $(function() {
            
            // read from database
            var query_sql = "select ac_cserie,actual_start_year,actual_start_month,count(ac_cmsn) as 'number' " +
                        "from apc_jaguar_bi_orc " +
                        "where pel_cplanningeventname='CDF' " +
                        "and actual_start_date > add_months(sysdate,-6) " +
                        "and actual_start_date < sysdate " +
                        "group by ac_cserie,actual_start_year,actual_start_month"
            query_sql = query_sql.replace(new RegExp(' ', 'g'), '%20').replace(new RegExp("'", 'g'), '%27');
            // query for dataset
            $.get("../index.php/inceptor?query=" + query_sql,function(response) {

                var data = response;
                // query for model_list
                var query_model = "select distinct ac_cserie from apc_jaguar_bi_orc order by ac_cserie"
                query_model = query_model.replace(new RegExp(' ', 'g'), '%20').replace(new RegExp("'", 'g'), '%27');
                $.get("../index.php/inceptor?query=" + query_model,function(response_model) {
                //     // query for month_list
                    var data_model = response_model;
                    var query_month = "SELECT concat(cast(actual_start_year AS STRING),'-',cast(actual_start_month AS STRING)) AS year_and_month " +
                                  "FROM APC_Jaguar_BI_orc WHERE actual_start_date > add_months(SYSDATE,-6) AND actual_start_date <SYSDATE " +
                                  "GROUP BY actual_start_year,actual_start_month ORDER BY actual_start_year,actual_start_month"
                    query_month = query_month.replace(new RegExp(' ', 'g'), '%20').replace(new RegExp("'", 'g'), '%27');
                    $.get("../index.php/inceptor?query=" + query_month,function(response_month) {
                            var data_month = response_month;
                            var model_list = []
                            var month_list = []
                            var formated_data = []

                            for(var i = 0;i<data_month.length-1;i++){
                                month_list.push(data_month[i].year_and_month)
                            }

                            
                            for(var i = 0;i<data_model.length;i++){
                                model_list.push(data_model[i].ac_cserie)
                            }

                            
                            formated_data.push(['month'].concat(model_list))
                            var row_month = []
                            for(i=0; i < model_list.length; i++) {
                                row_month.push(0)
                            }

                            month_list.forEach(function(item, index) {
                                formated_data.push([item].concat(row_month))
                            })
                                data.forEach(function(item, index) {
                                var model = item['ac_cserie'];
                                var month = item['actual_start_year'] + '-' + item['actual_start_month'];
                                row = month_list.indexOf(month) + 1;
                                col = model_list.indexOf(model) + 1;
                                if(row!=-1&&col!=-1) {
                                    formated_data[row][col] = item['number'];
                                }
                            })

                            // 基于准备好的dom，初始化echarts实例
                            var dom = document.getElementById("chart-1");
                            myChart = echarts.init(dom);


                            option = {
                                legend: {},
                                tooltip: {},
                                dataset: {
                                    source: formated_data
                                },
                                xAxis: {data:month_list},
                                yAxis: {},
                                // Declare several bar series, each will be mapped
                                // to a column of dataset.source by default.
                                series: [
                                    {type: 'bar',stack:'CDF'},
                                    {type: 'bar',stack:'CDF'},
                                    {type: 'bar',stack:'CDF'},
                                    {type: 'bar',stack:'CDF'}
                                ]
                            };

                            myChart.setOption(option);
                            window.addEventListener("resize", function(){
                                myChart.resize();
                            });
                        });
                    });
            });

        });

        $(function() {
            
            // read from database
            var query_sql = "select ac_cserie,actual_end_year,actual_end_month,count(ac_cmsn) as 'number' " +
                        "from apc_jaguar_bi_orc " +
                        "where pel_cplanningeventname='HandOver' " +
                        "and actual_end_date > add_months(sysdate,-6) " +
                        "and actual_end_date < sysdate " +
                        "group by ac_cserie,actual_end_year,actual_end_month"
            query_sql = query_sql.replace(new RegExp(' ', 'g'), '%20').replace(new RegExp("'", 'g'), '%27');
            // query for dataset
            $.get("../index.php/inceptor?query=" + query_sql,function(response) {

                var data = response;
                // query for model_list
                var query_model = "select distinct ac_cserie from apc_jaguar_bi_orc order by ac_cserie"
                query_model = query_model.replace(new RegExp(' ', 'g'), '%20').replace(new RegExp("'", 'g'), '%27');
                $.get("../index.php/inceptor?query=" + query_model,function(response_model) {
                //     // query for month_list
                    var data_model = response_model;
                    var query_month = "SELECT concat(cast(actual_end_year AS STRING),'-',cast(actual_end_month AS STRING)) AS year_and_month " +
                                  "FROM APC_Jaguar_BI_orc WHERE actual_end_date > add_months(SYSDATE,-6) AND actual_end_date <SYSDATE " +
                                  "GROUP BY actual_end_year,actual_end_month ORDER BY actual_end_year,actual_end_month"
                    query_month = query_month.replace(new RegExp(' ', 'g'), '%20').replace(new RegExp("'", 'g'), '%27');
                    $.get("../index.php/inceptor?query=" + query_month,function(response_month) {
                            var data_month = response_month;
                            var model_list = []
                            var month_list = []
                            var formated_data = []

                            for(var i = 0;i<data_month.length-1;i++){
                                month_list.push(data_month[i].year_and_month)
                            }

                            
                            for(var i = 0;i<data_model.length;i++){
                                model_list.push(data_model[i].ac_cserie)
                            }

                            
                            formated_data.push(['month'].concat(model_list))
                            var row_month = []
                            for(i=0; i < model_list.length; i++) {
                                row_month.push(0)
                            }

                            month_list.forEach(function(item, index) {
                                formated_data.push([item].concat(row_month))
                            })
                                data.forEach(function(item, index) {
                                var model = item['ac_cserie'];
                                var month = item['actual_end_year'] + '-' + item['actual_end_month'];
                                row = month_list.indexOf(month) + 1;
                                col = model_list.indexOf(model) + 1;
                                if(row!=-1&&col!=-1) {
                                    formated_data[row][col] = item['number'];
                                }
                            })

                            // 基于准备好的dom，初始化echarts实例
                            var dom = document.getElementById("chart-2");
                            myChart2 = echarts.init(dom);


                            option2 = {
                                legend: {},
                                tooltip: {},
                                dataset: {
                                    source: formated_data
                                },
                                xAxis: {data:month_list},
                                yAxis: {},
                                // Declare several bar series, each will be mapped
                                // to a column of dataset.source by default.
                                series: [
                                    {type: 'bar',stack:'HandOver'},
                                    {type: 'bar',stack:'HandOver'},
                                    {type: 'bar',stack:'HandOver'},
                                    {type: 'bar',stack:'HandOver'}
                                ]
                            };

                            myChart2.setOption(option2);
                            window.addEventListener("resize", function(){
                                myChart2.resize();
                            });
                        });
                    });
            });

        });
    </script>
</body>
</html>