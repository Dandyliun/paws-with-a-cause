@extends('layouts.dashboard')

@section('content')

    <div id="profile" class="individual-dog">

        @component('components.dog_header', ['dog' => $dog])
        @endcomponent

        <div class="uk-padding uk-padding-remove-horizontal uk-padding-remove-bottom uk-flex uk-flex-middle" uk-grid>
            <div class="uk-width-expand">
                <h1 class="title">Exercise</h1>
            </div>
            <div class="uk-width-auto">
                <a class="uk-button uk-button-primary" href="{{ URL::to('/dogs/exercise/new/' . $dog->id) }}">New Exercise Record</a>
            </div>
        </div>

        <div class="spacer-small"></div>

        <div class="content-wrapper">
            <div class="uk-card uk-card-default">
                <div class="uk-card-body uk-padding-remove uk-text-small">
                    <table class="uk-table uk-table-responsive uk-table-divider padded">
                        <thead>
                            <tr>
                                @if($exerciseRecords->count() != 0)
                                    <th>Record Type</th>
                                    <th>Value</th>
                                    <th>Date</th>
                                    <th>Normality</th>
                                    <th>Performed By</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($exerciseRecords as $exerciseRecord)
                            <tr>
                                <td>{{ $exerciseRecord->exercise_name }}</td>
                                <td>{{ $exerciseRecord->value }}</td>
                                <td>
                                    {{ date('M j, Y', strtotime($exerciseRecord->created_at)) }}
                                </td>
                                <td>
                                    @if($exerciseRecord->normality == 0)
                                        Abnormal
                                    @else
                                        Normal
                                    @endif
                                </td>
                                <td>{{ $exerciseRecord->performed_by }}</td>
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

        {{ $exerciseRecords->links() }}

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