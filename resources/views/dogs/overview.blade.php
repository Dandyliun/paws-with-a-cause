@extends('layouts.dashboard')

@section('content')
	
	<div id="overview" class="individual-dog">
		
		@component('components.dog_header', ['dog' => $dog])
    	@endcomponent

    	<div class="uk-padding uk-padding-remove-horizontal uk-padding-remove-bottom uk-flex uk-flex-middle" uk-grid>
    		<div class="uk-width-expand">
				<h1 class="title">Dog Overview</h1>
			</div>
			<div class="uk-width-auto">
				<!-- <a class="uk-button uk-button-primary" onclick="saveProfile()">Save</a> -->
			</div>
		</div>

		<div class="content-wrapper uk-grid-match" uk-grid>

			{{-- Start Details Card --}}
			<div class="uk-width-1-2@m">
				<div class="uk-card uk-card-default" >
				    <div class="uk-card-header">
				        <div class="uk-grid-small uk-flex-middle" uk-grid>
				            <div class="uk-width-expand">
				                <h3 class="uk-card-title uk-margin-remove-bottom">Details</h3>
				                <p class="uk-text-meta uk-margin-remove-top">&nbsp;</p>
				            </div>
				        </div>
				    </div>
				    <div class="uk-card-body uk-padding-remove uk-text-small" >
				       	
				    </div>
				</div>
			</div>
			{{-- End Details Card --}}
			
			{{-- Start Health Records Card --}}
			<div class="uk-width-1-2@m">
				<div class="uk-card uk-card-default">
				    <div class="uk-card-header">
				        <div class="uk-grid-small uk-flex-middle" uk-grid>
				            
				            <div class="uk-width-expand">
				                <h3 class="uk-card-title uk-margin-remove-bottom">Recent Health Records</h3>
				                <p class="uk-text-meta uk-margin-remove-top">Total Records: {{ $healthRecordsCount }}</p>
				            </div>
				            <div class="uk-width-auto">
				                <a class="uk-button uk-button-primary" href="{{ URL::to('/dogs/health/new/' . $dog->id) }}">Add New</a>
				            </div>
				        </div>
				    </div>
				    <div class="uk-card-body uk-padding-remove uk-text-small">
				        <ul class="uk-list uk-list-striped">

						    @forelse($healthRecords as $record)
						    	<li>
						    		<div class="uk-grid-collapse" uk-grid>
							    		<div class="uk-width-expand">
							    			<span class="uk-text-bold">{{ $record->attribute }}</span> – {{ $record->value }}
							    		</div>
							    		<div class="uk-width-auto">
							    			{{ date('M j, Y', strtotime($record->created_at)) }} at {{ date('g:i A', strtotime($record->created_at)) }}
							    			
							    		</div>
							    	</div>
						    	</li>
						    @empty
						    	<li class="no-results uk-text-center">No results found</li>
						    @endforelse

						    <li class="view-all"><a class="uk-button uk-button-text" href="{{ URL::to('/dogs/health/' . $dog->id) }}">View All</a></li>

						</ul>
				    </div>
				</div>
			</div>
			{{-- End Health Records Card --}}

			{{-- Start Grooming Records Card --}}
			<div class="uk-width-1-2@m">
				<div class="uk-card uk-card-default">
				    <div class="uk-card-header">
				        <div class="uk-grid-small uk-flex-middle" uk-grid>
				            
				            <div class="uk-width-expand">
				                <h3 class="uk-card-title uk-margin-remove-bottom">Recent Grooming Records</h3>
				                <p class="uk-text-meta uk-margin-remove-top">Total Records: {{ $groomingRecordsCount }}</p>
				            </div>
				            <div class="uk-width-auto">
				                <a class="uk-button uk-button-primary" href="{{ URL::to('/dogs/grooming/new/' . $dog->id) }}">Add New</a>
				            </div>
				        </div>
				    </div>
				    <div class="uk-card-body uk-padding-remove uk-text-small">
				        <ul class="uk-list uk-list-striped">

						    @forelse($groomingRecords as $record)
						    	<li>
						    		<div class="uk-grid-collapse" uk-grid>
							    		<div class="uk-width-expand">
							    			<span class="uk-text-bold">{{ $record->attribute }}</span> – {{ $record->value }}
							    		</div>
							    		<div class="uk-width-auto">
							    			{{ date('M j, Y', strtotime($record->created_at)) }} at {{ date('g:i A', strtotime($record->created_at)) }}
							    			
							    		</div>
							    	</div>
						    	</li>
						    @empty
						    	<li class="no-results uk-text-center">No results found</li>
						    @endforelse

						    <li class="view-all"><a class="uk-button uk-button-text" href="{{ URL::to('/dogs/grooming/' . $dog->id) }}">View All</a></li>

						</ul>
				    </div>
				</div>
			</div>
			{{-- End Grooming Records Card --}}

			{{-- Start Exercise Records Card --}}
			<div class="uk-width-1-2@m">
				<div class="uk-card uk-card-default">
				    <div class="uk-card-header">
				        <div class="uk-grid-small uk-flex-middle" uk-grid>
				            
				            <div class="uk-width-expand">
				                <h3 class="uk-card-title uk-margin-remove-bottom">Recent Exercise Records</h3>
				                <p class="uk-text-meta uk-margin-remove-top">Total Records: {{ $exerciseRecordsCount }}</p>
				            </div>
				            <div class="uk-width-auto">
				                <a class="uk-button uk-button-primary" href="{{ URL::to('/dogs/exercise/new/' . $dog->id) }}">Add New</a>
				            </div>
				        </div>
				    </div>
				    <div class="uk-card-body uk-padding-remove uk-text-small">
				        <ul class="uk-list uk-list-striped">

						    @forelse($exerciseRecords as $record)
						    	<li>
						    		<div class="uk-grid-collapse" uk-grid>
							    		<div class="uk-width-expand">
							    			<span class="uk-text-bold">{{ $record->exercise_name }}</span> – {{ $record->comments }}
							    		</div>
							    		<div class="uk-width-auto">
							    			{{ date('M j, Y', strtotime($record->created_at)) }} at {{ date('g:i A', strtotime($record->created_at)) }}
							    			
							    		</div>
							    	</div>
						    	</li>
						    @empty
						    	<li class="no-results uk-text-center">No results found</li>
						    @endforelse

						    <li class="view-all"><a class="uk-button uk-button-text" href="{{ URL::to('/dogs/exercise/' . $dog->id) }}">View All</a></li>

						</ul>
				    </div>
				</div>
			</div>
			{{-- End Excerise Records Card --}}

		</div>

	</div>

@endsection