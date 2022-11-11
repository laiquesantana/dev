<!DOCTYPE html>
<html lang="pt-br" class="notranslate" translate="no">

<head>
    <meta charset="UTF-8">
    <meta name="google" content="notranslate">
    <meta http-equiv="Content-Language" content="pt-br">

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Test Dev</title>
  <link rel="stylesheet" href="css/app.css">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper" id="app">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #001f3f">
      <!-- Brand Logo -->

      <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">

          <div class="info">
            <a href="#" class="d-block">{{ Auth::user()->name }}<span></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">


            <li class="nav-item">
              <router-link :to="{ name: 'profile' }" class=" nav-link">
                <i class="nav-icon fas fa-user orange"></i>
                <p>
                  Perfil
                </p>
              </router-link>
            </li>
            <!-- /.profile -->

            <li class="nav-item">
              <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                <i class="nav-icon fas fa-power-off red"></i>
                <p>
                  {{ __('Sair') }}
                </p>
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <router-view></router-view>

          <vue-progress-bar></vue-progress-bar>
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="float-right d-none d-sm-inline">
      </div>
      <!-- Default to the left -->
      <strong>Copyright &copy; {{date('Y')}} </strong> All rights reserved.
    </footer>
  </div>
  <!-- ./wrapper -->
  @auth

    <script>
        window.user =  @json(
        [
            'user'=>  auth()->user(),
            'roles' => auth()->user()->getRoleNames(),
            'permissions'=> auth()->user()->getAllPermissions()->pluck('name')
        ])
    </script>
  @endauth

  <script src="/js/app.js"></script>
</body>

</html>
