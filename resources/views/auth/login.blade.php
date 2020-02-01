@extends('layouts.app')

@section('content')
<div class="flex-1 relative">
	<div class="absolute opacity-50 h-full w-full bg-no-repeat bg-center bg-cover" style="background-image:url('/bg-auth.jpg'); z-index:-1;">
	</div>
	<div class="md:w-140 p-4 w-full md:h-auto h-full mt-8 md:mt-16 mx-auto bg-white rounded border border-gray-200">
		<div class="text-lg font-bold">
			<span class="border-t border-l border-r border-gray-600 rounded-t px-2">
				Login
			</span>
			<a class="border border-gray-600 rounded-t text-base bg-gray-300 px-2 hover:bg-gray-400" href="{{ route('register') }}">
				{{ __('Register') }}
			</a>
		</div>

		<form method="POST" action="{{ route('login') }}">
			@csrf

			@formgroup(['class'=>'w-full', 'required'=>'true',
				'label'=>['value'=>'Email:'],
				'input'=>['value'=>old('email'),'id'=>'email','name'=>'email'],
				'iErrors'=>$errors->get('email')
			])
			@endformgroup
			
			@formgroup(['class'=>'w-full', 'required'=>'true',
				'label'=>['value'=>'Password:'],
				'input'=>['value'=>old('password'),'id'=>'password','name'=>'password','type'=>'password'],
				'iErrors'=>$errors->get('password')
			])
			@endformgroup

			<div class="form-group row">
				<div class="col-md-6 offset-md-4">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

						<label class="form-check-label" for="remember">
							{{ __('Remember Me') }}
						</label>
					</div>
				</div>
			</div>

			<div class="flex justify-between items-center">
				@if (Route::has('password.request'))
					<a class="text-blue-600 hover:text-blue-400" href="{{ route('password.request') }}">
						{{ __('Forgot Your Password?') }}
					</a>
				@endif
			
				@buttonSubmit(['value'=>'Login'])
				@endbuttonSubmit
			</div>
		</form>
	</div>
</div>
@endsection
