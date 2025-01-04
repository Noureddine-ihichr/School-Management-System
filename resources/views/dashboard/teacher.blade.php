@extends('layouts.teacher-dashboard') <!-- Use a dedicated layout for teachers -->

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="bg-white/80 backdrop-blur-sm border border-gray-200 rounded-lg p-4">
            <h1 class="text-xl font-semibold text-gray-800 mb-4">Teacher Dashboard</h1>

            <!-- Welcome Message -->
            <div class="mb-6">
                <p class="text-lg text-gray-700">Welcome, {{ $teacher->first_name }} {{ $teacher->last_name }}!</p>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                <a href="{{ route('teacher.profile') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-center">
                    View Profile
                </a>
                <a href="{{ route('teacher.classes') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-center">
                    My Classes
                </a>
                <a href="{{ route('teacher.schedule') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-center">
                    My Schedule
                </a>
            </div>

            <!-- Teacher Information -->
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">First Name</label>
                    <p class="mt-1 text-gray-900">{{ $teacher->first_name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Last Name</label>
                    <p class="mt-1 text-gray-900">{{ $teacher->last_name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Subject</label>
                    <p class="mt-1 text-gray-900">{{ $teacher->subject }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <p class="mt-1 text-gray-900">{{ $teacher->phone_number }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <p class="mt-1 text-gray-900">{{ $teacher->user->email }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection