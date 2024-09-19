<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>SMP 3 Muhammadiyah | Buat Qr Code Presensi</title>

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
    <link href="{{asset('lte/build/css/custom.min.css')}}" rel="stylesheet">
	<!-- bootstrap-wysiwyg -->
	<link href="{{asset('ltevendors/google-code-prettify/bin/prettify.min.css')}}" rel="stylesheet">
	<!-- Select2 -->
	<link href="{{asset('lte/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet">
	<!-- Switchery -->
	<link href="{{asset('lte/vendors/switchery/dist/switchery.min.css')}}" rel="stylesheet">
	<!-- starrr -->
	<link href="{{asset('lte/vendors/starrr/dist/starrr.css')}}" rel="stylesheet">
	

</head>

<body class="nav-md">
  
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Gentelella Alela!</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="{{asset('lte/production/images/img.jpg')}}" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2>John Doe</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                
                <ul class="nav side-menu">
                
                
                  <li><a href="{{route('dashboard.teacher.index')}}"><i class="fa fa-plus"></i> Buat Qr Code Kehadiran</a></li>
                  <li><a href="{{route('dashboard.teacher_scan.scan')}}"><i class="fa fa-plus"></i> Scan Qr</a></li>
                  <li><a href="{{route('dashboard.student_attend.index')}}"><i class="fa fa-list"></i> Kehadiran Siswa</a></li>
            
                  <li><a href="{{route('dashboard.teacher_schedule.index')}}"><i class="fa fa-clipboard"></i> Jadwal Pelajaran </a></li>
                  
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
                    <img src="{{asset('lte/production/images/img.jpg')}}" alt="">John Doe
                  </a>
                  <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item"  href="javascript:;"> Profile</a>
                      <a class="dropdown-item"  href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                      </a>
                  <a class="dropdown-item"  href="javascript:;">Help</a>
                    <a class="dropdown-item"  href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                  </div>
                </li>

                <li role="presentation" class="nav-item dropdown open">
                  
                  <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                    <li class="nav-item">
                      <a class="dropdown-item">
                        <span class="image"><img src="{{asset('production/images/img.jpg')}}" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="dropdown-item">
                        <span class="image"><img src="{{asset('production/images/img.jpg')}}" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="dropdown-item">
                        <span class="image"><img src="{{asset('images/img.jpg')}}" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="dropdown-item">
                        <span class="image"><img src="{{asset('production/images/img.jpg')}}" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        
                      </a>
                    </li>
                    <li class="nav-item">
                      <div class="text-center">
                        <a class="dropdown-item">
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
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
						<h3>Form Elements</h3>
					</div>

					<div class="title_right">
						<div class="col-md-5 col-sm-5  form-group pull-right top_search">
							<div class="input-group">
								<input type="text" class="form-control" placeholder="Search for...">
								<span class="input-group-btn">
									<button class="btn btn-default" type="button">Go!</button>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="row">
					<div class="col-md-12 col-sm-12 ">
						<div class="x_panel">
							<div class="x_title">
								<h2>Form Design <small>different form elements</small></h2>
								<ul class="nav navbar-right panel_toolbox">
									<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
									</li>
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-wrench"></i></a>
										<ul class="dropdown-menu" role="menu">
											<li><a class="dropdown-item" href="#">Settings 1</a>
											</li>
											<li><a class="dropdown-item" href="#">Settings 2</a>
											</li>
										</ul>
									</li>
									<li><a class="close-link"><i class="fa fa-close"></i></a>
									</li>
								</ul>
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
								<br />
              
              @if($errors -> any())
               <ul>
                 @foreach($errors->all() as $error)
                      <li class="py-5 px-5 bg-red-700 text-red>{{ $error }}</li>
                 @endforeach
               </ul>
              @endif              
								
              <form action="{{ route('dashboard.qrcode.store') }}" method="POST">
                @csrf
                  <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="course_id">Nama Pelajaran <span class="required">*</span></label>
                      <div class="col-md-6 col-sm-6 ">
                          <select id="course" name="course_id" required="required" class="form-control">
                              <option value="">Pilih Pelajaran</option>
                              @foreach($courses as $course)
                                  <option value="{{ $course->id }}">{{ $course->name }}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>
              
                  <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="classroom_id">Kelas <span class="required">*</span></label>
                      <div class="col-md-6 col-sm-6 ">
                          <select id="classroom" name="classroom_id" required="required" class="form-control">
                              <option value="">Kelas</option>
                              @foreach($classrooms as $classroom)
                                  <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>
              
                  <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="lesson_time">Waktu Pelajaran <span class="required">*</span></label>
                      <div class="col-md-6 col-sm-6 ">
                          <input type="datetime-local" name="lesson_time" id="lesson_time" class="form-control" required>
                      </div>
                  </div>
                  <div class="ln_solid"></div>
                  <div class="item form-group">
                      <div class="col-md-6 col-sm-6 offset-md-3">
                          <button class="btn btn-primary" type="button">Cancel</button>
                          <button class="btn btn-primary" type="reset">Reset</button>
                          <button type="submit" class="btn btn-success">Submit</button>
                      </div>
                  </div>
              </form>
              
              

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
            SMPN 3 Muhammadiyah
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
	<!-- bootstrap-daterangepicker -->
	<script src="{{asset('lte/vendors/moment/min/moment.min.js')}}"></script>
	<script src="{{asset('lte/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
	<!-- bootstrap-wysiwyg -->
	<script src="{{asset('lte/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js')}}"></script>
	<script src="{{asset('lte/vendors/jquery.hotkeys/jquery.hotkeys.js')}}"></script>
	<script src="{{asset('lte/vendors/google-code-prettify/src/prettify.js')}}"></script>
	<!-- jQuery Tags Input -->
	<script src="{{asset('lte/vendors/jquery.tagsinput/src/jquery.tagsinput.js')}}"></script>
	<!-- Switchery -->
	<script src="{{asset('lte/vendors/switchery/dist/switchery.min.js')}}"></script>
	<!-- Select2 -->
	<script src="{{asset('lte/vendors/select2/dist/js/select2.full.min.js')}}"></script>
	<!-- Parsley -->
	<script src="{{asset('lte/vendors/parsleyjs/dist/parsley.min.js')}}"></script>
	<!-- Autosize -->
	<script src="{{asset('lte/vendors/autosize/dist/autosize.min.js')}}"></script>
	<!-- jQuery autocomplete -->
	<script src="{{asset('lte/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js')}}"></script>
	<!-- starrr -->
	<script src="{{asset('lte/vendors/starrr/dist/starrr.js')}}"></script>
	<!-- Custom Theme Scripts -->
	<script src="{{asset('lte/build/js/custom.min.js')}}"></script>
    <!-- Include the html5-qrcode library -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <!-- Include the QRCode.js library -->
    <script src="https://unpkg.com/qrcode@1.5.1/build/qrcode.min.js"></script>
    <!-- Include the qrcodes.js -->
    <script src="{{asset('js/qrcodes.js')}}"></script>
    
  </body>

</html>
