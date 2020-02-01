<html>
	
	<body>
		@foreach ($flags as $flag)
			{{ Form::open([ 'url' => route('flags.update', ['flag' => $flag->id]), 'method' => 'patch' ]) }}
				{{ Form::text('name', $flag->name, ['placeholder' => 'Flag name...']) }}
				{{ Form::text('value', $flag->value, ['placeholder' => 'Flag value...']) }}
				{{ Form::submit('update', ['class'=>'btn-sm btn-success p-0']) }}
			{{ Form::close() }}
			@if ($flag->id !== 1)
				{{ Form::open([ 'url' => route( 'flags.destroy', ['flag' => $flag->id]), 'method' => 'delete' ]) }}
					{{ Form::submit('delete', ['class'=>'btn-sm btn-danger p-0']) }}
				{{ Form::close() }}
			@endif
		@endforeach
		<hr>
		{{ Form::open([ 'url' => route('flags.store'), 'method' => 'post' ]) }}
			{{ Form::text('name', '', ['placeholder' => 'Flag name...']) }}
			{{ Form::text('value', '', ['placeholder' => 'Flag value...']) }}
			{{ Form::submit('Add', ['class'=>'btn-sm submit-btn float-right']) }}
		{{ Form::close() }}
	</body>
</html>