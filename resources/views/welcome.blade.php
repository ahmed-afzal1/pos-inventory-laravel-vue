
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pos | Inventory</title>

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">t

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light" id="topbar" style="display: none" v-show="$route.path=== '/' || $route.path=== '/register' ? false: true ">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" id="leftbar" style="display: none" v-show="$route.path=== '/' || $route.path=== '/register' ? false: true ">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{asset('img/logo.png')}}" alt="Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">INVENTORY</span>
      </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{asset('img/profile.png')}}" class="img-circle elevation-2" alt="User Image">
          </div>
        <div class="info">
          <a href="#" class="d-block" v-html="$user.name()"></a>
        </div>
      </div>


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item" v-if='$user.isAdmin()'>
            <router-link to="/home" class="nav-link $route.path=== '/home' ? active: ''">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link to="/pos" class="nav-link $route.path=== '/employee' ? active: ''">
              <i class="nav-icon fa fa-shopping-cart"></i>
              <p>
                POS
              </p>
            </router-link>
          </li>


          <li class="nav-item">
            <router-link to="/employee" class="nav-link $route.path=== '/employee' ? active: ''">
              <i class="nav-icon fas fa-user-alt"></i>
              <p>
                Employee
              </p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link to="/customer" class="nav-link $route.path=== '/customer' ? active: ''">
              <i class="nav-icon fa fa-users"></i>
              <p>
                Customer
              </p>
            </router-link>
          </li>


          <li class="nav-item">
            <router-link to="/supplier" class="nav-link $route.path=== '/supplier' ? active: ''">
              <i class="nav-icon fa fa-industry"></i>
              <p>
                Supplier
              </p>
            </router-link>
          </li>


          <li class="nav-item">
            <a href="#" class="nav-link $route.path=== '/unit' || $route.path=== '/brand' || $route.path=== '/tax' ? active: ''">
              <i class="nav-icon fa fa-list-alt"></i>
              <p>
                Product
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/product" class="nav-link $route.path=== '/category' ? active: ''">
                  <p>Product List</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/add-product" class="nav-link $route.path=== '/category' ? active: ''">
                  <p>Add Product</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/category" class="nav-link $route.path=== '/category' ? active: ''">
                  <p>Category</p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="/unit" class="nav-link $route.path=== '/unit' ? active: ''">
                  <p>Unit</p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="/brand" class="nav-link $route.path=== '/brand' ? active: ''">
                  <p>Brand</p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="/tax" class="nav-link $route.path=== '/tax' ? active: ''">
                  <p>Tax</p>
                </router-link>
              </li>

            </ul>
          </li>

          <li class="nav-item">
            <router-link to="/expense" class="nav-link $route.path=== '/expense' ? active: ''">
              <i class="nav-icon fas fa-money-check"></i>
              <p>
                Expense
              </p>
            </router-link>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link $route.path=== '/given-salary' || $route.path=== '/salary' ? active: ''">
              <i class="nav-icon fab fa-btc"></i>
              <p>
                Employee Salary
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link :to="{name:'givenSalary'}" class="nav-link $route.path=== '/given-salary' ? active: ''">
                  <p>Pay Salary</p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="/salary" class="nav-link $route.path=== '/salary' ? active: ''">
                  <p>Salary Report</p>
                </router-link>
              </li>
            </ul>
          </li>


          <li class="nav-item">
            <a href="#" class="nav-link $route.path=== '/order' || $route.path=== '/search' ? active: ''">
              <i class="nav-icon fa fa-gift"></i>
              <p>
                Sales List (POS)
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link :to="{name:'order'}" class="nav-link $route.path=== '/order' ? active: ''">
                  <p>Sale Today</p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="/search" class="nav-link $route.path=== '/search' ? active: ''">
                  <p>Search Order</p>
                </router-link>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <router-link to="/stock" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Stock
              </p>
            </router-link>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link $route.path=== '/profit-loss' ? active: ''">
              <i class="nav-icon fa fa-download"></i>
              <p>
                Report
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/profit-loss" class="nav-link $route.path=== '/profit-loss' ? active: ''">
                  <p>Profit/Loss Report</p>
                </router-link>
              </li>

            </ul>
          </li>

          <li class="nav-item">
            <router-link to="/user" class="nav-link $route.path=== '/user' ? active: ''">
              <i class="nav-icon fas fa-user-alt"></i>
              <p>
                User
              </p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link to="/logout" class="nav-link">
              <i class="nav-icon fa fa-power-off"></i>
              <p>
                Logout
              </p>
            </router-link>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <router-view></router-view>
    <vue-progress-bar></vue-progress-bar>


    
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer" id="footer" style="display: none;" v-show="$route.path=== '/' || $route.path=== '/register' ? false: true ">
    <!-- To the right -->
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->


<script src="{{asset('js/app.js')}}"></script>

<script type="text/javascript">
  let token = localStorage.getItem('token');
  if(token != null){
    $("#topbar").css("display","");
    $("#leftbar").css("display","");
    $("#footer").css("display","");
  }
</script>


</body>
</html>
