@extends('layouts.admin-dashboard')

@section('content')
    <div class="w-full">
        <div class="bg-white/80 backdrop-blur-sm border border-gray-200 rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">View Teacher Details</h1>
                <a href="{{ route('teachers.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition duration-200 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to List
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">First Name</label>
                        <p class="mt-1 p-3 bg-gray-50 rounded-lg">{{ $teacher->first_name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Last Name</label>
                        <p class="mt-1 p-3 bg-gray-50 rounded-lg">{{ $teacher->last_name }}</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <p class="mt-1 p-3 bg-gray-50 rounded-lg">{{ $teacher->phone_number }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="mt-1 p-3 bg-gray-50 rounded-lg">{{ $teacher->user ? $teacher->user->email : 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Created At</label>
                        <p class="mt-1 p-3 bg-gray-50 rounded-lg">{{ $teacher->created_at->format('F j, Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <a href="{{ route('teachers.edit', $teacher->id) }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    Edit Teacher
                </a>
                <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition duration-200 flex items-center gap-2" onclick="return confirm('Are you sure you want to delete this teacher?')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        Delete Teacher
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection