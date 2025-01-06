@extends('layouts.admin-dashboard')


@section('content')
<div class="w-full">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
        <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-chalkboard text-indigo-500"></i>
                Edit Class: {{ $classe->name }}
            </h1>
            <p class="text-gray-600 mt-2">Update the class details below.</p>
        </div>
    </div>

    <!-- Edit Class Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form action="{{ route('classes.update', $classe->id) }}" method="POST">
            @csrf
            @method('PUT')
        
            <!-- Class Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700">Class Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $classe->name) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    required>
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        
            <!-- Assigned Teacher -->
            <div class="mb-6">
                <label for="teacher_id" class="block text-sm font-medium text-gray-700">Assigned Teacher</label>
                <select name="teacher_id" id="teacher_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Select Teacher</option>
                    @foreach ($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ $classe->teacher_id == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->first_name }} {{ $teacher->last_name }}
                        </option>
                    @endforeach
                </select>
                @error('teacher_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        
            <!-- Enrolled Students -->
            <div class="mb-6">
                <label for="students" class="block text-sm font-medium text-gray-700">Enrolled Students</label>
                <select name="students[]" id="students" multiple
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" {{ in_array($student->id, $classe->students->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $student->first_name }} {{ $student->last_name }}
                        </option>
                    @endforeach
                </select>
                @error('students')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        
            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('classes.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Cancel
                </a>
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Class
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
