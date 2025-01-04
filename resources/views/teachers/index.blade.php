@extends('layouts.admin-dashboard')

@section('content')
    <div class="bg-white/80 backdrop-blur-sm border border-gray-200 rounded-lg p-4">
        <h1 class="text-xl font-semibold text-gray-800 mb-4">Teachers</h1>
        
        <!-- Add New Teacher Button -->
        <a href="{{ route('teachers.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 mb-4 inline-block">
            Add New Teacher
        </a>

        <!-- Teachers Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">First Name</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Last Name</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Subject</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Phone Number</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Email</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($teachers as $teacher)
                        <tr>
                            <td class="px-6 py-4 border-b border-gray-300">{{ $teacher->first_name }}</td>
                            <td class="px-6 py-4 border-b border-gray-300">{{ $teacher->last_name }}</td>
                            <td class="px-6 py-4 border-b border-gray-300">{{ $teacher->subject }}</td>
                            <td class="px-6 py-4 border-b border-gray-300">{{ $teacher->phone_number }}</td>
                            <td class="px-6 py-4 border-b border-gray-300">
                                {{ $teacher->user ? $teacher->user->email : 'N/A' }} <!-- Display email from users table -->
                            </td>
                            <td class="px-6 py-4 border-b border-gray-300">
                                <a href="{{ route('teachers.show', $teacher->id) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                <a href="{{ route('teachers.edit', $teacher->id) }}" class="text-indigo-600 hover:text-indigo-900 ml-2">Edit</a>
                                <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this teacher?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 ml-2">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No teachers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $teachers->links() }}
        </div>
    </div>
@endsection