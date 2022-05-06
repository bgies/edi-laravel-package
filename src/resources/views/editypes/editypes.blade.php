<h2>Showing all EDI Types</h2>



@forelse ($ediTypes as $ediType)
    <li>{{ $ediType->edt_name }}</li>
    <li>{{ $ediType->edt_is_incoming }}</li>
@empty
    <p> 'No EDI Types yet' </p>
@endforelse