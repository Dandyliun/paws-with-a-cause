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
					<td><a class="uk-button" onclick="deleteDog( {{$dog->id}} )">Delete Dog</a></td>
				</tr>
			@endforeach
		</tbody>
	</table>


@endsection
@section('scripts')

	<script type="text/javascript">
        // Delete the Dog
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
                    console.log('success ');

                },
                error:function(data){
                    console.log('error ' + data);
                }
            });

        }


	</script>

@endsection



