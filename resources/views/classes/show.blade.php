@extends('layouts.admin-dashboard')

@section('content')
<div class="w-full">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow-lg border border-gray-200 mb-6">
        <div class="p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-chalkboard text-indigo-500"></i>
                        {{ $class->name }}
                    </h1>
                    <p class="text-gray-600 mt-2">Class Details and Management</p>
                </div>
                <a href="{{ route('classes.edit', ['class' => $class->id]) }}" 
                   class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Edit Class
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Teachers Section -->
        <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Teachers</h2>
                <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm">
                    {{ $class->teachers->count() }} Teachers
                </span>
            </div>
            <div class="space-y-3">
                @foreach($class->teachers as $teacher)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium">{{ $teacher->first_name }} {{ $teacher->last_name }}</p>
                            <p class="text-sm text-gray-500">{{ $teacher->email }}</p>
                        </div>
                        <form action="{{ route('classes.remove-teacher', ['class' => $class->id, 'teacher' => $teacher->id]) }}" 
                              method="POST" 
                              class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="text-red-600 hover:text-red-900"
                                    onclick="return confirm('Are you sure you want to remove this teacher?')">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Students Section -->
        <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Students</h2>
                <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm">
                    {{ $class->students->count() }} Students
                </span>
            </div>
            <div class="space-y-3">
                @foreach($class->students as $student)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium">{{ $student->first_name }} {{ $student->last_name }}</p>
                            <p class="text-sm text-gray-500">{{ $student->email }}</p>
                        </div>
                        <form action="{{ route('classes.remove-student', ['class' => $class->id, 'student' => $student->id]) }}" 
                              method="POST" 
                              class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="text-red-600 hover:text-red-900"
                                    onclick="return confirm('Are you sure you want to remove this student?')">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection 