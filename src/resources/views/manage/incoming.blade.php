@extends('edilaravel::layouts.layout')

@section('title', 'EDI Files')


@section('content')

<h2>EDI Files</h2>


<div class="container edi-grid">
	<div class="row header">EDI Files</div>
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
		<div class="col col-2 d-none d-sm-block">
			Read Attempts
		</div>
		<div class="col col-2 d-none d-sm-block">
			Read Date
		</div>
		
	</div>

	@forelse ($ediFiles as $ediFile)

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
			<div class="col col-2 d-none d-sm-block fs-6">   
   				<div>{{ $ediFile->ein_read_attempts }}</div>
   				<div>{{ $ediFile->ein_read_successful }}</div>
   			</div>
			<div class="col col-2 d-none d-sm-block fs-6">   
   				<div>{{ $ediFile->ein_read_datetime }}</div>
   			</div>
   			
   		</div>	

   		
	@empty
   		<p class="edi-sub-header"><strong> No Incoming EDI Files yet</strong></p>
	@endforelse   		
   
   {{ $ediFiles->links() }}
   
</div>

@endsection
