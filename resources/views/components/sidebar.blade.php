<aside class="app-sidebar d-print-none sticky" id="sidebar">
    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="/" class="header-logo">
            <img src="{{ asset('assets/images/logo-large-nobg.png') }}" alt="logo" class="desktop-dark">
            <img src="{{ asset('assets/images/logo-small-nobg.png') }}" alt="logo" class="toggle-dark">
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">
        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu">
                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Menu principal</span></li>
                <!-- End::slide__category -->

                <!-- Start::slide -->

                <li class="slide has-sub"> 
                    <a href="javascript:void(0);" class="side-menu__item {{ Route::is('home') ? 'active' : '' }}"> 
                        <i class="bx bx-home side-menu__icon"></i> 
                        <span class="side-menu__label">Tableaux de bord</span> <i class="fe fe-chevron-right side-menu__angle"></i> 
                    </a>
                    <ul class="slide-menu child1" style="position: relative; left: 0px; top: 0px; margin: 0px; transform: translate3d(119.2px, 122.4px, 0px); display: none; box-sizing: border-box;" data-popper-placement="bottom">
                        <!-- <li class="slide side-menu__label1"> <a href="javascript:void(0)">Error</a> </li> -->
                        <li class="slide"> <a href="{{url('/')}}" class="side-menu__item">Vue d'ensemble</a> </li>
                        <li class="slide"> <a href="#" class="side-menu__item">Rapport des activités</a> </li>
                    </ul>
                </li>

                <li class="slide">
                    <a href="{{ url("/agents.page") }}" class="side-menu__item {{ Route::is('agents.page') ? 'active' : '' }}"> <i class="bx bx-group side-menu__icon"></i> 
                        <span class="side-menu__label">Gestion des agents</span> 
                    </a>
                </li>
                <!-- End::slide -->
                <li class="slide">
                    <a href="#" class="side-menu__item"> <i class="bx bx-calendar-check side-menu__icon"></i> 
                        <span class="side-menu__label">Gestion des activités</span> 
                    </a>
                </li>

                <li class="slide">
                    <a href="#" class="side-menu__item"> <i class="bx bx-check-circle side-menu__icon"></i> 
                        <span class="side-menu__label">Gestion des tâches</span> 
                    </a>
                </li>

                

                <!-- Start::slide__category -->
                 @if (Auth::user()->role=="admin")
                 <li class="slide__category"><span class="category-name">Manager</span></li>
                 @endif
                <!-- End::slide__category -->
                <!-- Start::slide -->
                @if (Auth::user()->role=="admin")
                <li class="slide">
                    <a href="{{route('users')}}" class="side-menu__item {{  Route::is('users') ? 'active' : '' }}">
                        <i class="bx bxs-user-circle side-menu__icon"></i>
                        <span class="side-menu__label">Gestion utilisateurs</span>
                    </a>
                </li>
                @endif
                <!-- End::slide -->
            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg></div>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>