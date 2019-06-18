@extends('admin.index')
@section('content')

<div class="container" >

    <div class="row">

        <!--box header-->
        <div class="box-header">
            <h3 class="box-title"><a href="{{route('admin.charts.dashboard')}}">{{ trans('label.configuration') }}</a> > <b>{{ trans('label.brands') }}</b></h3>
        </div>
         <!--end box header-->
        <div class="col-md-12 margin_30_top">
          <div class="box">            
            <!--box body-->
            <div class="box-body" class="white_backg">
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
                            <th>{{ trans('label.brands') }}</th>
                            <th>{{ trans('label.added_by') }}</th>
                            <th>{{ trans('label.created_at') }}</th>
                            <th>{{ trans('label.status') }}</th>
                            <th></th>
                        </tr>
                      </thead>
                      <thead>
                        <tr>
                        <td class="width5percent"><input type="text" data-column="0"  class="search-input-text bs-filters form-control width100percent"></td>
                        <td class="width13percent"><input type="text" data-column="1"  class="search-input-text bs-filters form-control width100percent"></td>

                        <td class="width8percent">
                            <select data-column="2"  class="search-input-select bs-filters form-control width100percent">
                            <option value=""></option>
                            @foreach($employees as $employee)
                            <option value="{{$employee->id}}">{{$employee->name}}</option>
                            @endforeach
                            </select>
                        </td>

                        <td class="width12percent">
                            <input type="text" data-column="3" id="dayFrom" placeholder="{{ trans('label.from') }}" class="search-input-date bs-filters form-control width100percent">
                            
                            <input type="text" data-column="3" id="dayTo" placeholder="{{ trans('label.to') }}" class="search-input-date bs-filters form-control width100percent">
                        </td>

                        <td class="width8percent">
                            <select data-column="4"  class="search-input-select bs-filters  form-control width100percent">
                            <option selected></option>
                            <option value="1">{{ trans('label.active') }}</option>
                            <option value="0">{{ trans('label.ban') }}</option>
                            </select>
                        </td>

                        <td><p class="ban" id="clear"><i class="fa fa-times" aria-hidden="true"></i></p></td>
                        </tr>
                      </thead>
                
                  </table>
                  <!--end table-->
                  <form class="new_brand form-inline" data-id=0 id="add_form" action="{{route('admin.brands.add')}}" method="POST" >
                    {{csrf_field()}}    
                        <input type="text" placeholder="{{trans('label.add_brand')}}" name="name" class="form-control col-md-3 check-exists"> 
                        <input type="hidden" id="status" name="active" value="2">
                        <span class="alert-box"></span>
                        <span>
                            <div class="onoffswitch">
                                <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
                                <label class="onoffswitch-label" for="myonoffswitch">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch active"><i class="hang fas fa-check"></i></span>
                                </label>
                            </div>
                        </span>
                        <span>
                                <div class="g-recaptcha" data-sitekey="6Ld0yUwUAAAAAKwK0eTmOIfegWxfpVBC1QWTxHy6">
                                </div>

                            <input type="submit" class="btn btn-primary" id="add" value="{{ trans('label.add') }}" disabled>
                        </span>      
                   </form> 
            </div>
            <!--end box body-->
          </div>

        </div>

    </div>   
    6LclyUwUAAAAALFd5qOTQGJmJorULUNC6zCP_lp5
</div>
@endsection
@section('js')
<script src="{{url('/public/dist/js/brands.js')}}"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>


@endsection
