@extends('layouts.dashboard')

@section('content')
	
	<div id="profile" class="individual-dog">
		
		@component('components.dog_header', ['dog' => $dog])
    	@endcomponent

    	<div class="uk-padding uk-padding-remove-horizontal uk-padding-remove-bottom uk-flex uk-flex-middle" uk-grid>
    		<div class="uk-width-expand">
				<h1 class="title">Profile</h1>
			</div>
			<div class="uk-width-auto">
				<a class="uk-button uk-button-primary" onclick="saveProfile()">Save</a>
			</div>
		</div>

		{{-- $dog --}}

		<form uk-grid>
			{{-- Pass the dog ID via hidden input --}}
			<input value="{{ $dog->id }}" id="dog_id" name="dog_id" hidden>

			{{-- Name --}}
			<div class="uk-width-1-2@m">
				<label class="uk-form-label">Name:</label>
				<input class="uk-input" id="name" name="name" value="{{ $dog->name }}" />
			</div>
			{{-- Gender --}}
			<div class="uk-width-1-2@m">
				<label class="uk-form-label">Gender:</label>
				<select id="gender" class="uk-select" name="gender">
					<option selected disabled>Please select an option...</option>
					<option @if(strtolower($dog->sex) == 'male') selected @endif>Male</option>
					<option @if(strtolower($dog->sex) == 'female') selected @endif>Female</option>
				</select>
			</div>
			{{-- Breed --}}
			<div class="uk-width-1-2@m">
				<label class="uk-form-label">Breed:</label>
				<select id="breed" class="uk-select" name="breed">
					<option selected disabled>Please select an option...</option>
					@foreach($breeds as $breed)
						<option @if( strtolower($breed) == strtolower($dog->breed)) selected @endif>{{ $breed }}</option>
					@endforeach
				</select>
			</div>
			{{-- Color --}}
			<div class="uk-width-1-2@m">
				<label class="uk-form-label">Color:</label>
				<select id="color" class="uk-select" name="color">
					<option selected disabled>Please select an option...</option>
					@foreach($colors as $color)
						<option @if( strtolower($color) == strtolower($dog->color)) selected @endif>{{ $color }}</option>
					@endforeach
				</select>
			</div>
			{{-- Date of Birth --}}
			<div class="uk-width-1-2@m">
				<label class="uk-form-label">Date of Birth:</label>
				<input id="dob" class="uk-input" name="dob" value="{{ $dog->dob }}" />
			</div>
			{{-- Food Type --}}
			<div class="uk-width-1-2@m">
				<label class="uk-form-label">Food Type:</label>
				<input id="food" class="uk-input" name="food" value="{{ $dog->food_type }}" />
			</div>
			{{-- Internal ID --}}
			<div class="uk-width-1-2@m">
				<label class="uk-form-label">Internal ID:</label>
				<input id="internal_id" class="uk-input" name="internal_id" value="{{ $dog->internal_id }}" />
			</div>
			{{-- Microchip ID --}}
			<div class="uk-width-1-2@m">
				<label class="uk-form-label">Microchip ID:</label>
				<input id="microchip_id" class="uk-input" name="microchip_id" value="{{ $dog->microchip_id }}" />
			</div>
		</form>


	</div>

@endsection

@section('scripts')
	<script>
		// Initialize the date picker
  		dateSelect('#dob');
  	</script>

	<script type="text/javascript">
		
		function saveProfile() {
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type:'POST',
				url:'/save-profile',
				data: {
					'id'     :  $('input[name="dog_id"]').val(),
					'name'   :  $('input[name="name"]').val(),
					'gender' :  $('select[name="gender"]').val(),
					'breed'  :  $('select[name="breed"]').val(),
					'color'  :  $('select[name="color"]').val(),
					'dob'    :  $('input[name="dob"]').val(),
					'food'   :  $('input[name="food"]').val(),
					'internal_id'  :  $('input[name="internal_id"]').val(),
					'microchip_id'  :  $('input[name="microchip_id"]').val(),
				},
				success:function(data){
					console.log('success ' + data);
				},
				error:function(data){
					console.log('error');
				}
			});
		}


	</script>
@endsection