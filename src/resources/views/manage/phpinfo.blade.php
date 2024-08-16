@extends('edilaravel::layouts.layout')

@section('title', 'PHP Info')


@section('content')

<div>
<pre>
{{ phpinfo() }}
</pre>
</div>

@endsection