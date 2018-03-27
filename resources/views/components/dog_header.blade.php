<header class="individual">
	<div class="color-section" uk-grid>
		<div class="uk-width-auto toggle uk-transition-toggle" uk-toggle="target: #profile-image-modal">

	        <div class="uk-inline-clip" tabindex="0">
	            <img class="profile-image" src="@if( Storage::disk('public')->exists('/profile_images/' . $dog->profile_image) ) {{ URL::to('/storage/profile_images/' . $dog->profile_image ) }} @else {{ URL::to('/storage/profile_images/default.png') }} @endif" />
	            <div class="uk-transition-fade uk-position-cover uk-position-small uk-overlay uk-overlay-default uk-flex uk-flex-center uk-flex-middle">
	                <div class="uk-position-center">
	                    <span uk-icon="icon: upload; ratio: 2"></span>
	                </div>
	            </div>
	        </div>
		
			<p class="uk-text-small uk-text-center uk-text-small">Click to upload new image</p>

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
			            <li class="@if(Request::is('dogs/abnormalities/*')) uk-active @endif"><a href="{{ URL::to('/dogs/abnormalities/' . $dog->id) }}">Abnormalities</a></li>
			        </ul>
			    </div>
			</nav>
		</div>
	</div>

	{{-- Start Profile Image Modal --}}
	<div id="profile-image-modal" uk-modal>
	    <div class="uk-modal-dialog uk-modal-body uk-text-center">
	    	<button class="uk-modal-close-default" type="button" uk-close></button>
	        <h2 class="uk-modal-title">Upload New Profile Image</h2>
   	 		<div class="modal-content">

				

				<div class="uk-inline-clip" tabindex="0">
		            <img class="profile-image js-upload" src="@if( Storage::disk('public')->exists('/profile_images/' . $dog->profile_image) ) {{ URL::to('/storage/profile_images/' . $dog->profile_image ) }} @else {{ URL::to('/storage/profile_images/default.png') }} @endif" />
		            <div class="spinner-wrapper uk-position-cover uk-position-small uk-overlay uk-overlay-default uk-flex uk-flex-center uk-flex-middle">
		                <div class="uk-position-center">
		                   	<div uk-spinner></div>
		                </div>
		            </div>
		        </div>

		        <div class="upload-error">
		        	<div class="uk-flex uk-flex-middle uk-grid-collapse" uk-grid>
			        	<div class="uk-width-expand">
			        		<p class="uk-margin-remove"><span class="uk-text-bold">Invalid file type:</span> only .jpg, .jpeg, and .png files are allowed</p>
			        	</div>
			        	<div class="uk-width-auto">
			        		<a class="uk-float-right close" uk-icon="icon: close"></a>
			        	</div>
			        </div>
		        </div>

   	 			<div class="js-upload uk-placeholder uk-text-center uk-text-bold">
				    <span uk-icon="icon: cloud-upload"></span>
				    <span class="uk-text-middle">Upload an image by dropping it here or</span>
				    <div uk-form-custom>
				    	<input id="dog_id" name="dog_id" value="{{ $dog->id }}" hidden>
				        <input id="profile-image" class="profile-image" type="file" multiple name="profile-image">
				        <span class="uk-link">select one</span>
				    </div>
				    <span class="uk-text-middle uk-text-small uk-text-muted">Accepted file extensions: .jpg, .jpeg, and .png</span>
				</div>

				<progress id="js-progressbar" class="uk-progress" value="0" max="100" hidden></progress>


   	 		</div>
	        <p class="uk-text-center">
	            <a class="uk-button uk-button-primary uk-modal-close">Done</a>
	        </p>
	    </div>
	</div>
	{{-- End Profile Image Modal --}}

</header>