@extends('admin.layout.index')

@section('content')

<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">User
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
						<th>Name</th>
						<th>Email</th>
						<th>Level</th>
						<th>Delete</th>
						<th>Edit</th>
					</tr>
				</thead>
				<tbody>
					@foreach($user as $u)
						<tr class="odd gradeX" align="center">
							<td>{{$u->id}}</td>
							<td>{{$u->name}}</td>
							<td>{{$u->email}}</td>
							<td>
								@if($u->quyen==1)
									{{"admin"}}
								@else
									{{"user"}}
								@endif
							</td>
							<td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="index.php/admin/user/xoa/{{$u->id}}"> Delete</a></td>
							<td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="index.php/admin/user/sua/{{$u->id}}">Edit</a></td>
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