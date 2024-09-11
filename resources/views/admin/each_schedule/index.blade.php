<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Gentelella Alela! | </title>

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
    <link href="{{asset('lte/build/css/custom.min.css')}}" rel="stylesheet">
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
                      <li><a href="{{route('dashboard.teacher_list.index')}}">Daftar Guru</a></li>
                      {{-- <li><a href="{{route('dashboard.student_list.index')}}">Daftar Siswa</a></li> --}}
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
                <h3>Tabel Daftar Jadwal Untuk Guru/Siswa</h3>
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
                              <form action="{{ route('dashboard.each_schedule.create') }}" method="GET" style="display:inline;">
                                <button type="submit" class="btn btn-success btn-sm" style="margin-left: 10px; padding: 10px 20px;">
                                    Create
                                </button>
                            </form>                            
                            
                              <table id="datatable-buttons" class="table table-striped table-bordered" style="width:100%">
                                
                                <thead>
                                  
                                  <tr>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Nama Pelajaran</th>
                                    <th>Nama Kelas</th>
                                    <th>Tanggal</th> 
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Aksi</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach($schedules as $key => $schedule)
                                    <tr>
                                      <!-- No: Menggunakan $key + 1 untuk menghasilkan nomor urut -->
                                        <td>{{ $key + 1 }}</td>
                                        <!-- Mengambil email dari relasi user -->
                                        <td>{{ $schedule->user->email }}</td>
                                        
                                        <td>{{ $schedule->userSchedule->course->name }}</td>

                                        <td>{{ $schedule->userSchedule->classroom->name }}</td>
                                        <!-- Tanggal: Extract the date from start_time -->
                                        <td>{{ \Carbon\Carbon::parse($schedule->userSchedule->start_time)->locale('id')->translatedFormat('j F Y') }}</td>
                                        
                                        <!-- Jam Mulai: Extract the time from start_time -->
                                        <td>{{ \Carbon\Carbon::parse($schedule->userSchedule->start_time)->format('H:i') }}</td>
                                        
                                        <!-- Jam Selesai: Extract the time from end_time -->
                                        <td>{{ \Carbon\Carbon::parse($schedule->userSchedule->end_time)->format('H:i') }}</td>

                                      <!-- Aksi: Edit button -->
                                      <td style="display: flex; align-items: center;">
                                        <form action="{{ route('dashboard.each_schedule.edit', $schedule->id) }}" method="GET" style="display: inline-block;">
                                          <button type="submit" class="btn btn-primary btn-sm" style="margin-right: 5px;">
                                              Edit
                                          </button>
                                        </form>                                      
                                        
                                        <form action="{{ route('dashboard.each_schedule.delete', $schedule->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this attendance?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Delete
                                            </button>
                                        </form>
                                      </td>
                                    
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
