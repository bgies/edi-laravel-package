@extends('layouts.layout')

@section('title', 'EDI Type')


@section('content')
<!--
	<div class="">{{ $ediType->edt_name }} - {{ $fieldName }}</div>
 -->	
	@php( $indentLevel = 0)
	@php( method_exists($fieldObject,'getPropertyTypes') ? $propertyTypes = $fieldObject->getPropertyTypes() : $propertyTypes = null)
	
<!-- 	
	<p>{{ print_r(array_keys($objectProperties), true) }}</p>  
 -->

   <div class="container edi-grid edi-grid-bg column-gap: 10px">
   		<div class="row">
   			@if (! $fieldObject)
				<h5>Null</h5>
				<div class="mb-3">
					<label for="edt_edi_standard" class="form-label">Transaction Set</label>   
					<select class="mb-3 form-select" aria-label=".edt_transaction_set_name">
		   				<option value="100" {{ $ediType->edt_transaction_set_name == '100' ? 'selected' : '' }}>100 - Insurance Plan Description</option>
						<h5><a href="">Choose Object Type</a></h5>
					</select>
				</div>
			@else
				<div class="edi-grid-title">{{ get_class($fieldObject) }}</div>
			@endif   		
   		</div>
   		<form class="edi-grid-bg needs-validation" action="/edilaravel/updatefield" method="POST" novalidate>
   		
   			<input type="hidden" id="ediTypeFieldName" name="ediTypeFieldName" value="{{ $fieldName }}">
   			<input type="hidden" id="ediTypeId" name="ediTypeId" value="{{ $ediType->id }}">
   			
   			@foreach($objectProperties as $curField => $curFieldValue) 
   				@php( $fieldType = gettype($fieldObject->$curField) ) 
   				@php( $propertyAttributes = $propertyTypes[$curField] )
 				@php( $adjustedFieldName = Bgies\EdiLaravel\Functions\ObjectFunctions::breakFieldName($curField) )
   				
   				@switch($fieldType)
					@case('string')
						<div class="mb-3">
   							<label for="{{ $curField }}" class="form-label edi-field-name">{{ $adjustedFieldName }}</label>
   							<input type="input" class="form-control" id="{{ $curField }}" name="{{ $curField }}" aria-describedby="{{ $curField }}Help" value="{{ $curFieldValue }}">
							<div id="{{ $curField }}Help" class="form-text"></div>
						</div>
        			@break

    				@case('integer')
    					<div class="mb-3">
   							<label for="{{ $curField }}" class="form-label edi-field-name">{{ $adjustedFieldName }}</label>
   							<input type="input" class="form-control" id="{{ $curField }}" name="{{ $curField }}" aria-describedby="{{ $curField }}Help" value="{{ $curFieldValue }}">
							<div id="{{ $curField }}Help" class="form-text">Help</div>
						</div>
        				
        			@break

    				@case('boolean')
    					<div class="mb-3">
        					<div class="form-check">
  								<input class="form-check-input" type="checkbox" value="{{ $curFieldValue }}" name="{{ $curField }}" id="{{ $curField }}" {{ ($propertyAttributes->canEdit ? '' : 'disabled') }}>
							   <label class="form-check-label edi-field-name" for="{{ $curField }}">
								    	{{ $adjustedFieldName }}
  									</label>
								</div>
        				</div>
        			@break

					@case('array')
    					<div class="mb-3">
    					   {{ $curField }} 	array...
    					   @if (isset($curFieldValue))
    					   		{{ print_r($curFieldValue, true) }}
    					   	@endif
    					   
        				</div>
        			@break

					@case('object')
    					<div class="mb-3">
    						@php( $indentLevel++)
    						@if ( isset($curField) && isset($curFieldValue) )
    						    
    							{{ Bgies\EdiLaravel\Functions\BladeFunctions::showObject('', $curField, $curFieldValue, $indentLevel) }}
    						@endif
    						@php( $indentLevel--)
    					   
        				</div>
        			@break


    				@default
    					<div class="mb-3">
    					   	Current Field: {{ $curField }}
    						Current Value: {{ print_r($curFieldValue, true) }}
    					   @if (isset($fieldType))
	    						<div>Default...  Field Type: {{ $fieldType }}</div>
	    					@else
	    					   <div>Default...  Field Type: NULL</div>
        					@endif
        				</div>	
				@endswitch
   				
   			@endforeach
   			
   			<div class="form-button mt-3">
    			<button id="submit" class="btn btn-primary" type="submit">Submit form</button>
 
  			</div>
   			
   		</form>  
   		</div>  
   </div>




    
@endsection
