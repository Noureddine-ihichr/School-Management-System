@extends('layouts.admin-dashboard')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Admin Management</h1>
                <p class="text-gray-600 mt-1">Manage your system administrators</p>
            </div>
            <a href="{{ route('admin.create') }}" 
               class="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Create Admin
            </a>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Profile Icon</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Name</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Email</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($admins as $admin)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    @if($admin->profile_icon)
                                        <img src="{{ asset('storage/' . $admin->profile_icon) }}" 
                                             alt="Profile icon" 
                                             class="h-12 w-12 rounded-full object-cover border-2 border-gray-200">
                                    @else
                                        <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center border-2 border-gray-200">
                                            <span class="text-blue-600 font-semibold text-lg">
                                                {{ strtoupper(substr($admin->name, 0, 2)) }}
                                            </span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $admin->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $admin->email }}</div>
                                </td>
                                <td class="px-6 py-4 text-right space-x-3">
                                    <button class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors duration-200">
                                        <span class="flex items-center justify-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </span>
                                    </button>
                                    <button class="text-sm font-medium text-red-600 hover:text-red-800 transition-colors duration-200">
                                        <span class="flex items-center justify-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete
                                        </span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
