@extends('layouts.dashboard')

@section('content')

	<h1>All Dogs</h1>

	<table class="uk-table uk-table-divider">
		<thead>
	        <tr>
	            <th>ID</th>
	            <th>Dog Name</th>
	            <th>Date of Birth</th>
	            <th>Breed</th>
	            <th></th>
	        </tr>
	    </thead>
	    <tbody>
			@foreach($dogs as $dog)
				<tr>
					<td>{{ $dog->internal_id }}</td>
					<td>{{ $dog->name }}</td>
					<td>{{ $dog->dob }}</td>
					<td>{{ $dog->breed }}</td>
					<td><a href="{{route('dogs.overview', ['id' => $dog->id])}}">Manage Dog</a></td>
				</tr>
			@endforeach
		</tbody>
	</table>

@endsection

