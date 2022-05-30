@extends('layouts.layout')

@section('title', 'EDI Types')


@section('content')



<h2>Showing all EDI Types</h2>

<div class="container">
	<div class="row header">
		<div class="col col-1">
			id
		</div>
		<div class="col">
			Name
		</div>
		<div class="col col-2 d-none d-sm-block">
			Enabled
		</div>
		<div class="col col-2 d-none d-sm-block">
			Control Number
		</div>
		<div class="col col-2 d-none d-sm-block">
			Interchange Sender/Receiver
		</div>
		
	</div>

	@forelse ($ediTypes as $ediType)
	
   		{{-- $beforeProcessObject = (object) unserialize($ediType->edt_before_process_object); --}} 
		<div class="row">
			<div class="col col-1">
				<a href="/edilaravel/editype/{{ $ediType->id }}/edit" >{{ $ediType->id }}</a>
			</div>
			<div class="col ">   
   				<a href="/edilaravel/editype/{{ $ediType->id }}/edit" >{{ $ediType->edt_name }}</a>
   			</div>
			<div class="col col-2 d-none d-sm-block text-center">   
   				{{ $ediType->edt_enabled }}
   			</div>
			<div class="col col-2 d-none d-sm-block text-end">   
   				{{ $ediType->edt_control_number }}
   			</div>
			<div class="col col-2 d-none d-sm-block fs-6">   
   				<div>{{ $ediType->interchange_sender_id }}</div>
   				<div>{{ $ediType->interchange_receiver_id }}</div>
   			</div>
   			
   		</div>	

   		
	@empty
   		<p> 'No EDI Types yet' </p>
	@endforelse   		
   
   
</div>

@endsection

   
