@extends('layouts.app')

@section('content')
<div class="flex flex-wrap pt-12 w-170 shadow-md justify-center mx-auto px-8">
	<div class="text-red-600 font-bold w-full text-center">
		Resetare parola !!!
	</div>

	@if (session('status'))
		<div class="text-red-600 w-full" role="alert">
			{{ session('status') }}
		</div>
	@endif

	<form class="block w-full" method="POST" action="{{ route('password.email') }}">
		@csrf
		@formgroup(['required'=>'true',
			'label'=>['value'=>'Adresa de email:','class'=>'font-semibold'],
			'input'=>['value'=>old('email'),'id'=>'name','name'=>'email'],
			'iErrors'=>$errors->get('email')
		])
		@endformgroup
		<div class="flex justify-end p-2">
			@buttonUpdate(['value'=>'Trimite link resetare parola', 'class'=>'ml-auto'])
			@endbuttonUpdate
		</div>
	</form>
</div>
@endsection
