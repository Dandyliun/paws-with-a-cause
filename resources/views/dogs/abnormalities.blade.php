@extends('layouts.dashboard')

@section('content')

    <div id="abnormalities" class="individual-dog">

        @component('components.dog_header', ['dog' => $dog])
        @endcomponent

        <div class="uk-padding uk-padding-remove-horizontal uk-padding-remove-bottom uk-flex uk-flex-middle" uk-grid>
            <div class="uk-width-expand">
                <h1 class="title">Abnormalities</h1>
            </div>

        </div>

        <div class="spacer-small"></div>

        <div class="content-wrapper">

            <div class="uk-card uk-card-default">
                <div class="uk-card-header">
                    <div class="uk-grid-small uk-flex-middle" uk-grid>
                        
                        <div class="uk-width-expand">
                            <h3 class="uk-card-title uk-margin-remove-bottom">Health Abnormalities</h3>
                            <p class="uk-text-meta uk-margin-remove-top">Total Records: {{ $healthAbnormalities->count() }}</p>
                        </div>
                        <div class="uk-width-auto">
                            <!-- <a class="uk-button uk-button-primary" href="{{ URL::to('/dogs/health/new/' . $dog->id) }}">Add New</a> -->
                        </div>
                    </div>
                </div>
                <div class="uk-card-body uk-padding-remove uk-text-small">
                    <table class="uk-table uk-table-responsive uk-table-divider">
                        <thead>
                        <tr>
                            @if($healthAbnormalities->count() != 0)
                                <th>Date</th>
                                <th>Category</th>
                                <th>Value</th>
                                <th>Notes</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($healthAbnormalities as $abnormality)
                            <tr>
                                <td>
                                    {{ date('M j, Y', strtotime($abnormality->created_at)) }}
                                </td>
                                <td>
                                    {{ $abnormality->attribute }}
                                </td>
                                <td>
                                   {{ $abnormality->value }}
                                </td>
                                <td class="uk-width-medium uk-text-truncate">
                                   {{ $abnormality->comments }}
                                </td>
                            </tr>
                        @empty
                            <tr class="uk-width-1-1 no-border">
                                <td class="uk-padding-small uk-text-center">
                                    No Records Found
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="spacer"></div>

            <div class="uk-card uk-card-default">
                <div class="uk-card-header">
                    <div class="uk-grid-small uk-flex-middle" uk-grid>
                        
                        <div class="uk-width-expand">
                            <h3 class="uk-card-title uk-margin-remove-bottom">Grooming Abnormalities</h3>
                            <p class="uk-text-meta uk-margin-remove-top">Total Records: {{ $groomingAbnormalities->count() }}</p>
                        </div>
                        <div class="uk-width-auto">
                            <!-- <a class="uk-button uk-button-primary" href="{{ URL::to('/dogs/health/new/' . $dog->id) }}">Add New</a> -->
                        </div>
                    </div>
                </div>
                <div class="uk-card-body uk-padding-remove uk-text-small">
                    <table class="uk-table uk-table-responsive uk-table-divider">
                        <thead>
                            @if($groomingAbnormalities->count() != 0)
                                <th>Date</th>
                                <th>Category</th>
                                <th>Value</th>
                                <th>Notes</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($groomingAbnormalities as $abnormality)
                            <tr>
                                <td>
                                    {{ date('M j, Y', strtotime($abnormality->created_at)) }}
                                </td>
                                <td>
                                    {{ $abnormality->attribute }}
                                </td>
                                <td>
                                    {{ $abnormality->value }}
                                </td>
                                <td class="uk-width-medium uk-text-truncate">
                                   {{ $abnormality->comments }}
                                </td>
                            </tr>
                        @empty
                            <tr class="uk-width-1-1 no-border">
                                <td class="uk-padding-small uk-text-center">
                                    No Records Found
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>     

            <div class="spacer"></div>

            <div class="uk-card uk-card-default">
                <div class="uk-card-header">
                    <div class="uk-grid-small uk-flex-middle" uk-grid>
                        
                        <div class="uk-width-expand">
                            <h3 class="uk-card-title uk-margin-remove-bottom">Exercise Abnormalities</h3>
                            <p class="uk-text-meta uk-margin-remove-top">Total Records: {{ $exerciseAbnormalities->count() }}</p>
                        </div>
                        <div class="uk-width-auto">
                            <!-- <a class="uk-button uk-button-primary" href="{{ URL::to('/dogs/health/new/' . $dog->id) }}">Add New</a> -->
                        </div>
                    </div>
                </div>
                <div class="uk-card-body uk-padding-remove uk-text-small">
                    <table class="uk-table uk-table-responsive uk-table-divider">
                        <thead>
                            @if($exerciseAbnormalities->count() != 0)
                                <th>Date</th>
                                <th>Category</th>
                                <th>Value</th>
                                <th>Notes</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($exerciseAbnormalities as $abnormality)
                            <tr>
                                <td>
                                    {{ date('M j, Y', strtotime($abnormality->created_at)) }}
                                </td>
                                <td>
                                    {{ $abnormality->exercise_name }}
                                </td>
                                <td>
                                    {{ $abnormality->value }}
                                </td>
                                <td class="uk-width-medium uk-text-truncate">
                                   {{ $abnormality->comments }}
                                </td>
                            </tr>
                        @empty
                            <tr class="uk-width-1-1 no-border">
                                <td class="uk-padding-small uk-text-center">
                                    No Records Found
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
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