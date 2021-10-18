<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tasks;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
	public function index()
	{
		$task = Tasks::all();
		// dd($wiki->toArray());
		return view('chart', ['task' => $task]);
	}

	public function upschedule(Request $request)
	{
		$targetID  = !empty($request->input('targetID')) ? $request->input('targetID') : "";
		$start  = !empty($request->input('start')) ? $request->input('start') : "";
		$end  = !empty($request->input('end')) ? $request->input('end') : "";
		$up = DB::table('tasks')
			->where('id', $targetID)
			->update([
				'start_time' => $start,
				'end_time' => $end,
			]);
		return response()->json($up);
	}

	public function upprogress(Request $request)
	{
		$targetID  = !empty($request->input('targetID')) ? $request->input('targetID') : "";
		$progress  = !empty($request->input('progress')) ? $request->input('progress') : "";
		$up = DB::table('tasks')
			->where('id', $targetID)
			->update(['progress' => $progress]);
		return response()->json($up);
	}

}
