@extends('layouts.master')

@section('content')
<div class="row">
	<div class="col-12">
		@if (session('message'))
		    <div class="alert alert-success">
		        {{ session('message') }}
		    </div>
		@endif
	  	<h1>Document Search</h1><!--文档检索-->
	  
	  	<form action="/search" method="GET">
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="q" name="q" placeholder="Key words" value="{{$query}}" required autofocus><!--关键字-->
                <div class="input-group-append">
                    <button class="btn btn-dark" type="submit">Search</button><!--搜索-->
                </div>
            </div>
		</form>
	</div>
</div>

<div class="row">
	<div class="col-12">
    @if(!is_null($query))
    <p>Total returned results:{{$total}}</p><!--共返回检索结果{{$total}}条-->
    @endif
    </div>
</div>

@if(!is_null($query) && $total_page > 0)
<nav>
    <ul class="pagination">
        @if($page > 1)
            <li class="page-item"><a class="page-link" href="{{url('search?q='.$query.'&size='.$size.'&page='.($page-1))}}">Previous page<a></li><!--上一页-->
        @else
            <li class="page-item disabled"><a class="page-link" href="#">Previous page<a></li><!--上一页-->
        @endif

        @for($i = $page_min; $i <= $page_max; $i++)
            @if($i == $page)
            <li class="page-item active">
            @else
            <li class="page-item">
            @endif
                <a class="page-link" href="{{url('search?q='.$query.'&size='.$size.'&page='.$i)}}">{{$i}}<a>
            </li>
        @endfor

        @if($page < $total_page)
            <li class="page-item"><a class="page-link" href="{{url('search?q='.$query.'&size='.$size.'&page='.($page+1))}}">Next Page<a></li><!--下一页-->
        @else
            <li class="page-item disabled"><a class="page-link" href="#">Next Page<a></li><!--下一页-->
        @endif
    </ul>
</nav>
@endif

@foreach($results as $result)
<div class="row" style="margin-bottom:30px">
    <div class="col-12">
        <div>
            <i class="fa fa-fw fa-file-pdf-o"></i>
            <a target="_blank" href="{{url('download/'.$result['_id'])}}">{{$result["_source"]["file"]["filename"]}}</a>
        </div>
        <div><i><small>{{$result["_source"]["file"]["last_modified"]}}</small></i></div>
        <div>{{str_limit($result["_source"]["content"],400)}}</div>
    </div>
</div>
    @endforeach
@endsection