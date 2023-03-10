@extends('layouts.app')

@section('content')
    <div class="container">
        <br>
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>Todo list</h2>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-success mt-2 mb-2" href="{{ route('todo.create') }}"><i class="fa fa-plus"></i> Add New Todo </a>
                    </div>
                </div>
            </div>
            <br>
            <div class="col-md-12">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Task Name</th>
                            <th width="10%">
                                <center>Task Status</center>
                            </th>
                            <th width="20%">
                                <center>Action</center>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($todos as $todo)
                            <tr>
                                <th>{{ ++$i }}</th>
                                <td>{{ $todo->title }}</td>
                                <td>
                                    <center>{{ $todo->status }}</center>
                                </td>
                                <td>
                                    <div class="action_btn">
                                        <div class="action_btn">
                                            <form action="{{ route('todo.destroy', $todo->id) }}" method="post">
                                                <a href="{{ route('todo.show', $todo->id) }}" class="btn btn-info">view</a>
                                                <a href="{{ route('todo.edit', $todo->id) }}" class="btn btn-primary">Edit</a>
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger mt-1" type="submit">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <center>No data found</center>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
