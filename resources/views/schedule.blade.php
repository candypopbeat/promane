@include("components.header")

<h1 class="alert alert-secondary">スケジュール</h1>

<section class="gantchart mb-3">
	<div class="container">
		<?php echoGantchartHtml("schedule", "ガントチャート", "primary"); ?>
	</div>
</section>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/frappe-gantt/0.5.0/frappe-gantt.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/frappe-gantt/0.5.0/frappe-gantt.min.js"></script>
<script>
	<?php echoGantchartJs("schedule"); ?>

	function change_view(t, s) {
		eval("gantt_" + s + ".change_view_mode(t)"); // Quarter Day, Half Day, Day, Week, Month
	}

	function zeroPadding(NUM, LEN) {
		return (Array(LEN).join('0') + NUM).slice(-LEN);
	}
</script>

<div class="container">
	<div id="app">
		<?php echoDraggableSchedule(); ?>
	</div>
</div>

<div class="ps-1 ps-sm-2">
  <div class="addButton">
    <i
      class="fas fa-plus-circle display-5 text-danger"
      data-bs-toggle="modal"
      data-bs-target="#scheduleAddModal"
    >
    </i>
  </div>
</div>

<div id="appModal">
  <?php modalEditSchedule(); ?>
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
      data: <?php echo getScheduleDataConverted(); ?>,
      dragTarget: "",
      droped: "",
      editNumber: "",
    },
    methods: {
      dragStart(id) {
        this.dragTarget = id;
      },
      touchStart(id) {
        this.dragTarget = id;
      },
      updateData() {
        let ajaxUrl = '/schedule/sort';
        let params = new URLSearchParams();
        params.append('data', JSON.stringify(this.data));
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
      doDelete(cat, i) {
        if (confirm('本当に削除していいですか？')) {
          this.toDo[cat].splice(i, 1);
        }
      },
      doSessionClear: function() {
        location.reload();
      },
      editSubmit(id, title){
        let ajaxUrl = '/schedule/edit';
        let params = new URLSearchParams();
        params.append('targetId', id);
        params.append('title', title);
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
      deleteSchedule(id){
        let ajaxUrl = '/schedule/delete';
        let params = new URLSearchParams();
        params.append('targetId', id);
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
      setTarget(i){
        this.editNumber = i
      },
      editCancel(){
        location.reload();
      },
    },
    computed: {
      disabledSubmit(){
        if ( this.data[this.editNumber] == undefined ) return true
        let target = this.data[this.editNumber]
        let title = target.title
        let bool = true
        if ( title !== "") bool = false
        return bool
      },
    },
    watch: {
      data: {
        handler: function(n) {
          this.updateData();
        },
      },
    },
  });
</script>

<script>
	new Vue({
		el: "#appModal",
		data: {
      title: "",
      disabledSubmit: true,
 		},
		mounted(){
		},
		methods: {
      addSubmit(){
        let ajaxUrl = '/schedule/add';
        let params = new URLSearchParams();
        let addTitle = this.title;
        params.append('addTitle', this.title);
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
              location.reload("/wiki");
            })
            .catch(error => {
              alert(error + "\n送信失敗");
            });
        }
      },
      judgeSubmit(){
        let res = this.title == "" ? true : false;
        this.disabledSubmit = res
      },
		},
		watch: {
      title(){
        this.judgeSubmit()
      },
		}
	});
</script>

@include("components.footer")