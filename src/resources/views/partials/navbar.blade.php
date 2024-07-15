<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
	<div class="container-fluid">
		<a class="navbar-brand" href="#">EDI Laravel</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      		<span class="navbar-toggler-icon"></span>
    	</button>		
    
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
      			<ul class="navbar-nav mr-auto">
      			
						<li class="nav-item dropdown">
          				<a class="nav-link dropdown-toggle {{ $navPage=='dashboard' ? 'active' : '' }}" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            				Dashboard
          				</a>
          				<ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
           					<li>
           						<a class="dropdown-item" href="/edilaravel/dashboard/dashboard">Dashboard</a>
           					</li>
				            <li><a class="dropdown-item" href="/edilaravel/manage/files">EDI Files</a></li>
          				</ul>
        				</li>      			
      			
						<li class="nav-item dropdown">
          				<a class="nav-link dropdown-toggle {{ $navPage=='manage' ? 'active' : '' }}" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            				Manage
          				</a>
          				<ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
           					<li>
           						<a class="dropdown-item" href="/edilaravel/manage/index">Dashboard</a>
           					</li>
				            <li>
				            	<a class="dropdown-item" href="/edilaravel/manage/files">EDI Files</a>
				            </li>
				            <li>
				            	<a class="dropdown-item" href="/edilaravel/manage/readfile">Read File</a>
				            </li>

          				</ul>
        				</li>        			
      			

         			<li class="nav-item">
            			<a class="nav-link {{ $navPage=='reports' ? 'active' : '' }}" {{ $navPage=='reports' ? 'aria-current="page"' : ''}} href="/edilaravel/reports/index">Reports</a>
	               </li>
      			
      			
      				<li class="nav-item dropdown">
          				<a class="nav-link dropdown-toggle {{ $navPage=='editypes' ? 'active' : '' }}" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            				EDI Types
          				</a>
          				<ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
           					<li>
           						<a class="dropdown-item" href="/edilaravel/editype/index">EDI Types</a>
           					</li>
				            <li><a class="dropdown-item" href="/edilaravel/editype/createfiles">Create Files</a></li>
				            <li><a class="dropdown-item" href="/edilaravel/editype/readfile">Read File</a></li>

								<li><a class="dropdown-item" href="/edilaravel/editype/createsegment">Create Segment</a></li>
          				</ul>
        				</li>      			

         			<li class="nav-item">
            			<a class="nav-link {{ $navPage=='users' ? 'active' : '' }}" {{ $navPage=='users' ? 'aria-current="page"' : ''}} href="/edilaravel/users/index">Users</a>
	            </li>	            
	            
   		     	</ul>
   		     	
	   	</div>
    
    
   </div> 
</nav>
