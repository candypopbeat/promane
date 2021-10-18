@include("components.header")

<h1 class="alert alert-primary">メンバー一覧</h1>

<div class="container">
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>名前</th>
        <th>email</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($members as $k => $v) { ?>
        <tr>
          <td>{{ $v["id"] }}</td>
          <td>{{ $v["name"] }}</td>
          <td>{{ $v["email"] }}</td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

@include("components.footer")