@extends('vendor.multiauth.layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header bg-danger text-white">
					<h5 class="card-title">Criteria List</h5>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-4">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label for="criteria_name">Criteria Name</label>
                                <input type="text" name="criteria_name" class="form-control" id="criteria_name" aria-describedby="emailHelp" placeholder="Enter criteria...">
                                <small id="emailHelp" class="form-text text-muted">Criteria name.</small>
                            </div>
                            <div class="form-group">
                                <label for="percentage">Criteria Name</label>
                                <input type="number" name="percentage" class="form-control" id="percentage" aria-describedby="emailHelp" placeholder="Enter percentage...">
                                <small id="emailHelp" class="form-text text-muted">Percentage of the criteria.</small>
                            </div>
                            <button id="store" class="btn btn-primary">Save</button>
                            <button hidden id="update" class="btn btn-primary">Update</button>
						</div>
						<div class="col-md-8">
                            <table class="table table-striped table-bordered" width="100%" style="width:100%">
								<thead>
									<tr>
										<td>Criteria Name</td>
										<td>Percentage</td>
                                        <td>Actions</td>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<td>Criteria Name</td>
										<td>Percentage</td>
                                        <td>Actions</td>
									</tr>
								</tfoot>
								<tbody>
									@foreach ($criterias as $criteria)
                                    <tr class="hoverable" onclick="getCriteria({{ $id }},{{ $criteria->id }})">
                                        <td>{{ $criteria->criteria_name }}</td>
                                        <td>{{ $criteria->percentage }}</td>
                                        <td>
                                            <form style="display:inline-block;" action="{{ route('criteria.destroy', ['id' => $id, 'criteria' => $criteria->id]) }}" method="POST">
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
@endsection
@section('scripts')
<script>
    getCriteria = (id, criteria) => {
        $.get('criteria/'+criteria+'/edit')
        .then(res => {
            $('#id').val(res.id)
            $('#criteria_name').val(res.criteria_name)
            $('#percentage').val(res.percentage)
            $('#update').removeAttr('hidden','hidden')
            $('#store').attr('hidden','hidden')
        })
    }

    $(document).ready(() => {
        $('#store').on('click', () => {
            let token = $('#token').val()
            let criteria_name = $('#criteria_name').val()
            let percentage = $('#percentage').val()
            let data = {
                '_token': token,
                'criteria_name': criteria_name,
                'percentage': percentage,
            }
            $.post('criteria', data)
            .then(res => {
                if(res.message == 'Stored!'){
                    location.href = '{{ route("criteria.create",$id) }}';
                }
            })
            .catch(err => console.log(err))
        })

        $('#update').on('click', () => {
            let token = $('#token').val()
            let criteria_name = $('#criteria_name').val()
            let percentage = $('#percentage').val()
            let id = $('#id').val()
            let data = {
                '_method': 'PATCH',
                '_token': token,
                'criteria_name': criteria_name,
                'percentage': percentage,
            }
            $.post('criteria/'+id, data)
            .then(res => {
                if(res.message == 'Updated!'){
                    location.href = '{{ route("criteria.create",$id) }}';
                }
            })
            .catch(err => console.log(err))
        })

    })
</script>
@endsection
