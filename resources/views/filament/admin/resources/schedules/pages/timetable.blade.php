<x-filament-panels::page>
    <style>
        .timetable-wrapper {
            overflow-x: auto;
            margin-top: 8px;
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 6px rgba(0,0,0,0.04);
        }
        .dark .timetable-wrapper {
            background: #1e293b;
            border-color: #334155;
        }
        .timetable-grid {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            text-align: left;
            min-width: 800px;
        }
        .timetable-grid th, .timetable-grid td {
            border-bottom: 1px solid #e2e8f0;
            padding: 16px 12px;
            vertical-align: top;
        }
        .dark .timetable-grid th, .dark .timetable-grid td {
            border-bottom-color: #334155;
        }
        .timetable-grid th {
            font-weight: 600;
            color: #1e293b;
            background-color: #f8fafc;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }
        .dark .timetable-grid th {
            color: #e2e8f0;
            background-color: #0f172a;
        }
        .timetable-time {
            font-weight: 600;
            color: #475569;
            white-space: nowrap;
            width: 120px;
        }
        .dark .timetable-time {
            color: #94a3b8;
        }
        .timetable-cell {
            min-width: 150px;
        }
        .tt-subject {
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 4px;
        }
        .dark .tt-subject {
            color: #f8fafc;
        }
        .tt-room {
            color: #64748b;
            font-size: 12px;
        }
        .dark .tt-room {
            color: #94a3b8;
        }
        .tt-teacher {
            color: #3b82f6;
            font-size: 12px;
            margin-top: 4px;
        }
        .dark .tt-teacher {
            color: #60a5fa;
        }

        /* Filter Styles */
        .tt-filters {
            display: flex;
            gap: 16px;
            margin-bottom: 20px;
            align-items: center;
            flex-wrap: wrap;
        }
        .tt-select {
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            font-size: 14px;
            color: #334155;
            background: #fff;
            min-width: 200px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        .dark .tt-select {
            background: #1e293b;
            border-color: #475569;
            color: #e2e8f0;
        }
    </style>

    <div class="tt-filters">
        <select wire:model.live="teacher_id" class="tt-select">
            <option value="">ទាំងអស់ (All Teachers)</option>
            @foreach($teachers as $teacher)
                <option value="{{ $teacher->teacher_id }}">{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
            @endforeach
        </select>
        
        <!-- Add more filters like Academic Year here when ready -->
    </div>

    <div class="timetable-wrapper">
        <table class="timetable-grid">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                </tr>
            </thead>
            <tbody>
                @forelse($timeSlots as $timeKey => $slotData)
                    <tr>
                        <td class="timetable-time">
                            {{ \Carbon\Carbon::parse($slotData['start_time'])->format('g:i A') }} - 
                            {{ \Carbon\Carbon::parse($slotData['end_time'])->format('g:i A') }}
                        </td>
                        @foreach($days as $day)
                            <td class="timetable-cell">
                                @if(isset($slotData['days'][$day]))
                                    @foreach($slotData['days'][$day] as $schedule)
                                        <div style="margin-bottom: 12px; padding: 8px; background: rgba(59, 130, 246, 0.05); border-radius: 6px; border-left: 3px solid #3b82f6; position: relative;">
                                            <div class="tt-subject">
                                                {{ $schedule->classRoom->class_name ?? 'N/A' }}
                                            </div>
                                            <div class="tt-room">
                                                (Room {{ $schedule->classRoom->room_number ?? 'N/A' }})
                                            </div>
                                            <div class="tt-teacher">
                                                {{ $schedule->teacher->first_name ?? '' }} {{ $schedule->teacher->last_name ?? '' }}
                                            </div>
                                            
                                            <div style="position: absolute; top: 8px; right: 8px;">
                                                <a href="{{ \App\Filament\Admin\Resources\Schedules\ScheduleResource::getUrl('edit', ['record' => $schedule]) }}" style="color: #64748b; margin-right: 4px;" title="Edit">
                                                    ✏️
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #64748b;">
                            មិនមានទិន្នន័យកាលវិភាគទេ (No schedule data available)
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-filament-panels::page>
