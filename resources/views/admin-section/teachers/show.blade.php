@extends('layouts.admin-dashboard')

@section('content')
<div class="w-full">
    <!-- Header with back button -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Teacher Profile</h1>
            <a href="{{ route('teachers.index') }}" class="bg-white text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 border border-gray-300 transition duration-200 flex items-center gap-2">
                <i class="fas fa-arrow-left text-gray-500"></i>
                Back to List
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Profile Info -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 text-center">
                    <div class="relative inline-block">
                        @if($teacher->profile_picture)
                            <img class="h-32 w-32 rounded-full border-4 border-white shadow-lg object-cover mx-auto" 
                                src="{{ asset('storage/' . $teacher->profile_picture) }}" 
                                alt="{{ $teacher->first_name }}'s profile picture">
                        @else
                            <div class="h-32 w-32 rounded-full border-4 border-white shadow-lg bg-gray-100 flex items-center justify-center mx-auto">
                                <i class="fas fa-chalkboard-teacher text-4xl text-gray-400"></i>
                            </div>
                        @endif
                    </div>
                    <h2 class="mt-4 text-xl font-bold text-gray-900">{{ $teacher->first_name }} {{ $teacher->last_name }}</h2>
                    <p class="text-gray-500 text-sm">Teacher</p>
                    
                    <div class="mt-6">
                        <a href="{{ route('teachers.edit', $teacher->id) }}" 
                            class="inline-flex items-center justify-center w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Profile
                        </a>
                    </div>
                </div>

                <div class="border-t border-gray-200 px-6 py-4">
                    <div class="flex items-center py-2">
                        <div class="w-8 flex-shrink-0">
                            <i class="fas fa-envelope text-indigo-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="text-sm font-medium text-gray-900">{{ $teacher->user->email }}</p>
                        </div>
                    </div>
                    <div class="flex items-center py-2">
                        <div class="w-8 flex-shrink-0">
                            <i class="fas fa-phone text-indigo-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-500">Phone</p>
                            <p class="text-sm font-medium text-gray-900">{{ $teacher->phone_number ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-user mr-2 text-indigo-500"></i>
                        Personal Information
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-500">First Name</span>
                            <span class="mt-1 text-gray-900">{{ $teacher->first_name }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-500">Last Name</span>
                            <span class="mt-1 text-gray-900">{{ $teacher->last_name }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-500">Date of Birth</span>
                            <span class="mt-1 text-gray-900">
                                {{ $teacher->date_of_birth ? date('F j, Y', strtotime($teacher->date_of_birth)) : 'Not provided' }}
                            </span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-500">Subjects</span>
                            <span class="mt-1 text-gray-900">{{ $teacher->subjects->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subjects -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-book mr-2 text-indigo-500"></i>
                        Subjects
                    </h3>
                </div>
                <div class="p-6">
                    @if($teacher->subjects->count() > 0)
                        <div class="grid grid-cols-2 gap-4">
                            @foreach($teacher->subjects as $subject)
                                <div class="flex items-center space-x-2 bg-gray-50 p-3 rounded-lg">
                                    <i class="fas fa-book-open text-indigo-500"></i>
                                    <span class="text-gray-700">{{ $subject->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 italic">No subjects assigned</p>
                    @endif
                </div>
            </div>

            <!-- Classes -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-chalkboard mr-2 text-indigo-500"></i>
                        Classes
                    </h3>
                </div>
                <div class="p-6">
                    @if($teacher->classes->count() > 0)
                        <div class="grid grid-cols-2 gap-4">
                            @foreach($teacher->classes as $class)
                                <div class="flex items-center space-x-2 bg-gray-50 p-3 rounded-lg">
                                    <i class="fas fa-users text-indigo-500"></i>
                                    <span class="text-gray-700">{{ $class->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 italic">No classes assigned</p>
                    @endif
                </div>
            </div>

            <!-- Contact Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-address-card mr-2 text-indigo-500"></i>
                        Contact Information
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-500">Address</span>
                            <span class="mt-1 text-gray-900">{{ $teacher->address ?? 'Not provided' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            @if($teacher->extra_info)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-indigo-500"></i>
                        Additional Information
                    </h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-900 whitespace-pre-line">{{ $teacher->extra_info }}</p>
                </div>
            </div>
            @endif

            <!-- Teaching Schedule -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-calendar-alt mr-2 text-indigo-500"></i>
                        Teaching Schedule
                    </h3>
                </div>
                <div class="p-4 sm:p-6">
                    <!-- Mobile Schedule View -->
                    <div class="block lg:hidden">
                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                            <div class="mb-6 last:mb-0">
                                <h3 class="text-lg font-medium text-gray-900 bg-gray-50 p-3 rounded-lg mb-3">{{ $day }}</h3>
                                @if(isset($scheduleSlots[$day]) && count($scheduleSlots[$day]) > 0)
                                    <div class="space-y-3">
                                        @foreach($scheduleSlots[$day] as $slot)
                                            <div class="bg-white border border-gray-200 rounded-lg p-3">
                                                <div class="text-sm">
                                                    <div class="font-medium text-indigo-600 mb-1">
                                                        {{ substr($slot->start_time, 0, 5) }} - {{ substr($slot->end_time, 0, 5) }}
                                                    </div>
                                                    <div class="font-medium text-gray-900">{{ $slot->schedule->class->name }}</div>
                                                    <div class="text-gray-600">{{ $slot->subject->name }}</div>
                                                    <div class="text-gray-500 text-xs mt-1">Room: {{ $slot->room }}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500 text-center py-3 bg-gray-50 rounded-lg">No classes scheduled</p>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Desktop Schedule Table -->
                    <div class="hidden lg:block overflow-x-auto">
                        <div class="inline-block min-w-full align-middle">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3.5 px-4 text-left text-sm font-semibold text-gray-900 w-24">
                                            Day
                                        </th>
                                        @foreach($timeSlots as $time => $display)
                                            <th scope="col" class="px-4 py-3.5 text-center text-sm font-semibold text-gray-900">
                                                {{ $display }}
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                                        <tr>
                                            <td class="whitespace-nowrap py-4 px-4 text-sm font-medium text-gray-900 bg-gray-50">
                                                {{ $day }}
                                            </td>
                                            @php $skipCells = 0; @endphp
                                            @foreach($timeSlots as $time => $display)
                                                @if($skipCells > 0)
                                                    @php $skipCells--; @endphp
                                                    @continue
                                                @endif
                                                @php
                                                    $currentSlot = isset($scheduleSlots[$day]) ? 
                                                        $scheduleSlots[$day]->first(function($slot) use ($time) {
                                                            return substr($slot->start_time, 0, 5) === $time;
                                                        }) : null;
                                                    
                                                    if ($currentSlot) {
                                                        $startHour = intval(substr($currentSlot->start_time, 0, 2));
                                                        $endHour = intval(substr($currentSlot->end_time, 0, 2));
                                                        $colspan = $endHour - $startHour;
                                                        $skipCells = $colspan - 1;
                                                    }
                                                @endphp
                                                <td class="whitespace-nowrap p-3 text-sm {{ $currentSlot ? 'bg-indigo-50' : '' }}" 
                                                    @if($currentSlot && $colspan > 1) colspan="{{ $colspan }}" @endif>
                                                    @if($currentSlot)
                                                        <div class="flex flex-col items-center gap-1">
                                                            <div class="font-medium text-gray-900">{{ $currentSlot->schedule->class->name }}</div>
                                                            <div class="text-gray-600">{{ $currentSlot->subject->name }}</div>
                                                            <div class="text-gray-500 text-xs">Room: {{ $currentSlot->room }}</div>
                                                        </div>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection