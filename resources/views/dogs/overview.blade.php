@extends('layouts.dashboard')

@section('content')
	
	<div id="overview" class="individual-dog">
		
		@component('components.dog_header', ['dog' => $dog])
    	@endcomponent

		<h1>Edit Dog</h1>

		{{ $dog }}


	</div>

@endsection