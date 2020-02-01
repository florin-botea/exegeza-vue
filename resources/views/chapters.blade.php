@extends('layouts.chapters_verses')

@php
	$verses_preview = \Session::get('verses_preview');
@endphp

@section('_content')
	@can('create', App\Chapter::class)
		@include('forms.chapter_edit')
		@include('forms.chapter_add')
	@endcan
@endsection