<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employee Attendance') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="card mt-5">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 mt-1 mr-1">
                                <div class="float-right">
                                    <a class="btn btn-success" href="{{ route('employee.register') }}">New Employee</a>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <p>{{ $message }}</p>
                                </div>
                                @endif
                            </div>
                            <div class="col-lg-12">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact Number</th>
                                        <th width="280px">Action</th>
                                    </tr>
                                    @foreach ($users as $user)
                                    <tr>                                        
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>              
                                            <a class="btn btn-primary" href="{{ route('employee.edit',$user->id) }}">Edit</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                                {!! $users->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</x-app-layout>
