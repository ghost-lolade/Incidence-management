  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset("/bower_components/AdminLTE/dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">


          <p>{{ Auth::user()->username}}</p>

          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- search form (Optional) -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <!-- Optionally, you can add icons to the links -->
        <li class="active"><a href="{{ url('dashboard') }}"><i class="fa fa-link"></i> <span>Dashboard</span></a></li>
        @if (Auth::user()->usertype =='0')

          <li><a href="{{ route('atmdata-management.index') }}"><i class="fa fa-calendar"></i> <span>ATM Estate</span></a></li>

        {{--<li><a href="{{ url('employee-management') }}"><i class="fa fa-link"></i> <span>Employee Management</span></a></li>--}}
        {{--</li>  <li class="treeview">--}}
          {{--<a href="#"><i class="fa fa-object-group"></i> <span>Estate Management</span>--}}
            {{--<span class="pull-right-container">--}}
              {{--<i class="fa fa-angle-left pull-right"></i>--}}
            {{--</span>--}}
          {{--</a>--}}
          {{--<ul class="treeview-menu">--}}


          <li><a href="{{ url('logeco') }}"><i class="fa fa-laptop"></i> <span>Log New Incidence </span></a></li>
		  <li><a href="{{ url('listopencall') }}"><i class="fa fa-link"></i> <span>View Open Incidence</span></a></li>
		   
		   <li><a href="{{ route('confirmcall.index') }}"><i class="fa fa-laptop"></i> <span> Confirm Closure</span></a></li>

		   
		    <li><a href="{{ url('vendor-daily-report') }}"><i class="fa fa-calendar"></i> <span>Daily Trend Analysis</span></a></li>
              <li><a href="{{ url('search-terminal') }}"><i class="fa fa-link"></i> <span>Terminal Report</span></a></li>
            
            	<li><a href="{{ route('atmreport-management.index') }}"><i class="fa fa-laptop"></i> <span>View Suspended/Closed Call</span></a></li>
 <li><a href="{{ url('sla-report-management') }}"><i class="fa fa-laptop"></i> <span>Generate SLA Report</span></a></li>
 <li><a href="{{ url('search-management') }}"><i class="fa fa-link"></i> <span>Search Report</span></a></li>
 
<!--          <li class="treeview">-->
<!--            <a href="#"><i class="fa fa-link"></i> <span>Generate Report</span>-->
<!--              <span class="pull-right-container">-->
<!--              <i class="fa fa-angle-left pull-right"></i>-->
<!--            </span>-->
<!--            </a>-->
<!--            <ul class="treeview-menu">-->
		
<!--              <li><a href="{{ url('sla-report-management') }}"><i class="fa fa-laptop"></i> <span>Generate SLA Report</span></a></li>-->

<!--              <li><a href="{{ route('pm-management.index') }}"><i class="fa fa-link"></i> <span>Preventive Maintenance </span></a></li>-->
<!--              <li><a href="{{ url('search-management') }}"><i class="fa fa-link"></i> <span>Search Report</span></a></li>-->
<!--{{--              <li><a href="{{ url('sla-management') }}"><i class="fa fa-laptop"></i> <span>Set SLA Rules</span></a></li>--}}-->
<!--            </ul>-->
<!--          </li>-->
		 
        

          <li><a href="{{ route('partreplace-management.index') }}"><i class="fa fa-link"></i> <span>Cash & Charge</span></a></li>

          <!--<li><a href="{{ route('user-management.index') }}"><i class="fa fa-calendar"></i> <span>User Management</span></a></li>-->

          <li class="treeview">
            <a href="#"><i class="fa fa-link"></i> <span>System Management</span>
              <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ route('vendor-management.index') }}"><i class="fa fa-link"></i> <span>Vendor Management</span></a></li>
              <li><a href="{{ route('vendordata-management.index') }}"><i class="fa fa-link"></i> <span>Vendor Statff Data</span></a></li>
              <li><a href="{{ route('requester-management.index') }}"><i class="fa fa-link"></i> <span>Requester Management</span></a></li>
              <li><a href="{{ url('uploadATM') }}"><i class="fa fa-laptop"></i> <span> Upload ATM</span></a></li>
              <li><a href="{{ url('uploadCall') }}"><i class="fa fa-laptop"></i> <span> Upload Incidence</span></a></li>
              <li><a href="{{ url('pmcert') }}"><i class="fa fa-laptop"></i> <span> PM Certificate</span></a></li>
            </ul>
          </li>
		  
        @endif


        @if (Auth::user()->usertype >='1')

          <li><a href="{{ route('atmdata-management.index') }}"><i class="fa fa-calendar"></i> <span>ATM Estate</span></a></li>

