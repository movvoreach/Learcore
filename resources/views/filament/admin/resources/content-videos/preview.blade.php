@php
    $openUrl = $embedUrl ?? $videoUrl ?? (filled($record->video_url) ? $record->video_url : null);
@endphp

<div class="cv-preview">
    <style>
        .cv-preview {
            color: #334155;
            font-family: "Battambang", "Noto Sans Khmer", ui-sans-serif, system-ui, sans-serif;
        }

        .cv-path {
            margin-bottom: 12px;
            color: #5866f5;
            font-size: 14px;
            font-weight: 700;
        }

        .cv-title {
            margin: 0 0 12px;
            color: #1f2937;
            font-size: 20px;
            font-weight: 700;
        }

        .cv-frame {
            overflow: hidden;
            border: 1px solid #d8dbe8;
            border-radius: 6px;
            background: #0f172a;
            aspect-ratio: 16 / 9;
        }

        .cv-frame iframe,
        .cv-frame video {
            display: block;
            width: 100%;
            height: 100%;
            border: 0;
        }

        .cv-empty {
            display: grid;
            min-height: 240px;
            place-items: center;
            color: #64748b;
            background: #f8fafc;
            text-align: center;
        }

        .cv-link {
            display: inline-flex;
            align-items: center;
            min-height: 38px;
            margin-top: 14px;
            border-radius: 4px;
            background: #5866f5;
            color: #fff;
            padding: 0 14px;
            text-decoration: none;
        }

        .cv-desc {
            margin-top: 14px;
            color: #475569;
            line-height: 1.7;
        }
    </style>

    <div class="cv-path">{{ $contentPath }}</div>
    <h3 class="cv-title">{{ $record->title ?: 'Video' }}</h3>

    <div class="cv-frame">
        @if($embedUrl)
            <iframe src="{{ $embedUrl }}" allowfullscreen></iframe>
        @elseif($videoUrl)
            <video src="{{ $videoUrl }}" controls></video>
        @else
            <div class="cv-empty">No video file or URL has been added yet.</div>
        @endif
    </div>

    @if($openUrl)
        <a class="cv-link" href="{{ $openUrl }}" target="_blank" rel="noopener">Open video</a>
    @endif

    @if($record->description)
        <div class="cv-desc">{{ $record->description }}</div>
    @endif
</div>
