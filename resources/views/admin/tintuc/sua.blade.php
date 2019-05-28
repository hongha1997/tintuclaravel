@extends('admin.layout.index')

@section('content')

<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Tin tức
					<small>{{$tintuc->TieuDe}}</small>
				</h1>
			</div>
			<!-- /.col-lg-12 -->
			<div class="col-lg-7" style="padding-bottom:120px">
				@if(count($errors)>0)
				<div class="alert alert-danger" >
					@foreach($errors->all() as $err )
					{{$err}}<br>
					@endforeach
				</div>
				@endif

				@if(session('thongbao'))
				<div class="alert alert-success" >
					{{session('thongbao')}}
				</div>
				@endif 
				@if(session('loi'))
				<div class="alert alert-success" >
					{{session('loi')}}
				</div>
				@endif 
				<form action="index.php/admin/tintuc/sua/{{$tintuc->id}}" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<div class="form-group">
						<label>Thể loại</label>
						<select class="form-control" name="TheLoai" id="TheLoai">
							@foreach($theloai as $tl)
							<option 
							@if ($tintuc->loaitin->theloai->id==$tl->id) 
							{{"selected"}}
							@endif
							value="{{$tl->id}}">{{$tl->Ten}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Loại tin</label>
						<select class="form-control" name="LoaiTin" id="LoaiTin">
							@foreach($loaitin as $lt)
							<option
							@if ($tintuc->loaitin->id==$lt->id) 
							{{"selected"}}
							@endif
							value="{{$lt->id}}">{{$lt->Ten}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Tiêu đề</label>
						<input class="form-control" name="TieuDe" placeholder="Nhập tiêu đề" value="{{$tintuc->TieuDe}}"/>
					</div>
					<div class="form-group">
						<label>Tóm tắt</label>
						<textarea name="TomTat" id="demo" class="form-control ckeditor" rows="3">
							{{$tintuc->TomTat}}
						</textarea>
					</div>
					<div class="form-group">
						<label>Nội dung</label>
						<textarea name="NoiDung" id="demo" class="form-control ckeditor" rows="5">
							{{$tintuc->NoiDung}}
						</textarea>
					</div>
					<div class="form-group">
						<label>Hình</label>
						<p><img width="400px" src="upload/tintuc/{{$tintuc->Hinh}}"></p>
						<input type="file" name="Hinh" class="form-control">
					</div>
					<div class="form-group">
						<label>Nỗi bật</label>
						<label class="radio-inline">
							<input name="NoiBat" value="0" 
							@if($tintuc->NoiBat==0)
							{{"checked"}}
							@endif
							type="radio">Không
						</label>
						<label class="radio-inline">
							<input name="NoiBat" value="1" 
							@if($tintuc->NoiBat==1)
							{{"checked"}}
							@endif
							type="radio">Có
						</label>
					</div>
					<button type="submit" class="btn btn-default">Sửa</button>
					<button type="reset" class="btn btn-default">Reset</button>
					<form>
					</div>
				</div>
				<!-- /.row -->
				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">Comment
							<small>Danh sách</small>
						</h1>
					</div>
					<table class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr align="center">
								<th>ID</th>
								<th>Người dùng</th>
								<th>Nội dung</th>
								<th>Ngày đăng</th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
							@foreach($tintuc->comment as $cm)
							<tr class="odd gradeX" align="center">
								<td>{{$cm->id}}</td>
								<td>{{$cm->user->name}}</td>
								<td>{{$cm->NoiDung}}</td>
								<td>{{$cm->creared_at}}</td>
								<td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="index.php/admin/comment/xoa/{{$cm->id}}/{{$tintuc->id}}"> Delete</a></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>

		@endsection 

		@section('script')
		<script type="text/javascript">
			$(document).ready(function(){
				$("#TheLoai").change(function(){
					var idTheLoai = $(this).val();
					$.get("index.php/admin/ajax/loaitin/"+idTheLoai, function(data){
					//alert(data);
					$("#LoaiTin").html(data);
				});
				})
			});
		</script>
		@endsection