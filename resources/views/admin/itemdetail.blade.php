@extends('admin.index')
@section('content')
<div class="container">
  <div class="box-header-detail">
       <h3 class="box-title"><a href="{{route('admin.charts.dashboard')}}">{{ trans('label.administrator') }}</a>  > <b>{{ trans('label.items') }}</b></h3>
      <h4><span>{{$item->province ? $item->province->name.' | ' : ''}}</span> <span><a href="{{route('admin.accounts.detail',$item->user ? $item->user->id : '')}}"> {{$item->user ? $item->user->name.' | ' : ''}}</a></span> <span class="bold_words">{{$item->title ? $item->title:''}}</span></h4>
      <hr class="hr"/> 
  </div> <!-- box-header -->

      @if(session('alert'))
        <div id="message" class="alert alert-success">{{session('alert')}}</div>
      @endif
    <div class="body_detail col-md-12">
        <div class="col-md-4">
            {{$item->type ? ($item->type.($item->color || $item->engine_power?',' :'')): ''}} {{$item->color ? $item->color.($item->engine_power?',' :''):''}} {{$item->engine_power}} 
            <h3 class="price">{{number_format($item->price,"0",",",".")}} {{trans('label.currency')}} </h3>
            <span class="bold_words">{{$item->seri}}</span>
              {{$item->year ? '('.$item->year.')' : ''}} 
            <p class="bold_words">{{$item->number ? trans('label.km',['km'=>$item->number]).($item->quality_color ? ',' : '') : ''}}  {{$item->quality_color ? trans('label.quality',['quality'=>$item->quality_color]) : ''}}</p> 
            <p>{{$item->user ? trans('label.owner').':' : ''}} {{$item->user ? $item->user->name : '' }}</p>
        </div> <!-- col-md-4 -->

        <div class="col-md-8" >
            <form action="{{route('admin.items.update',$item->id)}}" method="POST">
           {{ csrf_field() }}
        
            <div class="btn-group" role="group">
              <select name="status" id="" class="form-control">
                @foreach($item->statuses as $status)
                  <option value="{{$status}}" {{$item->status == $status ? 'selected' : ''}}>{{$status}}</option>
                @endforeach
              </select>
            </div>
              <input class="btn btn-success" type="submit" value="{{trans('label.update_status')}}">
            </form>
          <br>
             <p class="bold_words">{{ trans('label.descripttion')}} :</p>
             <div>{{$item->description ? $item->description: ''}}</div>
        </div> <!-- col-md-8 -->
    </div> <!-- body_detail -->
    
  <div class="col-md-12">
     @if($item->images)
       @foreach($item->images as $image)
          <div class="col-md-3 col-sm-6 col-xs-6">
            <img class="thumb" src="{{url('/public/images')}}/{{$image->name}}" alt="">           
          </div>           
       @endforeach  
     @endif
  </div col-md-12> <!-- images -->
  <iframe class="map col-md-12 col-sm-12 col-xs-12"
            src="https://www.google.com/maps/embed/v1/place?key={{env('GOOGLE_MAP_KEY')}}
            &q={{$item->ward ? $item->ward->name : ($item->county ? $item->county->name : ($item->province ? $item->province->name : 'Việt Nam'))}}" allowfullscreen>
  </iframe> 
</div> <!-- container -->
@endsection
@section('js')
<script>
$(function() {
  setTimeout(function() {
      $("#message").hide('blind', {}, 500)
  }, 4000);
});
</script>
@endsection