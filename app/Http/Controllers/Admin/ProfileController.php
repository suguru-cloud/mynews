<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// 以下を追記することでProfile Modelが扱えるようになる
use App\Profile;

class ProfileController extends Controller
{
    //以下を追記
  public function add()
  {
    return view('admin.profile.create');
  }
  
  //以下を変更
  public function create(Request $request)
  {
    
    //以下を追記
    //Validationを行う
    $this->validate($request, Profile::$rules);
    
    $profiles = new Profile;
    $form = $request->all();
    
    // フォームから送信されてきた_tokenを削除する
    unset($form['_token']);
    
    // データベースに保存する
    $profiles->fill($form);
    $profiles->save();
    
    return redirect('admin/profile/create');
  }
  
  public function edit(Request $request)
  {
    
    //Profile Modelからデータを取得する
    $profiles = Profile::find($request->id);
    if (empty($profiles)) {
      abort(404);
    }
    
    return view('admin.profile.edit', ['profile_form' => $profiles]);
  }
  
  public function update(Request $request)
  {
    // Validationをかける
    $this->validate($request, Profile::$rules);
    //Profile Modelからデータを取得する
    $profiles = Profile::find($request->id);
    // 送信されてきたフォームデータを格納する
    $profile_form = $request->all();
    if (isset($profile_form['image'])) {
      $path = $request->file('image')->store('public/image');
      $profiles->image_path = basename($path);
      unset($profile_form['image']);
    } elseif (isset($request->remove)) {
      $profiles->image_path = null;
      unset($profile_form['remove']);
    }
    unset($profile_form['_token']);
    
    // 該当するデータを上書きして保存する
    $profiles->fill($profile_form)->save();
    
    return redirect('admin/profile/edit');
  }
  
}
