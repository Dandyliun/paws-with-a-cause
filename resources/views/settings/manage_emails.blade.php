@extends('layouts.dashboard')

@section('content')
		
		<header>
			<div class="color-section uk-flex uk-flex-middle" uk-grid>
				<div class="uk-width-expand uk-padding-remove">
					<h1>Manage Vet Emails</h1>
				</div>
				<div class="uk-width-auto">
					<!-- <a class="uk-button white" onclick="">Delete User</a> -->
				</div>
			</div>
		</header>

		<div id="manage-breeds" class="uk-flex uk-flex-center uk-padding uk-padding-remove-horizontal" uk-grid>
			<div class="uk-width-1-2@m">
				<div class="uk-card uk-card-default" >
				    <div class="uk-card-header">
				        <div class="uk-grid-small uk-flex-middle" uk-grid>
				            <div class="uk-width-expand">
				                <h3 class="uk-card-title uk-margin-remove-bottom">All Vet Emails</h3>
				                <p class="uk-text-meta uk-margin-remove-top">Total Emails: {{ $emails->count() }}</p>
				            </div>
				        </div>
				    </div>
				    <div class="uk-card-body uk-padding-remove uk-text-small" >
				    	<ul id="email-list" class="uk-list uk-list-striped">
					       	@foreach($emails as $email)
								<li id="{{ $email->id }}">{{ $email->email }} <a class="delete-email uk-float-right" data-id="{{ $email->id }}" uk-close uk-tooltip="Delete Email"></a></li>
							@endforeach
						</ul>
				    </div>
				</div>
			</div>
			<div class="uk-width-1-2@m">
				<div class="uk-card uk-card-default" >
				    <div class="uk-card-header">
				        <div class="uk-grid-small uk-flex-middle" uk-grid>
				            <div class="uk-width-expand">
				                <h3 class="uk-card-title uk-margin-remove-bottom">Add New Email</h3>
				                <p class="uk-text-meta uk-margin-remove-top">&nbsp;</p>
				            </div>
				        </div>
				    </div>
				    <div class="uk-card-body form-padding uk-text-small" >
				    	<form class="uk-form-stacked" data-validate>
				    		<label class="uk-form-label">Email</label>
				    		<input id="new-email" class="uk-input" name="new-email" placeholder="Enter a new email...">
				    	</form>
				    	<div class="uk-margin-top uk-flex uk-flex-right">
				    		<a id="create-email" class="uk-button uk-button-primary">Save Email</a>
				    	</div>
				    </div>
				</div>
			</div>
		</div>

@endsection

@section('scripts')

	<script type="text/javascript">

		$(document).ready(function() {
			// Post the breed to the database
			$('#create-email').click(function() {
		        var errors = formValidation('div[data-validate] input, form[data-validate] input');
		        // Check if errors object is empty
		        if(Object.keys(errors).length === 0 && errors.constructor === Object) {
		        	$('.element-spinner').fadeIn();
		            var email = $('input[name="new-email"]');
		            $.ajax({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						type:'POST',
						url:'/create-email',
						data: {
							'email'  :  email.val(),
						},
						success:function(data) {
							console.log('success ');
							$("ul#email-list").append('<li id="' + data.id + '">' + data.email + '<a class="delete-email uk-float-right" data-id="' + data.id + '" uk-close uk-tooltip="Delete Email"></a></li>');
							email.val('');
							$('.element-spinner').fadeOut();
						},
						error:function(data) {
							console.log('error');
							$('.element-spinner').fadeOut();
						}
					});
		        } else {
		            showFormErrors(errors); 
		        }    
		    });

			// Delete breed
			$('.delete-email').click(function() {
				$('.element-spinner').fadeIn();
				var email_id = $(this).attr("data-id");
	   			 $.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type:'POST',
					url:'/delete-email',
					data: {
						'email_id'  :  email_id,
					},
					success:function(data) {
						console.log('success ' );
						$('li#' + email_id).slideUp();
						$('.element-spinner').fadeOut();
					},
					error:function(data) {
						console.log('error');
						$('.element-spinner').fadeOut();
					}
				});
   
		    });

		});
	</script>
@endsection