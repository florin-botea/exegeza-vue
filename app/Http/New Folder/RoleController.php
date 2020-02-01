<?php

namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request as Req;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
		
class RoleController extends Controller
{
	
	public function __construct()
	{
		
	}
	
	public function manage ()
	{
		return view('manageUsers');
	}
	
	public function addRole ($user_id)
	{
		//return response()->json( Request::get('name') );
		$role = Role::firstOrCreate(['name' => Request::get('name')]);
		$user = \App\User::find($user_id);
		$user->assignRole($role);
		return response()->json($role);
	}
	
	public function getPermissions ($role_id){
		$permissions = Role::find($role_id)->permissions;
		return response()->json($permissions);
	}
	
	public function removeRole ($user_id, $role_id){
		$user = \App\User::find($user_id);
		$user->removeRole($role_id);
		return response()->json('deleted');
	}
	
	public function addPermission (){
		$role = Role::find(1);
		$permission = Permission::firstOrCreate(['name' => 'fraer']);
		$role->givePermissionTo($permission);
	}
	
	public function removePermission (){
		$role = Role::find(1);
		$role->revokePermissionTo($permission);
	}
	
	public function roleSuggestion ($qs){
		$roles = Role::where('name', 'LIKE', '%'.$qs.'%')->take(5)->get(['id', 'name']);
		return response()->json($roles);
	}
	
	public function permissionSuggestion (){
		$test = 'r';
		$roles = Permission::where('name', 'LIKE', '%'.$test.'%')->take(5)->pluck('name');
		inspect($roles);
	}
	
}
 
function inspect($data, $json = false){
	?>
	<pre>
	<?php
		if($json === true){
			print_r(json_encode($data, JSON_PRETTY_PRINT));
			die();
		}
		print_r($data);
		die();
	?>
	<pre>
	<?php
}