@extends('layouts.dashboard')

@section('content')
		
		<header>
			<div class="color-section uk-flex uk-flex-middle" uk-grid>
				<div class="uk-width-expand uk-padding-remove">
					<h1>Manage Breeds</h1>
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
				                <h3 class="uk-card-title uk-margin-remove-bottom">All Breeds</h3>
				                <p class="uk-text-meta uk-margin-remove-top">Total Breeds: {{ $breeds->count() }}</p>
				            </div>
				        </div>
				    </div>
				    <div class="uk-card-body uk-padding-remove uk-text-small" >
				    	<ul id="breed-list" class="uk-list uk-list-striped">
					       	@foreach($breeds as $breed)
								<li id="{{ $breed->id }}">{{ $breed->breed }} <a class="delete-breed uk-float-right" data-id="{{ $breed->id }}" uk-close uk-tooltip="Delete Breed"></a></li>
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
				                <h3 class="uk-card-title uk-margin-remove-bottom">Add New Breed</h3>
				                <p class="uk-text-meta uk-margin-remove-top">&nbsp;</p>
				            </div>
				        </div>
				    </div>
				    <div class="uk-card-body form-padding uk-text-small" >
				    	<form class="uk-form-stacked" data-validate>
				    		<label class="uk-form-label">Breed</label>
				    		<input id="new-breed" class="uk-input" name="new-breed" placeholder="Enter a new breed...">
				    	</form>
				    	<div class="uk-margin-top uk-flex uk-flex-right">
				    		<a id="create-breed" class="uk-button uk-button-primary">Save Breed</a>
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
			$('#create-breed').click(function() {
		        var errors = formValidation('div[data-validate] input, form[data-validate] input');
		        // Check if errors object is empty
		        if(Object.keys(errors).length === 0 && errors.constructor === Object) {
		        	$('.element-spinner').fadeIn();
		            var breed = $('input[name="new-breed"]');
		            $.ajax({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						type:'POST',
						url:'/create-breed',
						data: {
							'breed'  :  breed.val(),
						},
						success:function(data) {
							console.log('success ');
							$("ul#breed-list").append('<li id="' + data.id + '">' + data.breed + '<a class="delete-breed uk-float-right" data-id="' + data.id + '" uk-close uk-tooltip="Delete Breed"></a></li>');
							breed.val('');
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
			$('.delete-breed').click(function() {

				var dog_id = $(this).attr("data-id");
	   			 $.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type:'POST',
					url:'/delete-breed',
					data: {
						'dog_id'  :  dog_id,
					},
					success:function(data) {
						console.log('success ' );
						$('li#' + dog_id).slideUp();
					},
					error:function(data) {
						console.log('error');
					}
				});
   
		    });

		});
	</script>
@endsection