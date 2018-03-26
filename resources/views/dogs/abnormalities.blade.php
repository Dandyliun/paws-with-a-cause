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

    <div class="content-wrapper">
        <table class="uk-table uk-table-responsive uk-table-divider">
            <thead>
            <tr>
                <th>Record Type</th>
                <th>Date</th>
                <th>Abnormality</th>
            </tr>
            </thead>
        </table>
</div>





@endsection