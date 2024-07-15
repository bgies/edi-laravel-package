@extends('edilaravel::layouts.layout')

@section('title', 'Create Segment')


@section('content')
        
	<p>
		<div class="center"><h3> Create Segment </h3></div>
	</p>
	<p>
		@foreach($errors as $error)
			<p class="alert alert-danger">{{ $error }}</p>
		@endforeach	
	</p>	
	<p>
		@foreach($messages as $message)
			<p class="alert alert-info">{{ $message }}</p>
		@endforeach	
	</p>	

	<form id="create=segment-form" name="create=segment-form" action="/edilaravel/editype/createsegment" method="POST">
	   <p class="edi-duplicate-body">
    	   <label for="segment-name" class="form-label">Segment Name</label>
	   	<input type="text" id="segment-name" name="segment-name" class="form-control" value="">
	   </p>
  	   <p class="edi-duplicate-body"> 
     		<label for="edi-standard" class="form-label">EDI Standard</label>   
			<select id="edi-standard" name="edi-standard" class="mb-3 form-select" aria-label=".edi_test_file" >
			   <option value="X12" >X12</option>
   			<option value="EDIFACT" >EDIFACT</option>
	   	</select>
	   </p>
  	   <p class="edi-duplicate-body">Only add an extension str if the segment already exists, and you are creating a duplicate</p>
  	   <p>
         <label for="extension-str" class="form-label">Extension Str</label>
			<input type="text" id="extension-str" name="extension-str" class="form-control" value="">      	   
      </p>
  	   <p class="edi-duplicate-body"> 
     		<label for="is-incoming" class="form-label">Read or Send</label>   
			<select id="is-incoming" name="is-incoming" class="mb-3 form-select" aria-label=".edi_test_file">
			   <option value="1" >Read</option>
   			<option value="0" >Send</option>
	   	</select>
	   </p>
  	   <p class="edi-duplicate-body">
    	   <label for="segment-name" class="form-label">How many elements do you want dummy code for?</label>
	   	<input type="number" id="element-count" name="element-count" class="form-control" value="5">
  	   </p>
      	
	      <div class="modal-footer">
   	     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      	  <button class="btn btn-primary" type="submit">Create Segment</button>
   	   </div>
      	   
      </form>      	   

	
@endsection	