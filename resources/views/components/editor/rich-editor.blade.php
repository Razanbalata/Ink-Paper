@props([
    'name' => 'content',
    'value' => '',
])

<div x-data class="overflow-hidden rounded-xl border border-border bg-paper">
    {{-- Hidden input sent to Laravel --}}
    <input type="hidden" name="{{ $name }}" value="{{ $value }}" data-rich-editor-input>

    {{-- Toolbar --}}
    <div data-rich-editor-toolbar class="flex flex-wrap items-center gap-1 border-b border-border bg-paper p-2">
        {{-- Text formatting --}}
        <button type="button" data-command="bold" title="Bold" class="editor-button">
            <strong>B</strong>
        </button>

        <button type="button" data-command="italic" title="Italic" class="editor-button">
            <em>I</em>
        </button>

        <button type="button" data-command="strike" title="Strike" class="editor-button">
            <s>S</s>
        </button>

        <div class="mx-1 h-6 w-px bg-border"></div>

        {{-- Headings --}}
        <button type="button" data-command="h1" title="Heading 1" class="editor-button text-xs font-bold">
            H1
        </button>

        <button type="button" data-command="h2" title="Heading 2" class="editor-button text-xs font-bold">
            H2
        </button>

        <button type="button" data-command="h3" title="Heading 3" class="editor-button text-xs font-bold">
            H3
        </button>

        <div class="mx-1 h-6 w-px bg-border"></div>

        {{-- Lists --}}
        <button type="button" data-command="bulletList" title="Bullet List" class="editor-button">
            ••
        </button>

        <button type="button" data-command="orderedList" title="Ordered List" class="editor-button text-xs font-bold">
            1.
        </button>

        <div class="mx-1 h-6 w-px bg-border"></div>

        {{-- Blocks --}}
        <button type="button" data-command="blockquote" title="Blockquote" class="editor-button">
            "
        </button>

        <button type="button" data-command="code" title="Inline Code" class="editor-button text-xs font-mono">
            &lt;/&gt;
        </button>

        <button type="button" data-command="codeBlock" title="Code Block" class="editor-button text-xs font-mono">
            { }
        </button>

        <button type="button" data-command="horizontalRule" title="Horizontal Rule" class="editor-button">
            ―
        </button>

        <div class="mx-1 h-6 w-px bg-border"></div>

        {{-- Link --}}
        <button type="button" data-command="link" title="Add Link" class="editor-button text-xs font-semibold">
            Link
        </button>

        <div class="flex-1"></div>

        {{-- History --}}
        <button type="button" data-command="undo" title="Undo" class="editor-button">
            ↶
        </button>

        <button type="button" data-command="redo" title="Redo" class="editor-button">
            ↷
        </button>
    </div>

    {{-- Editor --}}
    <div data-rich-editor class="rich-editor min-h-[420px] bg-paper px-5 py-4 text-sm text-ink"></div>
</div>

@once
    @push('scripts')
        @vite('resources/js/rich-editor.js')
    @endpush
@endonce

@once
    @push('styles')
        <style>
            .editor-button {
                display: inline-flex;
                height: 32px;
                min-width: 32px;
                align-items: center;
                justify-content: center;
                border-radius: 8px;
                color: rgb(75 75 75);
                transition: all 150ms ease;
            }

            .editor-button:hover {
                background: rgb(245 245 245);
                color: rgb(20 20 20);
            }

            .editor-button.is-active {
                background: rgb(20 20 20);
                color: white;
            }

            .editor-button:disabled {
                cursor: not-allowed;
                opacity: 0.35;
            }

            .rich-editor {
                outline: none;
            }

            .rich-editor .tiptap {
                min-height: 380px;
                outline: none;
            }

            .rich-editor .tiptap p {
                margin-bottom: 1rem;
                line-height: 1.8;
            }

            .rich-editor .tiptap h1 {
                margin: 1.5rem 0 1rem;
                font-size: 2rem;
                font-weight: 700;
                line-height: 1.2;
            }

            .rich-editor .tiptap h2 {
                margin: 1.5rem 0 0.75rem;
                font-size: 1.5rem;
                font-weight: 700;
                line-height: 1.3;
            }

            .rich-editor .tiptap h3 {
                margin: 1.25rem 0 0.75rem;
                font-size: 1.25rem;
                font-weight: 700;
            }

            .rich-editor .tiptap ul {
                margin: 1rem 0;
                padding-left: 1.5rem;
                list-style: disc;
            }

            .rich-editor .tiptap ol {
                margin: 1rem 0;
                padding-left: 1.5rem;
                list-style: decimal;
            }

            .rich-editor .tiptap li {
                margin: 0.35rem 0;
            }

            .rich-editor .tiptap blockquote {
                margin: 1.25rem 0;
                padding-left: 1rem;
                border-left: 3px solid currentColor;
                font-style: italic;
                opacity: 0.8;
            }

            .rich-editor .tiptap code {
                border-radius: 4px;
                background: rgb(240 240 240);
                padding: 0.15rem 0.35rem;
                font-family: monospace;
                font-size: 0.9em;
            }

            .rich-editor .tiptap pre {
                margin: 1.25rem 0;
                overflow-x: auto;
                border-radius: 10px;
                background: rgb(30 30 30);
                padding: 1rem;
                color: white;
            }

            .rich-editor .tiptap pre code {
                background: transparent;
                padding: 0;
                color: inherit;
            }

            .rich-editor .tiptap hr {
                margin: 2rem 0;
                border: 0;
                border-top: 1px solid rgb(220 220 220);
            }

            .rich-editor .tiptap a {
                color: rgb(80 80 80);
                text-decoration: underline;
                text-underline-offset: 3px;
            }

            .rich-editor .tiptap p.is-editor-empty:first-child::before {
                color: rgb(150 150 150);
                content: attr(data-placeholder);
                float: left;
                height: 0;
                pointer-events: none;
            }
        </style>
    @endpush
@endonce
