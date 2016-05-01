<form action="/video/search" method="POST" role="form" class="navbar-form navbar-right">
	<input type="hidden" value="{{ csrf_token() }}" name="_token" />
	<div class="input-group">
       <input type="search" placeholder="Search..." name="search" class=" well-sm form-control" style="width: 100%; background: none; border: none; border-bottom: 2px solid #fff; border-radius: 0px;" />
       <div class="input-group-btn">
           <button class="btn btn-default">
           <span class="glyphicon glyphicon-search"></span>
           </button>
       </div>
   </div>
</form>