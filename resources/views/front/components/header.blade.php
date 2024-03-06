
<header>
	<nav class="navbar navbar-expand-lg navbar-light bg-white shadow py-3">
		<div class="container">
			<a class="navbar-brand" href="{{ route('home') }}">JobPlus</a>
            
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ms-0 ms-sm-0 me-auto mb-2 mb-lg-0 ms-lg-4">
					<li class="nav-item">
						<a class="nav-link" aria-current="page" href="{{ route('home') }}">Home</a>
					</li>	
					<li class="nav-item">
						<a class="nav-link" aria-current="page" href="{{ route('findJobPage') }}">Find Jobs</a>
					</li>										
				</ul>				
				
				{{-- check user is login or not if then login button change to account --}}
				@if (!Auth::check())
					<a class="btn btn-outline-primary me-2" href="{{ route('login') }}" type="submit">Login</a>
				@else
					@if (Auth::user()->role == 'admin')
					<a class="btn btn-outline-primary me-2" href="{{ route('admin.dashboardPage') }}" type="submit">Admin</a>				
					@endif				
					<a class="btn btn-outline-primary me-2" href="{{ route('profilePage') }}" type="submit">Account</a>
				
				@endif

				<a class="btn btn-primary" href="{{ route('createJobPage') }}" type="submit">Post a Job</a>
			</div>
		</div>
	</nav>
</header>

