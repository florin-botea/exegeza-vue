<form>
	@formgroup(['class'=>'w-full', 'required'=>'true',
		'input' => ['id'=>'password_confirmation', 'name'=>'password_confirmation', 'type'=>'password', 'attrs'=>['autocomplete'=>'off']],
		'iErrors' => $errors->get('password')
	])
	@endformgroup
	
	<div class="py-2">
		<button type="submit" class="adminDeleteBtn float-right">
			Sterge iremediabil cont
		</button>
		<div style="clear:both"></div>
	</div>
	
	<div class="text-red-500">
		Contul dumneavoastra va fi sters fara posibilitate de recuperare. Postarile dumneavoastra vor ramane totusi, dar sub autor anonim.
	</div>
</form>