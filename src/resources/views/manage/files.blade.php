@extends('edilaravel::layouts.layout')

@section('title', 'Edi Files')


@section('content')



<div class="container edi-grid">
	<div class="row header">
		<div class="text-center"><h2>EDI Files</h2></div>
	 </div>
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
		
		<div class="col col-2">
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
				<a href="/edilaravel/manage/file/view/{{ $ediFile->id }}" >{{ $ediFile->id }}</a>
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
			
			<div class="col col-2">   
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
