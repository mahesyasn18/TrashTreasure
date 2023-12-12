<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/" class="nav-link">Home</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        @if (Route::has('login'))
            @auth
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <img
                        src="{{ Auth::user()->image->url ? asset('storage/' . Auth::user()->image->url) : asset('img/default.png') }}"
                        class="user-image img-circle elevation-2"
                        alt="User Images">
                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- User image -->
                        <li class="user-header bg-primary">
                            <img
                            src="{{ Auth::user()->image->url ? asset('storage/' . Auth::user()->image->url) : asset('img/default.png') }}"
                            class="img-circle elevation-2"
                            alt="User Imagess">
                            <p>
                                {{ Auth::user()->name }}
                                <small>Bergabung pada @DateIndo(Auth::user()->created_at)</small>
                            </p>
                        </li>
    
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <a href="{{ route('profile') }}" class="btn btn-default btn-flat">Profile</a>
                                <a
                                    class="btn btn-default btn-flat float-right"
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
    
                                    <form
                                        id="logout-form"
                                        action="{{ route('logout') }}"
                                        method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                    <i class="ni ni-user-run"></i>
                                    <span>Logout</span>
                                </a>
                                {{-- <a href="#" class="btn btn-default btn-flat float-right">Sign out</a> --}}
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                            <i class="fas fa-expand-arrows-alt"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            data-widget="control-sidebar"
                            data-slide="true"
                            href="#"
                            role="button">
                            <i class="fas fa-th-large"></i>
                        </a>
                    </li>

                @else
                <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                @endif
            @endauth
    @endif
        
            </ul>
        </nav>
        <!-- /.navbar -->
