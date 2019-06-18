@extends('admin.index')
@section('content')

<div class="container" >

    <div class="row">
        <!--box header-->
        <div class="box-header">
          <h3 class="box-title"><a href="{{route('admin.charts.dashboard')}}">{{ trans('label.administrator') }}</a> > <b>{{ trans('label.accounts') }}</b></h3>
        </div>
        <!--end box header-->
        <div class="col-md-12" style="margin-top:30px;">
          
          <div class="box">            
            <!--box body-->
            <div class="box-body" style="background:white;">
              <form action="{{route('admin.accounts.bulkupdate')}}" method="post" class="form-inline" style="margin-top:30px;background:white;">
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
                            <th>{{ trans('label.phone') }}</th>
                            <th>{{ trans('label.name') }}</th>
                            <th>{{ trans('label.items') }}</th>
                            <th>{{ trans('label.under') }}</th>
                            <th>{{ trans('label.active') }}</th>
                            <th>{{ trans('label.inactive') }}</th>
                            <th>{{ trans('label.rejected') }}</th>
                            <th>{{ trans('label.cancelled') }}</th>
                            <th>{{ trans('label.status') }}</th>
                            <th>{{ trans('label.regison') }}</th>
                            <th>{{ trans('label.lastvisit') }}</th>
                            <th>{{ trans('label.action') }}</th>
                            <th><input type="checkbox" id="options" style="margin-left:-7px;"></th>
                        </tr>
                      </thead>
                      <thead>
                        <tr>
                        <td class="width5percent"><input type="text" data-column="0"  class="search-input-text form-control width100percent"></td>
                        <td class="width12percent"><input type="text" data-column="1"  class="search-input-text form-control width100percent"></td>
                        <td class="width12percent"><input type="text" data-column="2"  class="search-input-text form-control width100percent"></td>
                        

                        <td class="width3percent"></td>
                        <td class="width5percent"></td>
                        <td class="width2percent"></td>
                        <td class="width2percent"></td>
                        <td class="width2percent"></td>
                        <td class="width3percent"></td>

                        <td class="width8percent">
                            <select data-column="9"  class="search-input-select form-control width100percent">
                            <option value="">({{ trans('label.status') }})</option>
                            
                            @foreach($statuses as $key=>$value)
                            <option value="{{$value}}">{{$value}}
                            </option>
                            @endforeach
                            </select>
                        </td>
                        <td class="width5percent">
                            <input type="text" data-column="10" id="dayRegisFrom" placeholder="{{ trans('label.from') }}"  class="search-regis-date form-control width100percent">
                            <input type="text" data-column="10" id="dayRegisTo" placeholder="{{ trans('label.to') }}" class="search-regis-date form-control width100percent">
                        </td>
                        <td class="width5percent">
                            <input type="text" data-column="11" id="dayVisitFrom" placeholder="{{ trans('label.from') }}"  class="search-visit-date form-control width100percent">
                            <input type="text" data-column="11" id="dayVisitTo" placeholder="{{ trans('label.to') }}" class="search-visit-date form-control width100percent">
                        </td>
                        <td class="width1percent"></td>
                        <td class="width1percent"></td>
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
<script src="{{url('/public/dist/js/accounts.js')}}"></script>
@endsection
