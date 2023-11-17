@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Registration Approval</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->first_name}}</td>
                                <td>{{$user->role_id}}</td>
                                <td>
                                    <form action="{{route('admin.approve', $user->id)}}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Approve</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Reject</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

