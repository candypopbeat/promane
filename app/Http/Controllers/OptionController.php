<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Option;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OptionController extends Controller
{
	public function index()
	{
		$defaultTitle = defaultProjectTitle();
		$team_id = Auth::user()->current_team_id;
		$options = Option::where("team_id", $team_id)
			->select(
				"id",
				"team_id",
				"project_title",
				"theme_colors",
				"view_contributor",
			)
			->get()->first();
			if ( is_null($options) ) {
				$options = (object)[
					"project_title" => $defaultTitle,
					"theme_colors"  => defaultThemeColor(),
					"view_contributor" => false,
				];
			}
			if ( is_null($options->theme_colors) ) $options->theme_colors = defaultThemeColor();
			if ( is_null($options->project_title) ) $options->project_title = $defaultTitle;
			return view('dashboard', ['options' => $options]);
	}

	public function updateTitle(Request $request)
	{
		$title   = !empty($request->input("project_title")) ? $request->input("project_title") : "";
		$team_id = Auth::user()->current_team_id;
		Option::updateOrInsert(
			['team_id' => $team_id],
			['project_title' => $title],
		);
		return redirect("/dashboard");
	}

	public function updateThemeColors(Request $request)
	{
		$colors   = !empty($request->input()) ? $request->input() : "";
		array_shift($colors);
		array_pop($colors);
		$team_id = Auth::user()->current_team_id;
		Option::updateOrInsert(
			['team_id' => $team_id],
			['theme_colors' => json_encode($colors)],
		);
		return redirect("/dashboard");
	}

	public function updateViewContributor(Request $request)
	{
		$check   = $request->input("view_contributor");
		$bool = $check === "on" ? 1 : 0;
		$team_id = Auth::user()->current_team_id;
		Option::updateOrInsert(
			['team_id' => $team_id],
			['view_contributor' => $bool],
		);
		return redirect("/dashboard");
	}

}
