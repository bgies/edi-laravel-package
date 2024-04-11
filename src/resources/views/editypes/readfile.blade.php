@extends('edilaravel::layouts.layout')

@section('title', 'Read Files')


@section('content')

<h2>Read File</h2>


<div class="mb-3">
  <label for="formFile" class="form-label">Upload EDI file to read</label>
  <input class="form-control" type="file" id="fileChosen" name="fileChosen" onchange="getAfilename(this.value)">
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