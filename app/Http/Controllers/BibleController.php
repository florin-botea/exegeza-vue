<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use \App\Http\Validations\ValidBible;
use \App\Repositories\Eloquent\BibleRepository;

class BibleController extends Controller
{
	private $bibleRepository;
	
	public function __construct(BibleRepository $bibleRepository){
		$this->authorizeResource(\App\Bible::class, 'bible');
		$this->bibleRepository = $bibleRepository;
	}

    public function index(Request $req)
    {
		$data = $this->bibleRepository->get();
		
		return view('bibles')->with(['data' => $data]);
    }

    public function store(ValidBible $post)
    {
		$this->bibleRepository->store( $post->all() );
		
		return back();
    }

    public function update(ValidBible $req, string $version)
    {
		$this->bibleRepository->update($version, $req->all());
		
		return back();
    }

    public function destroy(string $version)
    {
        $this->bibleRepository->destroy($version);
				
		return back();
    }
}
