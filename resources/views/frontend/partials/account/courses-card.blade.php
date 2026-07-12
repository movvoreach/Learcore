<article class="learning-account-card">
    <h2>វគ្គសិក្សារបស់ខ្ញុំ</h2>
    @if($enrollments->isNotEmpty())
        <div class="table-responsive">
            <table class="table table-sm learning-account-table">
                <thead>
                    <tr>
                        <th>មុខវិជ្ជា</th>
                        <th>ឆ្នាំសិក្សា</th>
                        <th>ស្ថានភាព</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enrollments as $enrollment)
                        <tr>
                            <td>{{ $enrollment->course?->course_name ?? 'Untitled Course' }}</td>
                            <td>{{ $enrollment->academicYear?->year_name ?? '-' }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $enrollment->status ?? 'active' }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="learning-account-empty">
            <i class="fas fa-book-open"></i>
            <strong>មិនទាន់មានវគ្គសិក្សា</strong>
            <span>វគ្គសិក្សាដែលបានចុះឈ្មោះនឹងបង្ហាញនៅទីនេះ។</span>
        </div>
    @endif
</article>
