
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="{{asset('lte/images/favicon.ico')}}" type="image/ico" />

    <title>SMP 3 Muhammadiyah</title>

    <!-- Bootstrap -->
    <link href="{{asset('lte/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('lte/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{asset('lte/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{asset('lte/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="{{asset('lte/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{asset('lte/vendors/jqvmap/dist/jqvmap.min.css')}}" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="{{asset('lte/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{asset('lte/build/css/custom.css')}}" rel="stylesheet">
  </head>

  <body class="nav-md">
  
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href={{route('dashboard.admin.index')}} class="site_title"><i class="fa fa-server"></i><span> Administrator</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('images/default-image.jpg') }}" alt="Photo User" class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2>{{ $user->name }}</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                
                <ul class="nav side-menu">
                
                
                  <li><a href="{{route('dashboard.admin.index')}}"><i class="fa fa-home"></i> Home</a></li>
                  <li><a><i class="fa fa-table"></i> Kehadiran <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      
                    <li><a href="{{route('dashboard.tables_attend.table_teacher')}}">Guru</a></li>
                      <li><a href="{{route('dashboard.tables_attend.table_student')}}">Siswa</a></li>
                    </ul>
                  </li>
                  <li><a href="{{route('dashboard.attendance.create')}}"><i class="fa fa-plus"></i>Buat Qr Code Kehadiran</a>
                  </li>
                  <li><a href="{{route('dashboard.course.index')}}"><i class="fa fa-list"></i>Daftar Pelajaran</a>
                  </li>
                  <li><a href="{{route('dashboard.classroom.index')}}"><i class="fa fa-list-alt"></i>Daftar Kelas</a>
                  </li>
                  <li><a href="{{route('dashboard.schedule.index')}}"><i class="fa fa-clipboard"></i> Jadwal Pelajaran </a></li>
                  <li><a href="{{route('dashboard.each_schedule.index')}}"><i class="fa fa-clipboard"></i> Jadwal Guru & Siswa </a></li>
                  <li><a><i class="fa fa-credit-card"></i> Daftar Pengguna <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{route('dashboard.admin_list.index')}}">Daftar Admin</a></li>
              
                    </ul>
                  </li>
                  
                  
                </ul>
              </div>



              
              

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
              
              <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" data-toggle="tooltip" data-placement="top" title="Logout">
                  <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              <nav class="nav navbar-nav">
              <ul class=" navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                  <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                    <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('images/default-image.jpg') }}" alt="">{{$user->name}}
                    
                    
                  </a>
                  <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item"  href="javascript:;"> Profile</a>
                      <a class="dropdown-item"  href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                      </a>
                  <a class="dropdown-item"  href="javascript:;">Help</a>
                    <a class="dropdown-item"  href="{{ route('login') }}"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                  </div>
                </li>

                <li role="presentation" class="nav-item dropdown open">
                  
                 
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->
          <div class="row" style="display: inline-block;" >
          <div class="tile_count">
            <div class="col-md-4 col-sm-6  tile_stats_count">
              <span class="count_top"><i class="fa fa-users"></i> Siswa Hadir</span>
              <div class="count">{{ $attendedStudents ?? 0 }}</div>
              
            </div>
            
            <div class="col-md-4 col-sm-6  tile_stats_count">
              <span class="count_top"><i class="fa fa-times"></i> Siswa Absent</span>
              <div class="count">{{ $absentStudents ?? 0 }}</div>
              
            </div>
            <div class="col-md-4 col-sm-6  tile_stats_count">
              <span class="count_top"><i class="fa fa-users"></i> Total Siswa</span>
              <div class="count">{{ $totalStudents ?? 0 }}</div>
              
            </div>

            <div class="col-md-4 col-sm-6  tile_stats_count">
              <span class="count_top"><i class="fa fa-users"></i> Guru Hadir</span>
              <div class="count">{{ $attendedTeachers ?? 0 }}</div>
              
            </div>
            <div class="col-md-4 col-sm-6  tile_stats_count">
              <span class="count_top"><i class="fa fa-times"></i> Guru Absent</span>
              <div class="count">{{ $absentTeachers ?? 0 }}</div>
              
            </div>
            <div class="col-md-4 col-sm-6  tile_stats_count">
              <span class="count_top"><i class="fa fa-users"></i> Total Guru</span>
              <div class="count">{{ $totalTeacher ?? 0 }}</div>
              
            </div>
          </div>
        </div>


        <!-- Grafik -->

        <div class="page-title">
              <div class="title_left">
                <h3>Grafik Kehadiran Siswa &</h3>
                
              </div>
              <div class="title_right">
                <div class="col-md-5 col-sm-5   form-group pull-right top_search"></div>
              </div>
        </div>

          <!-- /top tiles -->
        <div class="row">
          <div class="col-md-12 col-sm-8  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Line graph<small>Sessions</small></h2>
                    <ul class="nav navbar-left panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      
                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <canvas id="lineChart"></canvas>
                  </div>
                </div>
              </div>

        </div>



        
        
        
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            SMP 3 Muhammadiyah
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="{{asset('lte/vendors/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('lte/vendors/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{asset('lte/vendors/fastclick/lib/fastclick.js')}}"></script>
    <!-- NProgress -->
    <script src="{{asset('lte/vendors/nprogress/nprogress.js')}}"></script>
    <!-- Chart.js -->
    <script src="{{asset('lte/vendors/Chart.js/dist/Chart.min.js')}}"></script>
    <!-- gauge.js -->
    <script src="{{asset('lte/vendors/gauge.js/dist/gauge.min.js')}}"></script>
    <!-- bootstrap-progressbar -->
    <script src="{{asset('lte/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
    <!-- iCheck -->
    <script src="{{asset('lte/vendors/iCheck/icheck.min.js')}}"></script>
    <!-- Skycons -->
    <script src="{{asset('lte/vendors/skycons/skycons.js')}}"></script>
    <!-- Flot -->
    <script src="{{asset('lte/vendors/Flot/jquery.flot.js')}}"></script>
    <script src="{{asset('lte/vendors/Flot/jquery.flot.pie.js')}}"></script>
    <script src="{{asset('lte/vendors/Flot/jquery.flot.time.js')}}"></script>
    <script src="{{asset('lte/vendors/Flot/jquery.flot.stack.js')}}"></script>
    <script src="{{asset('lte/vendors/Flot/jquery.flot.resize.js')}}"></script>
    <!-- Flot plugins -->
    <script src="{{asset('lte/vendors/flot.orderbars/js/jquery.flot.orderBars.js')}}"></script>
    <script src="{{asset('lte/vendors/flot-spline/js/jquery.flot.spline.min.js')}}"></script>
    <script src="{{asset('lte/vendors/flot.curvedlines/curvedLines.js')}}"></script>
    <!-- DateJS -->
    <script src="{{asset('lte/vendors/DateJS/build/date.js')}}"></script>
    <!-- JQVMap -->
    <script src="{{asset('lte/vendors/jqvmap/dist/jquery.vmap.js')}}"></script>
    <script src="{{asset('lte/vendors/jqvmap/dist/maps/jquery.vmap.world.js')}}"></script>
    <script src="{{asset('lte/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js')}}"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="{{asset('lte/vendors/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('lte/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{asset('lte/build/js/custom.min.js')}}"></script>
    
  </body>

</html>
