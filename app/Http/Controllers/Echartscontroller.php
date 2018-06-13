<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Elasticsearch\ClientBuilder;
use org\apache\hadoop\WebHDFS;

class EchartsController extends Controller
{
	
	public function odbcConnector(){
		
	}
	
    public function test2()
   {
	return view('erecharts');
   }
}
