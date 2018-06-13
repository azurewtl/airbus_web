@extends('layouts.master')

@section('content')
<div class="card mb-3">
  <div class="card-header">
        知乎
  </div>
  <div class="table-responsive">
    <table id="table_1" class="table display nowrap">
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
</div>

<div class="card mb-3">
    <div class="card-header">
        微博
    </div>
    <div class="table-responsive">
      <table id="table_2" class="table display nowrap">
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
</div>

@endsection


@section('chartJS')

<script type="text/javascript">
    $(function() {
      // zhihu
      var query_sql = "select * from zhihu_data limit 500"
      query_sql = query_sql.replace(new RegExp(' ', 'g'), '%20').replace(new RegExp("'", 'g'), '%27');
      // query for dataset
      $.get("../index.php/inceptor?query=" + query_sql,function(response) {
          var data = JSON.parse(response);
          $("#table_1").DataTable({
              data:data,
              scrollX: true,
              columns:[
                  {data:'num'},
                  {data:'author'},
                  {data:'voteup_count'},
                  {data:'gender'},
                  {data:'created_time'},
                  {data:'updated_time'},
                  {data:'thanks_count'},
                  {data:'comment_count'},
                  {data:'excerpt'},
                  {data:'content'}
              ]

          })
      });

      // weibo
      query_sql = "select * from weibo_data limit 500"
      query_sql = query_sql.replace(new RegExp(' ', 'g'), '%20').replace(new RegExp("'", 'g'), '%27');
      // query for dataset
      $.get("../index.php/inceptor?query=" + query_sql,function(response) {
          var data = JSON.parse(response);
          $("#table_2").DataTable({
              data:data,
              scrollX: true,
              columns:[
                  {data:'review_id'},
                  {data:'create_time'},
                  {data:'rootid'},
                  {data:'username'},
                  {data:'userid'},
                  {data:'user_description'},
                  {data:'user_city'},
                  {data:'user_location'},
                  {data:'image'},
                  {data:'verified'},
                  {data:'verified_type'},
                  {data:'profile_url'},
                  {data:'comment'}
              ]
          })
      });

    })

</script>
@endsection
