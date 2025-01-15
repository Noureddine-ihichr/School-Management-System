@extends('layouts.admin-dashboard')

@section('content')
    <div class="w-full">
        <div class="bg-white/80 backdrop-blur-sm border border-gray-200 rounded-lg shadow-lg p-6">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-600 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path d="M12 16l-9-5v5l9 5 9-5v-5l-9 5z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Subjects Management</h1>
                        <p class="text-sm text-gray-500">Manage and monitor all subjects</p>
                    </div>
                </div>
                <a href="{{ route('subjects.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Create New Subject
                </a>
            </div>

            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-blue-600 text-white">
                            <th class="px-6 py-3 text-left w-[40%]">Subject Name</th>
                            <th class="px-6 py-3 text-left w-[40%]">Teachers</th>
                            <th class="px-6 py-3 text-right w-[20%]">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($subjects as $subject)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="bg-blue-100 rounded-lg p-2.5 mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                                                <path d="M12 16l-9-5v5l9 5 9-5v-5l-9 5z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-['Poppins'] text-lg font-semibold text-gray-900">{{ $subject->name }}</div>
                                            <div class="text-xs text-gray-500">Subject ID: {{ $subject->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="bg-indigo-100 text-indigo-800 px-2.5 py-1 rounded-full text-xs font-medium">
                                        {{ $subject->teachers_count }} Teachers
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-end items-center gap-2">
                                        <a href="{{ route('subjects.show', $subject->id) }}" 
                                           class="p-1.5 hover:bg-blue-50 rounded-lg text-blue-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('subjects.edit', $subject->id) }}" 
                                           class="p-1.5 hover:bg-green-50 rounded-lg text-green-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <button type="button"
                                                onclick="deleteSubject('{{ $subject->id }}')"
                                                class="p-1.5 hover:bg-red-50 rounded-lg text-red-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                        <form id="delete-form-{{ $subject->id }}"
                                              action="{{ route('subjects.destroy', $subject->id) }}"
                                              method="POST" 
                                              class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 16l-9-5v5l9 5 9-5v-5l-9 5z"/>
                                        </svg>
                                        <span class="font-medium">No subjects found</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $subjects->links() }}
            </div>
        </div>
    </div>
@endsection

<script>
    function deleteSubject(id) {
        if (confirm('Are you sure you want to delete this subject? This action cannot be undone.')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>