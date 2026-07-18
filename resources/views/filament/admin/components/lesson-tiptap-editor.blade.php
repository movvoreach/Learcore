@php
    $fieldWrapperView = $getFieldWrapperView();
    $id = $getId();
    $statePath = $getStatePath();
    $isDisabled = $isDisabled();
@endphp

<x-dynamic-component :component="$fieldWrapperView" :field="$field">
    <div
        class="lc-tiptap"
        data-lms-tiptap
        data-upload-url="{{ route('admin.lesson-editor.upload') }}"
        data-csrf-token="{{ csrf_token() }}"
        data-disabled="{{ $isDisabled ? '1' : '0' }}"
        x-init="
            const init = () => window.initLearnCoreLessonEditor?.($el);
            init();
            setTimeout(init, 100);
            setTimeout(init, 500);
        "
    >
        <textarea id="{{ $id }}-state" class="lc-tiptap-state" {{ $applyStateBindingModifiers('wire:model') }}="{{ $statePath }}">{{ $getState() }}</textarea>

        <div class="lc-tiptap-toolbar" aria-label="Lesson editor toolbar">
            <button type="button" data-command="heading" data-level="1">H1</button>
            <button type="button" data-command="heading" data-level="2">H2</button>
            <button type="button" data-command="heading" data-level="3">H3</button>
            <button type="button" data-command="paragraph">P</button>
            <span></span>
            <button type="button" data-command="bold"><strong>B</strong></button>
            <button type="button" data-command="italic"><em>I</em></button>
            <button type="button" data-command="underline"><u>U</u></button>
            <button type="button" data-command="color">Color</button>
            <input type="color" data-color-picker value="#1f2937" aria-label="Text color">
            <button type="button" data-command="highlight">Highlight</button>
            <span></span>
            <button type="button" data-command="align" data-align="left">Left</button>
            <button type="button" data-command="align" data-align="center">Center</button>
            <button type="button" data-command="align" data-align="right">Right</button>
            <button type="button" data-command="bulletList">Bullets</button>
            <button type="button" data-command="orderedList">Numbers</button>
            <button type="button" data-command="blockquote">Quote</button>
            <button type="button" data-command="horizontalRule">HR</button>
            <button type="button" data-command="codeBlock">Code</button>
            <span></span>
            <button type="button" data-command="mediaSize" data-size="50%">50%</button>
            <button type="button" data-command="mediaSize" data-size="75%">75%</button>
            <button type="button" data-command="mediaSize" data-size="100%">100%</button>
            <label class="lc-tiptap-upload">
                Image
                <input type="file" data-upload="image" accept="image/jpeg,image/png,image/gif,image/webp">
            </label>
            <label class="lc-tiptap-upload">
                Video
                <input type="file" data-upload="video" accept="video/mp4,video/webm,video/quicktime">
            </label>
            <button type="button" data-command="youtube">YouTube</button>
            <button type="button" data-command="vimeo">Vimeo</button>
            <button type="button" data-command="deleteNode">Delete media</button>
        </div>

        <div class="lc-tiptap-editor" id="{{ $id }}-editor"></div>
        <p class="lc-tiptap-help">Images and videos are inserted at the current cursor position. Select media to resize or delete it.</p>
    </div>
</x-dynamic-component>
