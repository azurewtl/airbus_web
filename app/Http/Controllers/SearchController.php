<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Elasticsearch\ClientBuilder;
use org\apache\hadoop\WebHDFS;

class SearchController extends Controller
{
    public $hosts = [
        'http://172.16.140.94:9200'//,
        //'http://172.16.140.95:9200',
        //'http://172.16.140.96:9200'
    ];

    public $hdfs_base = "tmp/airbus/pdf/pdf";

    public $item_per_page = 10;

    public function index(Request $request)
    {
        $query = $request->input('q');
        $page = $request->input('page', 1);
        $size = $request->input('size', $this->item_per_page);
        $total = 0;
        $results = [];

        if($page < 1)
        {
            $page = 1;
        }

        if(!is_numeric($size) || $size < 1)
        {
            $size = 10;
        }

        $from = ($page - 1) * $size;

        if(isset($query))
        {
            $response = $this->search($query, $from, $size);

            $total = $response["hits"]["total"];
            $results = $response["hits"]["hits"];
        }

        $total_page = intval(ceil($total / $size));

        $page_min = 1;
        $page_max = $total_page;

        if($page > 4)
        {
            $page_min = $page - 4;
        }

        if(($total_page - $page) > 5)
        {
            $page_max = $page + 5;
        }

        return view('search')
            ->with('query', $query)
            ->with('results', $results)
            ->with('total', $total)
            ->with('page', $page)
            ->with('size', $size)
            ->with('total_page', $total_page)
            ->with('page_min', $page_min)
            ->with('page_max', $page_max)
            ;
    }

    public function search($query, $from = 0, $size = 10)
    {
        

        $client = ClientBuilder::create()
                            ->setHosts($this->hosts)
                            ->build();
        $params = [
            'index' => 'resfile',
            'type' => 'doc',
            'body' => [
                'from' => $from,
                'size' => $size,
                'query' => [
                    'match' => [
                        'content' => $query
                    ]
                ]
            ]
        ];
        
        $response = $client->search($params);

        return $response;
    }

    public function get($id)
    {
        $client = ClientBuilder::create()
                            ->setHosts($this->hosts)
                            ->build();
        $params = [
            'index' => 'resfile',
            'type' => 'doc',
            'id' => $id
        ];
        
        $response = $client->get($params);

        return $response;
    }

    public function download(Request $request, $id)
    {
        $response = $this->get($id);

        $filename = $response["_source"]["file"]["filename"];

        $hdfs_url = 'http://172.16.140.94:14000/webhdfs/v1/tmp/airbus/pdf/search/'.$filename.'?op=OPEN&user.name=hdfs';

        return redirect()->away($hdfs_url);
    }
}
