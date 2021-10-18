<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
	public function index(Request $request)
	{
		$teamId = Auth::user()->current_team_id;
		$error = "";
		$tasks = [];
		$wikis = [];
		$words = [];
		if ( is_null($request->search) ) {
			$error = "検索ワードが空白でした";
			return view('search', [
				'tasks' => $tasks,
				'wikis' => $wikis,
				'error' => $error,
				'words' => $words
			]);
		}
		$word = mb_convert_kana($request->search, 's');
		$words = explode(" ", $word);
		global $word;
		/**
		 * タスク検索
		 */
		foreach ($words as $word) {
			$task = DB::table("tasks")
			->join("users", "users.id", "=", "tasks.user_id")
			->where("team_id", "=", $teamId)
			->where(function($query){
				global $word;
				$query->where('tasks.title', 'like', "%$word%")
							->orWhere('tasks.contents', 'like', "%$word%")
							->orWhere('tasks.tags', 'like', "%$word%");
			})
			->select("tasks.id", "tasks.title", "tasks.status", "tasks.tags", "users.name as user_name")
			->get();
			if ( count($task) > 0 ) {
				foreach ($task as $k => $v) {
					array_push($tasks, $v);
				}
			}
		}
		/**
		 * Wiki検索
		 */
		foreach ($words as $word) {
			$wiki = DB::table("wikis")
			->where("team_id", "=", $teamId)
			->where(function($query){
				global $word;
				$query->where('title', 'like', "%$word%")
							->orWhere('contents', 'like', "%$word%")
							->orWhere('tags', 'like', "%$word%");
			})
			->select("id", "title", "tags")
			->get();
			if ( count($wiki) > 0 ) {
				foreach ($wiki as $k => $v) {
					array_push($wikis, $v);
				}
			}
		}
		if ( count($tasks) === 0 && count($wikis) === 0 ) {
			$error = "見つかりませんでした";
			return view('search', [
				'tasks' => $tasks,
				'wikis' => $wikis,
				'error' => $error,
				'words' => $words
			]);
		}

		return view('search', [
			'tasks' => $tasks,
			'wikis' => $wikis,
			'error' => $error,
			'words' => $words
		]);
	}
}
