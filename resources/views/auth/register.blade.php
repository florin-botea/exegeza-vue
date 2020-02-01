@extends('layouts.app')

@php
	$form_fields = ['name'=>'Nume si prenume:', 'email'=>'Adresa de email:', ]
@endphp

@section('content')
<div class="flex-1 bg-no-repeat bg-center bg-cover" style="background-image:url('/bg-auth.jpg')">
  <div class="md:w-140 p-4 w-full md:h-auto h-full mt-8 md:mt-16 mx-auto bg-white rounded border border-gray-200">
    <div class="text-lg font-bold">
      <a class="border border-gray-600 rounded-t text-base bg-gray-300 px-2 hover:bg-gray-400" href="{{ route('login') }}">
        Login
      </a>
      <span class="border-t border-l border-r border-gray-600 rounded-t px-2">
        {{ __('Register') }}
      </span>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
		
		@formgroup(['class'=>'w-full', 'required'=>'true',
			'label'=>['value'=>'Nume si prenume:'],
			'input'=>['value'=>old('name'),'id'=>'name','name'=>'name'],
			'iErrors'=>$errors->get('name')
		])
		@endformgroup
		
		@formgroup(['class'=>'w-full', 'required'=>'true',
			'label'=>['value'=>'Adresa de email:'],
			'input'=>['value'=>old('email'),'id'=>'name','name'=>'email'],
			'iErrors'=>$errors->get('email')
		])
		@endformgroup
		
		@formgroup(['class'=>'w-full', 'required'=>'true',
			'label'=>['value'=>'Parola:'],
			'input'=>['value'=>old('password'),'id'=>'password','name'=>'password','type'=>'password'],
			'iErrors'=>$errors->get('password')
		])
		@endformgroup
		
		@formgroup(['class'=>'w-full', 'required'=>'true',
			'label'=>['value'=>'Parola (confirmare):'],
			'input'=>['value'=>old('password_confirmation'),'id'=>'password_confirmation','name'=>'password_confirmation','type'=>'password'],
			'iErrors'=>$errors->get('password_confirmation')
		])
		@endformgroup
		
		<div class="flex py-2 justify-end">
			@buttonUpdate(['value'=>'Register'])
			@endbuttonUpdate
		</div>
    </form>
  </div>
</div>
@endsection
