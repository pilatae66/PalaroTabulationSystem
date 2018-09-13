@extends('vendor.multiauth.layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header bg-danger text-white">
					<h5 class="card-title">Contestant List</h5>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-4">
                            <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" id="id" name="id">
                            <div class="form-group">
                                <label for="contestant_name">Contestant</label>
                                <input type="text" name="contestant_name" class="form-control" id="contestant_name" aria-describedby="emailHelp" placeholder="Enter contestant name...">
                                <small id="emailHelp" class="form-text text-muted">Contestant name here.</small>
                            </div>
                            <div class="form-group">
                                <label for="department">Department</label>
                                <select name="department" class="form-control" id="department">
                                    <option selected hidden>Choose a department...</option>
                                    <option value="COE">College of Enginnering</option>
                                    <option value="CED">College of Education</option>
                                    <option value="CCS">College of Computer Studies</option>
                                    <option value="COC">College of Criminology</option>
                                    <option value="CBA">College of Business Administration</option>
                                    <option value="CASS">College of Arts and Social Sciences</option>
                                </select>
                                <small id="emailHelp" class="form-text text-muted">Contestant department here.</small>
                            </div>
                            <div class="form-group">
                                <label for="event">Event</label>
                                <select name="event" class="form-control" id="event">
                                        <option selected hidden>Choose an event...</option>
                                    @foreach ($events as $event)
                                        <option value="{{ $event->id }}">{{ $event->event_name }}</option>
                                    @endforeach
                                </select>
                                <small id="emailHelp" class="form-text text-muted">Contestant department here.</small>
                            </div>
                            <button id="store" class="btn btn-primary">Save</button>
                            <button hidden id="update" class="btn btn-primary">Update</button>
						</div>
						<div class="col-md-8">
                            <table class="table table-striped table-bordered" width="100%" style="width:100%">
								<thead>
									<tr>
										<td>Contestant Name</td>
										<td>Department</td>
										<td>Event Entered</td>
										<td>Actions</td>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<td>Contestant Name</td>
										<td>Department</td>
										<td>Event Entered</td>
										<td>Actions</td>
									</tr>
								</tfoot>
								<tbody>
									@foreach ($contestants as $contestant)
                                    <tr class="hoverable" onclick="getContestant({{ $contestant->id }})">
                                        <td>{{ $contestant->name }}</td>
                                        <td>{{ $contestant->department }}</td>
                                        <td>{{ $contestant->event->event_name }}</td>
                                        <td>
                                            <form style="display:inline-block;" action="{{ route('contestant.destroy', $contestant->id) }}" method="POST">
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
    getContestant = ($id) => {
        $.get('contestant/'+$id+'/edit')
        .then(res => {
            $('#id').val(res.id)
            $('#contestant_name').val(res.name)
            $('#department').val(res.department)
            $('#event').val(res.event_id)
            $('#update').removeAttr('hidden','hidden')
            $('#store').attr('hidden','hidden')
        })
    }

    $(document).ready(() => {
        $('#store').on('click', () => {
            let token = $('#token').val()
            let contestant_name = $('#contestant_name').val()
            let department = $('#department').val()
            let event = $('#event').val()
            let data = {
                '_token': token,
                'contestant_name': contestant_name,
                'department': department,
                'event_id': event
            }
            console.log(data)
            $.post('contestant', data)
            .then(res => {
                if(res.message == 'Stored!'){
                    location.href = '{{ route("contestant.index") }}';
                }
                console.log(res)
            })
            .catch(err => console.log(err))
        })

        $('#update').on('click', () => {
            let token = $('#token').val()
            let contestant_name = $('#contestant_name').val()
            let department = $('#department').val()
            let event = $('#event').val()
            let id = $('#id').val()
            let data = {
                '_method': 'PATCH',
                '_token': token,
                'contestant_name': contestant_name,
                'department': department,
                'event_id': event,
            }
            $.post('contestant/'+id, data)
            .then(res => {
                if(res.message == 'Updated!'){
                    location.href = '{{ route("contestant.index") }}';
                }
            })
            .catch(err => console.log(err))
        })

    })
</script>
@endsection
