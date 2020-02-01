<button class="border rounded bg-green-700 hover:bg-green-900 text-white font-semibold px-2 py-1 {{$class ?? ''}}">
	@isset($value)
		{{$value}}
		@else
		<i class="fas fa-check"></i>
	@endif
</button>