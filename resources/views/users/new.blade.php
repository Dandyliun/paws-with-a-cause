@extends('layouts.dashboard')

@section('content')

	<header>
		<div class="color-section uk-flex uk-flex-middle" uk-grid>
			<div class="uk-width-expand uk-padding-remove">
				<h1>Create New User</h1>
			</div>
			<div class="uk-width-auto">
				<!-- <a class="uk-button white" onclick="">Delete User</a> -->
			</div>
		</div>
	</header>

	<form class="uk-form-stacked padded" uk-grid>
		<div class="uk-width-1-1 uk-position-relative line-strike first">
			<span>User Information</span>
		</div>

		<div class="uk-width-1-2@m" data-validate required>
			<label class="uk-form-label">First Name:</label>
			<input class="uk-input" id="first_name" name="first_name" type="text" data-error="First name is required">
		</div>
		<div class="uk-width-1-2@m" data-validate required>
			<label class="uk-form-label">Last Name:</label>
			<input class="uk-input" id="last_name" name="last_name" type="text" data-error="Last name is required">
		</div>

		<div class="uk-width-1-2@m" data-validate required>
			<label class="uk-form-label">Email:</label>
			<input class="uk-input" id="email" name="email" type="text" data-error="Email is required">
		</div>
		<div class="uk-width-1-2@m" data-validate required>
			<label class="uk-form-label">Role:</label>
			<select class="uk-select" id="role" name="role" data-error="Role is required">
				<option selected disabled>Please select an option...</option>
				<option>User</option>
				<option>Admin</option>
			</select>
		</div>

		<div class="uk-width-1-1 uk-position-relative line-strike">
			<span>Set Password</span>
		</div>

		<div class="uk-width-1-2@m" data-validate required>
			<label class="uk-form-label">New Password:</label>
			<p class="uk-text-small uk-text-meta label-text">Password must be at least 6 characters</p>
			<input class="uk-input" id="password" name="password" type="password" autocomplete="off">
			<div class="password-meta" uk-grid>
				<div class="uk-width-expand">
					<p class="uk-text-meta text">Password Strength<span class="strength-text"></span></p>
					<div class="strength-lines">
					  	<div class="line"></div>
					  	<div class="line"></div>
						<div class="line"></div>
					</div>
				</div>
				<div class="uk-width-auto">
					<label class="uk-text-meta text">Show Password</label>
					<input class="uk-checkbox" id="show_password" type="checkbox" name="show_password">
				</div>
			</div>
		</div>
		<div class="uk-width-1-2@m" data-validate required>
			<label class="uk-form-label">Confirm New Password:</label>
			<p class="uk-text-small uk-text-meta label-text">&nbsp;</p>
			<input class="uk-input" id="confirmed_password" name="confirmed_password" type="password" autocomplete="off">
		</div>

		<div class="uk-width-1-1 uk-text-right">
			<a id="create-user" class="uk-button uk-button-primary" >Create New User</a>
		</div>
	</form>


@endsection


@section('scripts')

<script type="text/javascript">

	$(document).ready(function() {

		// Initalize the password strength indicator
		passwordStrength('#password');

		// Save the dog to the database
		$('#create-user').click(function() {

	        var errors = formValidation('div[data-validate] input, div[data-validate] select');
	        
	        // Check if errors object is empty
	        if(Object.keys(errors).length === 0 && errors.constructor === Object) { 

	            $.ajax({
	                headers: {
	                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                },
	                type: 'POST',
	                url: '/create-user',
	                data: {
	                	'user_id' : $('input[name="user_id"]').val(),
	                    'first_name' : $('input[name="first_name"]').val(),
	                    'last_name'     : $('input[name="last_name"]').val(),
	                    'email' : $('input[name="email"]').val(),
	                    'role' : $('select[name="role"]').val(),
	                    'password' : $('input[name="password"]').val(),
	                    'confirmed_password' : $('input[name="confirm-password"]').val()
	                },
	                success:function(data){
	                    console.log('success ');
	                    // UIkit.modal('#success-modal').show();
	                    // animateCheckmark();
	                },
	                error:function(data){
	                    console.log('error' + data);

	                }
	            });

	        } else {
	            showFormErrors(errors); 
	        }    

	    });


	});


</script>

@endsection

