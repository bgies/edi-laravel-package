@extends('edilaravel::layouts.layout')

@section('title', 'Outgoing EDI Files')


@section('content')



<h2>Outgoing EDI Files</h2>






<div>&nbsp;</div>
<div class="container edi-grid">
	<div class="row header">Outgoing</div>
	<div class="row header">
		<div class="col col-1">
			Id
		</div>
		<div class="col">
			Name
		</div>
		<div class="col col-2 d-none d-sm-block">
			Date
		</div>
		<div class="col col-2 d-none d-sm-block">
			Control Number
		</div>
		<div class="col col-4 d-none d-sm-block">
			Interchange Sender/Receiver
		</div>
		
	</div>

	@forelse ($ediOutgoingFiles as $ediFile)

		<div class="row">
			<div class="col col-1">
				<a href="/edilaravel/manage/{{ $ediFile->id }}/view" >{{ $ediFile->id }}</a>
			</div>
			<div class="col ">   
   				<a href="/edilaravel/ediFile/{{ $ediFile->id }}/edit" >{{ $ediFile->edt_name }}</a>
   			</div>
			<div class="col col-2 d-none d-sm-block text-center">   
   				{{ $ediFile->edt_enabled }}
   			</div>
			<div class="col col-2 d-none d-sm-block text-end">   
   				{{ $ediFile->edt_control_number }}
   			</div>
			<div class="col col-4 d-none d-sm-block fs-6">   
   				<div>{{ $ediFile->interchange_sender_id }}</div>
   				<div>{{ $ediFile->interchange_receiver_id }}</div>
   			</div>
   			
   		</div>	

   		
	@empty
   		<p class="edi-sub-header"><strong> No Outgoing EDI Files yet</strong></p>
	@endforelse   		
   
   
</div>



@endsection

   