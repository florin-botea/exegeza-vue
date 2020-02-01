<button class="border rounded bg-red-600 hover:bg-red-400 text-white font-semibold px-2 py-1 {{$class ?? ''}}">
	@isset($value)
		{{$slot}}
		@else
		<i class="far fa-trash-alt"></i>
	@endif
</button>