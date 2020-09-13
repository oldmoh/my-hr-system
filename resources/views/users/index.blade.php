@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-4 d-flex">
                <form class="form-inline my-2 my-lg-0 mr-sm-2" action="/users">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search"
                        name="keyword" value="{{request()->input('keyword')}}">
                    <select id="department" class="form-control mr-sm-2" name="department_id"
                        value="{{request()->input('department_id')}}">
                        <option value="0" @if (request()->input('department_id') == null)
                            selected
                            @endif>-</option>
                        @foreach ($departments as $department)
                        <option value="{{$department->id}}" @if (request()->input('department_id') == $department->id)
                            selected
                            @endif >{{$department->code}}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
                @can('create', Auth::user())
                <form class="form-inline my-2 my-lg-0" action="{{ route('users.create') }}">
                    <button class="btn btn-primary my-2 my-sm-0" type="submit">Create</button>
                </form>
                @endcan
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email Address</th>
                        <th scope="col">Department</th>
                        <th scope="col">Operations</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{($users->currentPage() - 1) * $users->perPage() + $loop->index + 1}}</th>
                        <td><a href="{{ route('users.show', $user) }}">{{$user->name}}</a></td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->department->code}}</td>
                        <td>
                            <form style="display: inline-block" action="{{ route('users.edit', $user) }}" method="GET">
                                <button type="submit" @cannot('update', $user) disabled @endcannot
                                    class="btn btn-primary">Edit</button>
                            </form>
                            <form style="display: inline-block" action="{{ route('users.delete', $user) }}"
                                method="GET">
                                <button type="submit" @cannot('delete', $user) disabled @endcannot
                                    class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{$users->appends(request()->except('page'))->links()}}
        </div>
    </div>
</div>
@endsection
