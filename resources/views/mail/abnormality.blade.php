@component('mail::message')
# Abnormality Alert

A new dog abnormality has been recorded.

@component('mail::table')
	|                          |                         |
	| :----------------------- | ----------------------: |
	| <strong>Dog ID:</strong> | {{ $dog->internal_id }} |
	| <strong>Name:</strong>   | {{ $dog->name }}        |
	| <strong>Gender:</strong> | {{ $dog->sex }}         |
	| <strong>D.O.B:</strong>  | {{ $dog->dob }}         |
@endcomponent

@component('mail::table')
	| Record Type       | Value        |
	| :---------------- | ------------:|
	| {{ $recordType }} | {{ $value }} |
@endcomponent

@component('mail::panel')
	<p><strong>Notes:</strong></p>
	{{ $comments }}
@endcomponent

@endcomponent