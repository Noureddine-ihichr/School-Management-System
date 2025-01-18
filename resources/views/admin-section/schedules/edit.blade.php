@extends('layouts.admin-dashboard')

@section('content')
<div class="w-full" 
     x-data="{ 
        slots: {{ Js::from($slotsByDay) }},
        addTimeSlot(day) {
            if (!this.slots[day]) {
                this.slots[day] = [];
            }
            this.slots[day].push({
                start_time: '08:00',
                end_time: '09:00',
                teacher_id: '',
                subject_id: '',
                room: ''
            });
        },
        removeTimeSlot(day, index) {
            this.slots[day].splice(index, 1);
        }
     }">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow-lg border border-gray-200 mb-6">
        <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-calendar-alt text-indigo-500"></i>
                Edit Schedule
            </h1>
            <p class="text-gray-600 mt-2">Modify the schedule for {{ $schedule->class->name }}.</p>
        </div>
    </div>

    <!-- Edit Schedule Form -->
    <div class="bg-white rounded-lg shadow-lg border border-gray-200">
        <form action="{{ route('schedules.update', $schedule->id) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <!-- Class Selection -->
            <div class="mb-6">
                <label for="class_id" class="block text-sm font-medium text-gray-700 mb-2">Class</label>
                <select name="class_id" id="class_id" required
                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ $schedule->class_id == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Weekly Schedule -->
            <div class="space-y-6">
                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">{{ $day }}</h3>
                            <button type="button" 
                                    @click.prevent="addTimeSlot('{{ $day }}')"
                                    class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition-colors duration-150">
                                <i class="fas fa-plus mr-2"></i>
                                Add Time Slot
                            </button>
                        </div>

                        <div x-show="!slots['{{ $day }}'] || slots['{{ $day }}'].length === 0" class="text-gray-500 text-center py-4">
                            No time slots added for {{ $day }}
                        </div>

                        <template x-for="(slot, index) in slots['{{ $day }}']" :key="index">
                            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                    <!-- Time Range -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Time</label>
                                        <div class="flex items-center gap-2">
                                            <select x-model="slot.start_time" 
                                                    :name="`schedule[{{ $day }}][${index}][start_time]`"
                                                    class="rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                                @foreach(range(8, 17) as $hour)
                                                    <option value="{{ sprintf('%02d:00', $hour) }}">{{ sprintf('%02d:00', $hour) }}</option>
                                                @endforeach
                                            </select>
                                            <span>to</span>
                                            <select x-model="slot.end_time" 
                                                    :name="`schedule[{{ $day }}][${index}][end_time]`"
                                                    class="rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                                @foreach(range(9, 18) as $hour)
                                                    <option value="{{ sprintf('%02d:00', $hour) }}">{{ sprintf('%02d:00', $hour) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Teacher Selection -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Teacher</label>
                                        <select x-model="slot.teacher_id" 
                                                :name="`schedule[{{ $day }}][${index}][teacher_id]`"
                                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Select Teacher</option>
                                            @foreach($teachers as $teacher)
                                                <option value="{{ $teacher->id }}">
                                                    {{ $teacher->first_name }} {{ $teacher->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Subject Selection -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                                        <select x-model="slot.subject_id" 
                                                :name="`schedule[{{ $day }}][${index}][subject_id]`"
                                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Select Subject</option>
                                            @foreach($subjects as $subject)
                                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Room Input -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Room</label>
                                        <div class="flex items-center gap-2">
                                            <input type="text" 
                                                   x-model="slot.room" 
                                                   :name="`schedule[{{ $day }}][${index}][room]`"
                                                   class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                            <button type="button" 
                                                    @click="removeTimeSlot('{{ $day }}', index)"
                                                    class="text-red-500 hover:text-red-700">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                @endforeach
            </div>

            <!-- Form Actions -->
            <div class="mt-6 flex items-center justify-end gap-4">
                <a href="{{ route('schedules.index') }}" 
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                    Update Schedule
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
