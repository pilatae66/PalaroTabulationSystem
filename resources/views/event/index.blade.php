@extends('vendor.multiauth.layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header bg-danger text-white">
					<h5 class="card-title">Event List</h5>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-4">
                                <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" id="id" name="id">
								<div class="form-group">
									<label for="event_name">Event</label>
									<input type="text" name="event_name" class="form-control" id="event_name" aria-describedby="emailHelp" placeholder="Enter event...">
									<small id="emailHelp" class="form-text text-muted">Add one event for every.</small>
								</div>
								<button id="store" class="btn btn-primary">Save</button>
								<button hidden id="update" class="btn btn-primary">Update</button>
						</div>
						<div class="col-md-8">
                            <table class="table table-striped table-bordered" width="100%" style="width:100%">
								<thead>
									<tr>
										<td>Event Name</td>
										<td>Actions</td>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<td>Event Name</td>
										<td>Actions</td>
									</tr>
								</tfoot>
								<tbody>
									@foreach ($events as $event)
											<tr class="hoverable" onclick="getEvent({{ $event->id }})">
                                                <td>{{ $event->event_name }}</td>
                                                <td>
                                                    <a href="{{ route('criteria.create', $event->id) }}" class="btn btn-sm btn-dark"><i class="far fa-eye"></i></a>
                                                    <form style="display:inline-block;" action="{{ route('event.destroy', $event->id) }}" method="POST">
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
        getEvent = ($id) => {
            $.get('event/'+$id+'/edit')
            .then(res => {
                $('#id').val(res.id)
                $('#event_name').val(res.event_name)
                $('#update').removeAttr('hidden','hidden')
                $('#store').attr('hidden','hidden')
            })
        }

        $(document).ready(() => {
            $('#store').on('click', () => {
                let token = $('#token').val()
                let event_name = $('#event_name').val()
                let data = {
                    '_token': token,
                    'event_name': event_name
                }
                $.post('event', data)
                .then(res => {
                    if(res.message == 'Stored!'){
                        location.href = '{{ route("event.index") }}';
                    }
                })
                .catch(err => console.log(err))
            })

            $('#update').on('click', () => {
                let token = $('#token').val()
                let event_name = $('#event_name').val()
                let id = $('#id').val()
                let data = {
                    '_method': 'PATCH',
                    '_token': token,
                    'event_name': event_name
                }
                $.post('event/'+id, data)
                .then(res => {
                    if(res.message == 'Updated!'){
                        location.href = '{{ route("event.index") }}';
                    }
                })
                .catch(err => console.log(err))
            })

        })
    </script>
@endsection
