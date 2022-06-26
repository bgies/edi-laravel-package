<div class="edi-object">
	<div class="edi-object-wrapper">
	   <div><strong>{{ $objName }}</strong></div>
	
	   <div class="{{ $indentLevel == 1 ? 'edi-padleft1' : 'edi-padleft2' }}">
		   @php( $curObjectProperties = Bgies\EdiLaravel\Functions\ObjectFunctions::getVars($inObj) )
		   @php( method_exists($inObj,'getPropertyTypes') ? $propertyTypes = $inObj->getPropertyTypes() : $propertyTypes = null)

			@foreach($curObjectProperties as $curObjectField => $curObjectFieldValue) 
				@if ( $propertyTypes && isset($propertyTypes[$curObjectField]) )
					@php( $fieldType = $propertyTypes[$curObjectField]->propertyType )
				@else
					@php( $fieldType = gettype($curObjectField) )
				@endif
				
				
				   @switch($fieldType)
						@case('string')
 					
							<div class="mb-3">
   								<label for="{{ $curObjectField }}" class="form-label">{{ $curObjectField }}</label>
   								<input type="input" class="form-control" id="{{ print_r($curObjectField, true) }}" aria-describedby="{{ print_r($curObjectField, true) }}Help" value="{{ print_r($curObjectFieldValue, true) }}">
								<div id="{{ $curObjectField }}Help" class="form-text"></div>
							</div>
						
        				@break
        				
    					@case('integer')
    						<div class="mb-3">
   								<label for="{{ $curObjectField }}" class="form-label">{{ $curObjectField }}</label>
   								<input type="input" class="form-control" id="{{ print_r($curObjectField, true) }}" aria-describedby="{{ print_r($curObjectField, true) }}Help" value="{{ print_r($curObjectFieldValue, true) }}">
								<div id="{{ $curObjectField }}Help" class="form-text">Help</div>
							</div>
        				
        				
        				@case('array')
						   	<div class="mb-3">
    						   {{ $curObjectField }} 	array...
    						   @if (isset($curObjectFieldValue))
    				   				{{ print_r($curObjectFieldValue, true) }}
		    				   	@endif
    						</div>
        				
        				@break
        			
        				@case('bool')
        				@case('boolean')
        					<div class="mb-3">
        						<div class="form-check">
  									<input class="form-check-input" type="checkbox" value="{{ $curObjectFieldValue }}" id="{{ $curObjectField }}">
								   <label class="form-check-label" for="{{ $curObjectField }}">
								    	{{ $curObjectField }}
  									</label>
								</div>
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
        				
		    	
    					  
	    	@endforeach
    	</div>
	</div>
</div>