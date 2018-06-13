@extends('layouts.master')

@section('content')
<div class="row">
	<div class="col-12">
		@if (session('message'))
		    <div class="alert alert-success">
		        {{ session('message') }}
		    </div>
		@endif
	  	<h1>文档检索</h1>
	  
	  	<form action="/search" method="GET">
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="q" name="q" placeholder="关键字" value="{{$query}}" required autofocus>
                <div class="input-group-append">
                    <button class="btn btn-dark" type="submit">搜索</button>
                </div>
            </div>
		</form>
	</div>
</div>

<div class="row">
	<div class="col-12">
    @if(!is_null($query))
    <p>共返回检索结果{{$total}}条</p>
    @endif
    </div>
</div>

@if(!is_null($query) && $total_page > 0)
<nav>
    <ul class="pagination">
        @if($page > 1)
            <li class="page-item"><a class="page-link" href="{{url('search?q='.$query.'&size='.$size.'&page='.($page-1))}}">上一页<a></li>
        @else
            <li class="page-item disabled"><a class="page-link" href="#">上一页<a></li>
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
            <li class="page-item"><a class="page-link" href="{{url('search?q='.$query.'&size='.$size.'&page='.($page+1))}}">下一页<a></li>
        @else
            <li class="page-item disabled"><a class="page-link" href="#">下一页<a></li>
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