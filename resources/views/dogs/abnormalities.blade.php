@extends('layouts.dashboard')

@section('content')

    <div id="profile" class="individual-dog">

        @component('components.dog_header', ['dog' => $dog])
        @endcomponent

        <div class="uk-padding uk-padding-remove-horizontal uk-padding-remove-bottom uk-flex uk-flex-middle" uk-grid>
            <div class="uk-width-expand">
                <h1 class="title">Abnormalities</h1>
            </div>

        </div>

        {{-- $dog --}}

            <div class="content-wrapper">
                <table class="uk-table uk-table-responsive uk-table-divider">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Category</th>
                        <th>Comments</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($abnormalitiesRecords as $abnormalitiesRecord)
                        <tr>
                            <td> {{ date('M j, Y', strtotime($abnormalitiesRecord->created_at)) }}</td>
                            <td>{{ $abnormalitiesRecord->discovered_at }}</td>
                            <td>
                                {{ $abnormalitiesRecord->comments }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{ $abnormalitiesRecords->links() }}
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