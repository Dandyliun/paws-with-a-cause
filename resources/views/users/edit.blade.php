@extends('layouts.dashboard')

@section('content')

	<header>
		<div class="color-section uk-flex uk-flex-middle" uk-grid>
			<div class="uk-width-expand uk-padding-remove">
				<h1>Edit User</h1>
			</div>
			<div class="uk-width-auto">
				<a class="uk-button white" href="#confirm-delete-modal" uk-toggle>Delete User</a>
			</div>
		</div>
	</header>

	<br>

	<div class="content-wrapper" uk-grid>
		<div class="uk-width-1-2@m">
			<div class="uk-card uk-card-default" >
			    <div class="uk-card-header">
			        <div class="uk-grid-small uk-flex-middle" uk-grid>
			            <div class="uk-width-expand">
			                <h3 class="uk-card-title uk-margin-remove-bottom">{{ $user->first_name }}&nbsp;{{ $user->last_name }}</h3>

			            </div>
			        </div>
			    </div>
			    <div class="uk-card-body uk-padding-remove uk-text-small" >
			       	
			    </div>
			</div>
		</div>

		<div class="uk-width-1-2@m">
			<form class="uk-form-stacked" uk-grid>
				<div class="uk-width-1-1 uk-position-relative line-strike first">
					<span>Update Information</span>
				</div>
				<input id="user_id" name="user_id" value="{{ $user->id }}" hidden>
				<div class="uk-width-1-2@m">
					<label class="uk-form-label">First Name:</label>
					<input class="uk-input" id="first_name" name="first_name" type="text" value="{{ $user->first_name }}">
				</div>
				<div class="uk-width-1-2@m">
					<label class="uk-form-label">Last Name:</label>
					<input class="uk-input" id="last_name" name="last_name" type="text" value="{{ $user->last_name }}">
				</div>

				<div class="uk-width-1-1@m">
					<label class="uk-form-label">Email:</label>
					<input class="uk-input" id="email" name="email" type="text" value="{{ $user->email }}">
				</div>
				<div class="uk-width-1-1@m">
					<label class="uk-form-label">Role:</label>
					<select class="uk-select" id="role" name="role">
						<option selected disabled>Please select an option...</option>
						<option @if($user->is_admin == 0) selected @endif>User</option>
						<option @if($user->is_admin == 1) selected @endif>Admin</option>
					</select>
				</div>

				<div class="uk-width-1-1 uk-position-relative line-strike">
					<span>Change Password</span>
				</div>

				<div class="uk-width-1-1@m">
					<label class="uk-form-label">New Password:</label>
					<p class="uk-text-small uk-text-meta label-text">Password must be at least 6 characters</p>
					<input class="uk-input" id="password" name="password" type="password">
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
				<div class="uk-width-1-1@m">
					<label class="uk-form-label">Confirm New Password:</label>
					<input class="uk-input" id="confirm_new_password" name="confirm_new_password" type="password">
				</div>

				<div class="uk-width-1-1 uk-text-right">
					<a class="uk-button uk-button-primary" onclick="updateUser()">Update User</a>
				</div>
			</form>

		</div>
	</div>

	<div id="confirm-delete-modal" uk-modal>
	    <div class="uk-modal-dialog uk-modal-body uk-text-center">
	    	<button class="uk-modal-close-default" type="button" uk-close></button>
	        <h2 class="uk-modal-title">Are you sure?</h2>
	        <p>You are about to delete the user {{ $user->first_name }}&nbsp;{{ $user->last_name }}, <span class="uk-text-bold">would you like to continue?</span></p>
	        <p class="uk-text-center">
	            <a class="uk-button uk-button-default uk-modal-close">Cancel</a>
	            <a class="uk-button uk-button-primary" onclick="deleteUser()">Delete</a>
	        </p>
	    </div>
	</div>


@endsection


@section('scripts')

    <script type="text/javascript">

    	$(document).ready(function() {

			// strength validation on keyup-event
			$("#password").on("keyup", function() {
				var val = $(this).val(),
					color = testPasswordStrength(val);

				styleStrengthLine(color, val);
			});

			// check password strength
			function testPasswordStrength(value) {
				var strongRegex = new RegExp(
					"^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})"
				),
					mediumRegex = new RegExp(
						"^(((?=.*[a-z])(?=.*[A-Z]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(?=.{6,})"
					);


				if (strongRegex.test(value)) {
					$('.strength-text').html(': Strong');
					return "green";
				} else if (mediumRegex.test(value)) {
					$('.strength-text').html(': Medium');
					return "orange";
				} else {
					$('.strength-text').html(': Weak');
					return "red";
				}
			}

			function styleStrengthLine(color, value) {
				$(".line")
					.removeClass("bg-red bg-orange bg-green")
					.addClass("bg-transparent");
				
				if (value) {
					
					if (color === "red") {
						$(".line:nth-child(1)")
							.removeClass("bg-transparent")
							.addClass("bg-red");
					} else if (color === "orange") {
						$(".line:not(:last-of-type)")
							.removeClass("bg-transparent")
							.addClass("bg-orange");
					} else if (color === "green") {
						$(".line")
							.removeClass("bg-transparent")
							.addClass("bg-green");
					}
				}
			}


			// Show password checkbox event listener
			$('input#show_password:checkbox').change(function() {
		        if ($(this).is(':checked')) {
		            $('input#password').attr('type', 'text')
		        } else {
		        	$('input#password').attr('type', 'password')
		        }
		    });


		});


		// Check for errors and post update user
		function updateUser() {

        	var password = $('input[name="password"]').val();
        	var confirmed_password = $('input[name="confirmed_password"]').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/update-user',
                data: {
                	'user_id' : $('input[name="user_id"]').val(),
                    'first_name' : $('input[name="first_name"]').val(),
                    'last_name'     : $('input[name="last_name"]').val(),
                    'email' : $('input[name="email"]').val(),
                    'role' : $('select[name="role"]').val(),
                    'password' : password,
                    'confirmed_password' : confirmed_password
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

        }


        // Delete the user
		function deleteUser() {

        	var password = $('input[name="password"]').val();
        	var confirmed_password = $('input[name="confirmed_password"]').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/delete-user',
                data: {
                	'user_id' : $('input[name="user_id"]').val(),
                },
                success:function(data){
                    console.log('success ');
                    location.href = '{{ URL::to("/users?status=delete_success") }}'
                },
                error:function(data){
                    console.log('error' + data);
                }
            });

        }


    </script>

@endsection


