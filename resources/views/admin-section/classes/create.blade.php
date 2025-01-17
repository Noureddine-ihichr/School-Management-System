@extends('layouts.admin-dashboard')

@section('content')
<div class="w-full">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow-lg border border-gray-200 mb-6">
        <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-chalkboard text-indigo-500"></i>
                Create New Class
            </h1>
            <p class="text-gray-600 mt-2">Fill in the details below to create a new class.</p>
        </div>
    </div>

    <!-- Create Class Form -->
    <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-6">
        <form action="{{ route('classes.store') }}" method="POST">
            @csrf
            
            <!-- Class Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-semibold text-gray-700">Class Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-600 focus:ring-indigo-600 sm:text-sm"
                    required>
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Teacher Selection -->
            <div class="mb-6" x-data="{ showTeacherModal: false, selectedTeachers: [], selectedSubjects: {} }">
                <div class="flex items-center justify-between">
                    <label class="block text-sm font-semibold text-gray-700">Assigned Teachers</label>
                    <button type="button" 
                        @click.prevent="showTeacherModal = true"
                        class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-lg hover:bg-indigo-200 transition">
                        <i class="fas fa-plus mr-2"></i>Select Teachers
                    </button>
                </div>

                <!-- Selected Teachers Display -->
                <div class="mt-4 space-y-4">
                    <template x-for="teacher in selectedTeachers" :key="teacher.id">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <div class="flex items-center justify-between mb-3">
                                <span class="font-medium" x-text="`${teacher.first_name} ${teacher.last_name}`"></span>
                                <button type="button" @click.prevent="selectedTeachers = selectedTeachers.filter(t => t.id !== teacher.id); delete selectedSubjects[teacher.id]"
                                    class="text-gray-500 hover:text-red-500">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            
                            <!-- Subjects for this teacher -->
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-700 mb-2">Select subjects for this teacher:</p>
                                <div class="space-y-2">
                                    <template x-for="subject in teacher.subjects" :key="subject.id">
                                        <div class="flex items-center">
                                            <input type="checkbox" 
                                                :id="'subject-' + teacher.id + '-' + subject.id"
                                                :name="'teacher_subjects[' + teacher.id + '][]'"
                                                :value="subject.id"
                                                :checked="selectedSubjects[teacher.id]?.includes(subject.id)"
                                                @change="
                                                    if (!selectedSubjects[teacher.id]) selectedSubjects[teacher.id] = [];
                                                    if ($event.target.checked) {
                                                        selectedSubjects[teacher.id].push(subject.id);
                                                    } else {
                                                        selectedSubjects[teacher.id] = selectedSubjects[teacher.id].filter(id => id !== subject.id);
                                                    }
                                                "
                                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                            <label :for="'subject-' + teacher.id + '-' + subject.id"
                                                class="ml-2 text-sm text-gray-700"
                                                x-text="subject.name"></label>
                                        </div>
                                    </template>
                                </div>
                            </div>
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
                                                    last_name: '{{ $teacher->last_name }}',
                                                    subjects: {{ $teacher->subjects->toJson() }}
                                                };
                                                if (!selectedTeachers.find(t => t.id === teacherData.id)) {
                                                    selectedTeachers.push(teacherData);
                                                }
                                            ">
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $teacher->first_name }} {{ $teacher->last_name }}</p>
                                                <p class="text-sm text-gray-500">{{ $teacher->subjects->count() }} subjects</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class="px-6 py-4 border-t border-gray-200">
                                    <button type="button"
                                        @click="showTeacherModal = false"
                                        class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                                        Done
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Students Selection -->
            <div class="mb-6" x-data="{ showStudentModal: false, selectedStudents: [] }">
                <div class="flex items-center justify-between">
                    <label class="block text-sm font-semibold text-gray-700">Enrolled Students</label>
                    <button type="button" 
                        @click.prevent="showStudentModal = true"
                        class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-lg hover:bg-indigo-200 transition">
                        <i class="fas fa-plus mr-2"></i>Select Students
                    </button>
                </div>

                <!-- Selected Students Display -->
                <div class="mt-2 flex flex-wrap gap-2">
                    <template x-for="student in selectedStudents" :key="student.id">
                        <div class="bg-gray-50 px-3 py-1 rounded-full border border-gray-200 flex items-center">
                            <span x-text="`${student.first_name} ${student.last_name}`"></span>
                            <button type="button" @click.prevent="selectedStudents = selectedStudents.filter(s => s.id !== student.id)"
                                class="ml-2 text-gray-500 hover:text-red-500">
                                <i class="fas fa-times"></i>
                            </button>
                            <input type="hidden" name="students[]" :value="student.id">
                        </div>
                    </template>
                </div>

                <!-- Students Modal -->
                <template x-teleport="body">
                    <div x-show="showStudentModal" 
                        x-cloak
                        class="fixed inset-0 z-50 overflow-y-auto"
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        
                        <!-- Modal Backdrop -->
                        <div class="fixed inset-0 bg-black bg-opacity-50" @click="showStudentModal = false"></div>
                        
                        <!-- Modal Content -->
                        <div class="relative min-h-screen flex items-center justify-center p-4">
                            <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full">
                                <div class="px-6 py-4 border-b border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-medium text-gray-900">Select Students</h3>
                                        <button @click="showStudentModal = false" class="text-gray-400 hover:text-gray-500">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="px-6 py-4 max-h-[60vh] overflow-y-auto">
                                    @foreach($students as $student)
                                        <div class="flex items-center p-3 hover:bg-gray-50 cursor-pointer rounded-lg"
                                            @click.prevent="
                                                const studentData = { 
                                                    id: {{ $student->id }}, 
                                                    first_name: '{{ $student->first_name }}', 
                                                    last_name: '{{ $student->last_name }}'
                                                };
                                                const index = selectedStudents.findIndex(s => s.id === studentData.id);
                                                if (index === -1) {
                                                    selectedStudents.push(studentData);
                                                } else {
                                                    selectedStudents.splice(index, 1);
                                                }
                                            "
                                            :class="{ 'bg-indigo-50': selectedStudents.some(s => s.id === {{ $student->id }}) }">
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ $student->first_name }} {{ $student->last_name }}
                                                </p>
                                                <p class="text-sm text-gray-500">{{ $student->email }}</p>
                                            </div>
                                            <div class="ml-3" x-show="selectedStudents.some(s => s.id === {{ $student->id }})">
                                                <i class="fas fa-check text-indigo-600"></i>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class="px-6 py-4 border-t border-gray-200">
                                    <button type="button" 
                                        @click="showStudentModal = false"
                                        class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
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
                <a href="{{ route('classes.index') }}"
                    class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    Cancel
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    Create Class
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
