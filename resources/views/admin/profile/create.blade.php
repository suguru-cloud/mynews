<!DOCTYPE html>
<html>
  <head>
    <meta charset="uft-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>MyProfile</title>
  </head>
  <body>
    <h1>Myプロフィール作成画面</h1>
  </body>
</html>

{{-- layouts/profile.blade.phpファイルを読み込む --}}
@extends('layouts.profile')

{{-- profile.blade.phpの@yield('title')に'プロフィールの新規作成'を埋め込む --}}
@section('title', 'プロフィールの新規作成')

{{-- profile.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
  <div class ="container">
    <div class ="row">
      <div class ="col-md-8 mx-auto">
        <h2>プロフィール新規作成</h2>
      </div>
    </div>
  </div>
@endsection