<div class="cd-preview">
    <style>
        .cd-preview {
            color: #334155;
            font-family: "Battambang", "Noto Sans Khmer", ui-sans-serif, system-ui, sans-serif;
        }

        .cd-path {
            margin-bottom: 12px;
            color: #5866f5;
            font-size: 14px;
            font-weight: 700;
        }

        .cd-title {
            margin: 0 0 12px;
            color: #1f2937;
            font-size: 20px;
            font-weight: 700;
        }

        .cd-frame {
            overflow: hidden;
            border: 1px solid #d8dbe8;
            border-radius: 6px;
            background: #f8fafc;
            min-height: 420px;
        }

        .cd-frame iframe {
            display: block;
            width: 100%;
            height: 640px;
            border: 0;
            background: #fff;
        }

        .cd-empty {
            display: grid;
            min-height: 360px;
            place-items: center;
            padding: 28px;
            color: #64748b;
            text-align: center;
        }

        .cd-empty strong {
            display: block;
            margin-bottom: 6px;
            color: #253052;
            font-size: 18px;
        }

        .cd-link {
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

        .cd-desc {
            margin-top: 14px;
            color: #475569;
            line-height: 1.7;
        }
    </style>

    <div class="cd-path">{{ $contentPath }}</div>
    <h3 class="cd-title">{{ $record->title ?: 'Document' }}</h3>

    <div class="cd-frame">
        @if($documentUrl && $canPreview)
            <iframe src="{{ $documentUrl }}"></iframe>
        @elseif($documentUrl)
            <div class="cd-empty">
                <div>
                    <strong>Preview not available for this file type.</strong>
                    Open the document to view it in a new tab.
                </div>
            </div>
        @else
            <div class="cd-empty">
                <div>
                    <strong>No document file has been added yet.</strong>
                    Upload a document before previewing.
                </div>
            </div>
        @endif
    </div>

    @if($documentUrl)
        <a class="cd-link" href="{{ $documentUrl }}" target="_blank" rel="noopener">Open document</a>
    @endif

    @if($record->description)
        <div class="cd-desc">{{ $record->description }}</div>
    @endif
</div>
