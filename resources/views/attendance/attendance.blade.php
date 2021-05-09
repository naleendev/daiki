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
                                    @if($attendance['checkIn'] == '')
                                    <a class="btn btn-success" href="{{ route('checkIn',['id' => $attendance['userID'],'type' => 'inBtn']) }}"> Check In</a>
                                    @endif

                                    @if($attendance['checkOut'] == '')
                                    <a class="btn btn-success" href="{{ route('checkOut',['id' => $attendance['userID'],'type' => 'outBtn']) }}"> Check Out</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="mt2"> 
                            <div class="col-lg-12">
                                @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <p>{{ $message }}</p>
                                </div>
                                @endif
                            </div>


                            <p>You Last Attendance Records : </p>
                            @if ($attendance['flag'] == '1')
                            <p>Check In: {{$attendance['checkIn']}} / Check Out: {{$attendance['checkOut']}}</p>
                            @else
                            <p>Check In: {{$attendance['checkIn']}} / Check Out: {{$attendance['checkOut']}}</p>
                            @endif
                        </div>

                    </div>
                </div>
            </div> 
        </div>
    </div>
</x-app-layout>