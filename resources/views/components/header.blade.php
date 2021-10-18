<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ getProjectTitle() }}</title>
  <link rel="shortcut icon" href="{{ asset('storage/img/favicon.png') }}" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
  {{ colorCustomizer() }}
</head>
<body>
<div id="wrapper">
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary-grade">
    <div class="container-fluid">
      <div class="navbar-brand">{{ getProjectTitle() }}</div>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
        <ul class="navbar-nav mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="/">タスクボード</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/chart">タスクチャート</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/schedule/">スケジュール</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/wiki/">Wiki</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/dashboard">ダッシュボード</a>
          </li>
        </ul>
        <form method="post" action="/search" class="d-flex">
          @csrf
          <input name="search" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
