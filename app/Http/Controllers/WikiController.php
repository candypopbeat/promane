<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wiki;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mail\Markdown;

class WikiController extends Controller
{
	public function index()
	{
		$team_id = Auth::user()->current_team_id;
		try {
			$wikiFirst = DB::table("wikis")
				->where("team_id", $team_id)
				->orderBy("sort", "ASC")
				->get()
				->first();
		} catch (\Throwable $th) {
			$wikiFirst = (object) [
				"title" => "存在しません",
				"contents" => "最初の記事もしくは１番上の記事がWikiトップに表示されます"
			];
		}
		return view('wiki.index', ['wikiFirst' => $wikiFirst]);
	}

	public function show($id)
	{
		$wiki = wiki::find($id);
		if (empty($wiki)) {
			return view('wiki.index');
		}
		return view('wiki.show', ['wiki' => $wiki->toArray()]);
	}

	public function listup(Request $request)
	{
		$toDo      = !empty($request->input('toDo')) ? $request->input('toDo') : "";
		$toDoArr   = json_decode(stripslashes($toDo));
		foreach ($toDoArr as $k => $v) {
			DB::table('wikis')
			->where('id', $v->id)
			->update(['sort' => $k]);
		}
		echo "true";
	}

	public function edit(Request $request)
	{
		$targetId            = $request->input("targetId");
		$editFormStr         = !empty($request->input("editWikiForm")) ? $request->input("editWikiForm") : "";
		$editFormObj         = json_decode($editFormStr);
		$title               = $editFormObj->title;
		$contentHtml         = $editFormObj->contents;
		$tags                = $editFormObj->tags;
		$tagArr              = [];
		if ( count($tags) > 0) {
			foreach ($tags as $k => $v) {
				$tagArr[] = $v->value;
			}
		}
		DB::table('wikis')->where('id', $targetId)
		->update([
			'title'      => $title,
			'tags'       => json_encode($tagArr, JSON_UNESCAPED_UNICODE),
			'contents'   => Markdown::parse($contentHtml),
		]);
		echo "true";
	}

	public function add(Request $request)
	{
		$addWikiFormStr = !empty($request->input("addWikiForm")) ? $request->input("addWikiForm") : "";
		$addWikiFormObj = json_decode($addWikiFormStr);
		$title          = $addWikiFormObj->title;
		$userId         = Auth::user()->id;
		$teamId         = Auth::user()->current_team_id;
		$contentHtml    = $addWikiFormObj->contents;
		$tags           = $addWikiFormObj->tags;
		$tagArr         = [];
		if ( count($tags) > 0 ) {
			foreach ($tags as $k => $v) {
				$tagArr[] = $v->value;
			}
		}
		DB::table('wikis')->insert([
			'title' => $title,
			'user_id' => $userId,
			'team_id' => $teamId,
			'tags' => json_encode($tagArr, JSON_UNESCAPED_UNICODE),
			'contents' => Markdown::parse($contentHtml),
			'sort' => 0,
		]);
		echo "true";
	}

	public function delete(Request $request)
	{
		$targetId = !empty($request->input("targetId")) ? $request->input("targetId") : "";
		Wiki::where('id', $targetId)->delete();
		return response()->json("true");
	}

}
