@extends('layouts.layout')

@section('title', 'PHP Information')


@section('content')

<h2>PHP Info</h2>

<div> @php( phpinfo() )</div>


@endsection

