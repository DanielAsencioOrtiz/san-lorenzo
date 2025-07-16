<!DOCTYPE html>

<html lang="es" style="height: 100% !important">
<!-- Mirrored from academy.w3itexperts.com/xhtml/login-6.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 02 Apr 2024 03:25:12 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="keywords" content="" />
<meta name="author" content="" />
<meta name="robots" content="" />
<meta name="description" content="" />
<meta name="format-detection" content="telephone=no">
<!-- Favicons Icon -->
<link rel="icon" href="error-404.html" type="image/x-icon" />
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
<!-- Page Title Here -->
<title>San Lorenzo</title>
<!-- Mobile Specific -->
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" type="text/css" href="{{asset('plantilla2/css/bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('plantilla2/css/fontawesome/css/font-awesome.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('plantilla2/plugins/themify/themify-icons.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('plantilla2/css/style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('plantilla2/plugins/scroll/scrollbar.css')}}">
<link class="skin"  rel="stylesheet" type="text/css" href="{{asset('plantilla2/css/skin/skin-2.css')}}">
<link  rel="stylesheet" type="text/css" href="{{asset('plantilla2/css/coming-soon.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('plantilla2/css/switcher.css')}}"/>
<!-- Google fonts -->
<link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900|Open+Sans:300,400,600,700,800|Roboto:100,300,400,500,700,900" rel="stylesheet"> 
<style>
	.site-button:hover{
		background: #CF312A !important;
	}
	.w3-separator{
		background: #CF312A !important;
	}
    .bg-img-fix{
        background-position-x: -200px;
    }
    .logo-prodista{
           width: 230px;
    position: absolute;
    top: 10px;
    left: 10px;
    height: 110px;
    background: white;
    padding: 20px;
    border-radius: 20px;
border: 2px solid #DAA521
    }
</style>
</head>
<body id="bg">
<div class="page-wraper">
    <img src="{{asset('img/logox.png')}}" class="logo-prodista" alt=""/>
    <!-- Content -->
    <div class="blog-page-content full-blog-dark style-1 ">
        <!-- Coming Soon -->
        <div class="bg-img-fix" style="background-image:url({{asset('img/bannerlogin2.jpg')}});">
            <div class="clearfix">
				<div class=" col-md-8 p-a0">
				</div>
				<div class="col-md-4 bg-white z-index2 relative skew-section left-bottom winHeight" style="    align-content: center;">
					<div class="login-form style-2">
						<div class="login-logo p-tb30 text-center">
							<a href="#" ><img src="{{asset('img/logo.png')}}" style="width: 200px" alt=""/></a>
						</div>
						<div class="clearfix"></div>
						<div class="tab-content p-b50">
							<div id="login" class="tab-pane active ">
								<form class="w3-form p-b30" method="POST" action="{{route('login')}}">
									{{ csrf_field() }}
									<h2 class="form-title m-t0">Bienvenido</h2>
									<div class="w3-separator-outer m-b5">
										<div class="w3-separator bg-primary style-liner"></div>
									</div>
									<p>Introduzca su dirección de correo electrónico y su contraseña. </p>
									<div class="form-group">
										<input name="email" required="" class="form-control @error('email') is-invalid @enderror" placeholder="Correo Electrónico" type="email" value="{{ old('email') }}"/>
										@error('email')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
									<div class="form-group">
										<input name="password" required="" class="form-control @error('password') is-invalid @enderror " placeholder="Contraseña" type="password"/>
										@error('password')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
                                    <div class="bg-primary text-center bottom">
                                        <button class="site-button  m-r5 text-center bottom btn-block" style="background-color: #27509B" type="submit">Iniciar Sesión</button>
                                    </div>
									<div class="form-group text-left mt-2" style="margin-top: 20px">
										<a data-toggle="tab" style="color:#C20B19 " href="#forgot-password" class="m-l5"><i class="fa fa-unlock-alt"></i> Recuperar Contraseña</a> 
									</div>

								</form>
							
							</div>
                          
							<div id="forgot-password" class="tab-pane fade " style="margin-bottom: 80px">
								<form class="w3-form ">
									<h3 class="form-title m-t0" >Recuperar Contraseña</h3>
									<div class="w3-separator-outer m-b5">
										<div class="w3-separator bg-primary style-liner"></div>
									</div>
									<p>Ingrese su dirección de correo electrónico a continuación para restablecer su contraseña. </p>
									<div class="form-group">
										<input name="dzName" required="" class="form-control" placeholder="Correo Electrónico" type="text"/>
									</div>
									<div class="form-group text-left"> <a class="site-button outline gray" data-toggle="tab" href="#login">Atrás</a>
										<button class="site-button pull-right" style="background-color: #27509B">Enviar</button>
									</div>
								</form>
							</div>
                            <div class="clearfix text-right mt-5">
                                
                            </div>
						</div>
					</div>
					<div class="bottom-footer text-center text-white">
						<span>Copyright &copy; Prodista {{ date('Y') }}</span>
					</div>	
				</div>
				
			</div>
		</div>
        
        <!-- Full Blog Page Contant -->
    </div>
    <!-- Content END-->
</div>
<!-- JavaScript  files ========================================= -->
<script type="text/javascript" src="{{asset('plantilla2/js/jquery.min.js')}}"></script>
<!-- jquery.min js -->
<script type="text/javascript" src="{{asset('plantilla2/js/bootstrap.min.js')}}"></script>
<!-- bootstrap.min js -->
<script type="text/javascript" src="{{asset('plantilla2/js/jquery.countdown.js')}}"></script>
<!-- jquery countdown -->
<script type="text/javascript" src="{{asset('plantilla2/plugins/scroll/scrollbar.min.js')}}"></script>
<!-- custom fuctions  -->
<script type="text/javascript" src="{{asset('plantilla2/js/coming-soon.js')}}"></script>
<!-- custom fuctions  -->
<script src="{{asset('plantilla2/js/particles.js')}}"></script>
<script src="{{asset('plantilla2/js/particles.app.js')}}"></script>
<script >
jQuery(document).ready(function(){
	jQuery('.winHeight').css('height', $(window).height());
})
</script>

</body>

<!-- Mirrored from academy.w3itexperts.com/xhtml/login-6.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 02 Apr 2024 03:25:13 GMT -->
</html>
