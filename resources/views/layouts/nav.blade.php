<div class="blog-masthead">
	<div class="container">
		<nav class="navbar navbar-default navbar-static-top">
				<div class="navbar-header">
					<a class="navbar-brand" href="{{ url('/') }}">
						{{ config('app.name', 'Laravel') }}
					</a>
					<!-- Only appears on smaller screens -->
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div> <!-- navbar-header -->

				<div class="collapse navbar-collapse" id="app-navbar-collapse">
					<!-- Left Side Of Navbar -->
					<ul class="nav navbar-nav">
						<!-- Intentionally empty for now -->
					</ul>

					<!-- Right Side Of Navbar -->
					<ul class="nav navbar-nav navbar-right">
						<!-- Authentication Links -->
						@guest
							<li><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
							<li><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
						@else
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="navbarDropdown" role="button" aria-expanded="false">
									{{ Auth::user()->name }}
									<span class="caret"></span>
								</a>

								<ul class="dropdown-menu" role="menu">
									<li>
										<a class="fa fa-btn fa-user" href="{{ route('logout') }}"
										onclick="event.preventDefault();
														document.getElementById('logout-form').submit();">
											{{ __('Logout') }}
										</a>
										<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
											@csrf
										</form>
									</li>
								</ul>
							</li>
						@endguest
					</ul>
				</div>
		</nav>
	</div>
</div>