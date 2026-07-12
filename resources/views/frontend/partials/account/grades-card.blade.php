<article class="learning-account-card">
    <h2>ពិន្ទុចុងក្រោយ</h2>
    @if($grades->isNotEmpty())
        <div class="table-responsive">
            <table class="table table-hover learning-account-table">
                <thead>
                    <tr>
                        <th>ប្រភេទ</th>
                        <th>ពិន្ទុ</th>
                        <th>និទ្ទេស</th>
                        <th>ថ្ងៃដាក់ពិន្ទុ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grades as $grade)
                        @php
                            $gradeTitle = $grade->exam?->title
                                ?? $grade->quiz?->title
                                ?? $grade->assignment?->title
                                ?? 'Assessment';
                            $maxScore = (float) ($grade->max_score ?: 100);
                            $score = (float) $grade->score;
                        @endphp
                        <tr>
                            <td>{{ $gradeTitle }}</td>
                            <td>{{ number_format($score, 2) }} / {{ number_format($maxScore, 2) }}</td>
                            <td><span class="badge bg-primary">{{ $grade->grade ?: '-' }}</span></td>
                            <td>{{ $grade->graded_at?->format('Y-m-d') ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="learning-account-empty">
            <i class="fa fa-list-alt"></i>
            <strong>មិនទាន់មានពិន្ទុ</strong>
            <span>ពិន្ទុតេស្ត និងកិច្ចការនឹងបង្ហាញនៅទីនេះបន្ទាប់ពីបានវាយតម្លៃ។</span>
        </div>
    @endif
</article>
