@extends('edilaravel::layouts.layout')

@section('title', 'Read Files')


@section('content')
<br />
<p class="edi-file-background bg-light">
<h4>From the File</h4>
<div class="mb-3"><span class="fw-bold">(ISA-) Interchange Receiver ID : </span>{{ $ediObj->interchangeReceiverID }}</div>
<div class="mb-3"><span class="fw-bold">(ISA-) Interchange Sender ID : </span>{{ $ediObj->interchangeSenderID }}</div>
<div class="mb-3"><span class="fw-bold">(GS) Application Receiver Code : </span>{{ $ediObj->applicationReceiverCode }}</div>
<div class="mb-3"><span class="fw-bold">(GS) Application Sender Code : </span>{{ $ediObj->applicationSenderCode }}</div>
<div class="mb-3"><span class="fw-bold">EDI Standard : </span>{{ $ediObj->ediStandard }}</div>
<div class="mb-3"><span class="fw-bold">Is Incoming : </span>{{ $ediObj->fileDirection }}</div>
</p>

@if ($retValues->getErrorCount() > 0) 
<p class="bg-success bg-opacity-10" >
	@php $errorList = $retValues->getErrorList() @endphp
	@foreach($errorList as $errorEntry)
		<div class="mb-3 ms-1 bg-danger bg-opacity-75 text-white ps-2">
			{{ $errorEntry }}
		</div>
	@endforeach
</p>
<br />
@endif

@if ($retValues->getMessageCount() > 0) 
<p>
	@php $messageList = $retValues->getMessages() @endphp
	@foreach($messageList as $message)
		<div class="mb-3 bg-success bg-opacity-75 text-white">
			{{ $message }}
		</div>
	@endforeach
</p>
<br />
@endif

<p class="bg-success bg-opacity-10">
	@foreach($fileArray as $fileEntry)
		<div class="mb-3 bg-success bg-opacity-10">
			{{ $fileEntry }}
		</div>
	@endforeach
</p>






<div class="mb-3">
  <label for="formFile" class="form-label">Upload EDI file to read</label>
  <input class="form-control" type="file" id="fileChosen" name="fileChosen" onchange="getAfilename(this.value)">
</div>


<script>
/*
	var input = document.getElementById("fileChosen");
	
	if (input) {
		var filename = input.files[0].name;
		}	

	function getAfilename(val){    
		alert(val);

	}
*/

</script>

@endsection