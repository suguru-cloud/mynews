<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// 以下を追記することでProfile Modelが扱えるようになる
use App\Profile;

//以下を追記
use App\ProfileHistory;

//以下を追記
use Carbon\Carbon;

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
    
    $profile = new Profile;
    $form = $request->all();
    
    // フォームから送信されてきた_tokenを削除する
    unset($form['_token']);
    
    // データベースに保存する
    $profile->fill($form);
    $profile->save();
    
    return redirect('admin/profile/create');
  }
  
  public function index(Request $request)
  {
    $cond_title = $request->cond_title;
    if ($cond_title != '') {
      //検索されたら検索結果を取得する
      $posts = Profile::where('title', $cond_title)->get();
    } else {
      // それ以外はすべてのプロフィールを取得する
      $posts = Profile::all();
    }
    return view('admin.profile.index', ['posts' => $posts, 'cond_title' => $cond_title]);
  }
  
  public function edit(Request $request)
  {
    
    //Profile Modelからデータを取得する
    $profile = Profile::find($request->id);
    if (empty($profile)) {
      abort(404);
    }
    
    return view('admin.profile.edit', ['profile_form' => $profile, 'test'=>$profile->profile_histories]);
  }
  
  public function update(Request $request)
  {
    // Validationをかける
    $this->validate($request, Profile::$rules);
    //Profile Modelからデータを取得する
    $profile = Profile::find($request->id);
    // 送信されてきたフォームデータを格納する
    $profile_form = $request->all();

    unset($profile_form['_token']);
    unset($profile_form['image']);
    unset($profile_form['remove']);
    
    // 該当するデータを上書きして保存する
    $profile->fill($profile_form)->save();
    
    //以下を追記
    $history = new ProfileHistory;
    $history->profile_id = $profile->id;
    $history->edited_at = Carbon::now();
    $history->save();
    
    return redirect('admin/profile/');
  }
  
  public function delete(Request $request)
  {
    // 該当するNews Modelを取得
    $profile = Profile::find($request->id);
    //削除する
    $profile->delete();
    return redirect('admin/profile/');
  }
}
