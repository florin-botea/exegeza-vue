<button class="border rounded bg-gray-800 hover:bg-black text-white font-semibold px-2 py-1 {{$class ?? ''}}">
	@isset($value)
		{{$value}}
		@else
		<i class="fas fa-check"></i>
	@endif
</button>