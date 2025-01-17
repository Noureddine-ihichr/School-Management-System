@extends('layouts.admin-dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $class->name }}</h1>
                <p class="text-gray-600 mt-2">Edit Class Details</p>
            </div>
            <a href="{{ route('classes.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                </svg>
                Back to Classes
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Basic Info Section -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <form action="{{ route('classes.update', ['class' => $class->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="name" class="block text-lg font-semibold text-gray-900 mb-2">Class Name</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $class->name) }}"
                           class="w-full px-4 py-2 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                           required>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Teachers Selection -->
                <div class="mb-6" x-data="{ 
                    showTeacherModal: false, 
                    selectedTeachers: {{ json_encode($class->teachers->map(fn($teacher) => [
                        'id' => $teacher->id,
                        'first_name' => $teacher->first_name,
                        'last_name' => $teacher->last_name,
                        'subjects' => $teacher->subjects
                    ])) }},
                    selectedSubjects: {{ json_encode($class->subjects->groupBy('pivot.teacher_id')->map(fn($subjects) => $subjects->pluck('id')->toArray())) }}
                }">
                    <div class="flex justify-between items-center mb-4">
                        <label class="text-lg font-semibold text-gray-900">Assigned Teachers & Subjects</label>
                        <button type="button" 
                                @click="showTeacherModal = true"
                                class="flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-150">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Select Teachers
                        </button>
                    </div>

                    <!-- Selected Teachers Display -->
                    <div class="space-y-4">
                        <template x-for="teacher in selectedTeachers" :key="teacher.id">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                                            <span x-text="teacher.first_name.charAt(0) + teacher.last_name.charAt(0)"></span>
                                        </div>
                                        <span class="ml-3 font-medium" x-text="`${teacher.first_name} ${teacher.last_name}`"></span>
                                    </div>
                                    <button type="button" 
                                            @click="selectedTeachers = selectedTeachers.filter(t => t.id !== teacher.id); delete selectedSubjects[teacher.id]"
                                            class="text-red-600 hover:text-red-800 p-1 rounded-full hover:bg-red-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
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
                             class="fixed inset-0 z-50 overflow-y-auto"
                             style="display: none;">
                            <div class="fixed inset-0 bg-black bg-opacity-50" @click="showTeacherModal = false"></div>
                            
                            <div class="relative min-h-screen flex items-center justify-center p-4">
                                <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full">
                                    <div class="px-6 py-4 border-b border-gray-200">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-xl font-semibold text-gray-900">Select Teachers</h3>
                                            <button @click="showTeacherModal = false" 
                                                    class="text-gray-400 hover:text-gray-500 p-2 rounded-full hover:bg-gray-100">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="px-6 py-4 max-h-[60vh] overflow-y-auto">
                                        @foreach($teachers as $teacher)
                                            <div class="flex items-center p-3 hover:bg-gray-50 cursor-pointer rounded-lg mb-2"
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
                                                "
                                                :class="{ 'bg-indigo-50 border border-indigo-200': selectedTeachers.some(t => t.id === {{ $teacher->id }}) }">
                                                <div class="flex items-center flex-1">
                                                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 mr-3">
                                                        {{ strtoupper(substr($teacher->first_name, 0, 1) . substr($teacher->last_name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <span class="font-medium block">{{ $teacher->first_name }} {{ $teacher->last_name }}</span>
                                                        <span class="text-sm text-gray-500">{{ $teacher->subjects->count() }} subjects</span>
                                                    </div>
                                                </div>
                                                <div class="ml-3" x-show="selectedTeachers.some(t => t.id === {{ $teacher->id }})">
                                                    <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <div class="px-6 py-4 border-t border-gray-200">
                                        <button type="button" 
                                                @click="showTeacherModal = false"
                                                class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-150">
                                            Done
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Students Selection (Similar structure as Teachers) -->
                <div class="mb-6" x-data="{ 
                    showStudentModal: false, 
                    selectedStudents: {{ json_encode($class->students->map(fn($student) => [
                        'id' => $student->id,
                        'first_name' => $student->first_name,
                        'last_name' => $student->last_name
                    ])) }}
                }">
                    <div class="flex justify-between items-center mb-4">
                        <label class="text-lg font-semibold text-gray-900">Enrolled Students</label>
                        <button type="button" 
                                @click="showStudentModal = true"
                                class="flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-150">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Select Students
                        </button>
                    </div>

                    <!-- Selected Students Display -->
                    <div class="space-y-2">
                        <template x-for="student in selectedStudents" :key="student.id">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                        <span x-text="student.first_name.charAt(0) + student.last_name.charAt(0)"></span>
                                    </div>
                                    <span class="ml-3" x-text="`${student.first_name} ${student.last_name}`"></span>
                                </div>
                                <button type="button" 
                                        @click="selectedStudents = selectedStudents.filter(s => s.id !== student.id)"
                                        class="text-red-600 hover:text-red-800 p-1 rounded-full hover:bg-red-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                                <input type="hidden" name="students[]" :value="student.id">
                            </div>
                        </template>
                    </div>

                    <!-- Students Modal -->
                    <template x-teleport="body">
                        <div x-show="showStudentModal" 
                             class="fixed inset-0 z-50 overflow-y-auto"
                             style="display: none;">
                            <div class="fixed inset-0 bg-black bg-opacity-50" @click="showStudentModal = false"></div>
                            
                            <div class="relative min-h-screen flex items-center justify-center p-4">
                                <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full">
                                    <div class="px-6 py-4 border-b border-gray-200">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-xl font-semibold text-gray-900">Select Students</h3>
                                            <button @click="showStudentModal = false" 
                                                    class="text-gray-400 hover:text-gray-500 p-2 rounded-full hover:bg-gray-100">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="px-6 py-4 max-h-[60vh] overflow-y-auto">
                                        @foreach($students as $student)
                                            <div class="flex items-center p-3 hover:bg-gray-50 cursor-pointer rounded-lg mb-2"
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
                                                :class="{ 'bg-green-50 border border-green-200': selectedStudents.some(s => s.id === {{ $student->id }}) }">
                                                <div class="flex items-center flex-1">
                                                    <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 mr-3">
                                                        {{ strtoupper(substr($student->first_name, 0, 1) . substr($student->last_name, 0, 1)) }}
                                                    </div>
                                                    <span class="font-medium">{{ $student->first_name }} {{ $student->last_name }}</span>
                                                </div>
                                                <div class="ml-3" x-show="selectedStudents.some(s => s.id === {{ $student->id }})">
                                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <div class="px-6 py-4 border-t border-gray-200">
                                        <button type="button" 
                                                @click="showStudentModal = false"
                                                class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-150">
                                            Done
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end gap-4 mt-8">
                    <a href="{{ route('classes.index') }}"
                        class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Update Class
                    </button>
                </div>
            </form>
        </div>

        <!-- Preview Section -->
        <div class="space-y-6">
            <!-- Current Teachers -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Current Teachers
                </h2>
                <div class="space-y-2">
                    @forelse($class->teachers as $teacher)
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 mr-3">
                                {{ strtoupper(substr($teacher->first_name, 0, 1) . substr($teacher->last_name, 0, 1)) }}
                            </div>
                            <span class="font-medium">{{ $teacher->first_name }} {{ $teacher->last_name }}</span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No teachers assigned yet</p>
                    @endforelse
                </div>
            </div>

            <!-- Current Students -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Current Students
                </h2>
                <div class="space-y-2">
                    @forelse($class->students as $student)
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 mr-3">
                                {{ strtoupper(substr($student->first_name, 0, 1) . substr($student->last_name, 0, 1)) }}
                            </div>
                            <span class="font-medium">{{ $student->first_name }} {{ $student->last_name }}</span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No students enrolled yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
