@extends('edilaravel::layouts.layout')

@section('title', 'EDI Dashboard')


@section('content')



<div class="container edi-grid">

	<div class="row header text-center"><h3>EDI Files</h3></div>
	<div class="row header text-center">
		@csrf
		<div class="col col-1 overflow-hidden"></div>
		<div class="col col-1 overflow-hidden">
			<select class="form-control w-100" id="ch_status">
				<option value="" {{ $status === null ? 'selected' : '' }}>
                Select Status
            </option>
            <option value="1" {{ $status === '1' ? 'selected' : '' }}>
                Active
            </option>
            <option value="0" {{ $status === '0' ? 'selected' : '' }}>
                Cancelled
            </option>
			</select>
		</div>	
	<div class="row header">
		<div class="col col-1 overflow-hidden">
			Id
		</div>
		<div class="col col-1 overflow-hidden">
			Can-celled
		</div>
		<div class="col col-1 overflow-hidden">
			Acknowledged
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
		<div class="col col-3 d-none d-sm-block">
			Interchange Sender/Receiver
		</div>
		
	</div>

	@forelse ($ediFiles as $ediFile)

		<div class="row">
			<div class="col col-1 overflow-hidden">
				<a href="/edilaravel/manage/file/view/{{ $ediFile->id }}" >{{ $ediFile->id }}</a>
			</div>
			<div class="col col-1 overflow-hidden">
				<input class="form-check-input" type="checkbox" value="{{ $ediFile->edf_cancelled }}" id="edf_cancelled" {{ $ediFile->edf_cancelled == '1' ? 'checked' : '' }}>		
			</div>
			<div class="col col-1 overflow-hidden">
				<input class="form-check-input" type="checkbox" value="{{ $ediFile->edf_acknowledged }}" id="edf_acknowledged" {{ $ediFile->edf_acknowledged == '1' ? 'checked' : '' }}>		
			</div>
			<div class="col overflow-hidden">   
   				<a href="/edilaravel/ediFile/{{ $ediFile->id }}/edit" >{{ $ediFile->edf_filename }}</a>
   			</div>
			<div class="col col-2 d-none d-sm-block text-center overflow-hidden">   
   				{{ $ediFile->edf_datetime }}
   			</div>
			<div class="col col-2 d-none d-sm-block text-end">   
   				{{ $ediFile->edf_transaction_control_number }}
   			</div>
			<div class="col col-3 d-none d-sm-block fs-6">   
   				<div>{{ $ediFile->interchange_sender_id }}</div>
   				<div>{{ $ediFile->interchange_receiver_id }}</div>
   			</div>
   			
   		</div>	

   		
	@empty
   		<p class="edi-sub-header"><strong> No Incoming EDI Files yet</strong></p>
	@endforelse   		
   
   {{ $ediFiles->links() }}
   
</div>



@endsection

   