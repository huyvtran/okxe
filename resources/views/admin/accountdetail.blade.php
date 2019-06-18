@extends('admin.index')

@section('content')

<div  class="container" >
    <input type="hidden" name="id" id="accountid" value="{{request()->id}}"> 
        <!--box header-->
        <div class="box-header">
              <h3 class="box-title"><a href="{{route('admin.charts.dashboard')}}">{{trans('label.administrator')}}</a> > <b>{{trans('label.accouts')}}</b></h3>
        </div>
        <div class="box-header">
              <span style="float: left;"><h3 class="box-title"><p class="username">{{$user->name }} | <a href=".">{{ $user->phone }}</a> | {{ $user->status}}</h3></span>
               <div class="select-input-account-status">
                  <span id="action" class="{{($user->status == 'Active') ? 'ban' : 'active'}}">{{($user->status == 'Active') ? trans('label.ban') : ($user->status == 'Banned' ? trans('label.re_active') : '')}}</span>
                </div>
        </div>
    <div class="row-account">
        <div class="col-md-12" style="margin-top:30px;">
          <div class="box">            
            <!--end box header-->
            <!--box body-->
            <div class="box-body" style="background:white;">
              <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped" width="100%">
              <thead class="">
                  <tr>
                      <th>{{trans('label.items')}}</th>
                      <th>{{trans('label.under')}}</th>
                      <th>{{trans('label.active')}}</th>
                      <th>{{trans('label.inactive')}}</th>
                      <th>{{trans('label.rejected')}}</th>
                      <th>{{trans('label.cancelled')}}</th>
                      <th>{{trans('label.created_at')}}</th>
                      <th>{{trans('label.last_visit')}}</th>                               
                  </tr>
              </thead>
              <tbody>
                  <tr>
                  <td  class="width10percent"><label data-val="Items" class="select-input-status">{{$items}}</label></td>
                  <td  classs="width13percent"><label data-val="Under review" class="select-input-status">{{$under}}</label></td>                 
                  <td  class="width10percent"><label data-val="Active" class="select-input-status">{{$active}}</label></td>
                  <td  class="width5percent"><label data-val="Inactive" class="select-input-status">{{$inactive}}</label></td>
                  <td  class="width13percent"><label data-val="Rejected" class="select-input-status">{{$rejected}}</label></td>
                  <td  class="width13percent"><label data-val="Cancelled" class="select-input-status">{{$cancelled}}</label></td>
                  <td  class="width8percent">{{$user->created_at}}</td>
                  <td>{{$user->last_visit}}
                  </tr>  
              </tbody>
            </table>
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
                            <th>{{trans('label.title')}}</th>
                            <th>{{trans('label.location')}}</th>
                            <th>{{trans('label.regisno')}}</th>
                            <th>{{trans('label.price')}} (đ)</th>
                            <th>{{trans('label.status')}}</th>
                            <th>{{trans('label.date')}}</th>
                            <th><input type="checkbox" id="options" style="margin-left:-7px;"></th>
                        </tr>
                      </thead>
                      <thead>
                        <tr>
                        <td class="width10percent"><input type="text" data-column="0" style="width:100% !important;"  class="search-input-text form-control"></td>
                        <td class="width13percent"><input type="text" data-column="1"  style="width:100% !important;" class="search-input-text form-control"></td>
                      
                        <td class="width13percent">
                            <select data-column="2"  class="search-input-select form-control" style="width:100% !important;">
                            <option value="">(Select a city)</option>
                            @foreach($cities as $city)
                            <option value="{{$city->id}}">{{$city->name}}</option>
                            @endforeach
                            </select>
                        </td>

                        <td class="width5percent"><input type="text" data-column="3" style="width:100% !important;"  class="search-input-text form-control"></td>
                        <td class="width10percent"><input type="text" data-column="4" style="width:100% !important;"  class="search-input-text form-control"></td>

                        <td class="width8percent">
                            <select data-column="5"  class="search-input-select form-control" style="width:100% !important;">
                            <option value="">(Select a status)</option>
                            
                            @foreach($statuses as $key=>$value)
                            <option value="{{$value}}">{{$value}}
                            </option>
                            @endforeach
                            </select>
                        </td>
                        <td class="width5percent">
                            <input type="text" data-column="6" id="dayFrom" placeholder="From"  class="search-input-date form-control width100percent ">
                            <input type="text" data-column="6" id="dayTo" placeholder="To" class="search-input-date form-control width100percent">
                        </td>
                        <td class="width5percent"></td>
                        </tr>
                      </thead>                
                  </table>
                  <!--end table-->
                  <!--Change status-->    
                  <div class="form-group" style="float:right;position:relative;top:-30px;right:-165px"> 
                    <div class="col-md-12">{{trans('label.changestatus')}}</div>
                      <select name="checkBoxes" id="" class="form-control" style="margin-left:15px;">
                        @foreach($statuses as $key=>$value)
                        <option value="{{$value}}">{{$value}}
                        </option>
                        @endforeach
                      </select>
                      <input type="submit" class="btn btn-success" value="Submit">
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

<script src="{{url('/public/dist/js/accountdetail.js')}}"></script>
@endsection
