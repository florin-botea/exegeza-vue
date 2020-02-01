@php
	$profile_img = json_encode(['url' => '/images/profile-photos/'.auth()->user()->profile_image]);
@endphp

<form class="section user_profile_section flex flex-wrap p-8 shadow-md relative mx-auto mt-12 form-prevent-multiple-submits w-full md:w-200"
action="{{ route('users.update', ['id' => $data['user']->id]) }}" method="POST" files="true" enctype="multipart/form-data">
	@csrf @method('PUT')
	
	<div class="w-full md:w-1/2 mb-4">
		<input-one-image name="photo" class="w-64 h-64 border border-black mx-auto md:mx-0 shadow-md" :default-src="{{$profile_img}}" :label="{class:'cursor-pointer'}">
		</input-one-image>
	</div>
	
	<div class="flex flex-wrap items-center w-full md:w-1/2">
	
		@formgroup(['class'=>'w-2/3', 'required'=>'true',
			'label'=>['value'=>'Nume si prenume:'],
			'input'=>['value'=>$data['user']->name,'id'=>'name','name'=>'name'],
			'iErrors'=>$errors->get('name')
		])
		@endformgroup
		
		@formgroup(['class'=>'w-1/3 pl-2',
			'label'=>['value'=>'Varsta:'],
			'input'=>['value'=>$data['user']['details']['age'],'id'=>'age','name'=>'age'],
			'iErrors'=>$errors->get('age')
		])
		@endformgroup
		
		@formgroup(['class'=>'w-full', 'required'=>'true',
			'label'=>['value'=>'Adresa de mail:'],
			'input'=>['value'=>$data['user']->email,'id'=>'email','name'=>'email'],
			'iErrors'=>$errors->get('email')
		])
		@endformgroup
		
		<div class="form-group flex flex-wrap mb-4">
			<label class="col-sm-4 col-form-label text-md-right font-semibold w-full">
				Sex:
			</label>
			<div class="col-md-6">
				<input id="male" type="radio" name="gender" value="1" {{$data['user']['details']['gender'] == 1 ? 'checked' : ''}}>
				<label for="male" class="col-sm-4 col-form-label text-md-right">
					Barbat 
				</label>
				
				<input id="female" type="radio" name="gender" value="2" {{$data['user']['details']['gender'] == 2 ? 'checked' : ''}}>
				<label for="female" class="col-sm-4 col-form-label text-md-right">
					Femeie 
				</label>

				<input id="na" type="radio" name="gender" value="0" {{$data['user']['details']['gender'] == 0 ? 'checked' : ''}}>
				<label for="na" class="col-sm-4 col-form-label text-md-right">
					Nementionat
				</label>
			</div>
			@if ($errors->has('gender'))
				<span class="text-red-500" role="alert">
					<strong>{{ $errors->first('gender') }}</strong>
				</span>
			@endif
		</div>
	</div>

	@formgrouptextarea(['class'=>'w-full flex-col',
		'label'=>['value'=>'Descriere:'],
		'input'=>['value'=>$data['user']['details']['description'],'id'=>'description','name'=>'description','class'=>'h-32 w-full resize-none'],
		'iErrors'=>$errors->get('description')
	])
	@endformgrouptextarea
	
	<div class="w-full pt-2">
		<button name="submit" value="update-data" class="adminUpdateBtn float-right hover:bg-green-400 btn-prevent-multiple-submit">
			Actualizeaza
		</button>
		<div style="clear:both"></div>
	</div>
</form>

<div class="section user_profile_section mt-4 flex flex-wrap justify-between p-8 shadow-md relative mx-auto w-full md:w-200">
	<div class="w-full md:w-72">
		@include('user.change-password-form')
	</div>
	<div class="w-full md:w-72 mt-12 md:mt-0">
		@include('user.delete-form')
	</div>
</div>