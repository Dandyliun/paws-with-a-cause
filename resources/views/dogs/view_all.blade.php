@extends('layouts.dashboard')

@section('content')

	<h1>All Dogs</h1>

	<table class="uk-table uk-table-divider">
		<thead>
	        <tr>
	            <th>Id</th>
	            <th>Name</th>
	            <th>D.O.B.</th>
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
					<td>breed here...</td>
					<td><a href="{{route('dogs.overview', ['id' => $dog->id])}}">Change</a></td>
				</tr>
			@endforeach
		</tbody>
	</table>

@endsection

