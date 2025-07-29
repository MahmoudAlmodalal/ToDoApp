<!-- Header -->
<header class="main-header " id="header">
    <nav class="navbar navbar-static-top navbar-expand-lg">
    <!-- Sidebar toggle button -->
        <h3 class="pl-5">ToDo App</h3>

        <div class="navbar-right ">
            <ul class="nav navbar-nav">
                <li class="dropdown notifications-menu custom-dropdown">
                <!-- User Account -->
                <li class="dropdown user-menu">
                    <button href="#" class=" dropdown-toggle nav-link" data-toggle="dropdown">
                      <span id="user" class="d-none d-lg-inline-block">{{Auth::user()->name}}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                      <!-- User image -->
                      <li class="dropdown-header">

                        <div class="d-inline-block">
                          {{Auth::user()->name}} <small class="pt-1">{{Auth::user()->email}}</small>
                        </div>
                      </li>


                      <li>
                        <a href="{{route('tasks.report')}}">
                          <i class="mdi mdi-email"></i>PDF Reports
                        </a>
                      </li>
                         <li>
                        <a href="{{route('tasks.index', -1)}}">
                          <i class="mdi mdi-email"></i>Tasks
                        </a>
                      </li>
                      <li>
                        <a href="{{route('categorys.index')}}">
                          <i class="mdi mdi-email"></i>Category
                        </a>
                      </li>


                      <li class="dropdown-footer">
                        <a href="{{route('logout')}}"> <i class="mdi mdi-logout"></i> Log Out </a>
                      </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
