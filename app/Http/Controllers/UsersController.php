<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Postmeta;
use App\Models\term_relationships;
use App\Models\User;
use App\Models\Usermeta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    function __construct()
    {
        $users = User::all();
        view()->share('allUsers', $users);
        if (!session()->has('limit')) {
            session(['limit' => 10]);
        }
    }
    //limit
    public function limit(Request $request)
    {
        session(['limit' => $request->showData]);
        return redirect()->route('listUsers');
    }
    //sort
    public function sort(Request $request)
    {
        session(['sort' => $request->sort]);
        return redirect()->route('listUsers');
    }
    //status
    public function status(Request $request)
    {
        session(['status' => $request->status]);
        return redirect()->route('listUsers');
    }

    public function checkValidate(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'phone' => 'nullable|numeric',
                'status' => 'required',
                'password' => 'required|min:8',
            ],
            [
                'email.unique' => 'email đã tồn tại',
            ]
        );
    }
    public function listUsers()
    {
        if (session()->has('sort') && session()->has('status')) {
            $users = User::where('status', session('status'))->orderBy('name', session('sort'))->paginate(session('limit'));
        } else if (session()->has('sort') && !session()->has('status')) {
            $users = User::orderBy('name', session('sort'))->paginate(session('limit'));
        } else if (!session()->has('sort') && session()->has('status')) {
            $users = User::where('status', session('status'))->paginate(session('limit'));
        } else {
            $users = User::paginate(session('limit'));
        }

        return view('admin.users.listUsers', ['users' => $users]);
    }

    public function getAddUser()
    {
        return view('admin.users.addUser');
    }
    public function postAddUser(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|numeric',
            'status' => 'required',
            'password' => 'required|min:8',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => 0,
                'errors' => $validation->errors()
            ]);
        } else {
            $user = new User;
            $user->name = $request->name;
            $user->password = bcrypt($request->password);
            $user->email = mb_strtolower($request->email);
            $user->phone = $request->phone;
            if (isset($request->role)) {
                $user->role = $request->role;
            }
            $user->address = $request->address;
            $user->status = $request->status;
            $user->confirmed = 0;
            $user->confirmation_code = md5($request->email . Carbon::now('Asia/Ho_Chi_Minh'));
            if ($request->hasFile('img')) {

                $path = 'admin_asset/image/upload/' . Carbon::now()->year . '/' . Carbon::now()->month;
                if (!file_exists($path)) {
                    $result = mkdir($path, 0777, true);
                }
                $file = $request->file('img');
                $name = $file->getClientOriginalName();
                while (!file_exists($path . '/' . $name)) {
                    $file->move($path . '/', $name);
                }
                $user->avatar = Carbon::now()->year . '/' . Carbon::now()->month . '/' . $name;
            } else {
                $user->avatar = null;
            }
            $user->save();
            return response()->json([
                'status'     => 1,
                'message'     => "thêm thành công ",
                'class'  => "alert alert-success"
            ]);
        }
    }
    public function getEditUser($id)
    {
        $user = User::find($id);
        return view('admin.users.editUser', ['user' => $user]);
    }
    public function postEditUser(Request $request)
    {

        $this->validate(
            $request,
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $request->id . ',id',
                'status' => 'required',
                'phone' => 'nullable|numeric',
                'password' => 'nullable|min:8'
            ],
            [
                'email.unique' => 'email đã tồn tại',
            ]
        );
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = mb_strtolower($request->email);
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->status = $request->status;
        $user->role = $request->role;
        if (isset($request->password)) {
            $user->password = bcrypt($request->password);
        }
        if ($request->hasFile('img')) {
            $path = 'admin_asset/image/upload/' . Carbon::now()->year . '/' . Carbon::now()->month;
            if (!file_exists($path)) {
                $result = mkdir($path, 0777, true);
            }
            $file = $request->file('img');
            $name = $file->getClientOriginalName();
            while (!file_exists($path . '/' . $name)) {
                $file->move($path . '/', $name);
            }
            $user->avatar = Carbon::now()->year . '/' . Carbon::now()->month . '/' . $name;
        } else {
            if ($request->getImg != "") {
                $user->avatar = $request->getImg;
            } else {
                $user->avatar = "";
            }
        }
        $user->save();
        return redirect()->route('getEditUser', ['id' => $request->id])->with('message', 'Update thành công');
    }

    public function changestatus($id)
    {
        $user = User::find($id);
        if ($user->status == 1) {
            $user->status = 0;
            $user->save();
        } else {
            $user->status = 1;
            $user->save();
        }
        return redirect()->route('listUsers')->with('message', 'Changed successfully');
    }


    // public function deleteUsers($id)
    // {
    //     $commentsId=DB::table('comments')->where('author',$id)->pluck('id');
    //     DB::table('comments')->whereIn('comment_parent',$commentsId)->delete();
    //     DB::table('comments')->whereIn('id',$commentsId)->delete();
    //     $post = Post::where('author',$id)->pluck('id');
    //     Postmeta::whereIn('post_id',$post)->delete();
    //     term_relationships::whereIn('post_id',$post)->delete();
    //     Usermeta::whereIn('meta_value',$post)->delete();
    //     Post::where('author',$id)->delete();

    //     $postId = Usermeta::where([['user_id',$id],['meta_key','vote_post']])->pluck('meta_value');
    //     foreach($postId as $value){
    //         $unvote = Post::find($value);
    //         $unvote->vote_count = $unvote->vote_count - 1;
    //         $unvote->save();
    //     }
    //     Usermeta::where([['user_id',$id]])->delete();
    //     $user = User::find($id);
    //     $user->delete();
    //     return redirect('admin/users/list-users')->with('message','Deleted successfully');
    // }

    public function logout()
    {
        Auth::logout();
        return back();
    }
    public function searchUsers(Request $request)
    {
        $users = User::where('name', 'like', "%$request->search%")->orWhere('email', 'like', "%$request->search%")->paginate(session('limit'));
        return view('admin.users.listUsers', ['users' => $users]);
    }

    public function bulkActionUsers(Request $request)
    {

        if ($request->select == 1) {
            if (!empty($request->check)) {
                $posts = User::whereIn('id', $request->check)->update(['status' => 1]);
                return redirect()->route('listUsers')->with('message', "Changed successfully");
            } else {
                return redirect()->route('listUsers')->with('messageWarning', "Nothing selected");
            }
        } else if ($request->select == "delete") {
            if (isset($request->check)) {
                $commentsId = DB::table('comments')->whereIn('author', $request->check)->pluck('id');
                DB::table('comments')->whereIn('comment_parent', $commentsId)->delete();
                DB::table('comments')->whereIn('id', $commentsId)->delete();
                $post = Post::whereIn('author', $request->check)->pluck('id');
                Postmeta::whereIn('post_id', $post)->delete();
                term_relationships::whereIn('post_id', $post)->delete();
                Usermeta::whereIn('meta_value', $post)->delete();
                Post::whereIn('author', $request->check)->delete();
                $postId = Usermeta::whereIn('user_id', $request->check)->where('meta_key', 'vote_post')->pluck('meta_value');
                foreach ($postId as $value) {
                    $unvote = Post::find($value);
                    $unvote->vote_count = $unvote->vote_count - 1;
                    $unvote->save();
                }
                Usermeta::whereIn('user_id', $request->check)->delete();
                User::whereIn('id', $request->check)->delete();
                return redirect()->route('listUsers')->with('message', "Deleted successfully");
            } else {
                return redirect()->route('listUsers')->with('messageWarning', "Nothing selected");
            }
        } else if ($request->select == 0) {
            if (isset($request->check)) {
                $posts = User::whereIn('id', $request->check)->update(['status' => 0]);
                return redirect()->route('listUsers')->with('message', "Changed successfully");
            } else {
                return redirect()->route('listUsers')->with('messageWarning', "Nothing selected");
            }
        } else {
            return redirect()->route('listUsers')->with('message', 'chọn một tùy chọn');
        }
    }
}
