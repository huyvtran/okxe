<!DOCTYPE html>

<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Admin OkXe</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{url('/public/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('/public/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{url('/public/dist/css/jquery-ui.css')}}">
  <link rel="stylesheet" type="text/css" href="{{url('/public/dist/css/jquery.dataTables.min.css')}}" />
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{url('/public/bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  @yield('css')
  <link rel="stylesheet" href="{{url('public/dist/css/AdminLTE.min.css')}}">
  <link rel="stylesheet" href="{{url('public/dist/css/adminokxe.css')}}">
  <link href="{{url('public/dist/css/theme.jui.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{url('public/dist/css/skins/skin-blue.min.css')}}">
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
  <header class="main-header">
  <input type="hidden" value="{{Lang::locale()}}" id="lang">
    <a href="{{route('admin.charts.dashboard')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini" ><img src="{{url('/public/images/okxe.png')}}" width="30px"></span>
      <!-- logo for regular state and mobile devices -->

      <span class="logo-lg"><img src="{{url('/public/images/okxe.png')}}" width="40px"></span>
    </a>
    
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <section class="sidebar">
  
     <div class="navbar-static-top">
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="{!! Request::is('admin') ? 'active' : '' !!}"><a href="{{route('admin.charts.dashboard')}}"><i class="fa fa-home"></i> <span>{{ trans('label.dashboard') }}</span></a></li>
        <li class="treeview {!! Request::is('admin/items') || Request::is('admin/feedbacks') || Request::is('admin/accounts') ? 'active' : '' !!}" >
          <a href="#"><i class="fa fa-refresh"></i> <span>{{ trans('label.administrator') }}</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{Request::is('admin/items') ? 'selected' : ''}}"><a href="{{route('admin.items.index')}}">{{ trans('label.items') }}</a></li>
            <li class="{{Request::is('admin/accounts') ? 'selected' : ''}}"><a href="{{route('admin.accounts.index')}}">{{ trans('label.accounts') }}</a></li>
            <li class="{{Request::is('admin/feedbacks') ? 'selected' : ''}}"><a href="{{route('admin.feedbacks.index')}}">{{ trans('label.feedback') }}</a></li>
          </ul>
        </li>
        <li class="treeview {!! Request::is('admin/brands') || Request::is('admin/models')? 'active' : '' !!}">
          <a href="#"><i class="fa fa-cog"></i> <span>{{ trans('label.configuration') }}</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{Request::is('admin/brands') ? 'selected' : ''}}"><a href="{{route('admin.brands.index')}}">{{ trans('label.brands') }}</a></li>
          </ul>
        </li>
        <li><a href="{{ url('/admin/logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i><span>{{ trans('label.logout') }}</span></a></li>
        <li><a href="{{ url('/admin/password') }}"><i class="fa fa-sign-out" aria-hidden="true"></i><span>{{ trans('label.changepassword') }}</span></a></li>
      </ul>
      </ul>

     
        
      </div>
      <nav>
     <a href="#" class="alignCenter" data-toggle="push-menu" role="button"><center><i  class="fa fa-bars" aria-hidden="true"></i></center>
     </a>
     </nav>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
  <div class="content-wrapper">
    @yield('content')
    <div class="top-right links">
      <form action="{{ route('switchLang') }}" class="form-lang" method="post">
          <select name="locale" onchange='this.form.submit();'>
              <option value="en">{{ trans('label.lang.en') }}</option>
              <option value="vi"{{ Lang::locale() === 'vi' ? 'selected' : '' }}>{{ trans('label.lang.vi') }}</option>
          </select>
          {{ csrf_field() }}
      </form>
    </div>
  </div>
<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="{{url('/public/bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="{{url('/public/dist/js/jquery-ui.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{url('/public/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('/public/dist/js/adminlte.min.js')}}"></script>
<script src="{{url('/public/dist/js/datatables.min.js')}}"></script>
<script src="{{url('public/dist/js/index.js')}}"></script>
{{--  <script src="{{url('public/dist/js/moment.js')}}"></script>  --}}
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.js"></script>
{{--  <script type="text/javascript" src="{{url('public/dist/js/charts.js')}}"></script>  --}}

<script>
  var jsLang = <?php echo $jsLang ?>;
</script>
@yield('js')
</body>
</html>