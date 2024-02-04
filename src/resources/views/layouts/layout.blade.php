@include('edilaravel::partials.headcontent')

<body>

@include('edilaravel::partials.navbar')


<div class="container">
    @yield('content')
</div>

<!--    
      <div class="sidebar-wrapper">
        @section('layouts.sidebar')
        		@parent
            
            <p>This is appended to the master sidebar layout.blade</p>
        @show
 		</div>	
 -->
  
   		
@include('edilaravel::partials.footercontent')   		
   		
        
