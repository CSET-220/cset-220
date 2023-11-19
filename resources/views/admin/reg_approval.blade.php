@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
@section('navLink')
@endsection

@section('mainContent')
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
                        <form action="{{route('admin.reg_approval')}}" method="post">    
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->first_name}}</td>
                                    <td>{{$user->role_id}}</td>
                                    <td>
                                        <input type="checkbox" name="approve[]" value="{{$user->id}}">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="deny[]" value="{{$user->id}}">
                                    </td>
                                </tr>
                            @endforeach
                            <input type="submit" value="Submit">
                        </form>
                    </tbody>
                </table>
                {{$users->links()}}
            </div>
        </div>
    </div>
@endsection
