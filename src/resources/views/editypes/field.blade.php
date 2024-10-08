@extends('edilaravel::layouts.layout')

@section('title', 'EDI Type')


@section('content')
<!--
	<div class="">{{ $ediType->edt_name }} - {{ $fieldName }}</div>
 -->	
	@php( $indentLevel = 0)
	@php( method_exists($fieldObject,'getPropertyTypes') ? $propertyTypes = $fieldObject->getPropertyTypes() : $propertyTypes = null)
	@php( $parentObjectName = '' )
	@php( $objName = '' )
	
<!--  	
	<p>{{ print_r(array_keys($objectProperties), true) }}</p>  
 -->
	<br />
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
   		<form class="edi-grid-bg needs-validation" action="/edilaravel/editype/updatefield" method="POST" novalidate>
   			@csrf
   			<input type="hidden" id="ediTypeFieldName" name="ediTypeFieldName" value="{{ $fieldName }}">
   			<input type="hidden" id="ediTypeId" name="ediTypeId" value="{{ $ediType->id }}">

@php( \Log::info('field.blade.php objectProperties: ' . print_r($objectProperties, true))  )
@php( \Log::info('field.blade.php propertyTypes: ' . print_r($propertyTypes, true))  )   			
   			@foreach($objectProperties as $curField => $curFieldValue) 
   			
				@if ( $propertyTypes && isset($propertyTypes[$curField]) )
					@php( $fieldType = $propertyTypes[$curField]->propertyType )
					@php( $propertyAttributes = $propertyTypes[$curField] )
@php( \Log::info('field.blade.php object $propertyTypes $curField: ' . print_r($curField, true))  )
@php( \Log::info('field.blade.php object $propertyAttributes: ' . print_r($propertyAttributes, true))  )					
				@else
@php( \Log::info('field.blade.php propertyTypes else $curField: ' . print_r($curField, true))  )				
					@php( $fieldType = gettype($fieldObject) )
					@php( $propertyAttributes = new \Bgies\EdiLaravel\Lib\PropertyType(
						$fieldType, 0, 255, true, false, null, true, true					
					) )
				@endif
				
				@if ( $propertyAttributes->displayInForm )
					@php( $fullFieldName = (strlen($parentObjectName) > 0 ? $parentObjectName . '.' : '') . $objName . '.' . print_r($curField, true) )
					@php( $adjustedFieldName = Bgies\EdiLaravel\Functions\ObjectFunctions::breakFieldName($curField) ) 
   			
   				
   				@switch($fieldType)
					@case('string')
						<div class="mb-3">
   							<label for="{{ $curField }}" class="form-label edi-field-name">{{ $adjustedFieldName }}</label>
   							<input type="input" class="form-control" id="{{ $curField }}" name="{{ $curField }}" aria-describedby="{{ $curField }}Help" value="{{ $curFieldValue }}">
   							@if (strlen($propertyAttributes->propertyHelp) > 0)
	  							<div class="ps-3">
  									 {{ $propertyAttributes->propertyHelp }} 
								</div> 
							@endif
						</div>
        			@break

					@case('int')
    				@case('integer')
    					<div class="mb-3">
   							<label for="{{ $curField }}" class="form-label edi-field-name">{{ $adjustedFieldName }}</label>
   							<input type="input" class="form-control" id="{{ $curField }}" name="{{ $curField }}" aria-describedby="{{ $curField }}Help" value="{{ $curFieldValue }}">
							@if (strlen($propertyAttributes->propertyHelp) > 0)
  								<div class="ps-3">
									 {{ $propertyAttributes->propertyHelp }} 
								</div> 
							@endif
						</div>
        				
        			@break
        			
					@case('bool')
    				@case('boolean')
    					<div class="mb-3">
        					<div class="form-check">
        						<input type="hidden" name="{{ $curField }}" value="0">
  								<input class="form-check-input" type="checkbox" value="1" name="{{ $curField }}" id="{{ $curField }}" {{ ($propertyAttributes->canEdit ? '' : 'disabled') }}  {{ ($curFieldValue == 1 ? 'checked' : '') }}>
							   <label class="form-check-label edi-field-name" for="{{ $curField }}">
								    	{{ $adjustedFieldName }}
  								</label>
  								@if (strlen($propertyAttributes->propertyHelp) > 0)
	  								<div class="ps-3">
  										 {{ $propertyAttributes->propertyHelp }} 
									</div> 
								@endif
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
    	@php( \Log::info('field.blade.php object $curField: ' . print_r($curField, true))  )					
		@php( \Log::info('field.blade.php object $curFieldValue: ' . print_r($curFieldValue, true))  )
		    						    
    							{{ Bgies\EdiLaravel\Functions\BladeFunctions::showObject('', $curField, $curFieldValue, $indentLevel) }}
    						@endif
    						@php( $indentLevel--)
    					   
        				</div>
        			@break
        			
					@case('textarea')
						<div class="mb-3">
							<label for="{{ $curField }}" class="form-label">{{ $adjustedFieldName }}</label>
							<textarea class="form-control" name="{{ $curField }}" id="{{ print_r($curField, true) }}" rows="{{ $propertyAttributes->minLength }}">{{ print_r($curFieldValue, true) }}</textarea>
						
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
   				
   				@endif
   			@endforeach
   			
   			<div class="form-button mt-3">
   				<button type="button" class="btn btn-warning" data-bs-dismiss="modal" onclick="cancelEdit()">Cancel</button>
    			<button id="submit" class="btn btn-primary" type="submit">Submit form</button>
 
  			</div>
   			
   		</form>  
   		</div>  
   </div>


   <script>
		function cancelEdit() {
 			window.location.replace( "/edilaravel/editype/{{ $ediType->id }} . '/edit");
			return false; 
	 	}
	 		



	</script>
    
@endsection
