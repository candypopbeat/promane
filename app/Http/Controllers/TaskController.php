<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tasks;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mail\Markdown;

class TaskController extends Controller
{
	public function show($id)
	{
		$task   = Tasks::find($id);
		$status = setStatus($task->status);
		$tags   = setTag($task->tags);
		return view('task.show', [
			'task'     => $task,
			'tags'     => $tags,
			'catClass' => $status["class"],
			'catName'  => $status["catName"],
		]);
	}

	public function update(Request $request)
	{
		$toDo      = !empty($request->input('toDo')) ? $request->input('toDo') : "";
		$toDoArr   = json_decode(stripslashes($toDo));
		$targetID  = !empty($request->input('targetID')) ? $request->input('targetID') : "";
		$catId = !empty($request->input('updateCat')) ? $request->input('updateCat') : "";
		$up = DB::table('tasks')
			->where('id', $targetID)
			->update(['status' => $catId]);
		foreach ($toDoArr as $k => $v) {
			foreach ($v as $k2 => $v2) {
				DB::table('tasks')
					->where('id', $v2->id)
					->update(['sort' => $k2]);
			}
		}
		return response()->json($up);
	}

	public function add(Request $request)
	{
		$addTaskFormStr = !empty($request->input("addTaskForm")) ? $request->input("addTaskForm") : "";
		$addTaskFormObj = json_decode($addTaskFormStr);
		$title          = $addTaskFormObj->title;
		$userId         = Auth::user()->id;
		$teamId         = Auth::user()->current_team_id;
		$contentHtml    = empty($addTaskFormObj->contents) ? "" : $addTaskFormObj->contents;
		$status         = $addTaskFormObj->status;
		$start          = $addTaskFormObj->start;
		$end            = $addTaskFormObj->end;
		$progress       = $addTaskFormObj->progress;
		$follow         = empty($addTaskFormObj->follow) ? "0" : $addTaskFormObj->follow;
		$tags           = empty($addTaskFormObj->tags) ? [] : $addTaskFormObj->tags;
		$tagArr         = [];
		if ( count($tags) > 0 ) {
			foreach ($tags as $k => $v) {
				$tagArr[] = $v->value;
			}
		}
		$insertId = DB::table('tasks')->insertGetId([
			'title' => $title,
			'user_id' => $userId,
			'team_id' => $teamId,
			'follow' => $follow,
			'status' => $status,
			'tags' => json_encode($tagArr, JSON_UNESCAPED_UNICODE),
			'contents' => Markdown::parse($contentHtml),
			'progress' => $progress,
			'sort' => 0,
			'start_time' => $start,
			'end_time' => $end,
		]);
		return response()->json($insertId);
	}

	public function edit(Request $request)
	{
		$targetId = $request->input("targetId");
		$editFormStr  = !empty($request->input("editTaskForm")) ? $request->input("editTaskForm") : "";
		$editFormObj  = json_decode($editFormStr);
		$title        = $editFormObj->title;
		$contentHtml  = Markdown::parse($editFormObj->contents);
		$status       = $editFormObj->status;
		$start        = $editFormObj->start;
		$end          = $editFormObj->end;
		$progress     = $editFormObj->progress;
		$follow       = $editFormObj->follow;
		$tags         = $editFormObj->tags;
		$tagArr       = [];
		foreach ($tags as $k => $v) {
			$tagArr[] = $v->value;
		}
		DB::table('tasks')->where('id', $targetId)
			->update([
				'title' => $title,
				'follow' => $follow,
				'status' => $status,
				'tags' => json_encode($tagArr, JSON_UNESCAPED_UNICODE),
				'contents' => $contentHtml,
				'progress' => $progress,
				'start_time' => $start,
				'end_time' => $end,
			]);
		echo "true";
	}

	public function follow(Request $request)
	{
		$targetId      = $request->input("targetId");
		$judge         = !empty($request->input("judge")) ? $request->input("judge") : "";
		$judge = $judge === "true" ? 1 : 0;
		DB::table('tasks')->where('id', $targetId)
			->update([
				'follow' => $judge,
			]);
		echo "true";
	}

	public function delete(Request $request)
	{
		$targetID  = !empty($request->input('targetId')) ? $request->input('targetId') : "";
		DB::table('tasks')
			->where('id', $targetID)
			->delete();
		return response()->json($targetID);
	}
}
