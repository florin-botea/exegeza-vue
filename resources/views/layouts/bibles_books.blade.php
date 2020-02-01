@extends('layouts.app')
	
@section('content')
{{--aici e partea de jos a ecranului, de sub navbar. Ideea e ca voi face layerele -schema aici, iar stilizarile in css--}}
	<div class="flex-1 relative w-full h-full pt-12">
		<!--div class="absolute flex flex-wrap overflow-y-auto"-->
		<div class="absolute w-full flex flex-wrap overflow-y-auto">
			<div class="w-full md:w-1/3 order-last md:order-first">
				@include('components.search')
			</div>
			<!-- mijloc -->
			<div class="w-full md:w-2/3">
				@include('components.breadcrumb')
				@yield('_content')
			</div>
		</div>
	</div>
@endsection