@extends('adminlte::page')

@section('title', 'Role List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="mb-0">Role List</h1>
        <a href="{{ route('roles.create') }}" class="btn btn-success btn-sm">
            Add
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
        <table id="dataTables" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Role Name</th>
                        <th>Permissions</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                {{ $role->permissions->count() }}
                                permission{{ $role->permissions->count() !== 1 ? 's' : '' }}
                            </td>
                            <td>
                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <a href="{{ route('roles.show', $role->id) }}" class="btn btn-warning btn-sm">View</a>

                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                    style="display:inline-block;"
                                    onsubmit="return confirm('Are you sure you want to delete this role?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm ml-1">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@stop
