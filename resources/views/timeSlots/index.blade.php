@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h2>Time Slots</h2>
        </div>
        <div class="col-md-6">
            @can('time-slot-create')
            <a class="btn btn-success  float-end" href="{{ route('timeSlots.create') }}"> Create New Time Slot</a>
            @endcan
        </div>
    </div>
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <span>{{ $message }}</span>
        <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <hr>
    <div class="row">
        @if(!auth()->user()->hasRole("Staff"))
        <!-- Second Column (Filter Form) -->
        <div class="col-md-12">
            <h3>Filter</h3>
            <hr>
            <form action="{{ route('timeSlots.index') }}" method="GET" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Staff:</strong>
                            <input type="text" id="staffSearch" class="form-control mb-2" placeholder="Search staff by name">
                            <select name="staff_id" id="staffDropdown" class="form-control">
                                <option value="">Select</option>
                                @foreach ($staffs as $staff)
                                @if ($staff->staff->status == 1)
                                    <option value="{{ $staff->id }}" {{ $staff->id == $filter['staff_id'] ? 'selected' : '' }}>
                                        {{ $staff->name }}
                                    </option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 offset-md-8">
                        <div class="d-flex flex-wrap justify-content-md-end">
                            <div class="col-md-3 mb-3">
                                <a href="{{ url()->current() }}" class="btn btn-lg btn-secondary">Reset</a>
                            </div>
                            <div class="col-md-9 mb-3">
                                <button type="submit" class="btn btn-lg btn-block btn-primary">Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @endif

    </div>
    <h3>Time Slots  ({{ $total_time_slot }})</h3>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Sr#</th>
            <th>
                <div class="d-flex">
                    <a class="ml-2  text-decoration-none" href="{{ route('timeSlots.index', array_merge(request()->query(), ['sort' => 'name', 'direction' => request('direction', 'asc') == 'asc' ? 'desc' : 'asc'])) }}">Name</a>
                    @if (request('sort') === 'name')
                    <i class="fa {{ $direction == 'asc' ? 'fa-arrow-down' : 'fa-arrow-up' }} px-2 py-2"></i>
                    @endif

                </div>
            </th>
            <th>
                <div class="d-flex">
                    <a class="ml-2  text-decoration-none" href="{{ route('timeSlots.index', array_merge(request()->query(), ['sort' => 'time_start', 'direction' => request('direction', 'asc') == 'asc' ? 'desc' : 'asc'])) }}">Time Start -- Time End</a>
                    @if (request('sort') === 'time_start')
                    <i class="fa {{ $direction == 'asc' ? 'fa-arrow-down' : 'fa-arrow-up' }} px-2 py-2"></i>
                    @endif

                </div>
            </th>
            <th>Group</th>
            <th>Type</th>
            <th>Staff</th>
            <th>No. of Seats</th>
            <th width="280px">Action</th>
        </tr>
        @if(count($time_slots))
        @foreach ($time_slots as $time_slot)
        <tr>
            <td>{{ ++$i }}</td>
            <td>@if($time_slot->status == 1)
                <span class="text-success">{{ $time_slot->name }}</span>
                @else
                <span class="text-danger">{{ $time_slot->name }}</span>
                @endif</td>
            <td>{{ date('h:i A', strtotime($time_slot->time_start)) }} -- {{ date('h:i A', strtotime($time_slot->time_end)) }}</td>
            <td>{{ $time_slot->group->name }}</td>
            <td>{{ $time_slot->type }}</td>
            <td>
                @foreach($time_slot->staffs as $key => $staff)
                    {{ $staff->name }}@if($key != count($time_slot->staffs) -1),@endif
                @endforeach
            </td>
            <td>{{ $time_slot->seat }}</td>
            <td>
                <form id="deleteForm{{ $time_slot->id }}" action="{{ route('timeSlots.destroy',$time_slot->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('timeSlots.show',$time_slot->id) }}"><i class="fa fa-eye"></i></a>
                    @can('time-slot-edit')
                    <a class="btn btn-primary" href="{{ route('timeSlots.edit',$time_slot->id) }}"><i class="fa fa-edit"></i></a>
                    @endcan
                    @csrf
                    @method('DELETE')
                    @can('time-slot-delete')
                    <button type="button" onclick="confirmDelete('{{ $time_slot->id }}')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                    @endcan
                </form>
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="6" class="text-center">There is no time slots.</td>
        </tr>
        @endif
    </table>
    {!! $time_slots->links() !!}
</div>
<script>
    function confirmDelete(Id) {
        var result = confirm("Are you sure you want to delete this Item?");
            if (result) {
                document.getElementById('deleteForm' + Id).submit();
            }
        }
</script>
<script>
    $(document).ready(function () {
        function checkTableResponsive() {
            var viewportWidth = $(window).width();
            var $table = $('table');

            if (viewportWidth < 768) { 
                $table.addClass('table-responsive');
            } else {
                $table.removeClass('table-responsive');
            }
        }

        checkTableResponsive();

        $(window).resize(function () {
            checkTableResponsive();
        });
    });

    $(document).ready(function () {
        const $searchInput = $("#staffSearch");
        const $dropdown = $("#staffDropdown");
        const originalOptions = $dropdown.children().clone(); // Clone original options

        $searchInput.on("input", function () {
            const filter = $searchInput.val().toLowerCase().trim();

            // Filter options based on the search term
            const filteredOptions = originalOptions.filter(function () {
                const text = $(this).text().toLowerCase().trim();
                return text.startsWith(filter);
            });

            // Clear and append the filtered options
            $dropdown.empty().append(filteredOptions);
        });
    });

</script>
@endsection