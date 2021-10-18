<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Option extends Model
{
	use HasFactory;
	protected $guarded = [
		'id',
		'created_at',
		'updated_at',
	];
	protected $casts = [
		'theme_colors' => 'json',
	];
	protected $fillable = [
		'theme_colors',
	];

	public static function getThemeColor()
	{
		$team_id   = Auth::user()->current_team_id;
		$data = self::where("team_id", $team_id)
			->select("theme_colors")
			->get()->first();
		$default = defaultThemeColor();
		// dd($default);
		if ( is_null($data) ) {
			return $default;
		}
		$colors = $data->toArray()["theme_colors"];
		if ( empty($colors["head_title_color"]) ) $colors["head_title_color"] = $default["head_title_color"];
		if ( empty($colors["head_navi_color"]) ) $colors["head_navi_color"] = $default["head_navi_color"];
		if ( empty($colors["primary_color"]) ) $colors["primary_color"] = $default["primary_color"];
		if ( empty($colors["primary_color_sub"]) ) $colors["primary_color_sub"] = $default["primary_color_sub"];
		if ( empty($colors["primary_color_reverse"]) ) $colors["primary_color_reverse"] = $default["primary_color_reverse"];
		if ( empty($colors["secondary_color"]) ) $colors["secondary_color"] = $default["secondary_color"];
		if ( empty($colors["secondary_color_sub"]) ) $colors["secondary_color_sub"] = $default["secondary_color_sub"];
		if ( empty($colors["secondary_color_reverse"]) ) $colors["secondary_color_reverse"] = $default["secondary_color_reverse"];
		if ( empty($colors["success_color"]) ) $colors["success_color"] = $default["success_color"];
		if ( empty($colors["success_color_sub"]) ) $colors["success_color_sub"] = $default["success_color_sub"];
		if ( empty($colors["success_color_reverse"]) ) $colors["success_color_reverse"] = $default["success_color_reverse"];
		if ( empty($colors["info_color"]) ) $colors["info_color"] = $default["info_color"];
		if ( empty($colors["info_color_sub"]) ) $colors["info_color_sub"] = $default["info_color_sub"];
		if ( empty($colors["info_color_reverse"]) ) $colors["info_color_reverse"] = $default["info_color_reverse"];
		if ( empty($colors["warning_color"]) ) $colors["warning_color"] = $default["warning_color"];
		if ( empty($colors["warning_color_sub"]) ) $colors["warning_color_sub"] = $default["warning_color_sub"];
		if ( empty($colors["warning_color_reverse"]) ) $colors["warning_color_reverse"] = $default["warning_color_reverse"];
		if ( empty($colors["danger_color"]) ) $colors["danger_color"] = $default["danger_color"];
		if ( empty($colors["danger_color_sub"]) ) $colors["danger_color_sub"] = $default["danger_color_sub"];
		if ( empty($colors["danger_color_reverse"]) ) $colors["danger_color_reverse"] = $default["danger_color_reverse"];
		if ( empty($colors["light_color"]) ) $colors["light_color"] = $default["light_color"];
		if ( empty($colors["light_color_sub"]) ) $colors["light_color_sub"] = $default["light_color_sub"];
		if ( empty($colors["light_color_reverse"]) ) $colors["light_color_reverse"] = $default["light_color_reverse"];
		if ( empty($colors["dark_color"]) ) $colors["dark_color"] = $default["dark_color"];
		if ( empty($colors["dark_color_sub"]) ) $colors["dark_color_sub"] = $default["dark_color_sub"];
		if ( empty($colors["dark_color_reverse"]) ) $colors["dark_color_reverse"] = $default["dark_color_reverse"];
		return $colors;
	}

	public static function boolViewContributor()
	{
		$team_id   = Auth::user()->current_team_id;
		try {
			$data = self::where("team_id", $team_id)
				->select("view_contributor")
				->get()->first();
				return $data->view_contributor ? true : false;
		} catch (\Throwable $th) {
			return false;
		}
	}
}
