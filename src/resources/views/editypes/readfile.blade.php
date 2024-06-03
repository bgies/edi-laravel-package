@extends('edilaravel::layouts.layout')

@section('title', 'Read Files')


@section('content')

<h2>Read File</h2>
<p>To manually read a file, place it in the storage/edifile/To_Read directory, and 
it will show up in a list here, or you can choose it with the File Picker</p>
<p>
		@foreach($fileList as $file)
			<div class="mb-3">
				<a href="/edilaravel/editype/read/manually/{{ $file }}">{{ $file }}</a>  
				
			</div>
		@endforeach
</p>
<br/>

<div class="mb-3">
	<form method="POST" action="/edilaravel/editype/read/manually/" enctype="multipart/form-data">
		<label for="formFile" class="form-label">Upload EDI file to read</label>
		<input class="form-control" type="file" id="fileChosen" name="fileChosen[]" onchange="getAfilename(this.value)">
		<div class="mb-3 mt-1">
         <button type="submit" value="submit" class="btn btn-primary">Upload</button>
      </div>
		
	</form>	
</div>


<script>

	var input = document.getElementById("fileChosen");
	
	if (input) {
		var filename = input.files[0].name;
		}	

	function getAfilename(val){ 
	   
		alert(val);

	}


</script>

@endsection