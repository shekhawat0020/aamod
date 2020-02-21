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
	
	@can('Borrower Master')
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon ti-user"></i><span class="side-menu__label">Borrower</span><i class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
            @can('Borrower List')
                <li>
                    <a href="{{ route('borrower-list') }}" class="slide-item">Borrower List<a>
                </li>
            @endcan
            @can('Borrower Create')
                <li>
                    <a href="{{ route('borrower-create') }}" class="slide-item">Create Borrower<a>
                </li>
            @endcan
            </ul>
        </li>
    @endcan
	
	@can('Loan Type Master')
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon ti-user"></i><span class="side-menu__label">Loan Type</span><i class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
            @can('Loan Type List')
                <li>
                    <a href="{{ route('loan-type-list') }}" class="slide-item">Loan Type List<a>
                </li>
            @endcan
            @can('Loan Type Create')
                <li>
                    <a href="{{ route('loan-type-create') }}" class="slide-item">Create Loan Type<a>
                </li>
            @endcan
			
			@can('Loan Field List')
                <li>
                    <a href="{{ route('loan-field-list') }}" class="slide-item">Loan Field List<a>
                </li>
            @endcan
            @can('Loan Field Create')
                <li>
                    <a href="{{ route('loan-field-create') }}" class="slide-item">Create Field Type<a>
                </li>
            @endcan
            </ul>
        </li>
    @endcan
	
	@can('Loan Status Master')
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon ti-user"></i><span class="side-menu__label">Loan Status</span><i class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
            @can('Loan Status List')
                <li>
                    <a href="{{ route('loan-status-list') }}" class="slide-item">Loan Status List<a>
                </li>
            @endcan
            @can('Loan Status Create')
                <li>
                    <a href="{{ route('loan-status-create') }}" class="slide-item">Create Loan Status<a>
                </li>
            @endcan
            </ul>
        </li>
    @endcan
	
	@can('Document Master')
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon ti-user"></i><span class="side-menu__label">Document</span><i class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
            @can('Document Field List')
                <li>
                    <a href="{{ route('document-field-list') }}" class="slide-item">Document Field List<a>
                </li>
            @endcan
            @can('Document Field Create')
                <li>
                    <a href="{{ route('document-field-create') }}" class="slide-item">Document Field Create<a>
                </li>
            @endcan
			@can('Document Group List')
                <li>
                    <a href="{{ route('document-group-list') }}" class="slide-item">Document Group List<a>
                </li>
            @endcan
            @can('Document Group Create')
                <li>
                    <a href="{{ route('document-group-create') }}" class="slide-item">Document Group Create<a>
                </li>
            @endcan
			@can('Document Set List')
                <li>
                    <a href="{{ route('document-set-list') }}" class="slide-item">Document Set List<a>
                </li>
            @endcan
            @can('Document Set Create')
                <li>
                    <a href="{{ route('document-set-create') }}" class="slide-item">Document Set Create<a>
                </li>
            @endcan
            </ul>
        </li>
    @endcan
	
	@can('Loan Master')
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon ti-user"></i><span class="side-menu__label">Loan</span><i class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
            @can('Loan List')
                <li>
                    <a href="{{ route('loan-list') }}" class="slide-item">Loan List<a>
                </li>
            @endcan
            </ul>
        </li>
    @endcan
	
		
		

    </ul>
    
</aside>