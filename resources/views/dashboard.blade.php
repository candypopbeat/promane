<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Dashboard') }}
		</h2>
	</x-slot>
	<div class="py-4">
		<div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
			<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
				<form action="/option/update/title" method="post" class="grid grid-cols-1 gap-6 m-4">
					@csrf
					<label class="block">
						<span class="text-gray-700">プロジェクトタイトル</span>
						<input
							type="text"
							name="project_title"
							value="{{ $options->project_title }}"
							class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
						>
					</label>
					<div class="flex justify-end">
						<input type="submit" name="submit" value="変更する" class="px-2 py-1 bg-graylight rounded hover:bg-graylight-dark">
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="py-1">
		<div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
			<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

				<?php $colors = $options->theme_colors; ?>
				<form action="/option/update/themeColors" method="post" name="formThemeColors" class="m-4">
					@csrf
					<label class="block">
						<span class="text-gray-700">ヘッダーカラー</span>
					</label>

					<table class="table-auto">
						<tbody>
							<tr>
								<td class="py-2">
									<span class="text-gray-700 mr-2">タイトル</span>
								</td>
								<td class="py-2">
									<input type="color" name="head_title_color" value="{{ $colors['head_title_color'] }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
								</td>
							</tr>
							<tr>
								<td class="py-2">
									<span class="text-gray-700 mr-2">ナビ</span>
								</td>
								<td class="py-2">
									<input type="color" name="head_navi_color" value="{{ $colors['head_navi_color'] }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
								</td>
							</tr>
						</tbody>
					</table>

					<hr class="my-5">

					<label class="block">
						<span class="text-gray-700">テーマカラー</span>
					</label>

					<table class="table-auto">
						<thead>
							<tr class="text-center">
								<th class="p-2">カラー</th>
								<th class="p-2">デフォルト</th>
								<th class="p-2">サブ</th>
								<th class="p-2">リバース</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="p-2">
										プライマリー
								</td>
								<td class="p-2">
									<input type="color" name="primary_color" value="{{ $colors['primary_color'] }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
								</td>
								<td class="p-2">
									<input type="color" name="primary_color_sub" value="{{ $colors['primary_color_sub'] }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
								</td>
								<td class="p-2">
									<input type="color" name="primary_color_reverse" value="{{ $colors['primary_color_reverse'] }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
								</td>
							</tr>
							<tr>
								<td class="p-2">
									セカンダリー
								</td>
								<td class="p-2">
									<input type="color" name="secondary_color" value="{{ $colors['secondary_color'] }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
								</td>
								<td class="p-2">
									<input type="color" name="secondary_color_sub" value="{{ $colors['secondary_color_sub'] }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
								</td>
								<td class="p-2">
									<input type="color" name="secondary_color_reverse" value="{{ $colors['secondary_color_reverse'] }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
								</td>
							</tr>
							<tr>
								<td class="p-2">
									サクセス
								</td>
								<td class="p-2">
									<input type="color" name="success_color" value="{{ $colors['success_color'] }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
								</td>
								<td class="p-2">
									<input type="color" name="success_color_sub" value="{{ $colors['success_color_sub'] }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
								</td>
								<td class="p-2">
									<input type="color" name="success_color_reverse" value="{{ $colors['success_color_reverse'] }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
								</td>
							</tr>
							<tr>
								<td class="p-2">
									インフォ
								</td>
								<td class="p-2">
									<input type="color" name="info_color" value="{{ $colors['info_color'] }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
								</td>
								<td class="p-2">
									<input type="color" name="info_color_sub" value="{{ $colors['info_color_sub'] }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
								</td>
								<td class="p-2">
									<input type="color" name="info_color_reverse" value="{{ $colors['info_color_reverse'] }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
								</td>
							</tr>
							<tr>
								<td class="p-2">
									ラーニング
								</td>
								<td class="p-2">
									<input type="color" name="warning_color" value="{{ $colors['warning_color'] }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
								</td>
								<td class="p-2">
									<input type="color" name="warning_color_sub" value="{{ $colors['warning_color_sub'] }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
								</td>
								<td class="p-2">
									<input type="color" name="warning_color_reverse" value="{{ $colors['warning_color_reverse'] }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
								</td>
							</tr>
							<tr>
								<td class="p-2">
									デンジャー
								</td>
								<td class="p-2">
									<input type="color" name="danger_color" value="{{ $colors['danger_color'] }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
								</td>
								<td class="p-2">
									<input type="color" name="danger_color_sub" value="{{ $colors['danger_color_sub'] }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
								</td>
								<td class="p-2">
									<input type="color" name="danger_color_reverse" value="{{ $colors['danger_color_reverse'] }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
								</td>
							</tr>
							<tr>
								<td class="p-2">
									ライト
								</td>
								<td class="p-2">
									<input type="color" name="light_color" value="{{ $colors['light_color'] }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
								</td>
								<td class="p-2">
									<input type="color" name="light_color_sub" value="{{ $colors['light_color_sub'] }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
								</td>
								<td class="p-2">
									<input type="color" name="light_color_reverse" value="{{ $colors['light_color_reverse'] }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
								</td>
							</tr>
							<tr>
								<td class="p-2">
									ダーク
								</td>
								<td class="p-2">
									<input type="color" name="dark_color" value="{{ $colors['dark_color'] }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
								</td>
								<td class="p-2">
									<input type="color" name="dark_color_sub" value="{{ $colors['dark_color_sub'] }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
								</td>
								<td class="p-2">
									<input type="color" name="dark_color_reverse" value="{{ $colors['dark_color_reverse'] }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
								</td>
							</tr>
						</tbody>
					</table>
					<div class="flex justify-end">
						<input type="submit" name="submit" value="変更する" class="px-2 py-1 bg-graylight rounded hover:bg-graylight-dark">
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="py-1">
		<div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
			<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
				<?php
					$viewContributor = $options->view_contributor;
					$checked = "";
					if ( $viewContributor ) $checked = " checked";
				?>
				<form action="/option/update/viewContributor" method="post" name="formViewContributor" class="m-4 flex justify-between content-center">
					@csrf
					<label class="block">
						<span class="text-gray-700 mr-3">投稿者表示</span>
						<input type="checkbox" name="view_contributor"<?php echo $checked; ?>>
					</label>
					<div class="">
						<input type="submit" name="submit" value="変更する" class="px-2 py-1 bg-graylight rounded hover:bg-graylight-dark">
					</div>
				</form>
			</div>
		</div>
	</div>
</x-app-layout>