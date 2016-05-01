<nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    TEACHTECH
                </a>
            </div>

            <div class="collapse navbar-collapse navbar-right scroll-me" id="app-navbar-collapse">


            <div class="nav navbar-nav">
                @include('videos.search')
            </div>


                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}">Home</a></li>
                    <li><a href="{{ url('/videos') }}">Videos</a></li>
                    <li><a href="{{ url('/categories') }}">Categories</a></li>
                    <li><a href="#works">WORKS</a></li>
                    <li><a href="#contact">CONTACT</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <img src="{{ Auth::user()->getAvatar() }}" alt="{{ Auth::user()->name }}" class="img-responsive img-thumbnail hidden-xs" style="height: inherit; width: 30px;" />
                                <span class="hidden-sm">{{ Auth::user()->name }} <span class="caret"></span></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                                <li><a href="/profile"><i class=""></i>Profile</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>