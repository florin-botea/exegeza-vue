@extends('layouts.bibles_books')

{{--nu ma preocupa aranjarea in pagina, doar eventual margini--}}

@section('_content')	
	@can('create', \App\Bible::class)
		@include('forms.version_edit')
		@include('forms.version_add')
	@endcan
@endsection