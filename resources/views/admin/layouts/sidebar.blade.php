<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="side-header">
        <a class="header-brand1" href="index.html">
            <img src="{{ asset('admin/assets/images/brand/logo.png') }}" class="header-brand-img desktop-logo" alt="logo">
            <img src="{{ asset('admin/assets/images/brand/logo-1.png') }}" class="header-brand-img toggle-logo" alt="logo">
            <img src="{{ asset('admin/assets/images/brand/logo-2.png') }}" class="header-brand-img light-logo" alt="logo">
            <img src="{{ asset('admin/assets/images/brand/logo-3.png') }}" class="header-brand-img light-logo1" alt="logo">
        </a><!-- LOGO -->
        <a aria-label="Hide Sidebar" class="app-sidebar__toggle ml-auto" data-toggle="sidebar" href="#"></a><!-- sidebar-toggle-->
    </div>
    <div class="app-sidebar__user">
        <div class="dropdown user-pro-body text-center">
            <div class="user-pic">
                <img src="{{ asset(''.auth()->user()->profile_image) }}" alt="user-img" class="avatar-xl rounded-circle">
            </div>
            <div class="user-info">
                <h6 class=" mb-0 text-dark">{{auth()->user()->name}}</h6>
                <span class="text-muted app-sidebar__user-name text-sm">{{auth()->user()->getRoleNames()}}</span>
            </div>
        </div>
    </div>
    <div class="sidebar-navs">
        <ul class="nav  nav-pills-circle">
            <li class="nav-item" data-toggle="tooltip" data-placement="top" title="Settings">
                <a class="nav-link text-center m-2" href="{{ route('setting') }}">
                    <i class="fe fe-settings"></i>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="top" title="Chat">
                <a class="nav-link text-center m-2">
                    <i class="fe fe-mail"></i>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="top" title="Profile">
                <a class="nav-link text-center m-2"  href="{{ route('setting') }}">
                    <i class="fe fe-user"></i>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="top" title="Logout">
                <a class="nav-link text-center m-2" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    <i class="fe fe-power"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
    <ul class="side-menu">
        <li>
            <a class="side-menu__item" href="{{ route('dashboard') }}"><i class="side-menu__icon ti-home"></i><span class="side-menu__label">Dashboard</span></a>
        </li>

    @can('User Master')
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon ti-user"></i><span class="side-menu__label">Users</span><i class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
            @can('User List')
                <li>
                    <a href="{{ route('user-list') }}" class="slide-item">Users List<a>
                </li>
            @endcan
            @can('User Create')
                <li>
                    <a href="{{ route('user-create') }}" class="slide-item">Create User<a>
                </li>
            @endcan
            @can('User List')
                <li>
                    <a href="{{ route('roles-list') }}" class="slide-item">Roles List<a>
                </li>
            @endcan
            @can('User Create')
                <li>
                    <a href="{{ route('roles-create') }}" class="slide-item">Roles Create<a>
                </li>
            @endcan
            </ul>
        </li>
    @endcan
	
	
	<li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon ti-user"></i><span class="side-menu__label">Post</span><i class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
                <li>
                    <a href="{{ route('post-list') }}" class="slide-item">Post List<a>
                </li>
                <li>
                    <a href="{{ route('post-create') }}" class="slide-item">Create Post<a>
                </li>
            </ul>
        </li>
		
		

    </ul>
    
</aside>