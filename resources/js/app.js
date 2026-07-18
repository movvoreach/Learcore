import './bootstrap';

import { Editor, Node, mergeAttributes } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import Underline from '@tiptap/extension-underline';
import TextAlign from '@tiptap/extension-text-align';
import { TextStyle } from '@tiptap/extension-text-style';
import Color from '@tiptap/extension-color';
import Highlight from '@tiptap/extension-highlight';
import Image from '@tiptap/extension-image';
import Link from '@tiptap/extension-link';

const LmsImage = Image.extend({
    draggable: true,
    addAttributes() {
        return {
            ...this.parent?.(),
            width: {
                default: null,
                parseHTML: element => element.getAttribute('width') || element.style.width || null,
                renderHTML: attributes => attributes.width ? {
                    width: attributes.width,
                    style: `width:${attributes.width};height:${attributes.height || 'auto'};`,
                } : {},
            },
            height: {
                default: null,
                parseHTML: element => element.getAttribute('height') || null,
                renderHTML: attributes => attributes.height ? { height: attributes.height } : {},
            },
        };
    },
});

const LmsVideo = Node.create({
    name: 'lmsVideo',
    group: 'block',
    atom: true,
    draggable: true,

    addAttributes() {
        return {
            src: { default: null },
            provider: { default: 'uploaded' },
            width: { default: '100%' },
            height: { default: '420' },
        };
    },

    parseHTML() {
        return [
            { tag: 'iframe[data-lms-video]' },
            { tag: 'video[data-lms-video]' },
        ];
    },

    renderHTML({ HTMLAttributes }) {
        const attrs = {
            'data-lms-video': HTMLAttributes.provider,
            src: HTMLAttributes.src,
            width: HTMLAttributes.width || '100%',
            height: HTMLAttributes.height || '420',
        };

        if (HTMLAttributes.provider === 'uploaded') {
            return ['video', mergeAttributes(attrs, {
                controls: 'controls',
                style: `width:${attrs.width};max-width:100%;height:auto;border-radius:12px;`,
            })];
        }

        return ['iframe', mergeAttributes(attrs, {
            allowfullscreen: 'allowfullscreen',
            loading: 'lazy',
            style: `width:${attrs.width};max-width:100%;aspect-ratio:16/9;height:auto;border:0;border-radius:12px;`,
            allow: 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share',
        })];
    },
});

const youtubeEmbedUrl = url => {
    const match = String(url).match(/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&?/]+)/i);
    return match ? `https://www.youtube.com/embed/${match[1]}` : null;
};

const vimeoEmbedUrl = url => {
    const match = String(url).match(/vimeo\.com\/(?:video\/)?([0-9]+)/i);
    return match ? `https://player.vimeo.com/video/${match[1]}` : null;
};

