@extends('layouts.dashboard')

@section('content')

	<div uk-grid>
		<div class="uk-width-expand">
			<h1>Add New Dog</h1>
		</div>
		<div class="uk-width-auto">
			<a onclick="addNewDog()">Save</a>
		</div>
	</div>

	<form class="uk-form-stacked" uk-grid>
		<div class="uk-width-1-2">
			<label class="uk-form-label">Dog Name:</label>
			<input id="name" class="uk-input" name="name" type="text">
		</div>
		<div class="uk-width-1-2">
			<label class="uk-form-label">Gender:</label>
			<select id="sex" class="uk-select" name="sex">
				<option selected disabled></option>
				<option>Male</option>
				<option>Female</option>
			</select>
		</div>
		<div class="uk-width-1-2">
			<label class="uk-form-label">Breed:</label>
			<select id="breed" class="uk-select" name="breed">
				<option selected disabled></option>
				@foreach($breeds as $breed)
					<option>{{ $breed }}</option>
				@endforeach
			</select>
		</div>
		<div class="uk-width-1-2">
			<label class="uk-form-label">Color:</label>
			<input id="color" class="uk-input" name="color">
		</div>
		<div class="uk-width-1-2">
			<label class="uk-form-label">Date of Birth:</label>
			<input id="dob" class="uk-input" name="dob">
		</div>
		<div class="uk-width-1-2">
			<label class="uk-form-label">Food Type:</label>
			<input id="food" class="uk-input" name="food">
		</div>
		<div class="uk-width-1-2">
			<label class="uk-form-label">Internal ID:</label>
			<input id="internal_id" class="uk-input" name="internal_id">
		</div>
		<div class="uk-width-1-2">
			<label class="uk-form-label">Microchip ID:</label>
			<input id="microchip_id" class="uk-input" name="microchip_id">
		</div>
	</form>

	<!-- 	<a href="#success-modal" onclick="animateCheckmark()" uk-toggle>Open</a> -->

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
	
	function addNewDog() {

		var name = $('input[name="name"]').val();
		var sex = $('select[name="sex"]').val();
		var breed = $('input[name="breed"]').val();
		var color = $('input[name="color"]').val();
		var dob = $('input[name="dob"]').val();
		var food = $('input[name="food"]').val();
		var internal_id = $('input[name="internal_id"]').val();
		var microchip_id = $('input[name="microchip_id"]').val();

		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type: 'POST',
			url: '/post-new-dog',
			data: {
				'name' 	       : name,
				'sex' 	       : sex,
				'breed'	       : breed,
				'color'	       : color,
				'dob'	       : dob,
				'food'	       : food,
				'internal_id'  : internal_id,
				'microchip_id' : microchip_id,
			},
			success:function(){
				console.log('success');
				//UIkit.notification("...", {pos: 'bottom-right', status: 'primary', timeout: 600000});
				UIkit.modal('#success-modal').show();
				animateCheckmark();
			},
			error:function(){
				console.log('error');
			}
		});

	}
</script>

@endsection