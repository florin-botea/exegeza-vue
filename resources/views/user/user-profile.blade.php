@extends('layouts.app')
@php
	if (! $data['user']['details']){
		$data['user']['details'] = [
			'age' => '',
			'gender' => 0,
			'description' => ''
		];
	}
	$gender = ['nespecificat', 'barbat', 'femeie'];
	$can_update_user = ( auth()->user() && auth()->user()->can('update', $data['user']) );
@endphp

@section('content')
	<div class="h-12"></div>
	<div class="relative w-full h-full overflow-y-auto">
		<div class="relative w-full md:w-170 mx-auto">
			<!-- <div class="absolute overflow-y-auto"> -->
			@if ($can_update_user && request('edit'))
				@include('user.user-profile-edit')
				@else
				<div class="relative flex flex-wrap section user_profile_section w-full md:w-170 mx-auto py-4">
					@if ($can_update_user)
					<a class="block absolute right-0 px-2" href="?edit=true">
						@buttonUpdate(['value'=>'Edit'])
						@endbuttonUpdate
					</a>
					@endif
					
					<div class="w-full md:w-1/2 p-8 shadow-md">
						<div class="w-64 h-64 bg-no-repeat mx-auto md:mx-0"
						style="background-size:auto 100%;background-position:center;background-image:url('/images/profile-photos/{{$data['user']->profile_image}}')">
						</div>
					</div>
					
					<div class="w-full md:w-1/2 p-8">
						<div>
							<strong>Nume si prenume:</strong> {{ $data['user']->name }}
						</div>
						<div>
							<strong>Varsta:</strong> {{ $data['user']['details']['age'] ? $data['user']['details']['age'].' ani' : 'nespecificat' }}
						</div>
						<div>
							<strong>Sex:</strong> {{ $gender[$data['user']['details']['gender']] }}
						</div>
					</div>
					
					<div class="inline-block w-full p-8 float-right">
						<div>
							<strong>Descriere:</strong>
							<pre class="whitespace-pre-wrap">{{ $data['user']['details']['description'] }}</pre>
						</div>				
					</div>
				</div>
				
				<div class="relative section user_posts_section w-full md:w-170 mx-auto mt-4">
					<div class="p-8">
						<h1 class="text-lg font-semibold">
							Postari utilizator
						</h1>
						<section class="border border-gray-600">
							@foreach ($data['user']['comments'] as $comment)
								<a class="block py-1 px-2 font-bold text-blue-900 hover:text-blue-500 hover:underline"
								href="{{'/bible-resources/'.$comment->target.'?comment='.$comment->id}}">
									{{$comment->title.' ['.$comment['sending']['book'].' '.$comment['sending']['chapter'].', '.$comment['sending']['verse'].']'}}
								</a>
							@endforeach
						</section>
					</div>
				</div>
			@endif
			<!-- </div> -->
		</div>
	</div>
@endsection
