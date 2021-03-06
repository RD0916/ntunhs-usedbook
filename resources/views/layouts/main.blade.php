<!DOCTYPE html>
<html>
<head>

<link rel="icon" href="{{ asset('assets/img/favicon.ico') }}">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>北護二手書交易平台</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Fonts -->
<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300,400' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
<!-- CSS dist/libs -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/dist/lib/css/bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/dist/lib/css/font-awesome.min.css') }}">

<!-- CSS App -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themes/flat-blue.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/customer.css') }}">

<!-- JQuery -->
<script type="text/javascript" src="{{ asset('assets/dist/lib/js/jquery.min.js') }}"></script>

<style media="screen">

</style>

</head>
<body class="flat-blue">

<div class="app-container">
    <div class="row content-container">
        <nav id="navbar" class="navbar navbar-default navbar-fixed-top navbar-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-expand-toggle">
                        <i class="fa fa-bars icon"></i>
                    </button>
                    <ol class="breadcrumb navbar-breadcrumb title">
                        <li class="active">{{ $title or "404 Not Found" }}</li>
                    </ol>
                    <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                        <i class="fa fa-th icon"></i>
                    </button>
                </div>

                <ul class="nav navbar-nav navbar-right">
                    <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                        <i class="fa fa-times icon"></i>
                    </button>

                    @if(Auth::check())
                      <li class="dropdown profile">
                        <a role="button" href="{!! route('sell.create') !!} ">
                          <i class="fa fa-cloud-upload"></i>&nbsp; 書籍刊登
                        </a>
                      </li>
                    @endif

                    <li class="dropdown profile">
                        <?php $loginText = (Auth::check()) ? Auth::user()->name : 'Login';
                              $loginIcon = (Auth::check()) ?
                              '<img src="' . asset('assets/img/profile/' . Auth::user()->img) . '" class="img-responsive profile-img-sm profile-img-main" alt="' . Auth::user()->name . '" width="40">' :
                              '<i class="fa fa-sign-in"></i>';
                              $loginLink = (Auth::check()) ? 'href="#" data-toggle="dropdown" aria-expanded="false"' : 'href="' . url('login') . '"';  ?>
                        <a role="button" class="dropdown-toggle" {!! $loginLink !!}>
                          {!! $loginIcon !!}&nbsp; {{ $loginText }}
                          <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu animated fadeInDown">
                            <li class="profile-img">
                                <img src="{{ asset('assets/img/welcome.jpg') }}" class="profile-img">
                            </li>
                            <li>
                                <div class="profile-info">
                                  @if(Auth::check())
                                    <h4 class="username">{{ Auth::user()->name }}</h4>
                                    <p>{{ Auth::user()->department }}</p>
                                    <p>{{ Auth::user()->email }}</p>
                                    <div class="btn-group margin-bottom-2x" role="group">
                                        <a href="{{ action('ProfileController@show', ['id' => Auth::user()->id]) }}" class="btn btn-default"><i class="fa fa-user"></i> Profile</a>
                                        <a href="{{ action('Auth\LoginController@logout') }}" class="btn btn-default"><i class="fa fa-sign-out"></i> Logout</a>
                                    </div>
                                  @endif
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <div id="sidebar" class="side-menu sidebar-inverse">
          <nav class="navbar navbar-default" role="navigation">
            <div class="side-menu-container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="{!! action('SellController@index') !!}">
                        <div class="icon glyphicon glyphicon-book"></div>
                        <div class="title">北護二手書交易平台</div>
                    </a>
                    <button type="button" class="navbar-expand-toggle pull-right visible-xs">
                        <i class="fa fa-times icon"></i>
                    </button>
                </div>

                <!-- search form -->
                {!! Form::open(['action' => 'SellController@index', 'method' => 'get', 'class' => 'sidebar-form']) !!}
                  <div class="input-group">
                    @if(Request::get('department'))
                      {!! Form::hidden('department', Request::get('department')) !!}
                    @endif
                    {!! Form::text('search', Request::get('search'), ['class' => 'form-control', 'placeholder' => 'Search...']) !!}
                    <span class="input-group-btn">
                      <button type="submit" id="search-btn" class="btn btn-flat">
                        <i class="fa fa-search"></i>
                      </button>
                    </span>
                  </div>
                {!! Form::close() !!}
                <!-- /.search form -->

                <ul class="nav navbar-nav">
                    <li class="" id="usedbook-home">
                        <a href="{{ action('SellController@index') }}">
                            <span class="icon fa fa-home"></span>
                            <span class="title">Home</span>
                        </a>
                    </li>
                    <li class="panel panel-default dropdown" id="department">
                        <a data-toggle="collapse" href="#dropdown-element">
                            <span class="icon fa fa-tags"></span>
                            <span class="title">系所</span>
                        </a>
                        <!-- Dropdown level 1 -->
                        <div id="dropdown-element" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav navbar-nav department">
                                </ul>
                            </div>
                        </div>
                    </li>
                  @if(Auth::check())
                    <li class="" id="myBooks">
                        <a href="{!! action('ProfileController@showMyBooks', ['id' => Auth::user()->id]) !!}">
                            <span class="icon fa fa-file-text"></span>
                            <span class="title">我的刊登</span>
                        </a>
                    </li>

                    <li class="" id="myFavorites">
                        <a href="{!! action('ProfileController@showMyFavorites', ['id' => Auth::user()->id]) !!}">
                            <span class="icon fa fa-heart"></span>
                            <span class="title">我的收藏</span>
                        </a>
                    </li>
                  @endif
                  <li class="" id="feedback">
                      <a href="{{ action('FeedbackController@index') }}">
                          <span class="icon fa fa-envelope"></span>
                          <span class="title">意見回饋</span>
                      </a>
                  </li>
                    <!-- Dropdown-->
                </ul>
            </div>
            <!-- /.navbar-collapse -->
          </nav>
        </div>

        <!-- Main Content -->
        <div class="container-fluid">
            <div class="side-body">

              @if(session('message'))
                <div class="row">
                  <div class="col-md-12">
                    <div class="alert alert-success">
                      {{ session('message') }}
                    </div>
                  </div>
                </div>
              @endif

              @yield('content')

            </div>
        </div>
    </div>

    <footer class="app-footer">
        <div class="wrapper">
            <span class="pull-right">1.0 <a href="#"><i class="fa fa-long-arrow-up"></i></a>
            </span> © 2016 Copyright.
        </div>
    </footer>
<div>

<!-- Javascript bootstrap -->
<script type="text/javascript" src="{{ asset('assets/dist/lib/js/bootstrap.min.js') }}"></script>

<!-- Javascript -->
<script type="text/javascript" src="{{ asset('assets/js/app.js') }}"></script>

<script type="text/javascript">

$(function() {
  var department = [
    '護理系所',
    '資訊管理系所',
    '長期照護系所',
    '運動保健系所',
    '嬰幼兒保育系所',
    '健康事業管理系所',
    '語言治療與聽力學系',
    '休閒產業與健康促進系所',
    '生死與健康心理諮商系所'
  ];

  for (var i = 0; i < department.length; i++) {
    $('.department').append('<li><a href="<?= action('SellController@index'); ?>?department=' + (i + 1) + '">' + department[i] + '</a></li>');
  }

  // 隨解析度調整
  var resizeHandler = function() {
    var width = $(window).width();

    $('.navbar .dropdown.profile .dropdown-menu').css('width', (width <= 414) ? width - 116 : '305');
  };
  $(window).resize(resizeHandler);
  resizeHandler();

  // sidebar 亮頁選擇
  @if(isset($active))
    $('#<?= $active; ?>').addClass('active');
  @endif

});

</script>

</body>
</html>
