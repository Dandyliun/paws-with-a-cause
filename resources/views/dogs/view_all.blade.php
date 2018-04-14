@extends('layouts.dashboard')

@section('content')

	<header>
		<div class="color-section uk-flex uk-flex-middle" uk-grid>
			<div class="uk-width-expand uk-padding-remove">
				<h1>All Dogs</h1>
			</div>
			<div class="uk-width-auto">
				<!-- <a class="uk-button white" onclick="addNewDog()">Save</a> -->
			</div>
		</div>
	</header>

	<table class="uk-table uk-table-divider uk-table-middle uk-table-hover">
		<thead>
	        <tr>
	        	<th class="uk-table-shrink"></th>
	            <th>ID</th>
	            <th>Dog Name</th>
	            <th>Date of Birth</th>
	            <th>Breed</th>
	            <!-- <th></th> -->
	        </tr>
	    </thead>
	    <tbody>
			@foreach($dogs as $dog)
				<tr>
					<td class="uk-table-link">
						<a class="uk-link-reset" href="{{route('dogs.overview', ['id' => $dog->id])}}">
							<img class="uk-preserve-width uk-border-circle" src="@if( Storage::disk('public')->exists('/profile_images/thumbnails/' . $dog->profile_image) ) {{ URL::to('/storage/profile_images/' . $dog->profile_image ) }} @else {{ URL::to('/storage/profile_images/thumbnails/default.png') }} @endif" width="40" alt="">
						</a>
					</td>
					<td class="uk-table-link">
						<a class="uk-link-reset" href="{{route('dogs.overview', ['id' => $dog->id])}}">{{ $dog->internal_id }}</a>
					</td>
					<td class="uk-table-link">
						<a class="uk-link-reset" href="{{route('dogs.overview', ['id' => $dog->id])}}">{{ $dog->name }}</a>
					</td>
					<td class="uk-table-link">
						<a class="uk-link-reset" href="{{route('dogs.overview', ['id' => $dog->id])}}">{{ $dog->dob }}</a>
					</td>
					<td class="uk-table-link">
						<a class="uk-link-reset" href="{{route('dogs.overview', ['id' => $dog->id])}}">{{ $dog->breed }}</a>
					</td>
					<td><a class="uk-button uk-button-primary" name="{{$dog->id}}" onclick="confirmDeleteDog({{$dog->id}})" >Delete Dog</a></td>
					{{--Start Confirm Delete Modal--}}
					<div id="{{$dog->id}}" uk-modal>
						<div class="uk-modal-dialog uk-modal-body uk-text-center">
							<button class="uk-modal-close-default" type="button" uk-close></button>
							<h2 class="uk-modal-title">Are you sure?</h2>
							<p>You are about to delete {{$dog->name}}, <span class="uk-text-bold">would you like to continue?</span></p>
							<p class="uk-text-center">
								<a class="uk-button uk-button-default uk-modal-close">Cancel</a>
								<a class="uk-button uk-button-primary" onclick="deleteDog({{$dog->id}})">Delete</a>
							</p>
						</div>
					</div>
					{{--End Confirm Delete Modal--}}
				</tr>
			@endforeach
		</tbody>
	</table>

    {{-- Start Success Modal --}}
    <div id="success-modal" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-text-center">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <h2 class="uk-modal-title">Success!</h2>
            @component('components.success_check')
            @endcomponent
            <div class="modal-content uk-text-bold">
                <p>The dog has been removed</p>
            </div>
            <p class="uk-text-center">
                <a class="uk-button uk-button-primary uk-modal-close" href="{{ URL::to('/dogs') }}">Ok</a>
            </p>
        </div>
    </div>
    {{-- End Success Modal --}}


@endsection
@section('scripts')

	<script type="text/javascript">

        $(document).ready(function() {

            // Display the dog delete success notification if set
            var status = getUrlParameter('status');
            if(status == 'delete_success') {
                UIkit.notification({
                    message : '<span uk-icon="check"></span> <span class="notification-text">Dog Successfully Deleted</span>',
                    timeout : 5000,
                    pos: 'bottom-right'
                })
            }

        });

		function confirmDeleteDog(id) {
		    //Get the success modal for the same dog.
		    var confirmDeleteModal = $('#' + id);
            UIkit.modal(confirmDeleteModal).show();
		}

        // Delete Dog
        function deleteDog(id) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/delete-dog',
                data: {
                    'dog_id' : id
                },
                success:function(data){
                    location.href = '{{ URL::to("/dogs?status=delete_success") }}';
                },
                error:function(data){
                    console.log('error ' + data);
                }
            });
        }


	</script>

@endsection



