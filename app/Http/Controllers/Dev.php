<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artisan;
use DatabaseSeeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\Welcome;


class Dev extends Controller
{
	public function dbUp (){
		Artisan::call('migrate', array('--path' => 'database/migrations', '--force' => true));
		\App\Flag::create([
			'name' => 'nici unul',
			'value' => 0
		]);
	}
	
	public function dbDown (){
		DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		Artisan::call('migrate:reset', ['--force' => true]);
		DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}
	
	public function dbFill (){
		Role::create(['name' => 'admin']);
	}
	
	public function manageLib (){
		return view('manageLib');
	}
	
	public function gainPermission ($permission){
		if (Auth::id()){
			$permission = str_replace('-', ' ', $permission);
			$permission = Permission::firstOrCreate(['name' => $permission]);
			$user = \App\User::find(Auth::id())->givePermissionTo($permission);
		}
	}
	
	public function test (Request $req){
		Mail::to('florin.botea@digisign.ro')->send(new Welcome());
		
		// $this->inspect(
		
			// request()->getHost()
			
		// );
		//$start = memory_get_usage ();
		// \App\Book::find(1583);
		//$bible = \App\Bible::where(['slug' => 'NTR1'])->first();
		//$this->inspect($bible->books()->where(['slug' => 'asdsdasdad-sdas1dadsasd50'])->first());
		
		//dd(memory_get_usage () - $start);
		
		// header('Content-Type: text');
		// $f = @fopen('necompletat.txt', 'r') or die('aaa');
		// $c = fread($f, filesize('necompletat.txt'));
		// $u = gzdeflate($c, 9, ZLIB_ENCODING_RAW);
		//$file = fopen("confirmare.pdf", "r") or die('baaa');
		//$streamReader = new StreamReader($file);
		//$parsed = new PdfParser($streamReader);
		//dd($parsed->getPdfVersion());
		// $compressedParser = new CompressedReader($parsed, $file);
		//dd($compressedParser);

		// $data = DB::table('v_1_verses')->crossJoin('books', function($join){
			// $join->on('v_1_verses.book_index', '=', 'books.index')
			// ->where('books.bible_id', '=', 1);
		// })->get();
		// query to get tag id
		//tag id
		// $data = DB::table('model_has_tags')
			// ->join('comments', 'model_has_tags.comment_id', '=', 'comments.id')
			// ->join('v_2_verses', 'comments.target', '=', 'v_2_verses.global_id')
			// ->where('tag_id', 1)
			// ->get();
		
		// $this->inspect($data);
		//\App\Classes\Notification::fromComment( '#[comm=1]{asdf} #[user=1]{asdf}' )->send();
		
		//$comments = \App\Comments::with('author')->withCount('replies')->paginate(3);
		//:::::ABOUT PERMISSIONS IN COMMENT SECTION::::::::::::::::
		//$uid = \Illuminate\Support\Facades\Auth::id();
		// $perm = \App\User::find(1)->getAllPermissions();
		// inspect($perm, true);
		
		//:::::ABOUT PAGINATION IN COMMENT SECTION::::::::::::::::
		//
		
		//:::::ABOUT CASCADE DELETION::::::::::::::::
		//\App\Comments::find(4)->delete();
		
		//$role = Role::create(['name' => 'writer']);
		//$permission = Permission::create(['name' => 'edit articles']);
		//$role->givePermissionTo($permission);
		//$permission->assignRole($role);
		//$user = \App\User::find(1);
		//$user->givePermissionTo('edit articles');
		
		/*$book = \App\Book::where(['version_alias'=>'aer', 'book_name'=>'aer'])->first();
		//echo get_class($book);
		echo get_class($book);
		echo '<br>';
		inspect(
			$book->chapters()->create([
				'index' => 1,
				'title' => 'bla bla'
			])
		,true);
		//inspect($data, true);
		//$view = new \App\View\BooksView();
		//$view->render();
		//ia comm cu vot aplicat de user sau nu
/*		$test = \App\Comments::with([
			'vote' => function($query) { $query->where('user', '=', 22); },
		])
		->withCount('replies')
		->where('id', 41)->get();
		//get coordinates
		
		inspect ($test);
		$id = \Illuminate\Support\Facades\Auth::id();
		//pot avea oricate date despre user de aici
		$test = \App\User::with(
			'notifications'
		)->where('id', $id)->get();
		//$test2 = $test->notifications()->get();
		inspect ($test, true);//return null if not logged in*/

	}
}