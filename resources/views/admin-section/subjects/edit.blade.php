@extends('layouts.admin-dashboard')

@section('content')
<div class="w-full">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow-lg border border-gray-200 mb-6">
        <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-book text-indigo-500"></i>
                Edit Subject
            </h1>
            <p class="text-gray-600 mt-2">Update subject details and manage teacher assignments</p>
        </div>
    </div>

    <!-- Edit Subject Form -->
    <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-6">
        <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Subject Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-semibold text-gray-700">Subject Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $subject->name) }}"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-600 focus:ring-indigo-600 sm:text-sm"
                    required>
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Subject Code -->
            <div class="mb-6">
                <label for="code" class="block text-sm font-semibold text-gray-700">Subject Code</label>
                <input type="text" name="code" id="code" value="{{ old('code', $subject->code) }}"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-600 focus:ring-indigo-600 sm:text-sm"
                    required>
                @error('code')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Subject Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-semibold text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-600 focus:ring-indigo-600 sm:text-sm"
                    >{{ old('description', $subject->description) }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Teacher Selection -->
            <div class="mb-6" x-data="{ showTeacherModal: false, selectedTeachers: {{ $subject->teachers->map(fn($teacher) => ['id' => $teacher->id, 'first_name' => $teacher->first_name, 'last_name' => $teacher->last_name])->toJson() }} }">
                <div class="flex items-center justify-between">
                    <label class="block text-sm font-semibold text-gray-700">Assigned Teachers</label>
                    <button type="button" 
                        @click.prevent="showTeacherModal = true"
                        class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-lg hover:bg-indigo-200 transition">
                        <i class="fas fa-plus mr-2"></i>Select Teachers
                    </button>
                </div>

                <!-- Selected Teachers Display -->
                <div class="mt-2 flex flex-wrap gap-2">
                    <template x-for="teacher in selectedTeachers" :key="teacher.id">
                        <div class="bg-gray-50 px-3 py-1 rounded-full border border-gray-200 flex items-center">
                            <span x-text="`${teacher.first_name} ${teacher.last_name}`"></span>
                            <button type="button" @click.prevent="selectedTeachers = selectedTeachers.filter(t => t.id !== teacher.id)"
                                class="ml-2 text-gray-500 hover:text-red-500">
                                <i class="fas fa-times"></i>
                            </button>
                            <input type="hidden" name="teachers[]" :value="teacher.id">
                        </div>
                    </template>
                </div>

                <!-- Teachers Modal -->
                <template x-teleport="body">
                    <div x-show="showTeacherModal" 
                        x-cloak
                        class="fixed inset-0 z-50 overflow-y-auto"
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        
                        <!-- Modal Backdrop -->
                        <div class="fixed inset-0 bg-black bg-opacity-50" @click="showTeacherModal = false"></div>
                        
                        <!-- Modal Content -->
                        <div class="relative min-h-screen flex items-center justify-center p-4">
                            <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full">
                                <div class="px-6 py-4 border-b border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-medium text-gray-900">Select Teachers</h3>
                                        <button @click="showTeacherModal = false" class="text-gray-400 hover:text-gray-500">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="px-6 py-4 max-h-[60vh] overflow-y-auto">
                                    @foreach($teachers as $teacher)
                                        <div class="flex items-center p-3 hover:bg-gray-50 cursor-pointer rounded-lg"
                                            @click.prevent="
                                                const teacherData = { 
                                                    id: {{ $teacher->id }}, 
                                                    first_name: '{{ $teacher->first_name }}',
                                                    last_name: '{{ $teacher->last_name }}'
                                                };
                                                if (!selectedTeachers.find(t => t.id === teacherData.id)) {
                                                    selectedTeachers.push(teacherData);
                                                }
                                            ">
                                            <div class="flex-1">
                                                <h4 class="text-sm font-medium text-gray-900">{{ $teacher->first_name }} {{ $teacher->last_name }}</h4>
                                            </div>
                                            <div class="ml-3 flex-shrink-0">
                                                <template x-if="selectedTeachers.find(t => t.id === {{ $teacher->id }})">
                                                    <i class="fas fa-check text-green-500"></i>
                                                </template>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="px-6 py-4 border-t border-gray-200">
                                    <button type="button" @click="showTeacherModal = false"
                                        class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                                        Done
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('subjects.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                    Update Subject
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
