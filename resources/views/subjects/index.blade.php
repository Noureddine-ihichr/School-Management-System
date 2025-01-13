@extends('layouts.admin-dashboard')

<!-- Alert Messages -->
@if(session('success') || session('error'))
    <div class="alert-container mb-4"
         x-data="{ show: true }"
         x-show="show"
         x-init="setTimeout(() => show = false, 3000)"
         :class="{ 'alert-enter': show, 'alert-leave': !show }">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r shadow-lg">
                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-lg">
                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif
    </div>
@endif

@section('content')
    <div class="w-full">
        <div class="bg-white/80 backdrop-blur-sm border border-gray-200 rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Subjects Management</h1>
                <a href="{{ route('subjects.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add New Subject
                </a>
            </div>

            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teachers</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($subjects as $subject)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $subject->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    <span class="bg-indigo-100 text-indigo-800 px-2 py-1 rounded-full">
                                        {{ $subject->code }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($subject->description, 50) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full">
                                        {{ $subject->teachers_count }} Teachers
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium space-x-2">
                                    <a href="{{ route('subjects.show', $subject->id) }}" 
                                       class="text-blue-600 hover:text-blue-900 bg-blue-100 px-3 py-1 rounded-full">
                                        View
                                    </a>
                                    <a href="{{ route('subjects.edit', $subject->id) }}" 
                                       class="text-green-600 hover:text-green-900 bg-green-100 px-3 py-1 rounded-full">
                                        Edit
                                    </a>
                                    <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900 bg-red-100 px-3 py-1 rounded-full"
                                                onclick="return confirm('Are you sure you want to delete this subject?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center py-6">
                                        <svg class="h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        <p class="text-gray-500 mb-2">No subjects found</p>
                                        <a href="{{ route('subjects.create') }}" class="text-blue-600 hover:text-blue-900">Create one now</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="mt-4">
                {{ $subjects->links() }}
            </div>
        </div>
    </div>
@endsection