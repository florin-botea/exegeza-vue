<form>
	<h1>
		Schimbare parola:
	</h1>
	@formgroup(['class'=>'w-full', 'required'=>'true',
		'label' => ['value'=>'Parola actuala:'],
		'input' => ['id'=>'old_password', 'name'=>'old_password', 'type'=>'password'],
		'iErrors' => $errors->get('old_password')
	])
	@endformgroup
	
	@formgroup(['class'=>'w-full', 'required'=>'true',
		'label' => ['value'=>'Parola actuala:'],
		'input' => ['id'=>'password', 'name'=>'password', 'type'=>'password'],
		'iErrors' => $errors->get('password')
	])
	@endformgroup
	
	@formgroup(['class'=>'w-full', 'required'=>'true',
		'label' => ['value'=>'Noua parola (din nou):'],
		'input' => ['id'=>'password_confirmation', 'name'=>'password_confirmation', 'type'=>'password'],
		'iErrors' => $errors->get('password_confirmation')
	])
	@endformgroup
	
	<div class="py-2">
		<button type="submit" class="adminUpdateBtn float-right">
			Actualizeaza
		</button>
	</div>
</form>