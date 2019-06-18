<div class="margin_30_top">
    <p class="bold">{{ trans('label.provinces') }} {{ trans('label.w_items') }}</p>
    <div id="list_item_okxe">            
        <table cellpadding="0" cellspacing="0" border="0" class="staTable table table-bordered with100percent">
            <thead>
                <tr>
                    <tr>
                        <th>{{ trans('label.name') }}</th>
                        <th>{{ trans('label.total') }}</th>
                        <th>{{ trans('label.active') }}</th>
                    </tr>
                </tr>
            </thead>
            <tbody>
                @foreach($data[0] as $province)
                <tr>
                    <td>{{$province->name}}</td>
                    <td>{{$province->total}}</td>
                    <td>{{$province->active}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="margin_30_top">
    <p class="bold">{{ trans('label.brands') }} {{ trans('label.w_items') }}</p>
    <div id="list_item_okxe">            
        <table cellpadding="0" cellspacing="0" border="0" class="staTable table table-bordered table-dark with100percent">
            <thead>
                <tr>
                    <tr>
                        <th>{{ trans('label.name') }}</th>
                        <th>{{ trans('label.total') }}</th>
                        <th>{{ trans('label.active') }}</th>
                    </tr>
                </tr>
            </thead>
            <tbody>
                @foreach($data[1] as $brand)
                <tr>
                    <td>{{$brand->name}}</td>
                    <td>{{$brand->total}}</td>
                    <td>{{$brand->active}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="margin_30_top">
    <p class="bold">{{ trans('label.models') }} {{ trans('label.w_items') }}</p>
    <div id="list_item_okxe">            
        <table class="staTable table table-bordered table-dark with100percent">
            <thead>
                <tr>
                    <th>{{ trans('label.name') }}</th>
                    <th>{{ trans('label.total') }}</th>
                    <th>{{ trans('label.active') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data[2] as $model)
                <tr>
                    <td>{{$model->name}}({{$model->bname}})</td>
                    <td>{{$model->total}}</td>
                    <td>{{$model->active}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="margin_30_top padding_30_bottom">
    <p class="bold">{{ trans('label.accounts') }} {{ trans('label.w_items') }}</p>
    <div id="list_item_okxe">            
        <table cellpadding="0" cellspacing="0" border="0" class="staTable table table-bordered table-striped with100percent">
            <thead>
                <tr>
                    <tr>
                        <th>{{ trans('label.name') }}</th>
                        <th>{{ trans('label.total') }}</th>
                        <th>{{ trans('label.active') }}</th>
                    </tr>
                </tr>
            </thead>
            <tbody>
                @foreach($data[3] as $account)
                <tr>
                    <td><a target="_blank" href="{{route('admin.accounts.detail',$account->id)}}">{{$account->name}}</a></td>
                    <td>{{$account->total}}</td>
                    <td>{{$account->active}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    $('.staTable').DataTable();
</script>