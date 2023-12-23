@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 margin-tb">
            <div class="float-start">
                <h2>Customer</h2>
            </div>
            <div class="float-end">
                @can('customer-create')
                <a class="btn btn-success" href="{{ route('customers.create') }}"> Create New Customer</a>
                @endcan
            </div>
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
        <div class="col-md-9">
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Sr#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th width="280px">Action</th>
                </tr>
                @if(count($customers))
                @foreach ($customers as $customer)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>

                    <td>
                        <form id="deleteForm{{ $customer->id }}" action="{{ route('customers.destroy',$customer->id) }}" method="POST">
                            <a class="btn btn-info" href="{{ route('customers.show',$customer->id) }}"><i class="fas fa-eye"></i></a>
                            @can('customer-edit')
                            <a class="btn btn-primary" href="{{ route('customers.edit',$customer->id) }}"><i class="fas fa-edit"></i></a>
                            @endcan
                            @csrf
                            @method('DELETE')
                            @can('customer-delete')
                            <button type="button" onclick="confirmDelete('{{ $customer->id }}')" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            @endcan
                            @can('order-list')
                            <a class="btn btn-info" href="{{ route('orders.index') }}?customer_id={{ $customer->id }}">Order History</a>
                            @endcan
                        </form>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="5" class="text-center">There is no Customer</td>
                </tr>
                @endif
            </table>
            {!! $customers->links() !!}
        </div>
        <div class="col-md-3">
            <h3>Filter</h3>
            <hr>
            <form action="{{ route('customers.index') }}" method="GET" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Name:</strong>
                            <input type="text" name="name" value="{{$filter['name']}}" class="form-control" placeholder="Name">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Email:</strong>
                            <input type="email" name="email" value="{{$filter['email']}}" class="form-control" placeholder="abc@gmail.com">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Number:</strong>
                            <input type="text" name="number" value="{{$filter['number']}}" class="form-control" placeholder="+971 xxxxxx">
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function confirmDelete(Id) {
        var result = confirm("Are you sure you want to delete this Item?");
            if (result) {
                document.getElementById('deleteForm' + Id).submit();
            }
        }
</script>
@endsection