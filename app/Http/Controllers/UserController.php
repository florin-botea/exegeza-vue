<?php

namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request as Req;
use \App\Http\Validations\ValidUser;
use App\User;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Input;
		
class UserController extends Controller
{
	
	public function __construct()
	{
		// dd(request()->all());
	}
	
	public function manage ()
	{
		return view('manageUsers');
	}
	
	public function show($id)
	{
		$data = [
			'user' => \App\User::with('details')->with(['comments' => function($query){
	
			}])->findOrFail($id),
			'sending_base' => []
		];
		$bible = \App\Bible::first();
		$books = [];
		$t_books = \App\Book::where('bible_id', $bible->id)->get();
		foreach($t_books as $book){
			$books[$book->index] = $book->slug;
		}
		unset($t_books);
		foreach($data['user']['comments'] as &$comment){
			$comment['sending'] = [
				'bible' => $bible->slug,
				'book' => $books[floor($comment->target/1000000)],
				'chapter' => floor(($comment->target%1000000)/1000),
				'verse' => $comment->target%1000
			];
		}
		// $this->inspect($data);
		return view('user.user-profile')->with('data', $data);
	}
	
	public function update($id, ValidUser $req)
	{
		if ($req->submit === 'update-data'){
			$this->updateData($id, $req);
		} elseif ($req->submit === 'update-password'){
			$this->updatePassword($id, $req);
		}
		return redirect(request()->url());
	}
	
	public function search (){
		if ($email){
			User::where('email', $email)->first();
		} elseif ($name){
			User::where('name', $name)->first();
		}
	}
	
	public function updateData($id, ValidUser $req){
		$user = \App\User::findOrFail($id);
		$user->update($req->all());
		$user->details()->updateOrCreate(['user_id' => $id], $req->all());
        if ($req->hasfile('photo')){
            $file = $req->file('photo');
            $extension = 'jpeg';//$file->getClientOriginalExtension();
            $filename = $user->id.'.'.$extension;
            $file->move(public_path().'\images\profile-photos',$filename);
            $user->profile_image = $filename;
			$user->save();
        }
	}
	
	public function updatePassword($id, ValidUser $req){
		
	}
	
	public function emailSuggestion (){
		User::where('email', 'LIKE', '%'.$test.'%')->take(5)->pluck('email');
	}
	
	public function nameSuggestion ($qs){
		$suggestions = User::where('name', 'LIKE', '%'.$qs.'%')->take(5)->get(['id', 'name']);
		return response()->json($suggestions);
	}
	
}