@extends('layouts.bibles_books')

@php
	$version = request('version');
@endphp

{{--nu ma preocupa aranjarea in pagina, doar eventual margini--}}

@section('_content')
	<div class="flex flex-wrap justify-between p-4 m-2 section books_section">
		@isset($data['books'])
		<div class="flex-1 border border-gray-600 p-2">
			<h1>
				<strong>Vechiul Testament</strong>
			</h1>
			<ul>
				@for ($i=0;$i<count($data['books']['data']);$i++)
					<a class="block hover:bg-gray-300" 
						href="/traduceri/{{$version}}/carti/{{$data['books']['data'][$i]['slug']}}/capitole">
						{{ $data['books']['data'][$i]['name'] }}
					</a>
					@if ($i==37)
						@break
					@endif
				@endfor
			</ul>
		</div>

		<div class="flex-1 border border-gray-600 p-2">
			<h1>
				<strong>Noul Testament</strong>
			</h1>
			<ul>
				@for ($i=37;$i<count($data['books']['data']);$i++)
					<a class="block hover:bg-gray-300" 
						href="/traduceri/{{$version}}/carti/{{$data['books']['data'][$i]['name']}}/capitole">
						{{ $data['books']['data'][$i]['name'] }}
					</a>
					@if ($i==37)
						@break
					@endif
				@endfor
			</ul>
		</div>
		@endisset
	</div>
	@can('create', \App\Book::class)
		@include('forms.book_edit')
		@include('forms.book_add')
	@endcan
@endsection