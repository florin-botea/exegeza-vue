@if( request('edit') )
	<a href="{{url()->current()}}" class="inline-block adminUpdateBtn hover:bg-green-300 float-right">
		<i class="fas fa-check"></i>
	</a>
	@else
	<a href="?edit=true" class="inline-block adminUpdateBtn hover:bg-green-300 float-right">
		<i class="far fa-edit"></i>
	</a>
@endif