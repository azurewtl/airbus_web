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
        $conn = odbc_connect("inceptor_32", "", "");
        if (!($conn)) {
          echo "<p>Connection to Inceptor via ODBC failed : ";
          echo odbc_errormsg ($conn);
          echo "</p>\n";
        }
        //http://localhost/airbus_web/public/index.php/inceptor

        //$result_arr = array();
        $query_input = $_GET['query'];

        //dd($query_input);
        //$query_input = "select * from apc_jaguar_bi2 limit 10";
        $rs = odbc_do($conn,$query_input);
 
        while($result=odbc_fetch_array($rs))
        {
          $result_arr[] = $result;
        }
        //echo json_encode($result_arr);

        return response()->json($result_arr);
        odbc_close($conn);

        //$get_ac_cserie = "select distinct ac_cserie from apc_jaguar_bi2 order by ac_cserie";
        //$get_cdf = "select ac_cserie,actual_start_year,actual_start_month,count(ac_cmsn) as 'number' from apc_jaguar_bi2 where pel_cplanningeventname='CDF' and actual_start_date > add_months(sysdate,-6) and actual_start_date < sysdate group by ac_cserie,actual_start_year,actual_start_month";
        //$get_data2="select count(ac_cmsn) from apc_jaguar_bi2 where pel_cplanningeventname='$name2' and actual_end_year='$year' and actual_end_month = '$month[$key_month] and ac_cserie = '$ac_cserie[$key_cserie]'";
        //$rs_cdf = odbc_do($conn,$get_cdf);
        //echo $result = odbc_result_all($rs_cdf);

        /*
        while(odbc_fetch_row($rs_cdf))
        {
          $result_cdf = odbc_result($rs_cdf,2);
          array_push($arr_cdf,$result_cdf);
        }
        print_r($arr_cdf);
        */
        /*
        while($arr_cdf_data=odbc_fetch_array($rs_cdf))
        {
          $arr_test[] = $arr_cdf_data;
        }
        */
        //dd($arr_test);
        //echo json_encode(($arr_data),JSON_NUMERIC_CHECK);
        //return view('BI3')->with('abxc', $result_arr);
    }

    public function visualzeViews()
    {
      return view ('visualze');
    }
}
?>

