<article class="learning-account-card">
    <h2>ព័ត៌មានផ្ទាល់ខ្លួន</h2>
    <div class="learning-account-list">
        <div>
            <strong>ឈ្មោះ</strong>
            <span>{{ $displayName }}</span>
        </div>
        <div>
            <strong>អ៊ីមែល</strong>
            <span>{{ $student?->email ?: $user->email }}</span>
        </div>
        <div>
            <strong>លេខសម្គាល់សិស្ស</strong>
            <span>{{ $student?->student_code ?: 'មិនទាន់មាន' }}</span>
        </div>
        <div>
            <strong>ដេប៉ាតឺម៉ង់</strong>
            <span>{{ $student?->department?->department_name ?: 'មិនទាន់កំណត់' }}</span>
        </div>
        <div>
            <strong>ឆ្នាំសិក្សា</strong>
            <span>{{ $student?->academicYear?->year_name ?: 'មិនទាន់កំណត់' }}</span>
        </div>
        <div>
            <strong>ស្ថានភាព</strong>
            <span>{{ $student?->status ?: 'Active' }}</span>
        </div>
    </div>
</article>
