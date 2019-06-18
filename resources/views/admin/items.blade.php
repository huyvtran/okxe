@extends('admin.index')
@section('content')

<div class="container" >

    <div class="row">
        <!--box header-->
        <div class="box-header">
              <h3 class="box-title"><a href="{{route('admin.charts.dashboard')}}">{{ trans('label.administrator') }}</a> > <b>{{ trans('label.items') }}</b></h3>
            </div>
        <div class="col-md-12" style="margin-top:30px;">
          
          <div class="box">            
            <!--end box header-->
            <!--box body-->
            <div class="box-body" style="background:white;">
              <form action="{{route('admin.items.bulkupdate')}}" method="post" class="form-inline" style="margin-top:30px;background:white;">
                  {{csrf_field()}}
                  <!--alert-->
                  @if(session('alert'))
                      <div id="message" class="alert alert-success">{{session('alert')}}</div>
                  @endif
                  <!--end alert-->
                  <!--Table-->
                  <table id="itemTable" cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped" width="100%">
                      <thead class="">
                        <tr>
                            <th>ID</th>
                            <th>{{ trans('label.title') }}</th>
                            <th>{{ trans('label.location') }}</th>
                            <th>{{ trans('label.regisno') }}</th>
                            <th>{{ trans('label.price') }} ({{ trans('label.currency') }})</th>
                            <th>{{ trans('label.status') }}</th>
                            <th>{{ trans('label.date') }}</th>
                            <th><input type="checkbox" id="options" style="margin-left:-7px;"></th>
                        </tr>
                      </thead>
                      <thead>
                        <tr>
                        <td class="width10percent"><input type="text" data-column="0"  class="search-input-text form-control width100percent"></td>
                        <td class="width13percent"><input type="text" data-column="1"  class="search-input-text form-control width100percent"></td>
                        <td class="width13percent">
                            <select data-column="2"  class="search-input-select form-control width100percent">
                            <option value="">({{ trans('label.city') }})</option>
                            @foreach($cities as $city)
                            <option value="{{$city->id}}">{{$city->name}}</option>
                            @endforeach
                            </select>
                        </td>

                        <td class="width5percent"><input type="text" data-column="3"  class="search-input-text form-control width100percent"></td>
                       <td class="width10percent"><input type="text" data-column="4"  class="search-input-text form-control width100percent"></td>
                        <td class="width8percent">
                            <select data-column="5"  class="search-input-select form-control width100percent">
                            <option value="">({{ trans('label.status') }})</option>                            
                            @foreach($statuses as $key=>$value)
                            <option value="{{$value}}">{{$value}}
                            </option>
                            @endforeach
                            </select>
                        </td>
                        <td class="width12percent">
                            <input type="text" data-column="6" id="dayFrom" placeholder="{{ trans('label.from') }}"  class="search-input-date form-control width100percent">
                            <input type="text" data-column="6" id="dayTo" placeholder="{{ trans('label.to') }}" class="search-input-date form-control width100percent">
                        </td>
                        <td></td>
                        </tr>
                      </thead>
                
                  </table>
                  <!--end table-->
                  <!--Change status-->    
                  <div class="form-group" style="float:right;position:relative;top:-30px;right:-165px"> 
                    <div class="col-md-12">{{ trans('label.changestatus') }}</div>
                      <select name="checkBoxes" id="" class="form-control" style="margin-left:15px;">
                        @foreach($statuses as $key=>$value)
                        <option value="{{$value}}">{{$value}}
                        </option>
                        @endforeach
                      </select>
                      <input type="submit" class="btn btn-success" value="{{ trans('label.submit') }}">
                    </div>
                  </div>
                  <!--end sttus-->
              </form>
            </div>
            <!--end box body-->
          </div>

        </div>

    </div>   

</div>
@endsection
@section('js')
<script src="{{url('/public/dist/js/items.js')}}"></script>
@endsection
