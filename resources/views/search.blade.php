@include("components.header")

<h1 class="alert alert-primary">検索</h1>

<section class="resSearch">
  <div class="container">
    @if( $error )
      <h2 class="alert alert-danger mt-5">{{ $error }}</h2>
    @endif

    @if( count($words) > 0 )
      <div class="searchWord">
        <span class="headline">検索キーワード：</span>
        @foreach( $words as $word )
          <span class="px-1">「{{ $word }}」</span>
        @endforeach
      </div>
    @endif

    @if( count($tasks) > 0 )
      <h2 class="text-center mt-5">
        タスクの検索結果
        <small class="ms-3">{{ count($tasks) }}件</small>
      </h2>
			<table class="table">
        @foreach($tasks as $task)
          <tr class="bg-white">
            <td class="title"><a href="/task/{{ $task->id }}">{{ $task->title }}</a></td>
            <td class="term text-left">
              <?php
                $tagArr = setTag($task->tags);
                echoSearchBadge($task->status, $tagArr);
              ?>
            </td>
          </tr>
        @endforeach
			</table>
    @endif

    @if( count($wikis) > 0 )
      <h2 class="text-center mt-5">
        Wikiの検索結果
        <small class="ms-3">{{ count($wikis) }}件</small>
      </h2>
			<table class="table">
        @foreach($wikis as $wiki)
          <tr class="bg-white">
            <td class="title"><a href="/wiki/{{ $wiki->id }}">{{ $wiki->title }}</a></td>
            <td class="term text-left">
              <?php
                $tagArr = setTag($wiki->tags);
                echoSearchBadge("", $tagArr);
              ?>
            </td>
          </tr>
        @endforeach
			</table>
    @endif
  </div>
</section>

@include("components.footer")