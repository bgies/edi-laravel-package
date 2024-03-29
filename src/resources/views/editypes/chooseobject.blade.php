@extends('edilaravel::layouts.layout')

@section('title', 'Choose Object')


@section('content')



<h2>Choose Object Type</h2>


<div class="container edi-grid">
	<div class="row header">
		<div class="bs-bars float-left">
		</div>
	</div>
	<div class="row header">
		<div class="col col-1 px-1">
<!-- 		
			<button type="button" class="btn bg-light text-success edi-btn-new" id="row_new" name="row_new" 
					data-bs-toggle="tooltip" title="New">
					
  					<span>New +</span> 
				</button>
 -->				
		</div>
		
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
		<div class="col col-4 d-none d-sm-block fs-6">
			<div>Interchange Sender</div>
			<div>Interchange Receiver</div>
		</div>
		
	</div>



@endsection
