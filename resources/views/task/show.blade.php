@include("components.header")

<h1 class="alert alert-secondary">タスク</h1>

<div class="container">
  <div class="d-flex align-items-baseline justify-content-between mt-4 alert alert-secondary">
    <h1 class="me-4"><?php echo $task["title"]; ?></h1>
    <div id="app">
      <div class="form-check form-switch">
        <input v-model="radioSwitch" name="radioSwitch" class="form-check-input" type="checkbox" id="flexSwitchCheck">
        <label class="form-check-label" for="flexSwitchCheck"><b>Follow?</b></label>
      </div>
    </div>
  </div>
  <?php $progress = empty($task->progress) ? 1 : $task->progress; ?>
  <div class="progress mb-4">
    <div class="progress-bar progress-bar-striped" role="progressbar" style="width: <?php echo $progress; ?>%;" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $progress; ?>%</div>
  </div>
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-end">
        <?php if (!empty($catName)) { ?>
          <div class="me-2 btn <?php echo $catClass; ?>"><?php echo $catName; ?></div>
        <?php } ?>
        <?php foreach ($tags as $k => $v) { ?>
          <div class="badge bg-danger  me-2"><?php echo $v; ?></div>
        <?php } ?>
      </div>
      <div>
        <i
          class="fas fa-edit text-info"
          data-bs-toggle="modal"
          data-bs-target="#taskEditModal"
        >
        </i>
      </div>
    </div>
    <div class="card-body single">
      {!! $task->contents !!}
    </div>
  </div>
  <div class="mt-4 mb-5 text-center"><?php //echo echoBtnFooter(); ?></div>
</div>

<div id="appModal">
  <?php modalEditTask($task->id); ?>
  <?php modalEditTask(); ?>
</div>

<div class="ps-1 ps-sm-2">
  <div class="addButton">
    <i
      class="fas fa-plus-circle display-5 text-danger"
      data-bs-toggle="modal"
      data-bs-target="#taskAddModal"
    >
    </i>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@voerro/vue-tagsinput@2.0.2/dist/voerro-vue-tagsinput.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@voerro/vue-tagsinput@2.0.2/dist/style.css">
<link rel="stylesheet" href="https://unpkg.com/mavon-editor@2.7.4/dist/css/index.css">
<script src="https://unpkg.com/mavon-editor@2.7.4/dist/mavon-editor.js"></script>
<script type="text/javascript">
  Vue.use(window['MavonEditor']);
</script>
<script>
  const VoerroTagsInput = window.VoerroTagsInput;
  new Vue({
		el: "#app",
		data: {
			radioSwitch: <?php echo getFollow($task->follow); ?>,
      toDo: <?php echo getTaskById($task["id"]); ?>,
		},
		methods: {
			registSwitch(e){
				let targetId = <?php echo $task->id; ?>;
				let ajaxUrl = '/task/follow';
				let param = new URLSearchParams();
				param.append('targetId', targetId);
				param.append('judge', e);
				const params = {
					method: "POST",
          headers: {
            'X-CSRF-TOKEN': document.getElementsByName('csrf-token')[0].content
          },
					body: param
				}
				fetch(ajaxUrl, params)
					.then(res => res.json())
					.then(res => {
						console.log(res);
					})
					.catch(error => {
						alert(error + "\n送信失敗");
					});
			},
		},
		watch: {
			radioSwitch(){
				this.registSwitch(this.radioSwitch);
			},
		}
	});

  new Vue({
		el: "#appModal",
    components: {
      'tags-input': VoerroTagsInput,
    },
		data: {
			radioSwitch: <?php echo getFollow($task->follow); ?>,
      existingTags: <?php echo getTagsTaskWiki(); ?>,
      toDo: <?php echo getTaskById($task["id"]); ?>,
      disabledSubmit: true,
      disabledEdit: false,
      addData:{
        title: "",
        contents: "",
        tags: [],
        follow: "",
        status: "",
        start: "",
        end: "",
        progress: 0,
      },
      mavonEditor: {
        toolbars: {
          bold: true,
          italic: false,
          header: true,
          underline: false,
          strikethrough: false,
          mark: false,
          superscript: false,
          subscript: false,
          quote: false,
          ol: true,
          ul: true,
          link: true,
          code: true,
          table: true,
          fullscreen: true,
          readmodel: false,
          htmlcode: false,
          help: false,
          undo: false,
          redo: false,
          navigation: false,
          alignleft: false,
          aligncenter: false,
          alignright: false,
          subfield: false,
          preview: true,
        },
      },
		},
		methods: {
			registSwitch(e){
				let targetId = <?php echo $task->id; ?>;
				let ajaxUrl = '/task/follow';
				let param = new URLSearchParams();
				param.append('targetId', targetId);
				param.append('judge', e);
				const params = {
					method: "POST",
          headers: {
            'X-CSRF-TOKEN': document.getElementsByName('csrf-token')[0].content
          },
					body: param
				}
				fetch(ajaxUrl, params)
					.then(res => res.json())
					.then(res => {
						console.log(res);
					})
					.catch(error => {
						alert(error + "\n送信失敗");
					});
			},
      editSubmit(){
        let ajaxUrl = '/task/edit';
        let params = new URLSearchParams();
				let targetId = <?php echo $task["id"]; ?>;
        params.append('editTaskForm', JSON.stringify(this.toDo));
        params.append('targetId', targetId);
        const param = {
          method: "POST",
          headers: {
            'X-CSRF-TOKEN': document.getElementsByName('csrf-token')[0].content,
          },
          body: params
        }
				fetch(ajaxUrl, param)
					.then(res => res.json())
					.then(res => {
            location.reload();
					})
					.catch(error => {
						alert(error + "\n保存失敗");
					});
      },
      addSubmit(){
        let ajaxUrl = '/task/add';
        let params = new URLSearchParams();
        params.append('addTaskForm', JSON.stringify(this.addData));
        const param = {
          method: "POST",
          headers: {
            'X-CSRF-TOKEN': document.getElementsByName('csrf-token')[0].content,
          },
          body: params
        }
				fetch(ajaxUrl, param)
					.then(res => res.json())
					.then(res => {
            window.location.href = "/task/" + res;
					})
					.catch(error => {
						alert(error + "\n保存失敗");
					});
      },
      deleteTask(i) {
        if (confirm('本当に削除していいですか？')) {
          let ajaxUrl = '/task/delete';
          let params = new URLSearchParams();
          params.append('targetId', i);
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
              window.location.href = "/";
            })
            .catch(error => {
              alert(error + "\n送信失敗");
            });
        }
      },
      judgeSubmit(){
        let res = this.addData.title == "" ? true : false;
        this.disabledSubmit = res
      },
      judgeEdit(){
        let res = this.toDo.title == "" ? true : false;
        this.disabledEdit = res
      },
		},
		watch: {
			radioSwitch(){
				this.registSwitch(this.radioSwitch);
			},
      'toDo.title'(){
        this.judgeEdit()
      },
      'addData.title'(){
        this.judgeSubmit()
      },
		}
	});
</script>

@include("components.footer")