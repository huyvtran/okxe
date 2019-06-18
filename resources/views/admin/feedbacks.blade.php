@extends('admin.index')
@section('content')

<div class="container" >

    <div class="row">
        <!--box header-->
        <div class="box-header">
            <h3 class="box-title"><a href="{{route('admin.charts.dashboard')}}">{{ trans('label.administrator') }}</a> > <b>{{ trans('label.feedback') }}</b></h3>
        </div>
         <!--end box header-->
        <div class="col-md-12" class="margin_30_top">
          <div class="box">            
            <!--box body-->
            <div class="box-body" class="white_backg">
              <form action="{{route('admin.feedbacks.bulkupdate')}}" method="post" class="form-inline margin_30_top white_backg">
                  {{csrf_field()}}
                  <!--alert-->
                  @if(session('alert'))
                      <div id="message" class="alert alert-success">{{session('alert')}}</div>
                  @endif
                  <!--end alert-->
                  <!--Table-->
                  <table id="itemTable" cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped with100percent">
                      <thead class="">
                        <tr>
                            <th>ID</th>
                            <th>{{ trans('label.phone') }}</th>
                            <th>{{ trans('label.name') }}</th>
                            <th>{{ trans('label.feedback') }}</th>
                            <th>{{ trans('label.rating') }}</th>
                            <th>{{ trans('label.contact_able') }}</th>
                            <th>{{ trans('label.status') }}</th>
                            <th>{{ trans('label.regison') }}</th>
                            <th><input type="checkbox" id="options" class="margin_minus_7_left"></th>
                        </tr>
                      </thead>
                      <thead>
                        <tr>
                        <td class="width5percent"><input type="text" data-column="0"  class="search-input-text bs-filters form-control width100percent"></td>
                        <td class="width13percent"><input type="text" data-column="1"  class="search-input-text bs-filters form-control width100percent"></td>

                        <td class="width5percent"><input type="text" data-column="2"  class="search-input-text bs-filters form-control width100percent"></td>
                        <td class="width28percent"><input type="text" data-column="3"  class="search-input-text bs-filters form-control width100percent"></td>
                        <td class="width8percent">
                            <select data-column="4"  class="search-input-select bs-filters form-control width100percent">
                            <option value="">({{ trans('label.rating') }})</option>
                            @foreach($rates as $rate)
                            <option value="{{$rate}}">{{$rate}}</option>
                            @endforeach
                            </select>
                        </td>

                        <td class="width8percent">
                            <select data-column="5"  class="search-input-select bs-filters  form-control width100percent">
                            <option value="0">({{ trans('label.contact_able') }})</option>
                            <option value="2">{{ trans('label.yes') }}</option>
                            <option value="1">{{ trans('label.no') }}</option>
                            </select>
                        </td>

                        <td class="width8percent">
                            <select data-column="6"  class="search-input-select bs-filters form-control width100percent">
                            <option value="">({{ trans('label.status') }})</option>
                            
                            @foreach($statuses as $key=>$value)
                            <option value="{{$value}}">{{$value}}
                            </option>
                            @endforeach
                            </select>
                        </td>
                        <td class="width12percent">
                            <input type="text" data-column="7" id="dayFrom" placeholder="{{ trans('label.from') }}"  class="search-input-date bs-filters form-control width100percent">
                            <input type="text" data-column="7" id="dayTo" placeholder="{{ trans('label.to') }}" class="search-input-date bs-filters form-control width100percent">
                        </td>
                        <td></td>
                        </tr>
                      </thead>
                
                  </table>
                  <!--end table-->
                  <!--Change status-->    
                  <div class="form-group change_status_box"> 
                    <div class="col-md-12">{{ trans('label.changestatus') }}</div>
                      <select name="checkBoxes" id="" class="form-control margin_20_left">
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
<script src="{{url('/public/dist/js/feedbacks.js')}}"></script>
@endsection
