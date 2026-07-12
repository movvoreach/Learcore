<article class="learning-account-card">
    <h2>ប្រតិទិន និងកាលវិភាគ</h2>
    @if($schedules->isNotEmpty())
        <div class="table-responsive">
            <table class="table table-hover learning-account-table">
                <thead>
                    <tr>
                        <th>ថ្ងៃ</th>
                        <th>ម៉ោង</th>
                        <th>ថ្នាក់</th>
                        <th>គ្រូបង្រៀន</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($schedules as $schedule)
                        <tr>
                            <td>{{ $schedule->day }}</td>
                            <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                            <td>{{ $schedule->classRoom?->class_name ?? '-' }}</td>
                            <td>{{ $schedule->teacher?->user?->name ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="learning-account-empty">
            <i class="fa fa-calendar"></i>
            <strong>មិនទាន់មានកាលវិភាគ</strong>
            <span>កាលវិភាគរៀន ឬសកម្មភាពថ្មីៗនឹងបង្ហាញនៅទីនេះ។</span>
        </div>
    @endif
</article>
