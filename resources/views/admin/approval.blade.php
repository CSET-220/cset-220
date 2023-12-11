@extends('layouts.app')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

@section('title')
    Account Approval
@endsection

@section('pageHeader')
    <div class="bg-gradient-to-r from-gray-700 to-gray-900 text-white py-10 w-full">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold mb-4">Account Approval</h1>
        </div>
    </div>
@endsection

@section('mainContent')
    <div class="w-1/2 mx-auto mb-20 relative p-4 overflow-x-auto">
        <table id="myTable" class="text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Role
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Approve
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Deny
                    </th>
                </tr>
            </thead>
            <tbody>
                <form action="{{route('admin.approval')}}" method="post">  
                    @csrf
                    @foreach($users as $user)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$user->first_name}} {{$user->last_name}}
                        </th>
                        <td class="px-6 py-4">
                            {{App\Models\Role::where('id',$user->role_id)->value('role_title')}}
                        </td>
                        <td class="px-6 py-4">
                            <input type="checkbox" class="approved" value="{{$user->id}}">
                        </td>
                        <td class="px-6 py-4">
                            <input type="checkbox" class="denied" value="{{$user->id}}">
                        </td>
                    </tr>
                    @endforeach
                </form>
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script src="{{ asset('js/admin/approval.js') }}"></script>
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>
@endsection