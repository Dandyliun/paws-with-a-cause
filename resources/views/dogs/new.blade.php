@extends('layouts.dashboard')

@section('content')
	
	<header>
		<div class="color-section uk-flex uk-flex-middle" uk-grid>
			<div class="uk-width-expand uk-padding-remove">
				<h1>Add New Dog</h1>
			</div>
		</div>
	</header>

	<form class="uk-form-stacked padded" uk-grid>
		<div class="uk-width-1-2" data-validate required>
			<label class="uk-form-label">Dog Name:</label>
			<input id="name" class="uk-input" name="name" type="text">
		</div>
		<div class="uk-width-1-2" data-validate required>
			<label class="uk-form-label">Gender:</label>
			<select id="sex" class="uk-select" name="sex" data-type="select">
				<option selected disabled>Please select an option...</option>
				<option>Male</option>
				<option>Female</option>
			</select>
		</div>
		<div class="uk-width-1-2" data-validate required>
			<label class="uk-form-label">Breed:</label>
			<select id="breed" class="uk-select" name="breed" data-type="select">
				<option selected disabled>Please select an option...</option>
				@foreach($breeds as $breed)
					<option>{{ $breed }}</option>
				@endforeach
			</select>
		</div>
		<div class="uk-width-1-2" data-validate required>
			<label class="uk-form-label">Color:</label>
			<select id="color" class="uk-select" name="color" data-type="select">
				<option selected disabled>Please select an option...</option>
				@foreach($colors as $color)
					<option>{{ $color }}</option>
				@endforeach
			</select>
		</div>
		<div class="uk-width-1-2" data-validate required>
			<label class="uk-form-label">Date of Birth:</label>
			<input id="dob" class="uk-input" name="dob">
		</div>
		<div class="uk-width-1-2" data-validate required>
			<label class="uk-form-label">Food Type:</label>
			<input id="food" class="uk-input" name="food">
		</div>
		<div class="uk-width-1-2" data-validate required>
			<label class="uk-form-label">Internal ID:</label>
			<input id="internal_id" class="uk-input" name="internal_id">
		</div>
		<div class="uk-width-1-2" data-validate required>
			<label class="uk-form-label">Microchip ID:</label>
			<input id="microchip_id" class="uk-input" name="microchip_id">
		</div>
		<div class="uk-width-1-1 uk-text-right">
			<a id="add-new-dog" class="uk-button uk-button-primary">Save Dog</a>
		</div>
	</form>

	{{-- Start Success Modal --}}
	<div id="success-modal" uk-modal>
	    <div class="uk-modal-dialog uk-modal-body uk-text-center">
	    	<button class="uk-modal-close-default" type="button" uk-close></button>
	        <h2 class="uk-modal-title">Success!</h2>
	        @component('components.success_check')
   	 		@endcomponent
   	 		<div class="modal-content uk-text-bold">
   	 			<p>What would you like to do next?</p>
   	 		</div>
	        <p class="uk-text-center">
	            <a class="uk-button uk-button-default" href="{{ URL::to('/dogs') }}">Return to All</a>
	            <a class="uk-button uk-button-primary uk-modal-close">Add Another</a>
	        </p>
	    </div>
	</div>
	{{-- End Success Modal --}}

@endsection

@section('scripts')
<script type="text/javascript">

	// Initialize the date picker
  	dateSelect('#dob', true);
	
	$('#add-new-dog').click(function() {

		var name = $('input[name="name"]');
		var sex = $('select[name="sex"]');
		var breed = $('select[name="breed"]');
		var color = $('select[name="color"]');
		var dob = $('input[name="dob"]');
		var food = $('input[name="food"]');
		var internal_id = $('input[name="internal_id"]');
		var microchip_id = $('input[name="microchip_id"]');

		var errors = formValidation('div[data-validate] input, div[data-validate] select');      
        // Check if errors object is empty
        if(Object.keys(errors).length === 0 && errors.constructor === Object) {
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type: 'POST',
				url: '/create-new-dog',
				data: {
					'name' 	       : name.val(),
					'sex' 	       : sex.val(),
					'breed'	       : breed.val(),
					'color'	       : color.val(),
					'dob'	       : dob.val(),
					'food'	       : food.val(),
					'internal_id'  : internal_id.val(),
					'microchip_id' : microchip_id.val(),
				},
				success:function(){
					console.log('success');
					//UIkit.notification("...", {pos: 'bottom-right', status: 'primary', timeout: 600000});
					UIkit.modal('#success-modal').show();
					animateCheckmark();
					// Clear the form to prevent duplication submissions
					name.val('');
					sex.val('');
					breed.val(''); 
					color.val('');
					dob.val('');
					food.val('');
					internal_id.val('');
					microchip_id.val('');
				},
				error:function(){
					console.log('error');
				}
			});
		} else {
			showFormErrors(errors); 
		}

	});
</script>

@endsection