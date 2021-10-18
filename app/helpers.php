<?php

declare(strict_types=1);

use App\Models\Tasks;
use Illuminate\Support\Facades\Auth;
use App\Models\Status;
use App\Models\Wiki;
use App\Models\Schedule;
use App\Models\Option;

/**
 * モーダルからのタスク編集・追加
 */
function modalEditTask($m = "")
{
  $title      = "タスク編集";
  $submit     = "editSubmit";
  $submitName = "編集する";
  $modalId    = "Edit";
  $data       = "toDo";
  $delete     = true;
  $disabled   = "disabledEdit";
  if (empty($m)) {
    $title      = "タスク追加";
    $submit     = "addSubmit";
    $submitName = "追加する";
    $modalId    = "Add";
    $data       = "addData";
    $delete     = false;
    $disabled   = "disabledSubmit";
  }
?>
  <div class="modal fade" id="task<?php echo $modalId; ?>Modal" tabindex="-1" aria-labelledby="task<?php echo $modalId; ?>ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="task<?php echo $modalId; ?>ModalLabel"><?php echo $title; ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form name="addTaskForm">

            <div class="mb-2">
              <i class="fas fa-circle text-primary"></i>
              <strong>タイトル</strong>
            </div>
            <input type="text" v-model="<?php echo $data; ?>.title" name="title" class="form-control">

            <div class="mt-4 mb-2">
              <i class="fas fa-circle text-primary"></i>
              <strong>内容</strong>
            </div>
            <mavon-editor
              :language="'ja'"
              v-model="<?php echo $data; ?>.contents"
              placeholder="Markdown記入OK"
              :toolbars="mavonEditor.toolbars"
            >
            </mavon-editor>

            <div class="row row-cols-1 row-cols-sm-2 mt-4 mb-2">
              <div class="col">
                <div class="mb-2">
                  <i class="fas fa-circle text-primary"></i>
                  <strong>タグ</strong>
                </div>
                <tags-input element-id="tags" v-model="<?php echo $data; ?>.tags" placeholder="タグを追加" :existing-tags="existingTags" :typeahead="true">
                </tags-input>
              </div>
              <div class="col">
                <div class="mb-2">
                  <i class="fas fa-circle text-primary"></i>
                  <strong>Follow?</strong>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="forever_key" id="forever_key1_<?php echo $data; ?>" value="1" v-model="<?php echo $data; ?>.follow">
                  <label class="form-check-label" for="forever_key1_<?php echo $data; ?>">
                    はい
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="forever_key" id="forever_key2_<?php echo $data; ?>" value="0" v-model="<?php echo $data; ?>.follow">
                  <label class="form-check-label" for="forever_key2_<?php echo $data; ?>">
                    いいえ
                  </label>
                </div>
              </div>
            </div>

            <div class="row row-cols-1 row-cols-sm-2 mt-4">
              <div class="col">
                <div class="mb-2">
                  <i class="fas fa-circle text-primary"></i>
                  <strong>ステータス</strong>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="taskStatus" id="taskStatus1_<?php echo $data; ?>" value="1" v-model="<?php echo $data; ?>.status">
                  <label class="form-check-label" for="taskStatus1_<?php echo $data; ?>">
                    待機中
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="taskStatus" id="taskStatus2_<?php echo $data; ?>" value="2" v-model="<?php echo $data; ?>.status">
                  <label class="form-check-label" for="taskStatus2_<?php echo $data; ?>">
                    処理中
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="taskStatus" id="taskStatus3_<?php echo $data; ?>" value="3" v-model="<?php echo $data; ?>.status">
                  <label class="form-check-label" for="taskStatus3_<?php echo $data; ?>">
                    確認中
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="taskStatus" id="taskStatus4_<?php echo $data; ?>" value="4" v-model="<?php echo $data; ?>.status">
                  <label class="form-check-label" for="taskStatus4_<?php echo $data; ?>">
                    完了
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="taskStatus" id="taskStatus5_<?php echo $data; ?>" value="5" v-model="<?php echo $data; ?>.status">
                  <label class="form-check-label" for="taskStatus5_<?php echo $data; ?>">
                    アーカイブ
                  </label>
                </div>
              </div>
              <div class="col">
                <div class="mb-2">
                  <i class="fas fa-circle text-primary"></i>
                  <strong>開始日</strong>
                </div>
                <input type="date" name="start_key" v-model="<?php echo $data; ?>.start" class="form-control">
                <div class="mt-4 mb-2">
                  <i class="fas fa-circle text-primary"></i>
                  <strong>終了日</strong>
                </div>
                <input type="date" name="end_key" v-model="<?php echo $data; ?>.end" class="form-control">
                <div class="mt-4">
                  <i class="fas fa-circle text-primary"></i>
                  <strong>進捗</strong>
                </div>
                <div class="modalProgress">
                  <input type="range" name="progress_key" class="ms-2" v-model="<?php echo $data; ?>.progress" min="0" max="100">
                </div>
              </div>
            </div>

          </form>
        </div>
        <div class="modal-footer justify-content-between">
          <div>
            <button
              type="button"
              class="btn btn-primary"
              :disabled="<?php echo $disabled; ?>"
              @click="<?php echo $submit; ?>"
            >
              <?php echo $submitName; ?>
            </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
          </div>
          <?php if ($delete) { ?>
            <button type="button" class="btn btn-light" @click="deleteTask(<?php echo $data; ?>.id)">削除する</button>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
<?php }


/**
 * モーダルからのWiki編集・追加
 */
function modalEditWiki($m = "")
{
  $title      = "Wiki編集";
  $submit     = "editSubmit";
  $submitName = "編集する";
  $modalId    = "Edit";
  $data       = "toDo";
  $delete     = true;
  $disabled   = "disabledEdit";
  if (empty($m)) {
    $title      = "Wiki追加";
    $submit     = "addSubmit";
    $submitName = "追加する";
    $modalId    = "Add";
    $data       = "addData";
    $delete     = false;
    $disabled   = "disabledAdd";
  }
?>
  <div class="modal fade" id="wiki<?php echo $modalId; ?>Modal" tabindex="-1" aria-labelledby="wiki<?php echo $modalId; ?>ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="wiki<?php echo $modalId; ?>ModalLabel"><?php echo $title; ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form name="addTaskForm">

            <div class="mb-2">
              <i class="fas fa-circle text-primary"></i>
              <strong>タイトル</strong>
            </div>
            <input type="text" v-model="<?php echo $data; ?>.title" name="title" class="form-control">

            <div class="mt-4 mb-2">
              <i class="fas fa-circle text-primary"></i>
              <strong>内容</strong>
            </div>
            <mavon-editor
              :language="'ja'"
              v-model="<?php echo $data; ?>.contents"
              placeholder="Markdown記入OK"
              :toolbars="mavonEditor.toolbars"
            >
            </mavon-editor>
            <div class="row row-cols-1 row-cols-sm-2 mt-4 mb-2">
              <div class="col">
                <div class="mb-2">
                  <i class="fas fa-circle text-primary"></i>
                  <strong>タグ</strong>
                </div>
                <tags-input element-id="tags" v-model="<?php echo $data; ?>.tags" placeholder="タグを追加" :existing-tags="existingTags" :typeahead="true">
                </tags-input>
              </div>
            </div>

          </form>
        </div>
        <div class="modal-footer justify-content-between">
          <div>
            <button
              type="button"
              class="btn btn-primary"
              :disabled="<?php echo $disabled; ?>"
              @click="<?php echo $submit; ?>"
            >
              <?php echo $submitName; ?>
            </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
          </div>
          <?php if ($delete) { ?>
            <button type="button" class="btn btn-light" @click="deleteTask(toDo.id)">削除する</button>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
<?php }


/**
 * モーダルからのスケジュール編集・追加
 */
function modalEditSchedule()
{ ?>
  <div class="modal fade" id="scheduleAddModal" tabindex="-1" aria-labelledby="scheduleAddModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="scheduleAddModalLabel">スケジュール追加</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form name="addTaskForm">
            <div class="mb-2">
              <i class="fas fa-circle text-primary"></i>
              <strong>タイトル</strong>
            </div>
            <input type="text" v-model="title" name="title" class="form-control">
          </form>
        </div>
        <div class="modal-footer justify-content-between">
          <div>
            <button
              type="button"
              class="btn btn-primary"
              :disabled="disabledSubmit"
              @click="addSubmit()"
            >
              追加する
            </button>
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              キャンセル
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php }


/**
 * ボードのタイトル出力
 */
function echoBoardTitle($t, $c, $s, $n)
{ ?>
  <div class="boardTitle">
    <div>
      <i class="fas fa-circle text-<?php echo $c; ?>"></i>
      <h2><?php echo $t; ?></h2>
      <span class="badge rounded-pill bg-secondary text-white px-3" v-text="toDo.<?php echo $s; ?>.length"></span>
    </div>
    <i class="fas fa-plus-circle text-dark" data-bs-toggle="modal" data-bs-target="#taskAddModal" @click="setModal('<?php echo $n; ?>')">
    </i>
  </div>
<?php }


/**
 * ドラッガブル出力 タスク用
 */
function echoDraggable($s)
{ ?>
  <draggable tag="ul" class="list-group p-3" :options="{group:'ITEMS', handle:'.handle'}" v-model="toDo.<?php echo $s; ?>">
    <li v-for="(v, i) in toDo.<?php echo $s; ?>" :key="i" @touchstart="dragStart(v.id)" @dragstart="dragStart(v.id)" class="list-group-item d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center w-100">
        <i class="fas fa-grip-vertical text-gray handle me-3"></i>
        <div>
          <h3><a :href="'/task/' + v.id" v-text="v.title" class="text-decoration-none text-dark"></a></h3>
          <div><span v-for="tag in v.tags" class="me-1 badge bg-danger" v-text="tag"></span></div>
          <div v-if="viewContributor" v-text="v.userName" class="badge bg-dark"></div>
        </div>
        <?php if ($s === "archives") { ?>
          <i class="fas fa-trash ms-auto" @click="deleteTask(v.id)"></i>
        <?php } ?>
      </div>
    </li>
  </draggable>
<?php }


/**
 * toDoデータをカテゴリごとに変換してjsonエンコードして返す
 */
function getToDoDataConverted()
{
  $toDoData         = getToDoDataBoard();
  $arr["pending"]   = [];
  $arr["continue"]  = [];
  $arr["confirm"]   = [];
  $arr["complete"]  = [];
  $arr["archives"]  = [];
  foreach ($toDoData as $k => $v) {
    if ($v["category"] === 1) {
      $arr["pending"][] = $v;
    }
    if ($v["category"] === 2) {
      $arr["continue"][] = $v;
    }
    if ($v["category"] === 3) {
      $arr["confirm"][] = $v;
    }
    if ($v["category"] === 4) {
      $arr["complete"][] = $v;
    }
    if ($v["category"] === 5) {
      $arr["archives"][] = $v;
    }
  }
  return json_encode($arr);
}


/**
 * タスクデータ取得
 */
function getToDoData()
{
  date_default_timezone_set('Asia/Tokyo');
  $arr  = [];
  $tasks = Tasks::getAllOrder();
  if (count($tasks) > 0) :
    foreach ($tasks as $k => $v) :
      $id           = $v["id"];
      $content      = $v["contents"];
      $title        = $v["title"];
      $category     = $v["status"];
      $sort         = empty($v["sort"]) ? 0 : $v["sort"];
      $start        = empty($v["start_time"]) ? date("Y-m-d") : convertYmd($v["start_time"]);
      $end          = empty($v["end_time"]) ? date("Y-m-d") : convertYmd($v["end_time"]);
      $endUnix      = strtotime($end);
      $nowUnix      = strtotime("today");
      $diffUnix     = $endUnix - $nowUnix;
      if ($diffUnix < 0) {
        $end = date("Y-m-d");
      }
      $progress     = empty($v["progress"]) ? 1 : $v["progress"];
      $forever      = empty($v["follow"]) ? 0 : $v["follow"];
      if ($forever == 1) {
        $start      = date('Y-m-d');
      }
      $tags         = json_decode($v["tags"]);
      $tagArr       = [];
      foreach ($tags as $k2 => $v2) {
        $tagArr[] = $v2;
      }
      $arr[]        = [
        "id"        => $id,
        "title"     => $title,
        "content"   => $content,
        "category"  => $category,
        "sort"      => $sort,
        "start"     => $start,
        "end"       => $end,
        "progress"  => $progress,
        "forever"   => $forever,
        "tags"      => $tagArr,
      ];
      $ids = array_column($arr, 'sort');
      array_multisort($ids, SORT_ASC, $arr);
    endforeach;
  endif;
  return $arr;
}


/**
 * タスクデータ取得 ボードページ用
 */
function getToDoDataBoard()
{
  date_default_timezone_set('Asia/Tokyo');
  $arr  = [];
  $tasks = Tasks::getAllOrder();
  if (count($tasks) > 0) :
    foreach ($tasks as $k => $v) :
      $tags         = json_decode($v["tags"]);
      $tagArr       = [];
      foreach ($tags as $k2 => $v2) {
        $tagArr[] = $v2;
      }
      $arr[]        = [
        "id"        => $v["id"],
        "userId"    => $v["user_id"],
        "userName"  => $v["user_name"],
        "title"     => $v["title"],
        "category"  => $v["status"],
        "sort"      => empty($v["sort"]) ? 0 : $v["sort"],
        "tags"      => $tagArr,
      ];
      $ids = array_column($arr, 'sort');
      array_multisort($ids, SORT_ASC, $arr);
    endforeach;
  endif;
  return $arr;
}


/**
 * Follow 追従 選択スイッチ
 */
function getFollow($b)
{
  if (empty($b)) return "false";
  return "true";
}


/**
 * タスクの全てのタグをJSONで取得
 */
function getTagsAll()
{
  $tags = Tasks::getAllTag();
  $tagJson = json_encode($tags, JSON_UNESCAPED_UNICODE);
  return $tagJson;
}


/**
 * Wikiの全てのタグをJSONで取得
 */
function getTagsAllWiki()
{
  $tags = Wiki::getAllTag();
  $tagJson = json_encode($tags, JSON_UNESCAPED_UNICODE);
  return $tagJson;
}


/**
 * タスクとWikiの全てのタグを取得
 */
function getTagsTaskWiki()
{
  $tagsT = Tasks::getAllTag();
  $tagsW = Wiki::getAllTag();
  $tagsA = array_merge($tagsT, $tagsW);
  $tagsU = myArrayUnique($tagsA);
  $res = [];
  foreach ($tagsU as $k => $v) {
    $res[] = $v;
  }
  return json_encode($res);
}


/**
 * 連想配列の重複削除
 */
function myArrayUnique($array)
{
  $uniqueArray = [];
  foreach ($array as $key => $value) {
    if (!in_array($value, $uniqueArray)) {
      $uniqueArray[$key] = $value;
    }
  }
  return $uniqueArray;
}


/**
 * タスクのタグをJSONで取得
 */
function getJsonTags($id)
{
  $tags = Tasks::getTheTags($id);
  return $tags;
}


/**
 * WikiのタグをJSONで取得
 */
function getJsonTagsWiki($id)
{
  $tags = Wiki::getTheTags($id);
  return $tags;
}


/**
 * Y-m-d H:i:s を Y-m-d に変換
 * 開始と終了時間変換
 */
function convertYmd($t)
{
  $ymd = date('Y-m-d',  strtotime($t));
  return $ymd;
}


/**
 * Follow 追従 入り切り替え
 */
function registFollow($id, $e)
{
  $judge = $e === "true" ? 1 : 0;
  return $judge;
}


/**
 * ドラッガブル出力 Wiki用
 */
function echoDraggableWiki()
{ ?>
  <draggable tag="ul" class="list-group p-3" :options="{group:'ITEMS', handle:'.handle'}" v-model="toDo">
    <li v-for="(v, i) in toDo" :key="i" @touchstart="dragStart(v.id)" @dragstart="dragStart(v.id)" class="list-group-item d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center">
        <i class="fas fa-grip-vertical text-gray handle me-3"></i>
        <a :href="'/wiki/' + v.id" v-text="v.title" class="text-decoration-none text-dark"></a>
      </div>
    </li>
  </draggable>
<?php }


/**
 * WikiデータをJSON出力 リスト用
 */
function getWikiList()
{
  $items = Wiki::getAll();
  $arr = [];
  foreach ($items as $k => $v) {
    $id           = $v->id;
    $title        = $v->title;
    $sort         = empty($v->sort) ? 0 : $v->sort;
    $arr[]        = [
      "id"        => $id,
      "title"     => $title,
      "sort"      => $sort,
    ];
    $ids = array_column($arr, 'sort');
    array_multisort($ids, SORT_ASC, $arr);
  }
  return json_encode($arr, JSON_UNESCAPED_UNICODE);
}


/**
 * WikiデータをJSON出力 編集モーダル用
 */
function getWikiById($id)
{
  $items    = Wiki::getById($id);
  $tags     = setTagObj(json_decode($items->tags));
  $arr      = [
    "id"       => $items->id,
    "title"    => $items->title,
    "tags"     => $tags,
    "contents" => $items->contents,
  ];
  return json_encode($arr, JSON_UNESCAPED_UNICODE);
}


/**
 * スケジュールデータをJSON出力 編集モーダル用
 */
function getScheduleById($id)
{
  $items    = Schedule::findOrFail($id);
  dd($items);
  $tags     = setTagObj(json_decode($items->tags));
  $arr      = [
    "id"       => $items->id,
    "title"    => $items->title,
    "tags"     => $tags,
    "contents" => $items->contents,
  ];
  return json_encode($arr, JSON_UNESCAPED_UNICODE);
}


/**
 * タスクデータをJSON出力 編集モーダル用
 */
function getTaskById($id)
{
  $items = Tasks::getById($id);
  $arr = [
    "id"       => $items->id,
    "title"    => $items->title,
    "contents" => $items->contents,
    "tags"     => setTagObj(json_decode($items->tags)),
    "follow"   => $items->follow,
    "status"   => $items->status,
    "start"    => convertYmd($items->start_time),
    "end"      => convertYmd($items->end_time),
    "progress" => $items->progress,
  ];
  return json_encode($arr, JSON_UNESCAPED_UNICODE);
}


/**
 * タスクの状態設定
 */
function setStatus($id)
{
  $catClass = "btn-secondary";
  $catName  = "";
  if ($id === 1) {
    $catClass = "btn-secondary";
    $catName  = "待機中";
  }
  if ($id === 2) {
    $catClass = "btn-info";
    $catName  = "処理中";
  }
  if ($id === 3) {
    $catClass = "btn-warning";
    $catName  = "確認中";
  }
  if ($id === 4) {
    $catClass = "btn-gray";
    $catName  = "完了";
  }
  if ($id === 5) {
    $catClass = "btn-gray";
    $catName  = "アーカイブ";
  }
  $res = [
    "class" => $catClass,
    "catName" => $catName,
  ];
  return $res;
}


/**
 * タグ設定 配列返し
 */
function setTag($t)
{
  $tags   = json_decode($t);
  $tagArr = [];
  if (count($tags) > 0) {
    foreach ($tags as $k => $v) {
      $tagArr[] = $v;
    }
  }
  return $tagArr;
}

/**
 * タグ設定 オブジェクト返し
 */
function setTagObj($t)
{
  $res = [];
  if (count($t) > 0) {
    foreach ($t as $k => $v) {
      $obj = [
        "key" => $v,
        "value" => $v
      ];
      $res[] = $obj;
    }
  }
  return $res;
}


/**
 * ガントチャートHTML出力
 */
function echoGantchartHtml($slug, $title, $color)
{ ?>
  <div class='gantt-wrap'>
    <div class="d-flex justify-content-between my-2">
      <div class="d-flex align-items-center">
        <i class="fas fa-circle text-<?php echo $color; ?> me-2"></i>
        <h2><?php echo $title; ?></h2>
      </div>
      <div>
        <div class="btn btn-dark me-1" onClick="change_view('Day', '<?php echo $slug; ?>')">Day</div>
        <div class="btn btn-dark me-1" onClick="change_view('Week', '<?php echo $slug; ?>')">Week</div>
        <div class="btn btn-dark" onClick="change_view('Month', '<?php echo $slug; ?>')">Month</div>
      </div>
    </div>
    <svg id="<?php echo $slug; ?>"></svg>
  </div>
  <?php }


/**
 * タスクチャートJS出力
 */
function echoGantchartJs($slug)
{
  if ($slug === "schedule") { ?>
    let tasks = <?php echo getScheduleDataConvertedGant(); ?>;
  <?php } else { ?>
    var tasks = <?php echo getTaskDataConvertedGant($slug); ?>;
  <?php } ?>
  if(tasks.length > 0){
  var gantt_<?php echo $slug; ?> = new Gantt("#<?php echo $slug; ?>", tasks, {
  // ダブルクリック時
  on_click: (task) => {
  location.href = "/task/" + task.id;
  },
  // 日付変更時
  on_date_change: (task, start, end) => {
  let ys = start.getFullYear();
  let ms = zeroPadding(start.getMonth() + 1, 2);
  let ds = zeroPadding(start.getDate(), 2);
  let ymds = ys + "-" + ms + "-" + ds;
  let ye = end.getFullYear();
  let me = zeroPadding(end.getMonth() + 1, 2);
  let de = zeroPadding(end.getDate(), 2);
  let ymde = ye + "-" + me + "-" + de;
  let ajaxUrl = '/chart/upschedule';
  let params = new URLSearchParams();
  if (task.idSche) {
  params.append('targetID', task.idSche);
  }else{
  params.append('targetID', task.id);
  }
  params.append('start', ymds);
  params.append('end', ymde);
  const param = {
  method: "POST",
  headers: {
  'X-CSRF-TOKEN': document.getElementsByName('csrf-token')[0].content
  },
  body: params
  }
  fetch(ajaxUrl, param)
  .then(res => res.json())
  .then(res => {
  location.reload();
  })
  .catch(error => {
  alert(error + "\n送信失敗");
  });
  },
  // 進捗変更時
  on_progress_change: (task, progress) => {
  let ajaxUrl = '/chart/upprogress';
  let params = new URLSearchParams();
  if (task.idSche) {
  params.append('targetID', task.idSche);
  }else{
  params.append('targetID', task.id);
  }
  params.append('progress', progress);
  const param = {
  method: "POST",
  headers: {
  'X-CSRF-TOKEN': document.getElementsByName('csrf-token')[0].content
  },
  body: params
  }
  fetch(ajaxUrl, param)
  .then(res => res.json())
  .then(res => {
  location.reload();
  })
  .catch(error => {
  alert(error + "\n送信失敗");
  });
  },
  custom_popup_html: function(task) {
  let tags = task.tags;
  let tagStr = "";
  for( v of tags ){
  tagStr = tagStr + "<span class='badge bg-light text-dark me-1'>" + v + "</span>";
  }
  return `
  <div class="details-container">
    <div class="title">${task.name}</div>
    <div class="span">${task.start} ～ ${task.end}</div>
    <div class="comp">${task.progress}% completed!</div>
    <div class="desc">${tagStr}</div>
  </div>
  `;
  },
  view_mode: 'Day',
  header_height: 50,
  column_width: 30,
  step: 100,
  bar_height: 30,
  padding: 18,
  date_format: 'YYYY-MM-DD',
  });
  }
<?php }


/**
 * スケジュールデータをガントチャート用に変換してjsonエンコードして返す
 */
function getScheduleDataConvertedGant()
{
  $schedules = getScheduleData();
  $tasks     = getToDoData();
  $arr  = [];
  foreach ($schedules as $k => $v) {
    $arr[] = [
      "id"           => $v["title"],
      "idSche"       => strval($v["id"]),
      "name"         => $v["title"],
      "start"        => date('Y-m-d', strtotime('-1 day')),
      "end"          => date("Y-m-d"),
      "progress"     => 100,
    ];
    foreach ($tasks as $k2 => $v2) {
      if ($v2["category"] == 5 || $v2["category"] == 1) continue;
      foreach ($v2["tags"] as $k3 => $v3) {
        if ($v["title"] === $v3) {
          $arr[] = [
            "id"           => strval($v2["id"]),
            "name"         => $v2["title"],
            "description"  => $v2["content"],
            "start"        => $v2["start"],
            "end"          => $v2["end"],
            "progress"     => $v2["progress"],
            "forever"      => $v2["forever"],
            "tags"         => $v2["tags"],
            "dependencies" => $v3,
          ];
        }
      }
    }
  }
  return json_encode($arr, JSON_UNESCAPED_UNICODE);
}


/**
 * タスクデータをガントチャート用に変換してjsonエンコードして返す
 */
function getTaskDataConvertedGant($t)
{
  $status = 1;
  if ($t === "continue") $status = 2;
  if ($t === "confirm") $status = 3;
  $taskData = getToDoData();
  $arr      = [];
  foreach ($taskData as $k => $v) {
    if ($v["category"] === $status) {
      $dependencies = "";
      foreach ($v["tags"] as $k2 => $v2) {
        $dependencies .= $v2;
        if (array_key_last($v["tags"]) !== $k2) {
          $dependencies .= ",";
        }
      }
      $arr[] = [
        "id"           => strval($v["id"]),
        "name"         => $v["title"],
        "description"  => $v["content"],
        "start"        => $v["start"],
        "end"          => $v["end"],
        "progress"     => strval($v["progress"]),
        "forever"      => strval($v["forever"]),
        "tags"         => $v["tags"],
        "dependencies" => "",
        "link" => "",
      ];
    }
  }
  return json_encode($arr, JSON_UNESCAPED_UNICODE);
}

/**
 * スケジュールデータ取得
 */
function getScheduleData()
{
  $team_id   = Auth::user()->current_team_id;
  $items = Schedule::where("team_id", $team_id)->get();
  $arr   = [];
  if ( count($items) > 0 ) :
    foreach ($items as $k => $v) :
      $id           = $v->id;
      $title        = $v->title;
      $sort         = empty($v->sort) ? 0 : $v->sort;
      $slug         = "";
      $content      = "";
      $link         = "";
      $start        = "";
      $end          = "";
      $endUnix      = "";
      $nowUnix      = "";
      $diffUnix     = "";
      $progress     = "";
      $forever      = "";
      $tagArr       = [];
      $arr[]        = [
        "id"        => $id,
        "title"     => $title,
        "slug"      => $slug,
        "sort"      => $sort,
        "content"   => $content,
        "link"      => $link,
        "start"     => $start,
        "end"       => $end,
        "progress"  => $progress,
        "forever"   => $forever,
        "tags"      => $tagArr,
      ];
      $ids = array_column($arr, 'sort');
      array_multisort($ids, SORT_ASC, $arr);
    endforeach;
  endif;
  return $arr;
}


/**
 * ドラッガブル出力 スケジュール用
 */
function echoDraggableSchedule()
{ ?>
  <draggable tag="ul" class="d-flex flex-wrap p-0 m-0" :options="{group:'ITEMS', handle:'.handle'}" v-model="data">
    <li v-for="(v, i) in data" :key="i" @touchstart="dragStart(v.id)" @dragstart="dragStart(v.id)" class="d-flex justify-content-between align-items-center me-2 mb-2 draggableSchedule">
      <div class="d-flex align-items-center bg-white p-3 rounded">
        <i class="fas fa-grip-vertical text-gray handle me-3"></i>
        <div>
          <h3>
            <button
              v-text="v.title"
              class="text-dark"
              data-bs-toggle="modal"
              :data-bs-target="'#scheduleEditModal' + v.id"
              @click="setTarget(i)"
            >
            </button>
          </h3>
        </div>
      </div>
      <div class="modal fade" :id="'scheduleEditModal' + v.id" tabindex="-1" :aria-labelledby="'scheduleEditModalLabel' + v.id" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" :id="'scheduleEditModalLabel' + v.id">スケジュール編集</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form name="addTaskForm">
                <div class="mb-2">
                  <i class="fas fa-circle text-primary"></i>
                  <strong>タイトル</strong>
                </div>
                <input type="text" v-model="v.title" name="title" class="form-control">
              </form>
            </div>
            <div class="modal-footer justify-content-between">
              <div>
                <button
                  type="button"
                  class="btn btn-primary"
                  :disabled="disabledSubmit"
                  @click="editSubmit(v.id, v.title)"
                >
                  編集する
                </button>
                <button
                  type="button"
                  class="btn btn-secondary"
                  data-bs-dismiss="modal"
                  @click="editCancel()"
                >
                  キャンセル
                </button>
              </div>
              <button
                type="button"
                class="btn btn-light"
                @click="deleteSchedule(v.id)"
              >
                削除する
              </button>
            </div>
          </div>
        </div>
      </div>
    </li>
  </draggable>
  <?php }


/**
 * スケジュールデータをjsonエンコードして返す
 */
function getScheduleDataConverted()
{
  $data = getScheduleData();
  return json_encode($data, JSON_UNESCAPED_UNICODE);
}


/**
 * URLエンコードして小文字で返す
 */
function convertUrlLower($s)
{
  $r = urlencode($s);
  $r = strtolower($r);
  return $r;
}


/**
 * 検索結果のステータス出力
 */
function echoSearchBadge($s = "", $t = [])
{
  $status = "";
  $bg = " bg-dark";
  if ($s === 1) {
    $status = "待機中";
    $bg = " bg-secondary";
  }
  if ($s === 2) {
    $status = "処理中";
    $bg = " bg-primary";
  }
  if ($s === 3) {
    $status = "確認中";
    $bg = " bg-info";
  }
  if ($s === 4) {
    $status = "完了";
    $bg = " bg-dark";
  }
  if (!empty($s)) { ?>
    <span class="badge<?php echo $bg; ?> ms-1"><?php echo $status; ?></span>
  <?php }
  foreach ($t as $k => $v) { ?>
    <span class="badge bg-danger ms-1"><?php echo $v; ?></span>
<?php }
}


/**
 * ヘッド内へのテーマカラー出力
 */
function colorCustomizer()
{
  $colors = Option::getThemeColor();
  ?>
  <style type="text/css">
    a {
      color: <?php echo $colors['primary_color']; ?>;
      text-decoration: none;
    }
    .navbar-dark .navbar-brand {
      color: <?php echo $colors['head_title_color']; ?>;
    }
    
    .navbar-dark .navbar-nav .nav-link {
      color: <?php echo $colors['head_navi_color']; ?>;
    }
    
    .bg-primary-grade {
      background: <?php echo $colors['primary_color']; ?>;
      background: -moz-linear-gradient(left, <?php echo $colors['primary_color']; ?> 0%, <?php echo $colors['secondary_color']; ?> 100%);
      background: -webkit-gradient(left top, right top, color-stop(0%, <?php echo $colors['primary_color']; ?>), color-stop(100%, <?php echo $colors['secondary_color']; ?>));
      background: -webkit-linear-gradient(left, <?php echo $colors['primary_color']; ?> 0%, <?php echo $colors['secondary_color']; ?> 100%);
      background: -o-linear-gradient(left, <?php echo $colors['primary_color']; ?> 0%, <?php echo $colors['secondary_color']; ?> 100%);
      background: -ms-linear-gradient(left, <?php echo $colors['primary_color']; ?> 0%, <?php echo $colors['secondary_color']; ?> 100%);
      background: linear-gradient(to right, <?php echo $colors['primary_color']; ?> 0%, <?php echo $colors['secondary_color']; ?> 100%);
      filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ef017c', endColorstr='#ff5db1', GradientType=1);
    }
    
    .text-primary {
      color: <?php echo $colors['primary_color']; ?> !important;
    }
    
    .text-secondary {
      color: <?php echo $colors['secondary_color']; ?> !important;
    }
    
    .text-success {
      color: <?php echo $colors['success_color']; ?> !important;
    }
    
    .text-info {
      color: <?php echo $colors['info_color']; ?> !important;
    }
    
    .text-warning {
      color: <?php echo $colors['warning_color']; ?> !important;
    }
    
    .text-danger {
      color: <?php echo $colors['danger_color']; ?> !important;
    }
    
    .text-light {
      color: <?php echo $colors['light_color']; ?> !important;
    }
    
    .text-dark {
      color: <?php echo $colors['dark_color']; ?> !important;
    }
    
    .bg-primary {
      background-color: <?php echo $colors['primary_color']; ?> !important;
      color: <?php echo $colors['primary_color_reverse']; ?> !important;
    }
    
    .bg-secondary {
      background-color: <?php echo $colors['secondary_color']; ?> !important;
      color: <?php echo $colors['secondary_color_reverse']; ?> !important;
    }
    
    .bg-success {
      background-color: <?php echo $colors['success_color']; ?> !important;
      color: <?php echo $colors['success_color_reverse']; ?> !important;
    }
    
    .bg-info {
      background-color: <?php echo $colors['info_color']; ?> !important;
      color: <?php echo $colors['info_color_reverse']; ?> !important;
    }
    
    .bg-warning {
      background-color: <?php echo $colors['warning_color']; ?> !important;
      color: <?php echo $colors['warning_color_reverse']; ?> !important;
    }
    
    .bg-danger {
      background-color: <?php echo $colors['danger_color']; ?> !important;
      color: <?php echo $colors['danger_color_reverse']; ?> !important;
    }
    
    .bg-light {
      background-color: <?php echo $colors['light_color']; ?> !important;
      color: <?php echo $colors['light_color_reverse']; ?> !important;
    }
    
    .bg-dark {
      background-color: <?php echo $colors['dark_color']; ?> !important;
      color: <?php echo $colors['dark_color_reverse']; ?> !important;
    }
    
    .btn-primary {
      color: <?php echo $colors['primary_color_reverse']; ?>;
      background-color: <?php echo $colors['primary_color_sub']; ?>;
      border-color: <?php echo $colors['primary_color']; ?>;
    }
    
    .btn-secondary {
      color: <?php echo $colors['secondary_color_reverse']; ?>;
      background-color: <?php echo $colors['secondary_color_sub']; ?>;
      border-color: <?php echo $colors['secondary_color']; ?>;
    }
    
    .btn-success {
      color: <?php echo $colors['success_color_reverse']; ?>;
      background-color: <?php echo $colors['success_color_sub']; ?>;
      border-color: <?php echo $colors['success_color']; ?>;
    }
    
    .btn-info {
      color: <?php echo $colors['info_color_reverse']; ?>;
      background-color: <?php echo $colors['info_color_sub']; ?>;
      border-color: <?php echo $colors['info_color']; ?>;
    }
    
    .btn-warning {
      color: <?php echo $colors['warning_color_reverse']; ?>;
      background-color: <?php echo $colors['warning_color_sub']; ?>;
      border-color: <?php echo $colors['warning_color']; ?>;
    }
    
    .btn-danger {
      color: <?php echo $colors['danger_color_reverse']; ?>;
      background-color: <?php echo $colors['danger_color_sub']; ?>;
      border-color: <?php echo $colors['danger_color']; ?>;
    }
    
    .btn-light {
      color: <?php echo $colors['light_color_reverse']; ?>;
      background-color: <?php echo $colors['light_color_sub']; ?>;
      border-color: <?php echo $colors['light_color']; ?>;
    }
    
    .btn-dark {
      color: <?php echo $colors['dark_color_reverse']; ?>;
      background-color: <?php echo $colors['dark_color_sub']; ?>;
      border-color: <?php echo $colors['dark_color']; ?>;
    }
    .btn-check:focus+.btn-primary,
    .btn-primary:focus,
    .btn-primary:hover {
      background-color: <?php echo $colors['primary_color']; ?> !important;
      border-color: <?php echo $colors['primary_color_sub']; ?> !important;
      color: <?php echo $colors['primary_color_reverse']; ?> !important;
    }
    .btn-check:focus+.btn-secondary,
    .btn-secondary:focus,
    .btn-secondary:hover {
      background-color: <?php echo $colors['secondary_color_sub']; ?> !important;
      border-color: <?php echo $colors['secondary_color']; ?> !important;
      color: <?php echo $colors['secondary_color_reverse']; ?> !important;
    }
    .card-body.single .h1,
    .card-body.single h1 {
      border-bottom: 4px solid <?php echo $colors['primary_color']; ?> !important;
    }
    .markdown-body h1 {
      border-bottom: 4px solid <?php echo $colors['primary_color']; ?> !important;
      margin-bottom: 1rem !important;
    }
    .card-body.single .h2:before,
    .card-body.single h2:before {
      color: <?php echo $colors['primary_color']; ?>;
    }
    .markdown-body h2:before {
      color: <?php echo $colors['primary_color']; ?> !important;
    }
    .card-body.single h3:before,
    .card-body.single .h3:before {
      color: <?php echo $colors['primary_color']; ?>;
    }
    .markdown-body h3 {
      margin-bottom: 1rem !important;
    }
    .markdown-body h3:before {
      color: <?php echo $colors['primary_color']; ?> !important;
    }
    .markdown-body p {
      margin-bottom: 1rem !important;
    }
    .markdown-body ol {
      margin-bottom: 1rem !important;
    }
    .markdown-body ul {
      margin-bottom: 1rem !important;
    }
    .alert-danger {
      color: <?php echo $colors['danger_color_reverse']; ?>;
      background-color: <?php echo $colors['danger_color_sub']; ?>;
      border-color: <?php echo $colors['danger_color']; ?>;
    }
    .alert-primary {
      color: <?php echo $colors['primary_color_reverse']; ?>;
      background-color: <?php echo $colors['primary_color_sub']; ?>;
      border-color: <?php echo $colors['primary_color']; ?>;
    }
    .alert-secondary {
      color: <?php echo $colors['secondary_color_reverse']; ?>;
      background-color: <?php echo $colors['secondary_color']; ?>;
      border-color: <?php echo $colors['secondary_color']; ?>;
    }
    .form-switch .form-check-input:checked {
      background-color: <?php echo $colors['primary_color']; ?> !important;
      border: <?php echo $colors['primary_color']; ?> !important;
    }
    .form-check-input:focus {
      box-shadow: 0 0 0 0.25rem <?php echo $colors['primary_color_sub']; ?>;
    }
    .form-check-input:checked {
      background-color: <?php echo $colors['primary_color_sub']; ?> !important;
      border-color: <?php echo $colors['primary_color']; ?> !important;
    }
    .modalProgress input[type="range"] {
      -webkit-appearance: none;
      appearance: none;
      cursor: pointer;
      background: <?php echo $colors['secondary_color']; ?>;
      height: 12px;
      width: 100%;
      border-radius: 10px;
      border: solid 3px <?php echo $colors['secondary_color']; ?>;
      outline: 0;
    }
    .modalProgress input[type="range"]:focus {
      box-shadow: 0 0 3px rgb(0, 161, 255);
    }
    .modalProgress input[type="range"]::-webkit-slider-thumb {
      -webkit-appearance: none;
      background: <?php echo $colors['secondary_color']; ?>;
      width: 24px;
      height: 24px;
      border-radius: 50%;
      box-shadow: 0px 3px 6px 0px rgba(0, 0, 0, 0.15);
    }
    .modalProgress input[type="range"]::-moz-range-thumb {
      background: <?php echo $colors['secondary_color']; ?>;
      width: 24px;
      height: 24px;
      border-radius: 50%;
      box-shadow: 0px 3px 6px 0px rgba(0, 0, 0, 0.15);
      border: none;
    }
    .modalProgress input[type="range"]::-moz-focus-outer {
      border: 0;
    }
    .modalProgress input[type="range"]:active::-webkit-slider-thumb {
      box-shadow: 0px 5px 10px -2px rgba(0, 0, 0, 0.3);
    }
    .modalProgress input[type="range"]:focus {
      box-shadow: 0 0 3px <?php echo $colors['primary_color']; ?>;
    }
    .progress-bar {
      background-color: <?php echo $colors['info_color_sub']; ?>;
      color: <?php echo $colors['info_color_reverse']; ?>;
      flex-direction: column;
      justify-content: center;
      text-align: center;
      transition: width .6s ease;
      white-space: nowrap;
    }
    .progress-bar-striped {
      background-image: linear-gradient(45deg,hsla(0,0%,100%,.45) 25%,transparent 0,transparent 50%,hsla(0,0%,100%,.45) 0,hsla(0,0%,100%,.45) 75%,transparent 0,transparent);
      background-size: 1rem 1rem;
    }
    .form-control:focus {
      background-color: #fff;
      border-color: <?php echo $colors['primary_color']; ?> !important;
      box-shadow: 0 0 0 0.25rem <?php echo $colors['primary_color_sub']; ?> !important;
      outline: 0;
    }
    [multiple]:focus,
    [type=date]:focus,
    [type=datetime-local]:focus,
    [type=email]:focus,
    [type=month]:focus,
    [type=number]:focus,
    [type=password]:focus,
    [type=search]:focus,
    [type=tel]:focus,
    [type=text]:focus,
    [type=time]:focus,
    [type=url]:focus,
    [type=week]:focus,
    select:focus,
    textarea:focus {
      --tw-ring-inset: var(--tw-empty,/*!*/ /*!*/);
      --tw-ring-offset-width: 0px;
      --tw-ring-offset-color: <?php echo $colors['primary_color_reverse']; ?> !important;
      --tw-ring-color: <?php echo $colors['primary_color']; ?> !important;
      --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
      --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);
      border-color: <?php echo $colors['primary_color']; ?> !important;
      box-shadow: var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow,0 0 #0000);
      outline: 2px solid transparent;
      outline-offset: 2px;
    }
  </style>
<?php }


/**
 * デフォルトテーマカラー
 */
function defaultThemeColor(){
  $colors = [
    "head_title_color"        => "#ffffff",
    "head_navi_color"         => "#ffffff",
    "primary_color"           => "#0772a3",
    "primary_color_sub"       => "#1894ce",
    "primary_color_reverse"   => "#ffffff",
    "secondary_color"         => "#86ace6",
    "secondary_color_sub"     => "#a6c6f7",
    "secondary_color_reverse" => "#ffffff",
    "success_color"           => "#fdd926",
    "success_color_sub"       => "#e9e92b",
    "success_color_reverse"   => "#545454",
    "info_color"              => "#0dcaf0",
    "info_color_sub"          => "#52defa",
    "info_color_reverse"      => "#055464",
    "warning_color"           => "#ffd557",
    "warning_color_sub"       => "#fee9a9",
    "warning_color_reverse"   => "#525252",
    "danger_color"            => "#dc3545",
    "danger_color_sub"        => "#f04a5b",
    "danger_color_reverse"    => "#ffffff",
    "light_color"             => "#f8f9fa",
    "light_color_sub"         => "#dee2e6",
    "light_color_reverse"     => "#000000",
    "dark_color"              => "#212529",
    "dark_color_sub"          => "#495057",
    "dark_color_reverse"      => "#ffffff",
  ];
  return $colors;
}


/**
 * プロジェクトタイトル取得
 */
function getProjectTitle(){
  $team_id = Auth::user()->current_team_id;
  try {
    $data = Option::where("team_id", $team_id)
      ->get()
      ->first()
      ->project_title;
    if ( is_null($data) || empty($data) ) $data = defaultProjectTitle();
    return $data;
  } catch (\Throwable $th) {
    return defaultProjectTitle();
  }
}


/**
 * プロジェクトタイトルのデフォルト値
 */
function defaultProjectTitle(){
  return "プロジェクトタイトル未設定";
}


/**
 * ユーザーIDからチーム内での権限取得
 */
function getRole($user){
  try {
    $role = DB::table("team_user")
      ->join("users", "team_user.user_id", "=", "users.id")
      ->where("user_id", "=", $user->id)
      ->where("team_id", "=", $user->currentTeam->id)
      ->select("team_user.role")
      ->get()->first()->role;
  } catch (\Throwable $th) {
    $role = "";
  }
  return $role;
}


/**
 * タスクの投稿者を表示するかどうか
 */
function echoViewContributor() {
  $bool = Option::boolViewContributor();
  $echo = "false";
  if ( $bool ) $echo = "true";
  echo $echo;
}