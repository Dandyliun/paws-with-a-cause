@extends('layouts.dashboard')

@section('content')
		
		<header>
			<div class="color-section uk-flex uk-flex-middle" uk-grid>
				<div class="uk-width-expand uk-padding-remove">
					<h1>Manage Dog Colors</h1>
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
				                <h3 class="uk-card-title uk-margin-remove-bottom">All Dog Colors</h3>
				                <p class="uk-text-meta uk-margin-remove-top">Total Colors: {{ $colors->count() }}</p>
				            </div>
				        </div>
				    </div>
				    <div class="uk-card-body uk-padding-remove uk-text-small" >
				    	<ul id="color-list" class="uk-list uk-list-striped">
					       	@foreach($colors as $color)
								<li id="{{ $color->id }}">{{ $color->color }} <a class="delete-color uk-float-right" data-id="{{ $color->id }}" uk-close uk-tooltip="Delete Color"></a></li>
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
				                <h3 class="uk-card-title uk-margin-remove-bottom">Add New Color</h3>
				                <p class="uk-text-meta uk-margin-remove-top">&nbsp;</p>
				            </div>
				        </div>
				    </div>
				    <div class="uk-card-body form-padding uk-text-small" >
				    	<form class="uk-form-stacked" data-validate>
				    		<label class="uk-form-label">Color</label>
				    		<input id="new-color" class="uk-input" name="new-color" placeholder="Enter a new dog color...">
				    	</form>
				    	<div class="uk-margin-top uk-flex uk-flex-right">
				    		<a id="create-color" class="uk-button uk-button-primary">Save Color</a>
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
			$('#create-color').click(function() {
		        var errors = formValidation('div[data-validate] input, form[data-validate] input');
		        // Check if errors object is empty
		        if(Object.keys(errors).length === 0 && errors.constructor === Object) {
		        	$('.element-spinner').fadeIn();
		            var color = $('input[name="new-color"]');
		            $.ajax({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						type:'POST',
						url:'/create-color',
						data: {
							'color'  :  color.val(),
						},
						success:function(data) {
							console.log('success ');
							$("ul#color-list").append('<li id="' + data.id + '">' + data.color + '<a class="delete-color uk-float-right" data-id="' + data.id + '" uk-close uk-tooltip="Delete Color"></a></li>');
							color.val('');
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
			$('.delete-color').click(function() {
				$('.element-spinner').fadeIn();
				var color_id = $(this).attr("data-id");
	   			 $.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type:'POST',
					url:'/delete-color',
					data: {
						'color_id'  :  color_id,
					},
					success:function(data) {
						console.log('success ' );
						$('li#' + color_id).slideUp();
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