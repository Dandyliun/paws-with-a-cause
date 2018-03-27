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
				<div class="uk-card uk-card-default">
				    <div class="uk-card-header">
				        <div class="uk-grid-small uk-flex-middle" uk-grid>
				            
				            <div class="uk-width-expand">
				                <h3 class="uk-card-title uk-margin-remove-bottom">Details</h3>
				            </div>
				        </div>
				    </div>
				    <div class="uk-card-body uk-padding-remove uk-text-small">
				       	
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
				            </div>
				            <div class="uk-width-auto">
				                <a class="uk-button uk-button-primary" href="{{ URL::to('/dogs/health/new/' . $dog->id) }}">Add New</a>
				            </div>
				        </div>
				    </div>
				    <div class="uk-card-body uk-padding-remove uk-text-small">
				        <ul class="uk-list uk-list-striped">
						    @foreach($healthRecords as $record)
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
						    @endforeach
						</ul>
				    </div>
				    <div class="uk-card-footer">
				        <a class="uk-button uk-button-text" href="{{ URL::to('/dogs/health/' . $dog->id) }}">View All</a>
				    </div>
				</div>
			</div>
			{{-- End Health Records Card --}}

		</div>

	</div>

@endsection