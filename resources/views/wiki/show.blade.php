@include("components.header")

<h1 class="alert alert-secondary">Wiki</h1>

<div class="container-fluid p-4">
  <div class="row">
    <div class="col">
      <article>
        <div class="d-flex align-items-baseline alert alert-secondary">
          <h1>{{ $wiki["title"] }}</h1>
        </div>
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between align-items-baseline">
              <div>
                <?php $tags = json_decode($wiki["tags"]); ?>
                <?php foreach ($tags as $k => $v) { ?>
                  <div class="me-2 btn btn-danger text-white"><?php echo $v; ?></div>
                <?php } ?>
              </div>
              <div>
                <i
                  class="fas fa-edit text-info"
                  data-bs-toggle="modal"
                  data-bs-target="#wikiEditModal"
                >
                </i>
              </div>
            </div>
          </div>
          <div class="card-body single">
            {!! $wiki["contents"] !!}
          </div>
        </div>
      </article>
    </div>
    <div class="col-lg-auto mt-4 mt-lg-0">
      <div id="app">
        <div class="card">
          <div class="card-header text-center">リスト</div>
          <div class="card-body">
            <?php echoDraggableWiki(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="appModal">
  <?php modalEditWiki($wiki["id"]); ?>
  <?php modalEditWiki(); ?>
</div>

<div class="ps-1 ps-sm-2">
  <div class="addButton">
    <i
      class="fas fa-plus-circle display-5 text-danger"
      data-bs-toggle="modal"
      data-bs-target="#wikiAddModal"
    >
    </i>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.8.4/Sortable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.23.2/vuedraggable.umd.min.js"></script>
<script>
  const draggable = window['vuedraggable'];
  new Vue({
    el: "#app",
    components: {
      'draggable': draggable,
    },
    data: {
      toDo: <?php echo getWikiList(); ?>,
      dragTarget: "",
      droped: "",
    },
    methods: {
      dragStart(id) {
        this.dragTarget = id;
      },
      touchStart(id) {
        this.dragTarget = id;
      },
      updateToDoData() {
        let ajaxUrl = '/wiki/listup';
        let params = new URLSearchParams();
        params.append('toDo', JSON.stringify(this.toDo));
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
            console.log(res);
          })
          .catch(error => {
            alert(error + "\n送信失敗");
          });
      },
      doDelete(cat, i) {
        if (confirm('本当に削除していいですか？')) {
          this.toDo[cat].splice(i, 1);
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
    },
  });
</script>

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
		el: "#appModal",
    components: {
      'tags-input': VoerroTagsInput,
    },
		data: {
      existingTags: <?php echo getTagsTaskWiki(); ?>,
      toDo: <?php echo getWikiById($wiki["id"]); ?>,
      disabledAdd: true,
      disabledEdit: false,
      addData:{
        title: "",
        contents: "",
        tags: [],
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
		mounted(){
		},
		methods: {
      editSubmit(){
        let ajaxUrl = '/wiki/edit';
        let params = new URLSearchParams();
        let editTaskForm = this.toDo;
				let targetId = <?php echo $wiki["id"]; ?>;
        params.append('editWikiForm', JSON.stringify(this.toDo));
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
        let ajaxUrl = '/wiki/add';
        let params = new URLSearchParams();
        let editTaskForm = this.toDo;
				let targetId = <?php echo $wiki["id"]; ?>;
        params.append('addWikiForm', JSON.stringify(this.addData));
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
      deleteTask(i) {
        if (confirm('本当に削除していいですか？')) {
          let ajaxUrl = '/wiki/delete';
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
              location.href = "/wiki";
            })
            .catch(error => {
              alert(error + "\n送信失敗");
            });
        }
      },
      judgeSubmit(){
        let res = this.addData.title == "" ? true : false;
        this.disabledAdd = res
      },
      judgeEdit(){
        let res = this.toDo.title == "" ? true : false;
        this.disabledEdit = res
      },
		},
		watch: {
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
