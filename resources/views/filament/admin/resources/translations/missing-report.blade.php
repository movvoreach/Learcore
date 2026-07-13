<div class="space-y-3">
    @if($missing->isEmpty())
        <p class="text-sm text-gray-600 dark:text-gray-300">No missing translations detected.</p>
    @else
        <div class="max-h-96 overflow-y-auto rounded-lg border border-gray-200 dark:border-gray-700">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-700 dark:bg-gray-800 dark:text-gray-200">
                    <tr>
                        <th class="px-3 py-2">Language</th>
                        <th class="px-3 py-2">Locale</th>
                        <th class="px-3 py-2">Group</th>
                        <th class="px-3 py-2">Key</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach($missing as $row)
                        <tr>
                            <td class="px-3 py-2">{{ $row['language'] }}</td>
                            <td class="px-3 py-2">{{ $row['locale'] }}</td>
                            <td class="px-3 py-2">{{ $row['group'] }}</td>
                            <td class="px-3 py-2">{{ $row['key'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
