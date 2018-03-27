@extends('layouts.dashboard')

@section('content')

    <div id="profile" class="individual-dog">

        @component('components.dog_header', ['dog' => $dog])
        @endcomponent

        <div class="uk-padding uk-padding-remove-horizontal uk-padding-remove-bottom uk-flex uk-flex-middle" uk-grid>
            <div class="uk-width-expand">
                <h1 class="title">Add New Exercise</h1>
            </div>
            <div class="uk-width-auto">
                <a class="uk-button uk-button-primary" onclick="createExerciseRecord()">Save</a>
                <a class="uk-button white" href="../{{ $dog->id }}">View All Exercise Records</a>
            </div>
        </div>

        <form uk-grid>
            {{-- Pass the dog ID via hidden input --}}
            <input value="{{ $dog->id }}" id="dog_id" name="dog_id" hidden>

            {{-- Record Type --}}
            <div class="uk-width-1-2@m">
                <label class="uk-form-label">Select an exercise:</label>
                <select id="record_type" class="uk-select" name="record_type">
                    <option selected disabled>Please select an option...</option>
                    @foreach($exerciseAttributes as $exerciseAttribute)
                        <option>{{ $exerciseAttribute->exercise_name }} </option>
                    @endforeach
                </select>
            </div>

            {{-- Normality --}}
            <div class="uk-width-1-2@m">
                <label class="uk-form-label">Normality:</label>
                <select id="normality" class="uk-select" name="normality">
                    <option selected disabled>Please select an option...</option>
                    <option>Normal</option>
                    <option>Abnormal</option>
                </select>
            </div>

             {{--Abnormality Notes--}}
            <div id="abnormality-section" class="uk-width-1-1@m uk-hidden" >
                <div class="textarea-label" uk-grid>
                    <div class="uk-width-expand">
                        <label class="uk-form-label">Describe the abnormality:</label>
                    </div>
                    <div class="uk-width-auto">
                        <input class="uk-checkbox" type="checkbox" checked>
                        <label class="uk-form-label checkbox-label-right">Notify the vet staff via email</label>
                    </div>
                </div>
                <textarea id="description" class="uk-textarea" rows="5"></textarea>
            </div>

            {{-- Comments --}}
            <div class="uk-width-1-1@m">
                <div class="uk-width-auto">
                    <label class="uk-form-label">Comments:</label>
                </div>
                <textarea class="uk-textarea" id="comments" name="comments" rows="5"></textarea>
            </div>

        </form>

        {{-- Start Success Modal --}}
        <div id="success-modal" uk-modal>
            <div class="uk-modal-dialog uk-modal-body uk-text-center">
                <button class="uk-modal-close-default" type="button" uk-close></button>
                <h2 class="uk-modal-title">Success!</h2>
                @component('components.success_check')
                @endcomponent
                <div class="modal-content uk-text-bold">
                    <p>What would you like to do next?</p>
                </div>
                <p class="uk-text-center">
                    <a class="uk-button uk-button-default" href="{{ URL::to('/dogs/exercise/' . $dog->id) }}">Return to All</a>
                    <a class="uk-button uk-button-primary uk-modal-close">Add Another</a>
                </p>
            </div>
        </div>
        {{-- End Success Modal --}}


    </div>

@endsection

@section('scripts')
    <script>
        // Initialize the date picker
        dateSelect('#dob');

        console.log($( "select#normality option:selected" ).val());

        $( "select#normality" ).change(function() {
            var value = $( "select#normality option:selected" ).val();
            if(value.toLowerCase() == "abnormal") {
                $( "#abnormality-section" ).removeClass("uk-hidden");
                //$( "#abnormality-section" ).removeAttr("hidden");
            } else {
                $( "#abnormality-section" ).addClass("uk-hidden");
                //$( "#abnormality-section" ).addAttr("hidden");
            }
        });

        $( "select#record_type" ).change(function() {
            var value = $( "select#record_type option:selected" ).val();
            $( "#value" ).removeAttr("disabled");
            $( "#value" ).val("");
            if(value.toLowerCase() == "height")
            {
                $( "#value_type" ).html("Dog Height");
                $( "#value" ).attr("placeholder", "Enter height in inches");
            }
            else if(value.toLowerCase() == "weight")
            {
                $( "#value_type" ).html("Dog Weight");
                $( "#value" ).attr("placeholder", "Enter weight in lbs");
            }
            else if(value.toLowerCase() == "heat start date")
            {
                $( "#value_type" ).html("Heat Start Date");
                $( "#value" ).attr("placeholder", "Please select a date");
                dateSelect('#value');
            }
            else if(value.toLowerCase() == "heat end date")
            {
                $( "#value_type" ).html("Heat End Date");
                $( "#value" ).attr("placeholder", "Please select a date");
                dateSelect('#value');
            }
        });


    </script>

    <script type="text/javascript">

        function createExerciseRecord() {

            var normality = $('select[name="normality"]').val();
            if(normality.toLowerCase() === "abnormal") {
                normality = 0;
            } else {
                normality = 1;
            }

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'POST',
                url:'/new-exercise-record',
                data: {
                    'id'     :  $('input[name="dog_id"]').val(),
                    'exercise_type'   :  $('select[name="record_type"]').val(),
                    'comments' :  $('textarea[name="comments"]').val(),
                    'normality'  :  normality,
                },
                success:function(data){
                    console.log('success ');
                    UIkit.modal('#success-modal').show();
                    animateCheckmark();
                },
                error:function(data){
                    console.log('error');

                }
            });
        }


    </script>
@endsection