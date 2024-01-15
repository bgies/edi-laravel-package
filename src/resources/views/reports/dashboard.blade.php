@extends('layouts.layout')

@section('title', 'EDI Reports')


@section('content')



<h2>EDI Reports</h2>




<div class="container edi-grid">
	<div class="row header">
		<div class="col col-1">
			Selected
		</div>
		<div class="col col-1">
			Id
		</div>
		<div class="col col-2">
			Name
		</div>
		<div class="col d-none d-sm-block">
			Description
		</div>
<!-- 		
		<div class="col col-2 d-none d-sm-block">
			Control Number
		</div>
 -->		
	</div>

	@forelse ($ediReports as $ediFile)

		<div class="row">
			<div class="col col-1">
				<input type="checkbox" id="row{{ $ediFile->id }}" name=""row{{ $ediFile->id }}">
			</div>
			<div class="col col-1">
				<a href="/edilaravel/manage/{{ $ediFile->id }}/view" >{{ $ediFile->id }}</a>
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
			<div class="col col-4 d-none d-sm-block fs-6">   
   				<div>{{ $ediType->interchange_sender_id }}</div>
   				<div>{{ $ediType->interchange_receiver_id }}</div>
   			</div>
   			
   		</div>	

   		
	@empty
   		<p> 'No EDI Reports yet' </p>
	@endforelse   		
   
   
</div>

@endsection

   