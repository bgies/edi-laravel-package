@extends('edilaravel::layouts.layout')

@section('title', 'EDI Users')


@section('content')



<h2>EDI Users</h2>




<div class="container edi-grid">
	<div class="row header">
		<div class="col col-1">
			Id
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
		<div class="col col-4 d-none d-sm-block">
			Interchange Sender/Receiver
		</div>
		
	</div>

	@forelse ($ediUsers as $user)

		<div class="row">
			<div class="col col-1">
				<a href="/edilaravel/manage/{{ $ediFile->id }}/view" >{{ $user->id }}</a>
			</div>
			<div class="col ">   
   				<a href="/edilaravel/editype/{{ $ediType->id }}/edit" >{{ $user->name }}</a>
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
   		<p><strong>No EDI Users yet </strong></p>
	@endforelse   		
   
   
</div>

@endsection

   