{{--          <li><a href="{{ route('atmreport-management.index') }}"><i class="fa fa-link"></i> <span>View Closed Call</span></a></li>--}}
{{--          <li><a href="{{ route('atmreport-management.create') }}"><i class="fa fa-laptop"></i> <span>Log New Incidence </span></a></li>--}}

          <li><a href="{{ url('incidence-vendor') }}"><i class="fa fa-calendar"></i> <span> Close Bank Incidence </span></a></li>
          {{--<li><a href="{{ route('atmdata-management.index') }}"><i class="fa fa-link"></i> <span>ATM Estate </span></a></li>--}}
          {{--<li><a href="{{ route('atmreport-management.create') }}"><i class="fa fa-link"></i> <span>Log New Incidence </span></a></li>--}}
          {{--<li><a href="{{ url('atmreporter-management') }}"><i class="fa fa-link"></i> <span>Search Report</span></a></li>--}}
          {{--</ul>--}}
          {{--</li>--}}
          <li><a href="{{ url('vendor-daily-report2') }}"><i class="fa fa-calendar"></i> <span>Generate Daily Report</span></a></li>
          <li><a href="{{ url('search-terminal') }}"><i class="fa fa-link"></i> <span>Terminal Report</span></a></li>





{{--          <li><a href="{{ url('search-management') }}"><i class="fa fa-link"></i> <span>Search Report</span></a></li>--}}
          <li><a href="{{ url('incidence-status-vendor') }}"><i class="fa fa-laptop"></i> <span> CE Call Management</span></a></li>

          <li><a href="{{ route('engineer-management.index') }}"><i class="fa fa-calendar"></i> <span>CE Management</span></a></li>

          {{--<li><a href="{{ url('sla-report-management') }}"><i class="fa fa-laptop"></i> <span>Generate SLA Report</span></a></li>
		   <li><a href="{{ route('partreplace-management.index') }}"><i class="fa fa-link"></i> <span>Cash & Charge</span></a></li>

		   <li><a href="{{ url('vendor-daily-report2') }}"><i class="fa fa-calendar"></i> <span>View Daily Report</span></a></li>
		    <li><a href="{{ url('sla-management') }}"><i class="fa fa-laptop"></i> <span>Set SLA Rules</span></a></li>--}}
          <li><a href="{{ url('sla-report-management') }}"><i class="fa fa-laptop"></i> <span>Generate SLA Report</span></a></li>
          <li><a href="{{ url('pmcert') }}"><i class="fa fa-laptop"></i> <span> PM Certificate</span></a></li>
{{--          <li><a href="{{ route('pm-management.index') }}"><i class="fa fa-link"></i> <span>Preventive Maintenance </span></a></li>--}}
{{--          <li><a href="{{ route('user-management.index') }}"><i class="fa fa-calendar"></i> <span>User Management</span></a></li>--}}

<li class="treeview">
            <a href="#"><i class="fa fa-link"></i> <span>System Management</span>
              <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ route('vendor-management.index') }}"><i class="fa fa-link"></i> <span>Vendor Management</span></a></li>
              <li><a href="{{ route('vendordata-management.index') }}"><i class="fa fa-link"></i> <span>Vendor Statff Data</span></a></li>
              <li><a href="{{ route('requester-management.index') }}"><i class="fa fa-link"></i> <span>Requester Management</span></a></li>
              <li><a href="{{ url('uploadATM') }}"><i class="fa fa-laptop"></i> <span> Upload ATM</span></a></li>
              <li><a href="{{ url('uploadCall') }}"><i class="fa fa-laptop"></i> <span> Upload Incidence</span></a></li>
              <li><a href="{{ url('pmcert') }}"><i class="fa fa-laptop"></i> <span> PM Certificate</span></a></li>
            </ul>
          </li>

        @endif




        @if (Auth::user()->usertype =='2')

        	   <li><a href="{{ url('employee-management') }}"><i class="fa fa-link"></i> <span>Employee Management</span></a></li>
        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>System Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('brand-management.index') }}"><i class="fa fa-link"></i> <span>Brand Management</span></a></li>
            <li><a href="{{ url('system-management/department') }}">Department</a></li>
            <li><a href="{{ url('system-management/division') }}">Division</a></li>
            <li><a href="{{ url('system-management/country') }}">Country</a></li>
            <li><a href="{{ url('system-management/state') }}">State</a></li>
            <li><a href="{{ url('system-management/city') }}">City</a></li>
            <li><a href="{{ url('system-management/report') }}">Report</a></li>
          </ul>
        </li>
        <li><a href="{{ route('user-management.index') }}"><i class="fa fa-link"></i> <span>User Management</span></a></li>
      {{--   <li><a href="{{ route('supplier-management.index') }}"><i class="fa fa-link"></i> <span>Supplier Management</span></a></li>
        <li><a href="{{ route('category-management.index') }}"><i class="fa fa-link"></i> <span>Category Management</span></a></li>
		  <li><a href="{{ route('shop-management') }}"><i class="fa fa-link"></i> <span>Shopping</span></a></li>--}}
        <li><a href="{{ route('brand-management.index') }}"><i class="fa fa-link"></i> <span>Brand Management</span></a></li>
        <li><a href="{{ route('product-management.index') }}"><i class="fa fa-link"></i> <span>Product Management</span></a></li>
        <li><a href="{{ route('stock-management.index') }}"><i class="fa fa-link"></i> <span>Stock Management</span></a></li>
        <li><a href="{{ route('sale-management.index') }}"><i class="fa fa-link"></i> <span>Sale Management</span></a></li>
     
<li><a href="{{ url('shop-management') }}"><i class="fa fa-link"></i> <span>Shop Management</span></a></li>

		
		@endif
		
		
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
