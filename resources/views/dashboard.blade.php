<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ATM | Incidence Management</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link href="{{ asset("/bower_components/AdminLTE/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    {{--<link rel="stylesheet" href="bower_components/AdminLTE/plugins/morris.js/morris.css">--}}
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
   <link href="{{ asset("/bower_components/AdminLTE/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
   <link href="{{ asset("/bower_components/AdminLTE/dist/css/skins/skin-blue.min.css")}}" rel="stylesheet" type="text/css" />

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>-->
  <!--<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->
  <![endif]-->
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  @include('layouts.header')
  <!-- Sidebar -->
  @include('layouts.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <!-- li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li-->
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->

          <div class="small-box bg-aqua">
              <div class="inner">
              <p>Number of ATM Estate!</p>
              <h3>{{$no_ATM}}</h3>

            </div>
            <div class="icon">
              <i class="fa fa-globe fa-1x"></i>
            </div>
              <a href="atmdata-management" target="_blank" class="small-box-footer">View Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
                <p>Resolved Incidence!</p>
              <h3>{{$closedCall}}</h3>


            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="atmreport-management"  class="small-box-footer">View Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <p>Open Call</p>

              <h3>{{$openCall}}</h3>



            </div>
            <div class="icon">
              <i class="fa fa-bank fa-1x"></i>
            </div>
            <a href="listopencall"  class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <p>Aged Calls (3days above)!</p>
              <h3>{{$ageCall}}</h3>

            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" target="_blank" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      
      
      
      
        
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->

          <div class="small-box bg-blue">
              <div class="inner">
              <p>Bank Controllable</p>
              <h3>{{$suspendedCall}}</h3>

            </div>
            <div class="icon">
              <i class="fa fa-globe fa-1x"></i>
            </div>
              <a href="atmreport-management" target="_blank" class="small-box-footer">View Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
                <p>% of Open Incidence!</p>
              <h3>{{number_format(($openCall/$no_ATM)*100, 2, '.', ',')}}%</h3>


            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="atmreport-management"  class="small-box-footer">View Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-orange">
            <div class="inner">
              <p>Incidence Await Confirmation</p>

              <h3>{{$awaitCall}}</h3>



            </div>
            <div class="icon">
              <i class="fa fa-bank fa-1x"></i>
            </div>
            <a href="confirmcall"  class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-white">
            <div class="inner">
              <p>!</p>
              <h3></h3>

            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" target="_blank" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      
      
      
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
            
            
          <!-- Custom tabs (Charts with tabs)-->
          
          <!-- /.nav-tabs-custom -->

          <!-- Chat box -->
          <div class="box box-success">
          </div>
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">

          <!-- Map box -->
          <div class="box box-solid bg-light-blue-gradient">
            <div class="box-header">
              <!-- tools box -->
              <div class="pull-right box-tools">
                {{--<button type="button" class="btn btn-primary btn-sm daterange pull-right" data-toggle="tooltip"--}}
                        {{--title="Date range">--}}
                  {{--<i class="fa fa-calendar"></i></button>--}}
                {{--<button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse"--}}
                        {{--data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">--}}
                  {{--<i class="fa fa-minus"></i></button>--}}
              </div>
              <!-- /. tools -->

              <i class="fa fa-map-marker"></i>

              <h3 class="box-title">
               Latest Call Log
              </h3>

                
                <div class="panel-body">
                  @foreach($latests as $latest)
                    <div class="list-group">
                        <a href="#" class="list-group-item">
                            <i class="fa fa-comment fa-fw"></i> {{$latest->terminal_id}} || {{$latest->atm_name}}
                            <span class="pull-right text-muted small"><em>{{$latest->mail_at}}</em>
                                    </span>
                        </a>

                      @endforeach
                    </div>
					
                    <!-- /.list-group -->
                    {{--<a href="#" class="btn btn-default btn-block">View All Alerts</a>--}}
          
          </div>
          <!-- /.box -->

          <!-- solid sales graph -->
          <div class="box box-solid bg-teal-gradient">
            <div class="box-header">
              <i class="fa fa-th"></i>

              <h3 class="box-title">Graph</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                </button>
              </div>
            </div>
            <div class="box-body border-radius-none">
{{--                <img src="{{ asset("/bower_components/AdminLTE/dist/img/bar2.png") }}" width="100%" >--}}
              {{--<div class="chart" id="line-chart" style="height: 250px;"></div>--}}
            </div>
            <!-- /.box-body -->
                <!-- ./col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->

          <!-- Calendar -->
            <!-- /.box-header -->
          <!-- /.box -->

        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    
    
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
     
    </div>
    <strong>Copyright &copy; 2020 <a href="#">Universal Horizon Ltd </a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
{{--<script src="bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>--}}
<!-- jQuery UI 1.11.4 -->
{{--C:\xampp\htdocs\UEagledesk\public\bower_components\AdminLTE\plugins\jQueryUI\jquery-ui.min.js--}}
{{--<script src="bower_components/AdminLTE/plugins/jQueryUI/jquery-ui.min.js"></script>--}}
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
{{--<script>--}}
    {{--$.widget.bridge('uibutton', $.ui.button);--}}
{{--</script>--}}
{{--<!-- Bootstrap 3.3.2 JS -->--}}
{{--<script src="{{ asset ("/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>--}}

<!-- Morris.js charts -->
{{--<script src="bower_components/AdminLTE/plugins/raphael/raphael.min.js"></script>--}}
{{--<script src="bower_components/AdminLTE/plugins/morris.js/morris.min.js"></script>--}}
{{--<!-- Sparkline -->--}}
{{--<script src="bower_components/AdminLTE/plugins/sparkline/jquery.sparkline.js"></script>--}}
{{--<!-- jvectormap -->--}}
{{--<script src="bower_components/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>--}}
{{--<script src="bower_components/AdminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>--}}
{{--<!-- jQuery Knob Chart -->--}}
{{--<script src="bower_components/AdminLTE/plugins/knob/dist/jquery.knob.min.js"></script>--}}
{{--<!-- daterangepicker -->--}}
{{--<script src="bower_components/AdminLTE/plugins/moment/min/moment.min.js"></script>--}}
{{--<script src="bower_components/AdminLTE/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>--}}
{{--<!-- datepicker -->--}}
    {{--<script src="bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js"></script>--}}
{{--<!-- Bootstrap WYSIHTML5 -->--}}
{{--<script src="bower_components/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>--}}
{{--<!-- Slimscroll -->--}}
{{--<script src="bower_components/AdminLTE/plugins/slimscroll/jquery.slimscroll.min.js"></script>--}}
{{--<!-- FastClick -->--}}
{{--<script src="bower_components/AdminLTE/plugins/fastclick/fastclick.min.js"></script>--}}
<!-- AdminLTE App -->
{{--<script src="js/adminlte.min.js"></script>--}}
{{--<!-- AdminLTE dashboard demo (This is only for demo purposes) -->--}}
{{--<script src="dist/js/pages/dashboard.js"></script>--}}
{{--<!-- AdminLTE for demo purposes -->--}}
{{--<script src="dist/js/demo.js"></script>--}}
</body>
</html>


<!-- Main content -->
    {{--<section class="content">--}}

      {{--<!-- Your Page Content Here -->--}}

    {{--</section>--}}
    {{--<!-- /.content -->--}}
  {{--</div>--}}
  {{--<!-- /.content-wrapper -->--}}

  {{--<!-- Footer -->--}}
  {{--@include('layouts.footer')--}}

{{--<!-- ./wrapper -->--}}

{{--<!-- REQUIRED JS SCRIPTS -->--}}

 {{--<!-- jQuery 2.1.3 -->--}}
{{--<script src="{{ asset ("/bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js") }}"></script>--}}

{{--<!-- Bootstrap 3.3.2 JS -->--}}
{{--<script src="{{ asset ("/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>--}}

{{--<!-- AdminLTE App -->--}}
{{--<script src="{{ asset ("/bower_components/AdminLTE/dist/js/app.min.js") }}" type="text/javascript"></script>--}}

{{--<!-- Optionally, you can add Slimscroll and FastClick plugins.--}}
     {{--Both of these plugins are recommended to enhance the--}}
     {{--user experience. Slimscroll is required when using the--}}
     {{--fixed layout. -->--}}
{{--</body>--}}
{{--</html>--}}
