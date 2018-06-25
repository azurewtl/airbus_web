@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-4  col-xs-12">
        <div class="card bg-light mb-3 text-center" style="height:100%">
            <div class="media">
                <div class="media-left media-middle">
                    <i class="fa fa-plane" style="font-size:85px"></i>
                </div>
                <div class="media-body media-right">
                    <h2 class="card-text">Work-in-process aircraft last month:</h3>
                    <h2 class="card-text" id="plane_in_production" style="height:38px"></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4  col-xs-12">
        <div class="card bg-light mb-3 text-center" style="height:100%">
            <div class="media">
                <div class="media-left meida media-middle">
                    <span><i class="fa fa-calendar-plus-o" style="font-size:85px"></i></span>
                </div>
                <div class="media-body media-text-right">
                    <h2 class="card-text">Number of new orders last month: </h2>
                    <h2 class="card-text" id="new_order" style="height:38px"></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4  col-xs-12">
        <div class="card bg-light mb-3 text-center" style="height:100%">
            <div class="media">
                <div class="media-left meida media-middle">
                    <span><i class="fa fa-calendar-check-o" style="font-size:85px"></i></span>
                </div>
                <div class="media-body media-text-right">
                    <h2 class="card-text">Number of delivered orders last month: </h2>
                    <h2 class="card-text" id="finished_order" style="height:38px"></h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
	<div id="chart-1" class="col-md-6 col-xs-12"></div>
	<div id="chart-2" class="col-md-6 col-xs-12" style="height:400px"></div>
    
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
            var query_sql = "SELECT count(DISTINCT ac_cmsn) AS plane_in_production FROM apc_jaguar_bi_orc WHERE actual_end_date > SYSDATE AND actual_start_date <SYSDATE"
            $.get("../index.php/inceptor?query=" + query_sql,function(response) {
                plane_in_production = JSON.parse(response);
                document.getElementById("plane_in_production").innerHTML = plane_in_production[0].plane_in_production;
            });
        });

        $(setTimeout(function() {
            var query_sql = "SELECT count(ac_cmsn) AS new_order FROM apc_jaguar_bi_orc WHERE actual_start_date < SYSDATE AND actual_start_date > add_months(SYSDATE,-1)"
            $.get("../index.php/inceptor?query=" + query_sql,function(response) {
                var new_order = JSON.parse(response);
                document.getElementById("new_order").innerHTML = new_order[0].new_order;
            });
        },1000));

        $(setTimeout(function() {
            var query_sql = "SELECT count(ac_cmsn) AS finished_order FROM apc_jaguar_bi_orc WHERE actual_end_date < SYSDATE AND actual_end_date > add_months(SYSDATE,-1)"
            $.get("../index.php/inceptor?query=" + query_sql,function(response) {
                finished_order= JSON.parse(response);
                document.getElementById("finished_order").innerHTML = finished_order[0].finished_order;
            });
        },2000));

        $(setTimeout(function() {
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
                                title: {text: 'New aircraft orders in last six months',bottom:'2%',left:'center'},//近六个月开工数量
                                legend: {},
                                tooltip: {},
                                dataset: {
                                    source: formated_data
                                },
                                xAxis: [
                                    {
                                        name:'Last six months',//近六个月
                                        data:month_list
                                    }
                                ],
                                yAxis: [
                                    {
                                        name:'Order number(s)'//开工数目（个）
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

        },4000));

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
                                title: {text: 'Delivered aircraft orders in last six months',bottom:'2%',left:'center'},//近六个月交付数量
                                legend: {},
                                tooltip: {},
                                dataset: {
                                    source: formated_data
                                },
                                xAxis: [
                                    {
                                        name:'Last six months',//近六个月
                                        data:month_list
                                    }
                                ],
                                yAxis: [
                                    {
                                        name:'Order number(s)'//交付数目（个）
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

        },6000));

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
                        title: {text: 'Current production status',bottom:'2%',left:'center'},//实时生产状态
                        legend: {},
                        tooltip: {},
                        dataset: {
                            source: formated_data
                        },
                        xAxis: [
                            {
                                name:'Working procedures',//工序名称
                                data:peName_list
                            }
                        ],
                        yAxis: [
                            {
                                name:'Number(s) in production'//正在装配的数量（架）
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
        },6500));

        $(setTimeout(function() {
            var query_sql = "SELECT concat(week,'th week of ',flight_year) as week_of_year,count(week) AS 'number' from(SELECT weekofyear(flight_date) AS week,EXTRACT(YEAR FROM flight_date) AS flight_year FROM tianjin_flight_planning WHERE flight_date > add_months(SYSDATE,-15) AND flight_date <add_months(SYSDATE,-12) GROUP BY week,flight_date ORDER BY week) GROUP BY flight_year,week ORDER BY flight_year,week"
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
                    title: {text: 'Weekly inspections of finished orders in last 3 months last year',bottom:'2%',left:'center'},//每周交付工作量
                    tooltip: {},
                    xAxis: [
                        {
                            name:'Weeks in last 3 months last year',//全年同期三个月的每周
                            type:'category',
                            data: week_of_year_list
                        }
                    ],
                    yAxis: [
                        {
                            name: 'Numbers of inspections',//每星期交付完成数量（项）
                            type: 'value'
                        }
                    ],

                    series: [
                        {
                            name:'Inspections of finished orders',//交付完成量
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
        },8000));

    </script>
@endsection
