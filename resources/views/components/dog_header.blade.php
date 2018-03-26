<header>
	<div class="color-section" uk-grid>
		<div class="uk-width-auto">
			<img class="profile-image" src="{{ URL::to('/storage/default-profile-image.png') }}" />
			<a class="uk-text-small uk-text-center uk-display-block uk-padding-small uk-padding-remove-bottom" href="#">Edit Image</a>
		</div>
		<div class="uk-width-expand">
			<h1>{{ $dog->name }}</h1>

			<ul class="uk-list">
				<li><strong>Dog ID:</strong> {{ $dog->internal_id }}</li>
				<li><strong>Gender:</strong> {{ $dog->sex }}</li>
				<li><strong>Breed:</strong> {{ $dog->breed }}</li>
				<li><strong>Weight:</strong></li>
			</ul>

		</div>
	</div>

	<div class="uk-margin-remove-top" uk-grid>
		<div class="uk-width-1-1 uk-padding-remove-left">
			<nav uk-navbar>
			    <div class="uk-navbar-left">
			        <ul class="uk-navbar-nav">
			            <li class="@if(Request::is('dogs/overview/*')) uk-active @endif"><a href="{{ URL::to('/dogs/overview/' . $dog->id) }}">Overview</a></li>
			            <li class="@if(Request::is('dogs/profile/*')) uk-active @endif"><a href="{{ URL::to('/dogs/profile/' . $dog->id) }}">Profile</a></li>
			            <li class="@if(Request::is('dogs/health/*')) uk-active @endif"><a href="{{ URL::to('/dogs/health/' . $dog->id) }}">Health</a></li>
			            <li class="@if(Request::is('dogs/grooming/*')) uk-active @endif"><a href="{{ URL::to('/dogs/grooming/' . $dog->id) }}">Grooming</a></li>
			            <li class="@if(Request::is('dogs/exercise/*')) uk-active @endif"><a href="{{ URL::to('/dogs/exercise/' . $dog->id) }}">Exercise</a></li>
			            <li><a href="#">Abnormalities</a></li>
			            <li class="@if(Request::is('dogs/abnormalities/*')) uk-active @endif"><a href="{{ URL::to('/dogs/abnormalities/' . $dog->id) }}">Abnormalities</a></li>
			        </ul>
			    </div>
			</nav>
			<!-- <ul uk-tab>
			    <li><a href="{{ URL::to('/dogs/overview/' . $dog->id) }}">Overview</a></li>
			    <li><a href="#">Profile</a></li>
			    <li><a href="#">Health</a></li>
			    <li><a href="#">Grooming</a></li>
			    <li><a href="#">Exercise</a></li>
			    <li><a href="#">Abnormalities</a></li>
			</ul> -->
		</div>
	</div>

</header>