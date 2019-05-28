<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;

class TheLoaiController extends Controller
{
    //
    public function getDanhSach(){
        $theloai = TheLoai::all();
        return view('admin.theloai.danhsach',['theloai'=>$theloai]);
    }
    public function getThem(){
    	return view('admin.theloai.them');
    }
    public function postThem(Request $request){
        $this->validate($request,
        [
            'Ten' => 'required | min:3 | max:100 |unique:TheLoai'
        ],
        [
            'Ten.required'=>'Bạn chưa nhập',
            'Ten.min'=>'Bạn nhập quá ít',
            'Ten.max'=>'Bạn nhập quá nhiều',
            'Ten.unique' => 'Đã tồn tại',
        ]);

        $theloai = new TheLoai;
        $theloai->Ten = $request->Ten;
        $theloai->TenKhongDau = changeTitle($request->Ten);
        $theloai->save();
        return redirect('admin/theloai/them')->with('thongbao','Thêm thành công!');
    }
    public function getSua($id){
    	$theloai = TheLoai::find($id);
        return view('admin.theloai.sua',['theloai'=>$theloai]);
    }
    public function postSua(Request $request, $id){
        $theloai = TheLoai::find($id);
        $this->validate($request,
            [
                //                          bảng    cột
                'Ten' => 'required | unique:TheLoai| min:3 | max:100'
            ],
            [
                'Ten.required' => 'Bạn chưa nhập',
                'Ten.unique' => 'Đã tồn tại',
                'Ten.min'=>'Bạn nhập quá ít',
                'Ten.max'=>'Bạn nhập quá nhiều',
            ]);
        $theloai->Ten = $request->Ten;
        $theloai->TenKhongDau = changeTitle($request->Ten);
        $theloai->save();
        return redirect('admin/theloai/sua/'.$id)->with('thongbao','sửa thành công');
    }
    public function getXoa($id){
        $theloai = TheLoai::find($id);
        $theloai->delete();
        return redirect('admin/theloai/danhsach')->with('thongbao','đã xóa thành công');
    }
}
