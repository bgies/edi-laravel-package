@extends('edilaravel::layouts.layout')

@section('title', 'View File')


@section('content')

<h2>View EDI File</h2>




<div class="container edi-grid">
	<div class="row header">EDI File</div>
	<div class="row header">
		<div class="col col-1">
			Id
		</div>
		<div class="col col-1">
			Type
		</div>
		<div class="col col-1">
			Can-celled
		</div>
		<div class="col col-1">
			Test File
		</div>
		
		<div class="col">
			File Name
		</div>
		<div class="col col-2 d-none d-sm-block">
			Date
		</div>
		<div class="col col-1 d-none d-sm-block">
			Control Number
		</div>
		<div class="col col-1 d-none d-sm-block">
			Records Parsed
		</div>
		<div class="col col-2 d-none d-sm-block">
			Read Date
		</div>
		
	</div>

	@forelse ($ediFiles as $ediFile)

		<div class="row">
			<div class="col col-1">
				<a href="/edilaravel/manage/file/{{ $ediFile->id }}/view" >{{ $ediFile->id }}</a>
			</div>
			<div class="col col-1">
				<a href="/edilaravel/manage/{{ $ediFile->id }}/view" >{{ $ediFile->edt_name }}</a>
			</div>
			<div class="col col-1">
				<a href="/edilaravel/manage/{{ $ediFile->id }}/view" >{{ $ediFile->edf_cancelled }}</a>
			</div>
			<div class="col col-1">
				<a href="/edilaravel/manage/{{ $ediFile->id }}/view" >{{ $ediFile->edf_test_file }}</a>
			</div>
			
			<div class="col ">   
   				<a href="/edilaravel/ediFile/{{ $ediFile->id }}/edit" >{{ $ediFile->edf_filename }}</a>
   			</div>
			<div class="col col-2 d-none d-sm-block text-center">   
   				{{ $ediFile->edf_datetime }}
   			</div>
			<div class="col col-1 d-none d-sm-block text-end">   
   				{{ $ediFile->edf_transaction_control_number }}
   			</div>
			<div class="col col-1 d-none d-sm-block fs-6">
   				<div>{{ $ediFile->edf_records_parsed }}</div>
   				<div></div>
   				
   			</div>
			<div class="col col-2 d-none d-sm-block fs-6">   
   				<div></div>
   			</div>
   			
   		</div>	

   		
	@empty
   		<p class="edi-sub-header"><strong> No Incoming EDI Files yet</strong></p>
	@endforelse   		
   
   {{ $ediFiles->links() }}
   
</div>

@endsection
