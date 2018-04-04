@extends('layouts.dashboard')

@section('content')

    <div id="profile" class="individual-dog">

        @component('components.dog_header', ['dog' => $dog])
        @endcomponent

        <div class="uk-padding uk-padding-remove-horizontal uk-padding-remove-bottom uk-flex uk-flex-middle" uk-grid>
            <div class="uk-width-expand">
                <h1 class="title">Add New Exercise Record</h1>
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

            {{-- Value --}}
            <div class="uk-width-1-2@m">
                <label id="value_type" class="uk-form-label"> </label>
                <input class="uk-input" id="value" name="value" disabled />
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
            <div id="abnormality-section" class="uk-width-1-1@m uk-invisible" >
                <div class="textarea-label" uk-grid>
                    <div class="uk-width-expand">
                        <label class="uk-form-label">Describe the abnormality:</label>
                    </div>
                    <div class="uk-width-auto">
                        <input class="uk-checkbox" type="checkbox" checked>
                        <label class="uk-form-label checkbox-label-right">Notify the vet staff via email</label>
                    </div>
                </div>
                <textarea id="comments" class="uk-textarea" rows="5"></textarea>
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
        //Set the normality.
        $( "select#normality" ).change(function() {
            var value = $( "select#normality option:selected" ).val();
            if(value.toLowerCase() == "abnormal") {
                $( "#abnormality-section" ).removeClass("uk-invisible");
            } else {
                $( "#abnormality-section" ).addClass("uk-invisible");
            }
        });

        $( "select#record_type" ).change(function() {
            var value = $( "select#record_type option:selected" ).val();
            $( "#value" ).removeAttr("disabled");
            $( "#value" ).val("");
            $( "#value" ).attr("placeholder", "Enter Notes");
            if(value.toLowerCase() == "run")
            {
                $( "#value_type" ).html("Run");
            }
            else if(value.toLowerCase() == "walk")
            {
                $( "#value_type" ).html("Walk");
            }
            else if(value.toLowerCase() == "fetch")
            {
                $( "#value_type" ).html("Fetch");
            }
            else if(value.toLowerCase() == "outside alone")
            {
                $( "#value_type" ).html("Outside Alone");
            }
            else if(value.toLowerCase() == "outside pack")
            {
                $( "#value_type" ).html("Outside Pack");
            }
            else if(value.toLowerCase() == "mental exercise")
            {
                $( "#value_type" ).html("Mental Exercise");
            }
            else if(value.toLowerCase() == "obedience")
            {
                $( "#value_type" ).html("Obedience");
            }
            else if(value.toLowerCase() == "other")
            {
                $( "#value_type" ).html("Other");
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
                    'value' : $('input[name="value"]').val(),
                    'normality' : normality,
                    'comments' :  $('textarea#comments').val()
                },
                success:function(data){
                    console.log('success ' + data);
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