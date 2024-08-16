@extends('edilaravel::layouts.layout')

@section('title', 'Read Files')


@section('content')
<br />
<p class="edi-file-background bg-light">
<h4>From the File</h4>
<div class="mb-3"><span class="fw-bold">(ISA-) Interchange Receiver ID : </span>{{ $ediObj->interchangeReceiverID }}</div>
<div class="mb-3"><span class="fw-bold">(ISA-) Interchange Sender ID : </span>{{ $ediObj->interchangeSenderID }}</div>
<div class="mb-3"><span class="fw-bold">(GS-) Application Receiver Code : </span>{{ $ediObj->applicationReceiverCode }}</div>
<div class="mb-3"><span class="fw-bold">(GS-) Application Sender Code : </span>{{ $ediObj->applicationSenderCode }}</div>
<div class="mb-3"><span class="fw-bold">(ST-) Transaction Set Identifier : </span>{{ $ediObj->transactionSetIdentifier }}</div>
<div class="mb-3"><span class="fw-bold">EDI Standard : </span>{{ $ediObj->ediStandard }}</div>
<div class="mb-3"><span class="fw-bold">EDI Version : </span>{{ $ediObj->ediVersionReleaseCode }}</div>
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
	<div>Data</div>
	<pre>
		<p id="data-wrap">{{ $data }}</p>
	</pre>
	<button onclick="copyJSON()">Copy JSON</button>
</p>

<br />


<p class="bg-success bg-opacity-10">
	@foreach($fileArray as $fileEntry)
		<div class="bg-success bg-opacity-10">
			{{ $fileEntry }}
		</div>
	@endforeach
</p>






<div class="mb-3">
  <label for="formFile" class="form-label">Upload EDI file to read</label>
  <input class="form-control" type="file" id="fileChosen" name="fileChosen" onchange="getAfilename(this.value)">
</div>


<script>

	function copyJSON() {
		let text = document.getElementById('data-wrap').innerHTML;
		
		alert("copyJSON");
		alert("copyJSON");
		
		navigator.permissions.query({ name: "write-on-clipboard" }).then((result) => {
		  if (result.state == "granted" || result.state == "prompt") {
    			alert("Write access granted!");
  		  }
		});
		
  		const copyContent = async () => {
	 	  try {
   			   await navigator.clipboard.writeText(text);
      			console.log('Content copied to clipboard');
    		} catch (err) {
	      		console.error('Failed to copy: ', err);
    		}
  		}
	}
  			
	
/*	
	function testCopyJSON() {
	  // Get the text field
	  var copyTextElement = document.getElementById("data-wrap");

	  // Select the text field
	  var copyText = copyTextElement.innerHTML;
//	  copyTextElement.select();
//	  copyTextElement.setSelectionRange(0, 99999); // For mobile devices

		// Copy the text inside the text field
	  navigator.clipboard.writeText(copyTextElement.value);

	  // Alert the copied text
	  alert("Copied the text: " + copyTextElement.value);
	} 
*/

</script>

@endsection