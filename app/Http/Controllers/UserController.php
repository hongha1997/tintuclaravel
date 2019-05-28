<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;


class UserController extends Controller
{
    //
	public function getDanhSach(){
		$user = User::all();
		return view('admin.user.danhsach',['user'=>$user]);
	}
	public function getThem(){
		return view('admin.user.them');
	}
	public function postThem(Request $request){
		$this->validate($request,
            [
                'name'=>'required | min:3',
                'email'=>'required|email|unique:users',
                'password'=>'required|min:3|max:32',
                'passwordAgain'=>'required|same:password'
            ],
            [
                'name.required' => 'Sai',
                'name.min' => 'Sai',
                'email.required' =>'Sai',
                'email.email' =>'Sai',
                'email.unique'=>'Email đã tồn tại',
                'password.required'=>'Sai',
                'password.min'=>'Sai',
                'password.max'=>'Sai',
                'passwordAgain.required'=>'Sai',
                'passwordAgain.same'=>'Mật khẩu chưa trùng',
            ]
        );
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->quyen = $request->quyen;
        $user->save();
        return redirect('admin/user/them')->with('thongbao','Thêm thành công');
	}
	public function getSua($id){
		$user = User::find($id);
		return view('admin.user.sua',['user'=>$user]);
	}
	public function postSua(Request $request, $id){
		$this->validate($request,
            [
                'name'=>'required | min:3',
            ],
            [
                'name.required' => 'Sai',
                'name.min' => 'Sai',
            ]
        );
        $user = User::find($id);
        $user->name = $request->name;
        $user->quyen = $request->quyen;
        if($request->changePassword=="on"){
        	$this->validate($request,
	            [
	                'password'=>'required|min:3|max:32',
	                'passwordAgain'=>'required|same:password'
	            ],
	            [
	                'password.required'=>'Sai',
	                'password.min'=>'Sai',
	                'password.max'=>'Sai',
	                'passwordAgain.required'=>'Sai',
	                'passwordAgain.same'=>'Mật khẩu chưa trùng',
	            ]
	        );
        	$user->password = bcrypt($request->password);
        }
        $user->save();
        return redirect('admin/user/sua/'.$id)->with('thongbao','Sửa thành công');
	}
	public function getXoa($id){
		$user = User::find($id);
		$user->delete();
		return redirect('admin/user/danhsach')->with('thongbao','Xóa thành công');
	}
    public function getDangnhapAdmin(){
        return view('admin.login');
    }
    public function postDangnhapAdmin(Request $request){
        $this->validate($request,
            [
                'email'=>'required',
                'password'=>'required|min:3|max:32'
            ],
            [
                'email.required'=>'Chưa nhập email',
                'password.min'=>'Sai',
                'password.max'=>'Sai',
                'password.required'=>'Chưa nhập pass'
            ]
        );
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            return redirect('admin/theloai/danhsach');
        } else {
            return redirect('admin/dangnhap')->with('thongbao','Đăng nhập không thành công');
        }
    }
    public function getDangXuatAdmin(){
        Auth::logout();
        return redirect('admin/dangnhap'); 
    }
}
