@extends('layouts.admin-dashboard')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="bg-white/80 backdrop-blur-sm border border-gray-200 rounded-lg p-4">
            <h1 class="text-xl font-semibold text-gray-800 mb-4">Teacher Details</h1>
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
                    <p class="mt-1 text-gray-900">{{ $teacher->user ? $teacher->user->email : 'N/A' }}</p>
                </div>
                
            </div>
            <div class="mt-6">
                <a href="{{ route('teachers.edit', $teacher->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Edit Teacher</a>
                <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 ml-2">Delete Teacher</button>
                </form>
            </div>
        </div>
    </div>
@endsection