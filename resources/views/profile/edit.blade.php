@extends('layouts.dashboard')

@section('content')

	<header>
		<div class="color-section uk-flex uk-flex-middle" uk-grid>
			<div class="uk-width-expand uk-padding-remove">
				<h1>Profile</h1>
			</div>
			<div class="uk-width-auto">
			</div>
		</div>
	</header>

	<br>

	<div class="content-wrapper" uk-grid>
		<div class="uk-width-1-1@m">
			<form class="uk-form-stacked" uk-grid>
				<div class="uk-width-1-1 uk-position-relative line-strike first">
					<span>Update Information</span>
				</div>
				<input id="user_id" name="user_id" value="{{ $user->id }}" hidden>
				<div class="uk-width-1-2@m" data-validate required>
					<label id="first_name" class="uk-form-label">First Name:</label>
					<input class="uk-input" id="first_name" name="first_name" type="text" value="{{ $user->first_name }}" data-error="First name is required">
				</div>
				<div class="uk-width-1-2@m" data-validate required>
					<label for="last_name" class="uk-form-label">Last Name:</label>
					<input class="uk-input" id="last_name" name="last_name" type="text" value="{{ $user->last_name }}" data-error="Last name is required">
				</div>

				<div class="uk-width-1-1@m" data-validate required>
					<label class="uk-form-label">Email:</label>
					<input class="uk-input" id="email" name="email" type="text" value="{{ $user->email }}" data-type="email" data-error="Email is required">
				</div>

				<div class="uk-width-1-1 uk-position-relative line-strike">
					<span>Change Password</span>
				</div>
				<div class="uk-width-1-2@m" data-validate>
					<label class="uk-form-label">New Password:</label>
					<input class="uk-input" id="password" name="password" type="password" data-type="password-optional">
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
				<div class="uk-width-1-2@m" data-validate>
					<label class="uk-form-label">Confirm New Password:</label>
					<input class="uk-input" id="confirm-password" name="confirm-password" type="password" data-type="confirm-password-optional">
				</div>

				<div class="uk-width-1-1 uk-text-right">
					<a class="uk-button uk-button-primary" id="update-user">Save</a>
				</div>
			</form>

		</div>
	</div>
@endsection


@section('scripts')

    <script type="text/javascript">

    	$(document).ready(function() {

    		// Initalize the password strength indicator
			passwordStrength('#password');

			// Save the dog to the database
			$('#update-user').click(function() {

				console.log('test');

		        var errors = formValidation('div[data-validate] input, div[data-validate] select');
		        
		        // Check if errors object is empty
		        if(Object.keys(errors).length === 0 && errors.constructor === Object) { 

		            $.ajax({
		                headers: {
		                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		                },
		                type: 'POST',
		                url: '/update-profile',
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


