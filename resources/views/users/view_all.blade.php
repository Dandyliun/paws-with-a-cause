@extends('layouts.dashboard')

@section('content')

	<header>
		<div class="color-section uk-flex uk-flex-middle" uk-grid>
			<div class="uk-width-expand uk-padding-remove">
				<h1>All Users</h1>
			</div>
			<div class="uk-width-auto">
				<a class="uk-button white" href="{{ URL::to('/users/new') }}">Create New User</a>
			</div>
		</div>
	</header>

	<table class="uk-table uk-table-divider uk-table-middle uk-table-hover">
		<thead>
	        <tr>
	        	{{--
	        	<th class="uk-table-shrink"></th>
	        	--}}
	            <th>Name</th>
	            <th>Email</th>
	            <th>Role</th>
	        </tr>
	    </thead>
	    <tbody>
			@foreach($users as $user)
				 
				<tr>
					{{--
					<td class="uk-table-link">
						<a class="uk-link-reset" href="{{route('dogs.overview', ['id' => $dog->id])}}">
							<img class="uk-preserve-width uk-border-circle" src="@if( Storage::disk('public')->exists('/profile_images/thumbnails/' . $dog->profile_image) ) {{ URL::to('/storage/profile_images/' . $dog->profile_image ) }} @else {{ URL::to('/storage/profile_images/thumbnails/default.png') }} @endif" width="40" alt="">
						</a>
					</td>
					--}}
					<td class="uk-table-link">
						<a class="uk-link-reset" href="{{route('users.edit', ['id' => $user->id])}}">{{ $user->first_name }}&nbsp;{{ $user->last_name }}</a>
					</td>
					<td class="uk-table-link">
						<a class="uk-link-reset" href="{{route('users.edit', ['id' => $user->id])}}">{{ $user->email }}</a>
					</td>
					<td class="uk-table-link">
						<a class="uk-link-reset" href="{{route('users.edit', ['id' => $user->id])}}">
							@if($user->is_admin == 1)
								Admin
							@else
								User
							@endif
						</a>
					</td>
				</tr> 

			@endforeach
		</tbody>
	</table>

@endsection

@section('scripts')

    <script type="text/javascript">

    	$(document).ready(function() {

    		// Display the user delete success notification if set
			var status = getUrlParameter('status');
			if(status == 'delete_success') {
				UIkit.notification({
					message : '<span uk-icon="check"></span> <span class="notification-text">User Successfully Deleted</span>',
					timeout : 5000,
					pos: 'bottom-right'
				})
			}

        });


    </script>

@endsection



