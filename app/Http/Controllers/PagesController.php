<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\TheLoai;

use App\Slide;

use App\LoaiTin;

use App\TinTuc;

use App\User;

class PagesController extends Controller
{
    function __construct(){
    	$theloai = TheLoai::all();
    	$slide = Slide::all();
    	view()->share('theloai',$theloai);
    	view()->share('slide',$slide);
    	// if(Auth::check()){
    	// 	view()->share('nguoidung',Auth::user());
    	// }
    }
	public function trangchu(){
		return view('pages.trangchu');
	}
	public function lienhe(){
		return view('pages.lienhe');
	}
	public function loaitin($id){
		$loaitin = LoaiTin::find($id);
		$tintuc = TinTuc::where('idLoaiTin',$id)->paginate(5);
		return view('pages.loaitin',['loaitin'=>$loaitin,'tintuc'=>$tintuc]);
	}
	public function tintuc($id){
		$tintuc = TinTuc::find($id);
		$tinnoibat = TinTuc::where('NoiBat',1)->take(4)->get();
		$tinlienquan = TinTuc::where('idLoaiTin',$tintuc->idLoaiTin)->take(4)->get();
		return view('pages.tintuc',['tintuc'=>$tintuc,'tinnoibat'=>$tinnoibat,'tinlienquan'=>$tinlienquan]);
	}
	public function getDangnhap(){
		return view('pages.dangnhap');
	}
	public function postDangnhap(Request $request){
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
            return redirect('trangchu');
        } else {
            return redirect('dangnhap')->with('thongbao','Đăng nhập không thành công');
        }
	}
	public function getDangxuat(){
		Auth::logout();
		 return redirect('trangchu');
	}
	public function getNguoidung(){
		return view('pages.nguoidung');
	}
	public function postNguoidung(Request $request){
		$this->validate($request,
            [
                'name'=>'required | min:3',
            ],
            [
                'name.required' => 'Sai',
                'name.min' => 'Sai',
            ]
        );
        $user = Auth::user();
        $user->name = $request->name;
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
        return redirect('nguoidung')->with('thongbao','Sửa thành công');
	}
	public function getDangky(){
		return view('pages.dangky');
	}
	public function postDangky(Request $request){
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
        $user->quyen = 0;
        $user->save();
        return redirect('dangky')->with('thongbao','Đăng ký thành công');
	}
	public function timkiem(Request $request){
		$tukhoa = $request->tukhoa;
		$tintuc = TinTuc::where('TieuDe','like',"%$tukhoa%")->orWhere('TomTat','like',"%$tukhoa%")->orWhere('NoiDung','like',"%$tukhoa%")->take(10)->paginate(5);
		return view('pages.timkiem',['tintuc'=>$tintuc,'tukhoa'=>$tukhoa]);
	}
}
