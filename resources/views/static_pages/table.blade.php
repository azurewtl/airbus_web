@extends('layouts.master')

@section('content')
<div class="card mb-3">
    <div class="card-header">
        知乎
    </div>
    <table id="table_1" class="table-responsive display">
    <thead>
        <tr>
          <th>Review_Id</th>
          <th>Create_Time</th>
          <th>Rootid</th>
          <th>Username</th>
          <th>Userid</th>
          <th>User_Description</th>
          <th>User_City</th>
          <th>User_Location</th>
          <th>Image</th>
          <th>Verified</th>
          <th>Verified_Type</th>
          <th>Profile_Url</th>
          <th>Comment</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>

<div class="card mb-3">
    <div class="card-header">
        微博
    </div>
    <table id="table_2" class="table-responsive display">
    <thead>
        <tr>
          <th>Num</th>
          <th>Author</th>
          <th>Voteup_Count</th>
          <th>Gender</th>
          <th>Created_Time</th>
          <th>Updated_Time</th>
          <th>Thanks_Count</th>
          <th>Comment_Count</th>
          <th>Excerpt</th>
          <th>Content</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>

@endsection


@section('chartJS')

<script type="text/javascript">
    $(function() {
      // zhihu
      var query_sql = "select  *  from zhihu_data;"
      query_sql = query_sql.replace(new RegExp(' ', 'g'), '%20').replace(new RegExp("'", 'g'), '%27');
      // query for dataset
      $.get("../index.php/inceptor?query=" + query_sql,function(response) {
          data = JSON.parse(response);
          $("#table_1").dataTable().fnDestroy();
          table_1 = $("#table_1").DataTable({
              data:data,
              columns:[
                  {data:'Review_Id'},
                  {data:'Create_Time'},
                  {data:'Rootid'},
                  {data:'Username'},
                  {data:'Userid'},
                  {data:'User_Description'},
                  {data:'User_City'},
                  {data:'User_Location'},
                  {data:'Image'},
                  {data:'Verified'},
                  {data:'Verified_Type'},
                  {data:'Profile_Url'},
                  {data:'Comment'}
              ]
          })
      });

      // weibo
      query_sql = "select  *  from weibo_data;"
      query_sql = query_sql.replace(new RegExp(' ', 'g'), '%20').replace(new RegExp("'", 'g'), '%27');
      // query for dataset
      $.get("../index.php/inceptor?query=" + query_sql,function(response) {
          data = JSON.parse(response);
          $("#table_1").dataTable().fnDestroy();
          table_1 = $("#table_1").DataTable({
              data:data,
              columns:[
                  {data:'Num'},
                  {data:'Author'},
                  {data:'Voteup_Count'},
                  {data:'Gender'},
                  {data:'Created_Time'},
                  {data:'Updated_Time'},
                  {data:'Thanks_Count'},
                  {data:'Comment_Count'},
                  {data:'Excerpt'},
                  {data:'Content'}
              ]
          })
      });
    })

</script>
@endsection
