<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Mail\verifyEmail;
use App\Mail\forgetPassword;
use App\Models\Usermeta;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    //
    public function checkValidate(Request $request)
    {
        $this->validate($request,
        [
            'name' =>'required',
            'email' =>'required|unique:users,email|email',
            'password' =>'required',
            'repassword' =>'required|same:password'

        ],
        [
            'name.required' =>'bạn không thể bỏ trống name',
            'email.unique' =>'email đã tồn tại',
            'email.required' =>'bạn không thể bỏ trống email',
            'password.required' =>'bạn không thể bỏ trống password',
            'repassword.same' =>'password phải giống nhau',

        ]);
    }

    public function login(){
        return view('admin.login.signIn');
    }

    public function signIn(Request $request){

        $this->validate($request,
        [
            'email' =>'required|email',
            'password' =>'required',
        ],
        [
            'email.required' =>'bạn không thể bỏ trống email',
            'password.required' =>'bạn không thể bỏ trống password',
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect()->route('limitUsers');
        }else{
            return back()->with('message_error','email address or password is incorrect');
        }

    }

    public function getSignUp()
    {
        return view('admin.login.signUp');
    }
    public function postSignUp(Request $request)
    {
        $this->checkValidate($request);
        $user = new User;
        $user->name= $request->name;
        $user->password= bcrypt($request->password);
        $user->email= mb_strtolower($request->email);
        $user->status = 1;
        $user->confirmed = 0;
        $code=md5($request->email.time());
        $user->confirmation_code= $code;
        $user->save();
        $this->sendVerify($code,$request->email);
        return redirect()->route('get-signup')->with('message_email','Kiểm tra email để xác nhận tài khoản');
    }

    public function sendVerify($code,$mail)
    {
        $data = array(
            'content'=>'http://localhost/bt-laravel/public/home/verify/'.$code,
        );
        Mail::to($mail)->send(new verifyEmail($data));
    }

    public function verify($code)
    {
        $result = User::where('confirmation_code',$code)->update(['confirmed' => 1]);
        $user = User::where('confirmation_code',$code)->first();
        return redirect()->route('login')->with('message','kích hoạt tài khoản thành công nhập lại tài khoản để đăng nhập');
    }

    public function getForgetPassword()
    {
        return view('admin.login.forgetPassword');
    }
    public function postForgetPassword(Request $request)
    {
        $this->validate($request,
        [
            'email' =>'required|email',
        ],
        [
        ]);
        $user = User::where('email',$request->email)->first();
        if($user){
            $this->sendForgetPassword($user->confirmation_code,$request->email);
            return redirect()->route('get-forget-password')->with('message','một email đã được gửi để reset password kiểm tra hòm thư');
        }else{
            return redirect()->route('get-forget-password')->with('message_error','email không tồn tại');
        }
    }
    public function sendForgetPassword($code,$mail)
    {
        $data = array(
            'content'=>'http://localhost/bt-laravel/public/change-password/'.$code,
        );
        Mail::to($mail)->send(new forgetPassword($data));

    }
    public function forgetPassword($code)
    {
        $result = User::where('confirmation_code',$code)->update(['confirmed' => 1]);
        $user = User::where('confirmation_code',$code)->first();

        return redirect()->route('login')->with('message','kích hoạt tài khoản thành công nhập lại tài khoản để đăng nhập');
    }
    public function getChangePassword($code)
    {
        $user = User::where('confirmation_code',$code)->first();

        return view('admin.login.changePassword',['user'=>$user]);
    }
    public function postChangePassword(Request $request)
    {
        $this->validate($request,
        [
            'password' =>'required|min:8',
            'repassword' =>'same:password'

        ],
        [
            'password.min' =>'password phải có ít nhất 8 kí tự',
            'password.required' =>'bạn không thể bỏ trống password',
            'repassword.same' =>'password phải giống nhau',
        ]);
        $user = User::find($request->id);
        $user->password =bcrypt($request->password);
        $user->save();
        return redirect()->route('login')->with('message','thay đổi mật khẩu thành công nhập lại thông tin để đăng nhập');
    }

    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login');
        }
        $existingUser = User::where('email', $user->email)->first();
        if($existingUser){
            // log them in
            Auth::login($existingUser, true);
        } else {
            // create a new user
            $newUser                  = new User;
            $newUser->name            = $user->name;
            $newUser->email           = $user->email;
            $newUser->confirmation_code=md5($user->email.time());
            $newUser->status       = 1;
            $newUser->confirmed       = 1;
            $newUser->save();

            $idUser = User::where('email',$user->email)->value('id');
            $newUsermeta = new Usermeta;
            $newUsermeta->user_id= $idUser;
            $newUsermeta->meta_key = "provider_name";
            $newUsermeta->meta_value     = 'google';
            $newUsermeta->save();
            $newUsermeta = new Usermeta;
            $newUsermeta->user_id= $idUser;
            $newUsermeta->meta_key = "provider_id";
            $newUsermeta->meta_value      = $user->id;
            $newUsermeta->save();
            Auth::login($newUser, true);
        }
        return redirect()->route('listUsers');
    }

}
