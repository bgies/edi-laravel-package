@extends('edilaravel::layouts.layout')

@section('title', 'EDI Files')


@section('content')

<div class="container edi-grid">
	<div class="row header text-center" center>
		<div class="text-center"><h2>EDI File</h2></div>
	</div>
	<div class="row header">
		<div class="col col-1">Id</div>
		<div class="col col-5">File Name</div>
		<div class="col col-1">Can celled</div>
		<div class="col col-1">Test File</div>		
	</div>
	<div class="row header">
		<div class="col col-1">{{ $ediFile->id }}</div>
		<div class="col col-5">{{ $ediFile->edf_filename }}</div>	
		<div class="col col-1">
			<input class="form-check-input" type="checkbox" value="{{ $ediFile->edf_cancelled }}" id="edf_cancelled" {{ $ediFile->edf_cancelled == '1' ? 'checked' : '' }}>
		</div>
		<div class="col col-1">
			<input class="form-check-input" type="checkbox" value="{{ $ediFile->edf_test_file}}" id="edf_test_file" {{ $ediFile->edf_test_file == '1' ? 'checked' : '' }}>		
		</div>				
	</div>
</div>
<br />
<div class="container edi-grid">
	@forelse ($fileArray as $fileContent)
		<div class="row">
			<div class="col col-12">
			   {{ $fileContent }}
			</div>
   	</div>	
	@empty
   		<p class="edi-sub-header"><strong> No Incoming EDI Files yet</strong></p>
	@endforelse   		
</div>
<br />
<div class="container edi-grid">
	<div class="row header text-center">Raw File</div>
	<div class="row">{{ $fileContents }}</div>
</div>

@endsection