window.initLearnCoreLessonEditor = function (root) {
    if (!root || root.dataset.ready === '1') {
        return;
    }

    root.dataset.ready = '1';

    const textarea = root.querySelector('.lc-tiptap-state');
    const editorElement = root.querySelector('.lc-tiptap-editor');
    const uploadUrl = root.dataset.uploadUrl;
    const csrfToken = root.dataset.csrfToken;
    const disabled = root.dataset.disabled === '1';

    const syncState = editor => {
        textarea.value = editor.getHTML();
        textarea.dispatchEvent(new Event('input', { bubbles: true }));
    };

    const editor = new Editor({
        element: editorElement,
        editable: !disabled,
        content: textarea.value || '<p></p>',
        extensions: [
            StarterKit.configure({
                heading: { levels: [1, 2, 3] },
            }),
            Underline,
            TextStyle,
            Color,
            Highlight.configure({ multicolor: true }),
            TextAlign.configure({ types: ['heading', 'paragraph'] }),
            Link.configure({ openOnClick: false }),
            LmsImage,
            LmsVideo,
        ],
        onUpdate: ({ editor }) => syncState(editor),
        editorProps: {
            attributes: {
                class: 'lc-tiptap-prose',
            },
        },
    });

    root.editor = editor;

    const run = (command, button) => {
        const chain = editor.chain().focus();

        if (command === 'heading') chain.toggleHeading({ level: Number(button.dataset.level) }).run();
        if (command === 'paragraph') chain.setParagraph().run();
        if (command === 'bold') chain.toggleBold().run();
        if (command === 'italic') chain.toggleItalic().run();
        if (command === 'underline') chain.toggleUnderline().run();
        if (command === 'highlight') chain.toggleHighlight({ color: '#fde68a' }).run();
        if (command === 'align') chain.setTextAlign(button.dataset.align).run();
        if (command === 'bulletList') chain.toggleBulletList().run();
        if (command === 'orderedList') chain.toggleOrderedList().run();
        if (command === 'blockquote') chain.toggleBlockquote().run();
        if (command === 'horizontalRule') chain.setHorizontalRule().run();
        if (command === 'codeBlock') chain.toggleCodeBlock().run();
        if (command === 'color') {
            const color = root.querySelector('[data-color-picker]')?.value || '#111827';
            chain.setColor(color).run();
        }
        if (command === 'mediaSize') {
            const size = button.dataset.size;
            if (editor.isActive('image')) {
                editor.chain().focus().updateAttributes('image', { width: size, height: null }).run();
            } else if (editor.isActive('lmsVideo')) {
                editor.chain().focus().updateAttributes('lmsVideo', { width: size }).run();
            }
        }
        if (command === 'youtube') {
            const url = window.prompt('YouTube URL');
            const embedUrl = youtubeEmbedUrl(url || '');
            if (embedUrl) editor.chain().focus().insertContent({ type: 'lmsVideo', attrs: { src: embedUrl, provider: 'youtube' } }).run();
        }
        if (command === 'vimeo') {
            const url = window.prompt('Vimeo URL');
            const embedUrl = vimeoEmbedUrl(url || '');
            if (embedUrl) editor.chain().focus().insertContent({ type: 'lmsVideo', attrs: { src: embedUrl, provider: 'vimeo' } }).run();
        }
        if (command === 'deleteNode') {
            editor.chain().focus().deleteSelection().run();
        }

        syncState(editor);
    };

    root.querySelectorAll('[data-command]').forEach(button => {
        button.addEventListener('click', () => run(button.dataset.command, button));
    });

    root.querySelectorAll('[data-upload]').forEach(input => {
        input.addEventListener('change', async () => {
            const file = input.files?.[0];
            if (!file) return;

            const type = input.dataset.upload;
            const formData = new FormData();
            formData.append('file', file);
            formData.append('type', type);

            input.disabled = true;

            try {
                const response = await fetch(uploadUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                if (!response.ok) throw new Error('Upload failed');

                const data = await response.json();

                if (type === 'image') {
                    editor.chain().focus().setImage({ src: data.url, width: '100%' }).run();
                } else {
                    editor.chain().focus().insertContent({ type: 'lmsVideo', attrs: { src: data.url, provider: 'uploaded' } }).run();
                }

                syncState(editor);
            } catch (error) {
                window.alert('Upload failed. Please try again.');
            } finally {
                input.value = '';
                input.disabled = false;
            }
        });
    });
};

const initLearnCoreLessonEditors = () => {
    document.querySelectorAll('[data-lms-tiptap]').forEach(window.initLearnCoreLessonEditor);
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLearnCoreLessonEditors);
} else {
    initLearnCoreLessonEditors();
}

window.addEventListener('load', initLearnCoreLessonEditors);
document.addEventListener('livewire:init', initLearnCoreLessonEditors);
document.addEventListener('livewire:navigated', initLearnCoreLessonEditors);

let tiptapObserverTimeout = null;

new MutationObserver(() => {
    window.clearTimeout(tiptapObserverTimeout);
    tiptapObserverTimeout = window.setTimeout(initLearnCoreLessonEditors, 50);
}).observe(document.documentElement, {
    childList: true,
    subtree: true,
});
