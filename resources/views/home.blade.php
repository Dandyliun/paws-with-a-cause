@extends('layouts.dashboard')

@section('content')

    <header>
        <div class="color-section uk-flex uk-flex-middle" uk-grid>
            <div class="uk-width-expand uk-padding-remove">
                <h1>Kennels</h1>
            </div>
            <div class="uk-width-auto">
            </div>
        </div>
    </header>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="title"></h1>
                </div>
                <div>
                    <form>
                    <div class="uk-card uk-card-default">
                        <div class="uk-card-header">
                            <div class="uk-grid-small uk-flex-middle" uk-grid>
                                <div class="uk-width-expand">
                                    <h3 class="uk-card-title uk-margin-remove-bottom">CDF</h3>
                                </div>
                            </div>
                        </div>

                        <div class="uk-card-body uk-padding-remove uk-text-small">
                            <table class="uk-table uk-table-responsive uk-table-divider">
                                <thead>
                                    <tr>
                                        <th class="uk-text-center">#</th>
                                        <th>Dog</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cdfKennels as $kennel)
                                    <tr id={{ $kennel->id }}>
                                        <td><p class="uk-text-baseline uk-text-center">{{ $kennel->kennel_number }}</p></td>
                                        <td><input class="uk-input" name="name" type="text" value={{ $kennel->dog }}></td>
                                        <td><input class="uk-input date" name="startDate" value="{{ $kennel->start_date }}"></td>
                                        <td><input class="uk-input date" name="endDate" value="{{ $kennel->end_date }}"></td>
                                        <td><button class="uk-button uk-button-primary editButton"
                                                    type="button"
                                                    onclick="updateKennels( {{$kennel->id}} )" >Update</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                        <div class="uk-card uk-card-default uk-margin-medium-top">
                            <div class="uk-card-header">
                                <div class="uk-grid-small uk-flex-middle" uk-grid>
                                    <div class="uk-width-expand">
                                        <h3 class="uk-card-title uk-margin-remove-bottom">CEC ISO</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="uk-card-body uk-padding-remove uk-text-small">
                                <table class="uk-table uk-table-responsive uk-table-divider">
                                    <thead>
                                    <tr>
                                        <th class="uk-text-center">#</th>
                                        <th>Dog</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($cecKennels as $kennel)
                                        <tr id={{ $kennel->id }}>
                                            <td><p class="uk-text-baseline uk-text-center">{{ $kennel->kennel_number }}</p></td>
                                            <td><input class="uk-input" name="name" type="text" value={{ $kennel->dog }}></td>
                                            <td><input class="uk-input date" name="startDate" value="{{ $kennel->start_date }}"></td>
                                            <td><input class="uk-input date" name="endDate" value="{{ $kennel->end_date }}"></td>
                                            <td><button class="uk-button uk-button-primary editButton"
                                                        type="button"
                                                        onclick="updateKennels( {{$kennel->id}} )" >Update</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Start Success Modal --}}
<div id="success-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-text-center">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <h2 class="uk-modal-title">Success!</h2>
        @component('components.success_check')
        @endcomponent
        <div class="modal-content uk-text-bold">
            <p>The kennel has been updated.</p>
        </div>
        <p class="uk-text-center">
            <a class="uk-button uk-button-primary uk-modal-close" href="{{ URL::to('/home') }}">Ok</a>
        </p>
    </div>
</div>
{{-- End Success Modal --}}

@endsection

@section('scripts')
    <script type="text/javascript">

        // Initialize the date picker
        dateSelect('.date', true);

        // Update the kennel
        function updateKennels(id) {


            // $('#' + id + ' input[name="name"]').each(function () {
            //     var newName = $(this).val();
            //     console.log(newName);
            // });

            var newName = $('#' + id + ' input[name="name"]').val();
            var newStartdate = $('#' + id + ' input[name="startDate"]').val();
            var newEndDate = $('#' + id + ' input[name="endDate"]').val();

            console.log(newName + " " + newStartdate + " " + newEndDate);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/update-kennel',
                data: {
                    'kennel_id' : id,
                    'dog' : newName,
                    'startDate' : newStartdate,
                    'endDate' : newEndDate
                },
                success:function(data){
                    UIkit.modal('#success-modal').show();
                    animateCheckmark();
                },
                error:function(data){
                    console.log('error ' + data);
                }
            });

        }

    </script>

@endsection
