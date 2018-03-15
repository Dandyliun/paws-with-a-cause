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
			<ul uk-tab>
			    <li class="uk-active"><a href="#">Overview</a></li>
			    <li><a href="#">Profile</a></li>
			    <li><a href="#">Health</a></li>
			    <li><a href="#">Grooming</a></li>
			    <li><a href="#">Exercise</a></li>
			    <li><a href="#">Abnormalities</a></li>
			</ul>
		</div>
	</div>

</header>