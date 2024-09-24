<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Playlist;

use App\Helpers\ApiHelper;
use Illuminate\Support\Str;
use DB;
use Illuminate\Pagination\Paginator;

class PlaylistController extends Controller
{

	public function index(Request $request)
	{
		$lang = $request->query('lang', 'en'); // Default to 'en' if no language is specified
	
		$posts = Playlist::with(['translations' => function ($query) use ($lang) {
			$query->where('locale', $lang);
		}])->get();
	
		$result = ApiHelper::success('playlist', $posts);
		return response()->json($result, 200);
	}


}
