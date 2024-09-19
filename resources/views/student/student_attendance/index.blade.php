<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="https://fonts.gstatic.com/s/i/materialicons/school/v6/24px.svg" type="image/svg+xml">
    <title>SMP 3 Muhammadiyah | Kehadiran Siswa</title>

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

    <!-- Datatables -->
    
    <link href="{{asset('lte/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('lte/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('lte/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('lte/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('lte/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{asset('lte/build/css/custom.css')}}" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href={{route('dashboard.teacher.index')}} class="site_title"><i class="fa fa-server"></i><span> Form Siswa</span></a>
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
                
                
                  <li><a href="{{route('dashboard.student.index')}}"><i class="fa fa-qrcode"></i> Scan Qrcode Kehadiran</a></li>
                  <li><a href="{{route('dashboard.student_attendance.index')}}"><i class="fa fa-list"></i> Kehadiran Siswa</a></li>
                  <li><a href="{{route('dashboard.student_schedule.index')}}"><i class="fa fa-clipboard"></i> Jadwal Pelajaran </a></li>
                  
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
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                    
                    <a class="dropdown-item"  href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
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
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Tabel Kehadiran Siswa</h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  
                </div>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  
                  <div class="x_content">
                      <div class="row">
                          <div class="col-sm-12">
                            <div class="card-box table-responsive">
                  
                              <table id="datatable-buttons" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                  <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Waktu Scan</th>
                                   
                                    
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach($attendances as $key => $attendance)
                                    <tr>
                                      <!-- No: Menggunakan $key + 1 untuk menghasilkan nomor urut -->
                                      <td>{{ $key + 1 }}</td>
                              
                                      <!-- Nama: Mengambil dari relasi users melalui attendance -->
                                      <td>{{ $attendance->user ? $attendance->user->name : 'N/A' }}</td>
                              
                                      <!-- Kelas: Mengambil dari classroom melalui relasi di qrcodes -->
                                      <td>{{ $attendance->qrcode && $attendance->qrcode->classroom ? $attendance->qrcode->classroom->name : 'N/A' }}</td>

                                      <!-- Mata Pelajaran: Mengambil dari course melalui relasi di qrcodes -->
                                      <td>{{ $attendance->qrcode && $attendance->qrcode->course ? $attendance->qrcode->course->name : 'N/A' }}</td>


                              
                                      <!-- Waktu Scan: Mengambil dari kolom scan_at -->
                                      <td>{{ $attendance->scan_at }}</td>
                              
                                      
                                    </tr>
                                  @endforeach
                                </tbody>
                              </table>
                              
                  </div>
                </div>
              </div>
            </div>
                </div>
              </div>
              
                </div>
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
    <!-- iCheck -->
    <script src="{{asset('lte/vendors/iCheck/icheck.min.js')}}"></script>
    <!-- Datatables -->
    <script src="{{asset('lte/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('lte/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('lte/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('lte/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('lte/vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('lte/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('lte/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('lte/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{asset('lte/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{asset('lte/vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('lte/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
    <script src="{{asset('lte/vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
    <script src="{{asset('lte/vendors/jszip/dist/jszip.min.js')}}"></script>
    <script src="{{asset('lte/vendors/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{asset('lte/vendors/pdfmake/build/vfs_fonts.js')}}"></script>
    <!-- Custom Theme Scripts -->
    <script src="{{asset('lte/build/js/custom.min.js')}}"></script>
  </body>
</html>
