@extends('layouts.master')

@section('content')
<div class="content-wrapper">
        <!-- Example DataTables Card-->
        <div class="card mb-3">
            <div class="card-header">
                生产报表
            </div>
            <div class="card-body">
                <div class="input-group">
                    <select class="form-control input-group-text col-lg-2" id="production-column">
                            <option>ac_cmsn</option>
                            <option>pel_cplanningeventname</option>
                            <option>pe_cmanufacturingsite</option>
                            <option>ac_cserie</option>
                            <option>ac_ccust_name</option>
                            <option>actual_start_date</option>
                            <option>actual_start_year</option>
                            <option>actual_start_month</option>
                            <option>actual_end_date</option>
                            <option>actual_end_year</option>
                            <option>actual_end_month</option>
                            <option>cstartbaselinedate</option>
                    </select>
                    
                    <input type="text" class="form-control" placeholder="搜索值">
                    <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2"> <i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                查询结果
            </div>
            <div class="card-body">
                <div class="table-responsive"></div>
            </div>
        </div>
</div>
@endsection


@section('chartJS')

<script type="text/javascript">
    $(function() {
        // read from database
        var query_sql = "select * from apc_jaguar_bi_orc"
        query_sql = query_sql.replace(new RegExp(' ', 'g'), '%20').replace(new RegExp("'", 'g'), '%27');
        
        // query for dataset
        $.get("../index.php/inceptor?query=" + query_sql,function(response) {

            var data = JSON.parse(response);

        });
    });

</script>
@endsection
