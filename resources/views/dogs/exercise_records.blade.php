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

        <div class="content-wrapper">
            <table class="uk-table uk-table-responsive uk-table-divider">
                <thead>
                <tr>
                    <th>Activity</th>
                    <th>Date</th>
                    <th>Notes</th>
                </tr>
                </thead>
                <tbody>
                @foreach($exerciseRecords as $exerciseRecord)
                    <tr>
                        <td>{{ $exerciseRecord->exercise_name }}</td>
                        <td>
                            @php
                                $dt = new DateTime($exerciseRecord->created_at);
                                echo $dt->format('m-d-Y');
                            @endphp
                        </td>
                        <td>{{ $exerciseRecord->comments }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
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