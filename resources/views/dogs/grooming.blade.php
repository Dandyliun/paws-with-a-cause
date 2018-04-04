@extends('layouts.dashboard')

@section('content')

    <div id="profile" class="individual-dog">

        @component('components.dog_header', ['dog' => $dog])
        @endcomponent

        <div class="uk-padding uk-padding-remove-horizontal uk-padding-remove-bottom uk-flex uk-flex-middle" uk-grid>
            <div class="uk-width-expand">
                <h1 class="title">Grooming</h1>
            </div>
            <div class="uk-width-auto">
                <a class="uk-button uk-button-primary" href="{{ URL::to('/dogs/grooming/new/' . $dog->id) }}">New Grooming Record</a>
            </div>
        </div>

        <div class="spacer-small"></div>

        <div class="content-wrapper">
            <div class="uk-card uk-card-default">
                <div class="uk-card-body uk-padding-remove uk-text-small">
                    <table class="uk-table uk-table-responsive uk-table-divider padded">
                        <thead>
                            <tr>
                                @if($groomingRecords->count() != 0)
                                    <th>Record Type</th>
                                    <th>Value</th>
                                    <th>Date</th>
                                    <th>Normality</th>
                                    <th>Performed By</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($groomingRecords as $groomingRecord)
                            <tr>
                                <td>{{ $groomingRecord->attribute }}</td>
                                <td>{{ $groomingRecord->value }}</td>
                                <td>
                                    {{ date('M j, Y', strtotime($groomingRecord->created_at)) }}
                                </td>
                                <td>
                                    @if($groomingRecord->normality == 0)
                                        Abnormal
                                    @else
                                        Normal
                                    @endif
                                </td>
                                <td>{{ $groomingRecord->performed_by }}</td>
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

        {{ $groomingRecords->links() }}

    </div>

@endsection

@section('scripts')
@endsection