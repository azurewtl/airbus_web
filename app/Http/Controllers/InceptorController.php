<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Elasticsearch\ClientBuilder;
use org\apache\hadoop\WebHDFS;

class InceptorController extends Controller
{
	
  public function odbcConnector()
  {     
        //system DSN as the first parameter
        $conn = odbc_connect("inceptor_96", "", "");
        if (!($conn)) {
          echo "<p>Connection to Inceptor via ODBC failed : ";
          echo odbc_errormsg ($conn);
          echo "</p>\n";
        }

        $query_input = $_GET['query'];

        $rs = odbc_do($conn,$query_input);
 
        while($result=odbc_fetch_array($rs))
        {
          $result_arr[] = $result;
        }
        //echo json_encode($result_arr);

        return response()->json($result_arr);
        odbc_close($conn);

    }

    public function visualzeViews()
    {
      return view ('visualze');
    }
}
?>

