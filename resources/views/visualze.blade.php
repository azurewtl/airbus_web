@extends('layouts.master')

@section('content')
<div class="row">
	<div id="chart-1" class="col-md-6 col-xs-12">

	</div>
	<div id="chart-2" class="col-md-6 col-xs-12" style="height:400px">

    </div>
    
</div>
<hr>
<div class="row">

	<div id="chart-3" class="col-md-12 col-xs-12" style="height:400px">

    </div>
    
</div>
<hr>
<div class="row">

	<div id="chart-4" class="col-md-12 col-xs-12" style="height:400px">

    </div>
    
</div>
@endsection


@section('chartJS')

    <script type="text/javascript">
        $(function() {
            // read from database
            var query_sql = "select ac_cserie,actual_start_year,actual_start_month,count(ac_cmsn) as 'number' " +
                        "from apc_jaguar_bi_orc " +
                        "where pel_cplanningeventname='CDF' " +
                        "and actual_start_date > add_months(sysdate,-5) " +
                        "and actual_start_date < add_months(sysdate,1) " +
                        "group by ac_cserie,actual_start_year,actual_start_month"
            query_sql = query_sql.replace(new RegExp(' ', 'g'), '%20').replace(new RegExp("'", 'g'), '%27');
            // query for dataset
            $.get("../index.php/inceptor?query=" + query_sql,function(response) {

                var data = JSON.parse(response);
                // query for model_list
                var query_model = "select distinct ac_cserie from apc_jaguar_bi_orc order by ac_cserie"
                query_model = query_model.replace(new RegExp(' ', 'g'), '%20').replace(new RegExp("'", 'g'), '%27');
                $.get("../index.php/inceptor?query=" + query_model,function(response_model) {
                // query for month_list
                    var data_model = JSON.parse(response_model);
                    var query_month = "SELECT concat(cast(actual_start_year AS STRING),'-',cast(actual_start_month AS STRING)) AS year_and_month " +
                                  "FROM APC_Jaguar_BI_orc WHERE actual_start_date > add_months(SYSDATE,-5) AND actual_start_date <add_months(SYSDATE,1) " +
                                  "GROUP BY actual_start_year,actual_start_month ORDER BY actual_start_year,actual_start_month"
                    query_month = query_month.replace(new RegExp(' ', 'g'), '%20').replace(new RegExp("'", 'g'), '%27');
                    $.get("../index.php/inceptor?query=" + query_month,function(response_month) {
                            var data_month = JSON.parse(response_month);
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
                                title: {text: '近六个月开工数量',bottom:'2%',right:'35%'},
                                legend: {},
                                tooltip: {},
                                dataset: {
                                    source: formated_data
                                },
                                xAxis: [
                                    {
                                        name:'近六个月',
                                        data:month_list
                                    }
                                ],
                                yAxis: [
                                    {
                                        name = '开工数目（个）'
                                    }
                                ],
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

        $(setTimeout(function() {
            // read from database
            var query_sql = "select ac_cserie,actual_end_year,actual_end_month,count(ac_cmsn) as 'number' " +
                        "from apc_jaguar_bi_orc " +
                        "where pel_cplanningeventname='HandOver' " +
                        "and actual_end_date > add_months(sysdate,-5) " +
                        "and actual_end_date < sysdate " +
                        "group by ac_cserie,actual_end_year,actual_end_month"
            query_sql = query_sql.replace(new RegExp(' ', 'g'), '%20').replace(new RegExp("'", 'g'), '%27');
            // query for dataset
            $.get("../index.php/inceptor?query=" + query_sql,function(response) {

                var data = JSON.parse(response);
                // query for model_list
                var query_model = "select distinct ac_cserie from apc_jaguar_bi_orc order by ac_cserie"
                query_model = query_model.replace(new RegExp(' ', 'g'), '%20').replace(new RegExp("'", 'g'), '%27');
                $.get("../index.php/inceptor?query=" + query_model,function(response_model) {
                // query for month_list
                    var data_model = JSON.parse(response_model);
                    var query_month = "SELECT concat(cast(actual_end_year AS STRING),'-',cast(actual_end_month AS STRING)) AS year_and_month " +
                                  "FROM APC_Jaguar_BI_orc WHERE actual_end_date > add_months(SYSDATE,-5) AND actual_end_date <SYSDATE " +
                                  "GROUP BY actual_end_year,actual_end_month ORDER BY actual_end_year,actual_end_month"
                    query_month = query_month.replace(new RegExp(' ', 'g'), '%20').replace(new RegExp("'", 'g'), '%27');
                    $.get("../index.php/inceptor?query=" + query_month,function(response_month) {
                            var data_month = JSON.parse(response_month);
                            var model_list = []
                            var month_list = []
                            var formated_data = []

                            for(var i = 0;i<data_month.length;i++){
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
                                title: {text: '近六个月交付数量',bottom:'2%',right:'35%'},
                                legend: {},
                                tooltip: {},
                                dataset: {
                                    source: formated_data
                                },
                                xAxis: [
                                    {
                                        name:'近六个月',
                                        data:month_list
                                    }
                                ],
                                yAxis: [
                                    {
                                        name = '交付数目（个）'
                                    }
                                ],
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

        },2500));

        $(setTimeout(function() {
            var query_sql = "SELECT count(ac_cmsn) AS 'number',pel_cplanningeventname,pe_cmanufacturingsite " +
                        "FROM apc_jaguar_bi_orc WHERE SYSDATE > actual_start_date AND SYSDATE < actual_end_date " +
                        "GROUP BY pel_cplanningeventname,pe_cmanufacturingsite"

            query_sql = query_sql.replace(new RegExp(' ', 'g'), '%20').replace(new RegExp("'", 'g'), '%27');
            $.get("../index.php/inceptor?query=" + query_sql,function(response) {
                var data = JSON.parse(response);
                var query_peName = "select distinct pel_cplanningeventname from (select pel_cplanningeventname,pe_cmanufacturingsite FROM apc_jaguar_bi_orc WHERE SYSDATE > actual_start_date AND SYSDATE < actual_end_date GROUP BY pel_cplanningeventname,pe_cmanufacturingsite)"
                $.get("../index.php/inceptor?query=" + query_peName,function(response_peName) {
                    var data_peName = JSON.parse(response_peName);
                    var formated_data = [];
                    var peName_list = [];
                    var manufacturing_site_list = [];

                    for(var i = 0;i<data_peName.length;i++){
                        peName_list.push(data_peName[i].pel_cplanningeventname)
                    }

                    data.forEach(function(item,index){
                        if(manufacturing_site_list.indexOf(item['pe_cmanufacturingsite']) == -1){
                            manufacturing_site_list.push(item['pe_cmanufacturingsite'])
                        }
                    })
                    
                    formated_data.push(['pel_cplanningeventname'].concat(manufacturing_site_list))
                    var row_peName = []
                    for(i=0; i < manufacturing_site_list.length; i++) {
                        row_peName.push(0)
                    }

                    peName_list.forEach(function(item, index) {
                        formated_data.push([item].concat(row_peName))
                    })
                        data.forEach(function(item, index) {
                        var manufacturing_site = item['pe_cmanufacturingsite'];
                        var peName = item['pel_cplanningeventname'];
                        row = peName_list.indexOf(peName) + 1;
                        col = manufacturing_site_list.indexOf(manufacturing_site) + 1;
                        if(row!=-1&&col!=-1) {
                            formated_data[row][col] = item['number'];
                        }
                    })

                    // 基于准备好的dom，初始化echarts实例
                    var dom = document.getElementById("chart-3");
                    myChart3 = echarts.init(dom);


                    option3 = {
                        title: {text: '实时生产状态',bottom:'2%',right:'45%'},
                        legend: {},
                        tooltip: {},
                        dataset: {
                            source: formated_data
                        },
                        xAxis: [
                            {
                                name:'工序名称',
                                data:peName_list
                            }
                        ],
                        yAxis: [
                            {
                                name:'正在装配的数量（架）'
                            }
                        ],
                        // Declare several bar series, each will be mapped
                        // to a column of dataset.source by default.
                        series: [
                            {type: 'bar',stack:'peName'},
                            {type: 'bar',stack:'peName'},
                            {type: 'bar',stack:'peName'},
                            {type: 'bar',stack:'peName'},
                            {type: 'bar',stack:'peName'},
                            {type: 'bar',stack:'peName'},
                            {type: 'bar',stack:'peName'},
                            {type: 'bar',stack:'peName'},
                            {type: 'bar',stack:'peName'}

                        ]
                    };

                    myChart3.setOption(option3);
                    window.addEventListener("resize", function(){
                        myChart3.resize();
                    });
                });
            });
        },5000));

        $(setTimeout(function() {
            var query_sql = "SELECT concat(week,'th week of ',flight_year) as week_of_year,count(week) AS 'number' from(SELECT weekofyear(flight_date) AS week,EXTRACT(YEAR FROM flight_date) AS flight_year FROM tianjin_flight_planning WHERE flight_date > add_months(SYSDATE,-12) AND flight_date <add_months(SYSDATE,-9) GROUP BY week,flight_date ORDER BY week) GROUP BY flight_year,week ORDER BY flight_year,week"
            $.get("../index.php/inceptor?query=" + query_sql,function(response) {
                var data = JSON.parse(response);
                var week_of_year_list = [];
                var number_list = [];
                
                for(var i = 0;i<data.length;i++){
                    week_of_year_list.push(data[i].week_of_year)
                    number_list.push(data[i].number)
                }

                var dom = document.getElementById("chart-4");
                    myChart4 = echarts.init(dom);


                option4 = {
                    title: {text: '每周交付工作量',bottom:'2%',right:'45%'},
                    tooltip: {},
                    xAxis: [
                        {
                            name:'全年同期三个月的每周',
                            type:'category',
                            data: week_of_year_list
                        }
                    ],
                    yAxis: [
                        {
                            name: '每星期交付完成数量（项）',
                            type: 'value'
                        }
                    ],

                    series: [
                        {
                            name:'交付完成量',
                            type:'bar',
                            barWidth:'50%',
                            data: number_list,
                            itemStyle:{
                                    normal:{
                                        color:'#1E90FF'
                                    }
                            }
                
                        }
                    ]
                };

                myChart4.setOption(option4);
                window.addEventListener("resize", function(){
                    myChart4.resize();
                });
            });
        },7500));

    </script>
@endsection
