@extends('admin.index')
@section('css')
<link rel="stylesheet" href="{{url('public/dist/css/charts.css')}}">
@endsection
@section('content')
<div class="container" >
    <div class="row">
        <div id="loaderDiv">
            <img src="{{url('public/images/loading.gif')}}" />
        </div> 
        <!--DATE FILTER-->
        
        <div class="well">
            <div class="well-content">
                <div class="d-inline-block bg-success"><i class="fa fa-angle-left arrow arrow-prev" style="cursor:pointer;"></i></div>
                <div class="d-inline-block bg-success date"><input type="hidden" id="date" value="1"></div>
                <div class="d-inline-block bg-success"><i class="fa fa-angle-right arrow arrow-next" style="cursor:pointer;"></i></div>
            </div>
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-primary btn-1 " value="Day">
                    <input type="radio" name="options" class="option" id="option1" autocomplete="off" >{{ trans('label.day') }}
                </label>
                <label class="btn btn-primary btn-2"  value="Week">
                    <input type="radio" name="options" class="option" id="option2" autocomplete="off">{{ trans('label.week') }}
                </label>
                <label class="btn btn-primary btn-3 active" value="Month">
                    <input type="radio" name="options" id="option3" class="option" autocomplete="off" checked>{{ trans('label.month') }}
                </label>
            </div>
            
        </div>
        
        <!--Statistics and Charts-->
        <div class="box">
            <div id="chart_div" class="col-md-6 charts chart-border"></div>
            <div id="chart_div2" class="col-md-6 charts chart-border"></div>
            <div class="statistics"></div>    
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{url('/public/dist/js/dashboard.js')}}"></script>
@endsection