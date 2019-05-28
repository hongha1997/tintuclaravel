@extends('admin.layout.index')

@section('content')

<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Tin tức
					<small>Danh sách</small>
				</h1>
			</div>
			@if(session('thongbao'))
				<div class="alert alert-success" >
					{{session('thongbao')}}
				</div>
			@endif
			<table class="table table-striped table-bordered table-hover" id="dataTables-example">
				<thead>
					<tr align="center">
						<th>ID</th>
						<th>Tiêu đề</th>
						<th>Thể loại</th>
						<th>Loại tin</th>
						<th>Views</th>
						<th>Nỗi bậc</th>
						<th>Delete</th>
						<th>Edit</th>
					</tr>
				</thead>
				<tbody>
					@foreach($tintuc as $tt)
						<tr class="odd gradeX" align="center">
							<td>{{$tt->id}}</td>
							<td><p>{{$tt->TieuDe}}</p><img width="100px" src="upload/tintuc/{{$tt->Hinh}}" /></td>
							<td>{{$tt->loaitin->theloai->Ten}}</td>
							<td>{{$tt->loaitin->Ten}}</td>
							<td>{{$tt->SoLuotXem}}</td>
							<td>
								@if ($tt->NoiBat==0)
									{{'Không'}}
								@else
									{{'Có'}}
								@endif
							</td>
							<td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="index.php/admin/tintuc/xoa/{{$tt->id}}"> Delete</a></td>
							<td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="index.php/admin/tintuc/sua/{{$tt->id}}">Edit</a></td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<!-- /.row -->
	</div>
	<!-- /.container-fluid -->
</div>

@endsection 