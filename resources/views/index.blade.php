@include("components.header")

<h1 class="alert alert-secondary">タスクボード</h1>

<div id="app" class="p-4">
  <div class="table-responsive pb-4">
    <div class="row row-cols-5 area mx-auto">
      <div class="col">
        <?php echoBoardTitle("待機中", "secondary", "pending", 1); ?>
        <div class="card">
          <div class="card-body">
            <?php echoDraggable("pending"); ?>
          </div>
        </div>
      </div>
      <div class="col">
        <?php echoBoardTitle("処理中", "primary", "continue", 2); ?>
        <div class="card">
          <div class="card-body">
            <?php echoDraggable("continue"); ?>
          </div>
        </div>
      </div>
      <div class="col">
        <?php echoBoardTitle("確認中", "info", "confirm", 3); ?>
        <div class="card">
          <div class="card-body">
            <?php echoDraggable("confirm"); ?>
          </div>
        </div>
      </div>
      <div class="col">
        <?php echoBoardTitle("完了", "success", "complete", 4); ?>
        <div class="card">
          <div class="card-body">
            <?php echoDraggable("complete"); ?>
          </div>
        </div>
      </div>
      <div class="col">
        <?php echoBoardTitle("アーカイブ", "dark", "archives", 5); ?>
        <div class="card">
          <div class="card-body">
            <?php echoDraggable("archives"); ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php modalEditTask(); ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.8.4/Sortable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.23.2/vuedraggable.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@voerro/vue-tagsinput@2.0.2/dist/voerro-vue-tagsinput.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@voerro/vue-tagsinput@2.0.2/dist/style.css">
<link rel="stylesheet" href="https://unpkg.com/mavon-editor@2.7.4/dist/css/index.css">
<script src="https://unpkg.com/mavon-editor@2.7.4/dist/mavon-editor.js"></script>
<script type="text/javascript">
  Vue.use(window['MavonEditor']);
</script>
<script>
  const VoerroTagsInput = window.VoerroTagsInput;
  const draggable = window['vuedraggable'];
  new Vue({
    el: "#app",
    components: {
      'draggable': draggable,
      'tags-input': VoerroTagsInput,
    },
    data: {
      toDo: <?php echo getToDoDataConverted(); ?>,
      dragTarget: "",
      droped: "",
      addData:{
        title: "",
        mdEditor: "",
        selectedTags:[],
        selectedForever: "",
        status: 1,
        start: "<?php echo date("Y-m-d"); ?>",
        end: "<?php echo date("Y-m-d"); ?>",
        progress: 0,
      },
      existingTags: <?php echo getTagsTaskWiki(); ?>,
      disabledSubmit: true,
      viewContributor: <?php echoViewContributor(); ?>,
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
      addSubmit(){
        let ajaxUrl = '/task/add';
        let params = new URLSearchParams();
        params.append('addTaskForm', JSON.stringify(this.addData));
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
      judgeSubmit(){
        let res = this.addData.title == "" ? true : false;
        this.disabledSubmit = res
      },
      dragStart(id) {
        this.dragTarget = id;
      },
      touchStart(id) {
        this.dragTarget = id;
      },
      setModal(e) {
        this.addData.status = e;
      },
      setUpdateCategory(id) {
        for (const i in this.toDo.pending) {
          if (this.toDo.pending[i].id == id) {
            this.droped = 1;
          }
        }
        for (const i in this.toDo.continue) {
          if (this.toDo.continue[i].id == id) {
            this.droped = 2;
          }
        }
        for (const i in this.toDo.confirm) {
          if (this.toDo.confirm[i].id == id) {
            this.droped = 3;
          }
        }
        for (const i in this.toDo.complete) {
          if (this.toDo.complete[i].id == id) {
            this.droped = 4;
          }
        }
        for (const i in this.toDo.archives) {
          if (this.toDo.archives[i].id == id) {
            this.droped = 5;
          }
        }
      },
      updateToDoData() {
        this.setUpdateCategory(this.dragTarget);
        let ajaxUrl = '/task';
        let params = new URLSearchParams();
        params.append('toDo', JSON.stringify(this.toDo));
        params.append('targetID', this.dragTarget);
        params.append('updateCat', this.droped);
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
          })
          .catch(error => {
            alert(error + "\nエラー発生");
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
              let ar = this.toDo.archives;
              ar.forEach((e, i) => {
                if (e.id == res) {
                  ar.splice(i, 1);
                }
              });
            })
            .catch(error => {
              alert(error + "\nエラー発生");
            });
        }
      },
      doSessionClear: function() {
        location.reload();
      },
    },
    watch: {
      toDo: {
        handler: function(n) {
          this.updateToDoData();
        },
        deep: true,
      },
      'addData.title'(){
        this.judgeSubmit()
      },
    },
  });
</script>

@include("components.footer")