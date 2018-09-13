@extends('vendor.multiauth.layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header bg-danger text-white">
					<h5 class="card-title">Judge List</h5>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <table class="table table-striped table-bordered" width="100%" style="width:100%">
								<thead>
									<tr>
										<td>Judge Name</td>
										<td>Email</td>
										<td>Actions</td>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<td>Judge Name</td>
										<td>Email</td>
										<td>Actions</td>
									</tr>
								</tfoot>
								<tbody>
									@foreach ($judges as $judge)
                                    <tr>
                                        <td>{{ $judge->name }}</td>
                                        <td>{{ $judge->email }}</td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-ids="{{ $judge->id }}" data-target="#editJudge">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <form style="display:inline-block;" action="{{ route('contestant.destroy', $judge->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
                                            </form>
                                        </td>
                                    </tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="editJudge" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="id">
                <div class="form-group">
                    <label for="judge_name">Judge Name</label>
                    <input type="text" name="judge_name" class="form-control" id="judge_name" aria-describedby="emailHelp" placeholder="Enter judge name...">
                    <small id="emailHelp" class="form-text text-muted">Judge name here.</small>
                </div>
                <div class="form-group">
                    <label for="judge_email">Judge Email</label>
                    <input type="text" name="judge_email" class="form-control" id="judge_email" aria-describedby="emailHelp" placeholder="Enter judge email...">
                    <small id="emailHelp" class="form-text text-muted">Judge email here.</small>
                </div>
            </div>
            <div class="modal-footer bg-danger text-white">
                <button id="update" type="button" class="btn btn-danger">Update</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    getContestant = ($id) => {
        $.get('judge/'+$id+'/edit')
        .then(res => {
            $('#id').val(res.id)
            $('#judge_name').val(res.name)
            $('#judge_email').val(res.email)
            console.log(res)
        })
    }
    $(document).ready(() => {
        $(window).on('show.bs.modal', (e) => {
            let id = $(e.relatedTarget).attr('data-ids')
            getContestant(id)

        })

        $('#update').on('click', () => {
            let token = $('#token').val()
            let id = $('#id').val()
            let name = $('#judge_name').val()
            let email = $('#judge_email').val()
            let data = {
                '_method': 'PATCH',
                '_token': token,
                'name': name,
                'email': email,
            }
            console.log(data)
            $.post('judge/'+id, data)
            .then(res => {
                if(res.message == 'Updated!'){
                    location.href = '{{ route("judge.index") }}';
                }
            })
            .catch(err => console.log(err))
        })

    })
</script>
@endsection
