<div class="edi-object {{ $indentLevel == 1 ? 'edi-padleft1' : 'edi-padleft2' }}">
	<div class="edi-object-wrapper">

	   <div><strong>{{ $objName }}</strong></div>	
	   <div class="{{ $indentLevel == 1 ? 'edi-padleft1' : 'edi-padleft2' }}">
	   	
		   @php( $curObjectProperties = Bgies\EdiLaravel\Functions\ObjectFunctions::getVars($inObj) )
		   @php( method_exists($inObj,'getPropertyTypes') ? $propertyTypes = $inObj->getPropertyTypes() : $propertyTypes = null)

			@foreach($curObjectProperties as $curObjectField => $curObjectFieldValue) 
				@if ( $propertyTypes && isset($propertyTypes[$curObjectField]) )
					@php( $fieldType = $propertyTypes[$curObjectField]->propertyType )
					@php( $propertyAttributes = $propertyTypes[$curObjectField] )
				@else
					@php( $fieldType = gettype($curObjectField) )
					@php( $propertyAttributes = new \Bgies\EdiLaravel\Lib\PropertyType(
						$fieldType, 0, 255, true, false, null, true, true					
					) )
				@endif
				
				@if ( $propertyAttributes->displayInForm )
					@php( $fullFieldName = (strlen($parentObjectName) > 0 ? $parentObjectName . '.' : '') . $objName . '.' . print_r($curObjectField, true) )
					@php( $adjustedFieldName = Bgies\EdiLaravel\Functions\ObjectFunctions::breakFieldName($curObjectField) ) 
					
					
				
				   @switch($fieldType)

        				@case('array')
						   	<div class="mb-3">
    						   {{ $adjustedFieldName }}	array...
    						   @if (isset($curObjectFieldValue))
    				   				{{ print_r($curObjectFieldValue, true) }}
		    				   	@endif
    						</div>
        				
        				@break

        				        			
        				@case('bool')
        				@case('boolean')
        				   @php( \Log::info('BOOL curObjectField: ' . $curObjectField . '  curObjectFieldValue: ' . $curObjectFieldValue) )
        					<div class="mb-3">
        						
        						<div class="form-check">
        							<input type="hidden" name="{{ $fullFieldName }}" id="{{ $curObjectField }}" value="0">
  									<input class="form-check-input" type="checkbox" value="1" name="{{ $fullFieldName }}" id="{{ $curObjectField }}" {{ ($propertyAttributes->canEdit ? '' : 'disabled') }} {{ ($curObjectFieldValue == true ? 'checked' : '') }} {{ ($curObjectFieldValue == 1 ? 'checked' : '') }} >
								   <label class="form-check-label" for="{{ $curObjectField }}">
								    	{{ $adjustedFieldName }}
  									</label>
								</div>
        					</div>
        				
        				@break
        				
        				
        				@case('datetime')
        					<div class="mb-3">
        					Current Field: {{ $curObjectField }}
    						Current Value: {{ print_r($curObjectFieldValue, true) }}
    						<div>Default...  Field Type: {{ $fieldType }}</div>
        				
        					</div>
						@break

						
    					@case('integer')
    						<div class="mb-3">
   								<label for="{{ $curObjectField }}" class="form-label">{{ $adjustedFieldName }}</label>
   								<input type="input" class="form-control" name="{{ $fullFieldName }}" id="{{ print_r($curObjectField, true) }}" aria-describedby="{{ print_r($curObjectField, true) }}Help" value="{{ print_r($curObjectFieldValue, true) }}">
								<div id="{{ $curObjectField }}Help" class="form-text">Help</div>
							</div>
        				
        				@break
        				
				   
						@case('string')
 					
							<div class="mb-3">
   								<label for="{{ $curObjectField }}" class="form-label">{{ $adjustedFieldName }}</label>
   								<input type="input" class="form-control" name="{{ $fullFieldName }}" id="{{ $curObjectField }}" aria-describedby="{{ print_r($curObjectField, true) }}Help" value="{{ print_r($curObjectFieldValue, true) }}">
								<div id="{{ $curObjectField }}Help" class="form-text"></div>
							</div>
						
        				@break
        				
						@case('textarea')
							<div class="mb-3">
								<label for="{{ $curObjectField }}" class="form-label">{{ $adjustedFieldName }}</label>
  								<textarea class="form-control" name="{{ $fullFieldName }}" id="{{ print_r($curObjectField, true) }}" rows="{{ $propertyAttributes->minLength }}">{{ print_r($curObjectFieldValue, true) }}</textarea>
						
							</div>
						@break
        			
        				@case('default')
    					   	Current Field: {{ $curObjectField }}
    						Current Value: {{ print_r($curObjectFieldValue, true) }}
    					   @if (isset($fieldType))
	    						<div>Default...  Field Type: {{ $fieldType }}</div>
	    					@else
	    					   <div>Default...  Field Type: NULL</div>
        					@endif
        				@break
        				
        			@endswitch
        				
		    	@endif
    					  
	    	@endforeach
    	</div>
	</div>
</div>