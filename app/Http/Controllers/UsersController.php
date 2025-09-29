<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;
class UsersController extends Controller
{
    //
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {

       $user = User::findOrFail($id); // 从数据库查询 User 模型（对象）
       $this->authorize('update',$user);
        return view('users.edit', compact('user'));
     }

    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);
        $data= $request->all();
        if ($request->hasFile('avatar')) {
            $result = $uploader->save($request->file('avatar'), 'avatars', $user->id,416);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success','用户资料更新成功');
    }

  public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }
}
