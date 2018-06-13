<!DOCTYPE html>
@extends('layouts.master')
<head>
<meta charset="utf-8"> 
<title>Airbus POC - 爬虫数据</title> 
<style>
li.datatable
{
	float:left;
	margin:0px;
	padding:0px;
	overflow:hidden;
	display:inline;
}
a.datatable
{
	width:80px;
}
</style>
<script language="javascript">
function getCurDate()
{
var d = new Date();
var week;
switch (d.getDay()){
case 1: week="星期一"; break;
case 2: week="星期二"; break;
case 3: week="星期三"; break;
case 4: week="星期四"; break;
case 5: week="星期五"; break;
case 6: week="星期六"; break;
default: week="星期天";
}
var years = d.getFullYear();
var month = add_zero(d.getMonth()+1);
var days = add_zero(d.getDate());
var hours = add_zero(d.getHours());
var minutes = add_zero(d.getMinutes());
var seconds=add_zero(d.getSeconds());
var ndate = years+"年"+month+"月"+days+"日 "+hours+":"+minutes+":"+seconds+" "+week;
var divT=document.getElementById("logInfo");
divT.innerHTML= ndate;
}
function add_zero(temp)
{
if(temp<10) return "0"+temp;
else return temp;
}
setInterval("getCurDate()",100);
</script>
</head>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
						<a href = '/table?type=1' class="datatable"><li class="fa fa-table datatable">&nbsp;知乎数据&emsp;</li></a>
						<a href = '/table?type=2' class="datatable"><li class="fa fa-table datatable">&nbsp;微博数据&emsp;</li></a>
       	</div>
        <div class="card-body">
          <div class="table-responsive">
          <?php 
          if ($_GET['type'] == 1){
          ?>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
              <tfoot>
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
              </tfoot>
              <tbody>
                <tr>
                  <td>Tiger Nixon</td>
                  <td>System Architect</td>
                  <td>Edinburgh</td>
                  <td>61</td>
                  <td>2011/04/25</td>
                  <td>$320,800</td>
                  <td>$320,800</td>
                  <td>$320,800</td>
                  <td>$320,800</td>
                  <td>$320,800</td>
                  <td>$320,800</td>
                  <td>$320,800</td>
                  <td>888888</td>
                </tr>
              </tbody>
            </table>
            <?php
            } elseif($_GET['type'] == 2){
            ?>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
              <tfoot>
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
              </tfoot>
              <tbody>
                <tr>
                  <td>Tiger Nixon</td>
                  <td>System Architect</td>
                  <td>Edinburgh</td>
                  <td>61</td>
                  <td>2011/04/25</td>
                  <td>$320,800</td>
                  <td>$320,800</td>
                  <td>$320,800</td>
                  <td>$320,800</td>
                  <td>$320,800</td>
                </tr>
              </tbody>
            </table>
            <?php
            }
            ?>
          </div>
        </div>
        <div class="card-footer small text-muted"><p id="logInfo"></p></div>
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © Your Website 2018</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="login.html">Logout</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="js/sb-admin-datatables.min.js"></script>
  </div>
</body>

</html>
