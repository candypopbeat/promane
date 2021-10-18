<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\User;

class MembersController extends Controller
{
	public function show() {
		return view('members', [
			'members' => User::all()->toArray()
		]);
	}
}
