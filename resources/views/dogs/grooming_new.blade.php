@extends('layouts.dashboard')

@section('content')

    <div id="profile" class="individual-dog">

        @component('components.dog_header', ['dog' => $dog])
        @endcomponent

        <div class="uk-padding uk-padding-remove-horizontal uk-padding-remove-bottom uk-flex uk-flex-middle" uk-grid>
            <div class="uk-width-expand">
                <h1 class="title">Add New Grooming Record</h1>
            </div>
            <div class="uk-width-auto">
                <a class="uk-button uk-button-primary" onclick="createGroomingRecord()">Save</a>
                <a class="uk-button white" href="../{{ $dog->id }}">View All Grooming Records</a>
            </div>
        </div>

        <form uk-grid>
            {{-- Pass the dog ID via hidden input --}}
            <input value="{{ $dog->id }}" id="dog_id" name="dog_id" hidden>

            {{-- Record Type --}}
            <div class="uk-width-1-2@m">
                <label class="uk-form-label">Select a record type:</label>
                <select id="record_type" class="uk-select" name="record_type">
                    <option selected disabled>Please select an option...</option>
                    @foreach($groomingAttributes as $groomingAttribute)
                        <option>{{ $groomingAttribute->grooming_service }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Value --}}
            <div class="uk-width-1-2@m">
                <label id="value_type" class="uk-form-label">&nbsp;</label>
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

            {{-- Abnormality Notes --}}
            <div id="abnormality-section" class="uk-width-1-1@m uk-invisible">
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
                    <a class="uk-button uk-button-default" href="{{ URL::to('/dogs/grooming/' . $dog->id) }}">Return to All</a>
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
                $( "#abnormality-section" ).removeClass("uk-invisible");
            } else {
                $( "#abnormality-section" ).addClass("uk-invisible");
            }
        });


        $( "select#record_type" ).change(function() {
            var value = $( "select#record_type option:selected" ).val();
            $( "#value" ).removeAttr("disabled");
            $( "#value" ).val("");
            if(value.toLowerCase() == "bath")
            {
                $( "#value_type" ).html("Bath Notes");
                $( "#value" ).attr("placeholder", "Enter Notes");
            }
            else if(value.toLowerCase() == "nail trim")
            {
                $( "#value_type" ).html("Nail Trimming");
                $( "#value" ).attr("placeholder", "Enter Notes");
            }
            else if(value.toLowerCase() == "teeth brushing")
            {
                $( "#value_type" ).html("Teeth");
                $( "#value" ).attr("placeholder", "Enter Notes");
                dateSelect('#value');
            }
            else if(value.toLowerCase() == "brush")
            {
                $( "#value_type" ).html("Brushing");
                $( "#value" ).attr("placeholder", "Enter Notes");
                dateSelect('#value');
            }
            else if(value.toLowerCase() == "full groom")
            {
                $( "#value_type" ).html("Full Groom");
                $( "#value" ).attr("placeholder", "Enter Notes");
                dateSelect('#value');
            }
            else if(value.toLowerCase() == "ear cleaning")
            {
                $( "#value_type" ).html("Ear Cleaning");
                $( "#value" ).attr("placeholder", "Enter Notes");
                dateSelect('#value');
            }
        });


    </script>

    <script type="text/javascript">

        function createGroomingRecord() {

            var normality = $('select[name="normality"]').val();
            if(normality.toLowerCase() == "abnormal") {
                normality = 0;
            } else {
                normality = 1;
            }

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'POST',
                url:'/new-grooming-record',
                data: {
                    'id'     :  $('input[name="dog_id"]').val(),
                    'record_type'   :  $('select[name="record_type"]').val(),
                    'value' :  $('input[name="value"]').val(),
                    'normality'  :  normality,
                    'comments'  :  $('textarea#comments').val(),
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