@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    $subjects = DB::table('subjects')->get();
    $exams = DB::table('exams')->get();
@endphp
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{route('index')}}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{asset('images/logo.jpg')}}" alt="" height="50">
            </span>
            <span class="logo-lg">
                <img src="{{asset('images/logo.jpg')}}" alt="" height="50">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{route('index')}}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{asset('images/logo.jpg')}}" alt="" height="50">
            </span>
            <span class="logo-lg">
                <img src="{{asset('images/logo.jpg')}}" alt="" height="50">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>
    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                @if(Auth::user())
                <li class="nav-item d-none">
                    <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
                        <i class="ri-account-circle-line"></i> <span data-key="t-authentication">Sign in</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAuth">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('getLogin') }}" class="nav-link">Đăng nhập
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('getRegister') }}" class="nav-link">Đăng ký
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
                        <i class="ri-account-circle-line"></i> <span data-key="t-authentication">Thông tin</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAuth">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('users.profile',['user_uuid' => Auth::user()->uuid]) }}" class="nav-link">Thông tin cá nhân
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('users.transcript',['user_uuid' => Auth::user()->uuid]) }}" class="nav-link">Bảng điểm
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('users.getChangePassword',['uuid' => Auth::user()->uuid]) }}" class="nav-link">Đổi mật khẩu
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @else

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
                        <i class="ri-account-circle-line"></i> <span data-key="t-authentication">Đăng nhập</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAuth">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('getLogin') }}" class="nav-link">Đăng nhập
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('getRegister') }}" class="nav-link">Đăng ký
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarPages" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPages">
                        <i class="ri-pages-line"></i> <span data-key="t-pages">Môn thi</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarPages">
                        <ul class="nav nav-sm flex-column">
                            @foreach($subjects as $subject)
                            @if(Auth::user() && Auth::user()->level == 1)
                            <li class="nav-item">
                                <a href="{{ route('admin.exams.index',['subject_id' => $subject->id])}}" class="nav-link" data-key="t-starter"> {{ $subject->name }} </a>
                            </li>
                            @else
                            <li class="nav-item">
                                <a href="{{ route('users.subjects',['subject_id' => $subject->id]) }}" class="nav-link" data-key="t-starter"> {{ $subject->name }} </a>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                </li>
                @if(Auth::user())
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('logout')}}" role="button" aria-expanded="false" aria-controls="sidebarPages">
                        <i data-feather="log-out"></i> <span data-key="t-pages">Đăng xuất</span>
                    </a>
                </li>
                @endif
                @if(Auth::user() && Auth::user()->level == 1)
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.contact') }}" role="button" aria-expanded="false" aria-controls="sidebarPages">
                        <i data-feather="info"></i> <span data-key="t-pages">Góp ý</span>
                    </a>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('infomation') }}" role="button" aria-expanded="false" aria-controls="sidebarPages">
                        <i data-feather="info"></i> <span data-key="t-pages">Góp ý</span>
                    </a>
                </li>
                @endif

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>