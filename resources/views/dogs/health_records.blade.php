@extends('layouts.dashboard')

@section('content')
	
	<div id="profile" class="individual-dog">
		
		@component('components.dog_header', ['dog' => $dog])
    	@endcomponent

    	<div class="uk-padding uk-padding-remove-horizontal uk-padding-remove-bottom uk-flex uk-flex-middle" uk-grid>
    		<div class="uk-width-expand">
				<h1 class="title">Health</h1>
			</div>
			<div class="uk-width-auto">
				<a class="uk-button uk-button-primary" href="{{ URL::to('/dogs/health/new/' . $dog->id) }}">New Health Record</a>
			</div>
		</div>

		<div class="content-wrapper">
			<table class="uk-table uk-table-responsive uk-table-divider">
			    <thead>
			        <tr>
			            <th>Record Type</th>
			            <th>Date</th>
			            <th>Normality</th>
			            <th>Performed By</th>
			        </tr>
			    </thead>
			    <tbody>
			    	@foreach($healthRecords as $healthRecord)
			    	<tr>
			    		<td>{{ $healthRecord->attribute }}</td>
			            <td>
				            @php
				            	$dt = new DateTime($healthRecord->created_at);
								echo $dt->format('m-d-Y');
							@endphp
						</td>
			            <td>
			            	@if($healthRecord->normality == 0)
			            		Abnormal
			            	@else
			            		Normal
			            	@endif
			            </td>
			            <td>{{ $healthRecord->performed_by }}</td>
			        </tr>
			    	@endforeach
			    </tbody>
			</table>
		</div>

		{{ $healthRecords->links() }}

	</div>

@endsection

@section('scripts')
	<script>
		// Initialize the date picker
  		dateSelect('#dob');
  	</script>

	<script type="text/javascript">
		
		function saveProfile() {
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type:'POST',
				url:'/save-profile',
				data: {
					'id'     :  $('input[name="dog_id"]').val(),
					'name'   :  $('input[name="name"]').val(),
					'gender' :  $('select[name="gender"]').val(),
					'breed'  :  $('select[name="breed"]').val(),
					'color'  :  $('select[name="color"]').val(),
					'dob'    :  $('input[name="dob"]').val(),
					'food'   :  $('input[name="food"]').val(),
					'internal_id'  :  $('input[name="internal_id"]').val(),
					'microchip_id'  :  $('input[name="microchip_id"]').val(),
				},
				success:function(data){
					console.log('success ' + data);
				},
				error:function(data){
					console.log('error');
				}
			});
		}


	</script>
@endsection