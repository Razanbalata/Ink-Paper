<div
    x-data="{
        loading: false,
        action: null,

        result: '',
        resultType: '',

        titles: [],
        excerpt: '',

        suggestedTags: [],
        selectedTags: [],

        suggestedCategory: null,

        improvedArticle: null,

        error: '',

        getContentValue() {
            const textarea = document.querySelector(
                `[data-rich-editor-input]`
            );
            const hiddenInput = document.querySelector(
                `input[name='content']`
            );

            return hiddenInput ? hiddenInput.value : textarea ? textarea.value : '';
        },

        normalizeContent(value) {
            return (value ?? '')
                .replace(/<[^>]*>/g, '')
                .replace(/&nbsp;/gi, ' ')
                .replace(/\u00A0/g, ' ')
                .trim();
        },

        setContentValue(value) {
            const textarea = document.querySelector(
                `textarea[name='content']`
            );
            const hiddenInput = document.querySelector(
                `input[name='content'][data-rich-editor-input]`
            );

            if (textarea) {
                textarea.value = value;
                textarea.dispatchEvent(
                    new Event('input', {
                        bubbles: true,
                    })
                );
            }

            if (hiddenInput) {
                hiddenInput.value = value;
                hiddenInput.dispatchEvent(
                    new Event('input', {
                        bubbles: true,
                    })
                );
            }
        },

        async improveWriting() {
            const content = this.getContentValue();
            const normalizedContent = this.normalizeContent(content);

            if (!normalizedContent) {
                this.error = 'Write some content first.';
                this.result = '';
                return;
            }

            if (normalizedContent.length < 10) {
                this.error = 'Write at least 10 characters first.';
                this.result = '';
                return;
            }

            this.loading = true;
            this.action = 'improve';
            this.error = '';
            this.result = '';
            this.resultType = 'improve';

            try {
                const response = await fetch(
                    '{{ route("ai.writing.improve") }}',
                    {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            content,
                        }),
                    }
                );

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(
                        data.message || 'Something went wrong.'
                    );
                }

                this.result = data.result || '';

            } catch (error) {
                console.error(error);
                this.error = error.message;
            } finally {
                this.loading = false;
                this.action = null;
            }
        },

        async expandContent() {
            const content = this.getContentValue();
            const normalizedContent = this.normalizeContent(content);

            if (!normalizedContent) {
                this.error = 'Write some content first.';
                this.result = '';
                return;
            }

            this.loading = true;
            this.action = 'expand';
            this.error = '';
            this.result = '';
            this.resultType = 'expand';

            try {
                const response = await fetch(
                    '{{ route("ai.writing.expand") }}',
                    {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            content,
                        }),
                    }
                );

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(
                        data.message || 'Something went wrong.'
                    );
                }

                this.result = data.result || '';

            } catch (error) {
                console.error(error);
                this.error = error.message;
            } finally {
                this.loading = false;
                this.action = null;
            }
        },

        async generateTitle() {
            const content = this.getContentValue();
            const normalizedContent = this.normalizeContent(content);

            if (!normalizedContent) {
                this.error = 'Write some content first.';
                this.titles = [];
                return;
            }

            if (normalizedContent.length < 10) {
                this.error = 'Write at least 10 characters first.';
                this.titles = [];
                return;
            }

            this.loading = true;
            this.action = 'title';
            this.error = '';
            this.titles = [];

            try {
                const response = await fetch(
                    '{{ route("ai.writing.title") }}',
                    {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            content,
                        }),
                    }
                );

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(
                        data.message || 'Something went wrong.'
                    );
                }

                this.titles = data.titles || [];

            } catch (error) {
                console.error(error);
                this.error = error.message;
            } finally {
                this.loading = false;
                this.action = null;
            }
        },

        async generateExcerpt() {
            const content = this.getContentValue();
            const normalizedContent = this.normalizeContent(content);

            if (!normalizedContent) {
                this.error = 'Write some content first.';
                this.excerpt = '';
                return;
            }

            if (normalizedContent.length < 10) {
                this.error = 'Write at least 10 characters first.';
                this.excerpt = '';
                return;
            }

            this.loading = true;
            this.action = 'excerpt';
            this.error = '';
            this.excerpt = '';

            try {
                const response = await fetch(
                    '{{ route("ai.writing.excerpt") }}',
                    {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            content,
                        }),
                    }
                );

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(
                        data.message || 'Something went wrong.'
                    );
                }

                this.excerpt = data.excerpt || '';

            } catch (error) {
                console.error(error);
                this.error = error.message;
            } finally {
                this.loading = false;
                this.action = null;
            }
        },

        async suggestTags() {
            const content = this.getContentValue();
            const normalizedContent = this.normalizeContent(content);

            if (!normalizedContent) {
                this.error = 'Write some content first.';
                this.suggestedTags = [];
                return;
            }

            if (normalizedContent.length < 10) {
                this.error = 'Write at least 10 characters first.';
                this.suggestedTags = [];
                return;
            }

            this.loading = true;
            this.action = 'tags';
            this.error = '';
            this.suggestedTags = [];

            try {
                const response = await fetch(
                    '{{ route("ai.writing.tags") }}',
                    {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            content,
                        }),
                    }
                );

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(
                        data.message || 'Something went wrong.'
                    );
                }

                this.suggestedTags = data.tags || [];

            } catch (error) {
                console.error(error);
                this.error = error.message;
            } finally {
                this.loading = false;
                this.action = null;
            }
        },

        async improveArticle() {
            const content = this.getContentValue();
            const normalizedContent = this.normalizeContent(content);

            if (!normalizedContent) {
                this.error = 'Write some content first.';
                this.improvedArticle = null;
                return;
            }

            if (normalizedContent.length < 10) {
                this.error = 'Write at least 10 characters first.';
                this.improvedArticle = null;
                return;
            }

            this.loading = true;
            this.action = 'article';
            this.error = '';

            this.result = '';
            this.resultType = '';

            this.titles = [];
            this.excerpt = '';
            this.suggestedTags = [];
            this.selectedTags = [];
            this.suggestedCategory = null;
            this.improvedArticle = null;

            try {
                const response = await fetch(
                    '{{ route("ai.writing.improve-article") }}',
                    {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            content,
                        }),
                    }
                );

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(
                        data.message || 'Something went wrong.'
                    );
                }

                this.improvedArticle = data.article || null;

                this.suggestedCategory =
                    this.improvedArticle?.category || null;

            } catch (error) {
                console.error(error);
                this.error = error.message;
            } finally {
                this.loading = false;
                this.action = null;
            }
        },

        useImprovedTitle() {
            if (!this.improvedArticle?.title) return;

            const titleField = document.querySelector(
                `input[name='title']`
            );

            if (!titleField) return;

            titleField.value = this.improvedArticle.title;

            titleField.dispatchEvent(
                new Event('input', {
                    bubbles: true
                })
            );
        },

        useImprovedExcerpt() {
            if (!this.improvedArticle?.excerpt) return;

            const excerptField = document.querySelector(
                `textarea[name='excerpt']`
            );

            if (!excerptField) return;

            excerptField.value = this.improvedArticle.excerpt;

            excerptField.dispatchEvent(
                new Event('input', {
                    bubbles: true
                })
            );
        },

        useImprovedContent() {
            if (!this.improvedArticle?.content) return;

            this.setContentValue(this.improvedArticle.content);
        },

        useCurrentResult() {
            if (!this.result) return;

            this.setContentValue(this.result);
        },

        useImprovedCategory() {
            if (!this.improvedArticle?.category?.id) return;

            const categoryField = document.querySelector(
                `select[name='category_id']`
            );

            if (!categoryField) return;

            categoryField.value = String(
                this.improvedArticle.category.id
            );

            categoryField.dispatchEvent(
                new Event('change', {
                    bubbles: true
                })
            );
        },

        async addTagToForm(tag) {
            if (!tag?.name) return;

            const form = document.querySelector(
                'form'
            );

            const container = document.getElementById(
                'post-tags-container'
            );

            if (!form || !container) return;

            let tagId = tag.id;

            if (tag.exists && tag.id) {
                const checkboxes = form.querySelectorAll(
                    `input[name='tags[]']`
                );

                const checkbox = Array.from(checkboxes).find(
                    input => input.value === String(tag.id)
                );

                if (checkbox) {
                    checkbox.checked = true;

                    checkbox.dispatchEvent(
                        new Event('change', {
                            bubbles: true
                        })
                    );

                    return;
                }
            }

            if (!tag.id) {
                const response = await fetch(
                    '{{ route("ai.writing.tags.add") }}',
                    {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            name: tag.name,
                        }),
                    }
                );

                const data = await response.json();

                if (!response.ok || !data.success) {
                    throw new Error(
                        data.message || 'Failed to create tag.'
                    );
                }

                tagId = data.tag.id;

                tag.id = data.tag.id;
                tag.exists = true;
            }

            const existingCheckboxes = form.querySelectorAll(
                `input[name='tags[]']`
            );

            const existingCheckbox = Array.from(
                existingCheckboxes
            ).find(
                input => input.value === String(tagId)
            );

            if (existingCheckbox) {
                existingCheckbox.checked = true;

                existingCheckbox.dispatchEvent(
                    new Event('change', {
                        bubbles: true
                    })
                );

                return;
            }

            const emptyMessage = document.getElementById(
                'no-tags-message'
            );

            if (emptyMessage) {
                emptyMessage.remove();
            }

            const label = document.createElement('label');

            label.className =
                'inline-flex cursor-pointer items-center gap-2 rounded-lg border border-primary bg-primary/10 px-3 py-1.5 text-xs font-medium text-primary transition';

            label.dataset.tagId = tagId;

            const checkbox = document.createElement('input');

            checkbox.type = 'checkbox';
            checkbox.name = 'tags[]';
            checkbox.value = tagId;
            checkbox.checked = true;

            checkbox.className =
                'rounded border-border text-primary focus:ring-primary';

            const span = document.createElement('span');

            span.textContent = '#' + tag.name;

            label.appendChild(checkbox);
            label.appendChild(span);

            container.appendChild(label);
        },

        toggleTag(tag) {
            if (!tag?.name) return;

            const index = this.selectedTags.findIndex(
                selected =>
                    selected.name.toLowerCase() ===
                    tag.name.toLowerCase()
            );

            if (index !== -1) {
                this.selectedTags.splice(index, 1);

                this.removeTagFromForm(tag);

                return;
            }

            this.selectedTags.push(tag);

            this.addTagToForm(tag);
        },

        removeTagFromForm(tag) {
            if (!tag?.id) return;

            const form = document.querySelector(
                'form'
            );

            if (!form) return;

            const checkboxes = form.querySelectorAll(
                `input[name='tags[]']`
            );

            const checkbox = Array.from(checkboxes).find(
                input => input.value === String(tag.id)
            );

            if (!checkbox) return;

            checkbox.checked = false;

            checkbox.dispatchEvent(
                new Event('change', {
                    bubbles: true
                })
            );
        },

        async applyAllImprovements() {
            if (!this.improvedArticle) return;

            this.useImprovedTitle();
            this.useImprovedExcerpt();
            this.useImprovedContent();
            this.useImprovedCategory();

            const tags = this.improvedArticle.tags || [];

            for (const tag of tags) {
                const alreadySelected = this.selectedTags.some(
                    selected =>
                        selected.name.toLowerCase() ===
                        tag.name.toLowerCase()
                );

                if (!alreadySelected) {
                    this.selectedTags.push(tag);

                    await this.addTagToForm(tag);
                }
            }
        }
    }"
    class="space-y-4"
>

    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <div class="flex items-center gap-2">

                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary/10 text-primary">
                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M12 3l1.9 5.1L19 10l-5.1 1.9L12 17l-1.9-5.1L5 10l5.1-1.9L12 3z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M19 16l.8 2.2L22 19l-2.2.8L19 22l-.8-2.2L16 19l2.2-.8L19 16z"
                        />
                    </svg>
                </div>

                <div>
                    <h3 class="text-sm font-bold text-ink">
                        Ink AI
                    </h3>

                    <p class="text-xs text-muted">
                        AI-powered writing assistance
                    </p>
                </div>

            </div>
        </div>

        {{-- Improve Article --}}
        <button
            type="button"
            @click="improveArticle()"
            :disabled="loading"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-primary px-4 py-2.5 text-xs font-bold text-white transition hover:-translate-y-0.5 hover:shadow-md active:translate-y-0 disabled:cursor-not-allowed disabled:opacity-60"
        >

            <template x-if="!(loading && action === 'article')">
                <span class="flex items-center gap-2">

                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M12 3l1.9 5.1L19 10l-5.1 1.9L12 17l-1.9-5.1L5 10l5.1-1.9L12 3z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M19 16l.8 2.2L22 19l-2.2.8L19 22l-.8-2.2L16 19l2.2-.8L19 16z"
                        />
                    </svg>

                    Improve Article

                </span>
            </template>

            <template x-if="loading && action === 'article'">
                <span class="flex items-center gap-2">

                    <svg
                        class="h-4 w-4 animate-spin"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        />

                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                        />
                    </svg>

                    Improving Article...

                </span>
            </template>

        </button>

    </div>

    {{-- AI Actions --}}
    <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-4">

        {{-- Improve Writing --}}
        <button
            type="button"
            @click="improveWriting()"
            :disabled="loading"
            class="rounded-xl border border-border bg-white px-3 py-2.5 text-xs font-semibold text-ink transition hover:border-primary hover:text-primary disabled:cursor-not-allowed disabled:opacity-60"
        >
            <span x-show="!(loading && action === 'improve')">
                Improve Writing
            </span>

            <span
                x-show="loading && action === 'improve'"
                x-cloak
            >
                Improving...
            </span>
        </button>

        {{-- Expand Content --}}
        <button
            type="button"
            @click="expandContent()"
            :disabled="loading"
            class="rounded-xl border border-border bg-white px-3 py-2.5 text-xs font-semibold text-ink transition hover:border-primary hover:text-primary disabled:cursor-not-allowed disabled:opacity-60"
        >
            <span x-show="!(loading && action === 'expand')">
                Expand Content
            </span>

            <span
                x-show="loading && action === 'expand'"
                x-cloak
            >
                Expanding...
            </span>
        </button>

        {{-- Generate Titles --}}
        <button
            type="button"
            @click="generateTitle()"
            :disabled="loading"
            class="rounded-xl border border-border bg-white px-3 py-2.5 text-xs font-semibold text-ink transition hover:border-primary hover:text-primary disabled:cursor-not-allowed disabled:opacity-60"
        >
            <span x-show="!(loading && action === 'title')">
                Generate Titles
            </span>

            <span
                x-show="loading && action === 'title'"
                x-cloak
            >
                Generating...
            </span>
        </button>

        {{-- Generate Excerpt --}}
        <button
            type="button"
            @click="generateExcerpt()"
            :disabled="loading"
            class="rounded-xl border border-border bg-white px-3 py-2.5 text-xs font-semibold text-ink transition hover:border-primary hover:text-primary disabled:cursor-not-allowed disabled:opacity-60"
        >
            <span x-show="!(loading && action === 'excerpt')">
                Generate Excerpt
            </span>

            <span
                x-show="loading && action === 'excerpt'"
                x-cloak
            >
                Generating...
            </span>
        </button>

    </div>

    {{-- Suggest Tags --}}
    <button
        type="button"
        @click="suggestTags()"
        :disabled="loading"
        class="w-full rounded-xl border border-border bg-white px-3 py-2.5 text-xs font-semibold text-ink transition hover:border-primary hover:text-primary disabled:cursor-not-allowed disabled:opacity-60"
    >
        <span x-show="!(loading && action === 'tags')">
            Suggest Tags
        </span>

        <span
            x-show="loading && action === 'tags'"
            x-cloak
        >
            Suggesting Tags...
        </span>
    </button>

    {{-- Error --}}
    <template x-if="error">
        <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-xs font-medium text-rose-600">
            <span x-text="error"></span>
        </div>
    </template>

    {{-- AI Result --}}
    <template x-if="result">
        <div class="rounded-2xl border border-border bg-white p-4 sm:p-5">

            <div class="mb-3 flex items-center justify-between">

                <span
                    class="text-xs font-bold uppercase tracking-wider text-ink"
                    x-text="
                        resultType === 'expand'
                            ? 'Expanded Content'
                            : 'Improved Writing'
                    "
                ></span>

                <span class="rounded-full bg-primary/10 px-2 py-1 text-[9px] font-bold uppercase tracking-wider text-primary">
                    AI
                </span>

            </div>

            <div
                class="whitespace-pre-line text-sm leading-7 text-ink"
                x-text="normalizeContent(result)"
            ></div>

            <div class="mt-4 flex justify-end border-t border-border pt-4">

                <button
                    type="button"
                    @click="useCurrentResult()"
                    class="inline-flex items-center gap-2 rounded-lg border border-border bg-white px-3 py-2 text-xs font-bold text-ink transition hover:border-primary hover:text-primary active:scale-95"
                >

                    <svg
                        class="h-3.5 w-3.5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>

                    Use Content

                </button>

            </div>

        </div>
    </template>

    {{-- Generated Titles --}}
    <template x-if="titles.length">
        <div class="rounded-2xl border border-border bg-white p-4 sm:p-5">

            <div class="mb-4 flex items-center justify-between">

                <span class="text-xs font-bold uppercase tracking-wider text-ink">
                    Suggested Titles
                </span>

                <span class="rounded-full bg-primary/10 px-2 py-1 text-[9px] font-bold uppercase tracking-wider text-primary">
                    AI
                </span>

            </div>

            <div class="space-y-2">

                <template x-for="title in titles" :key="title">

                    <button
                        type="button"
                        @click="
                            document.querySelector('input[name=title]').value = title;
                            document.querySelector('input[name=title]').dispatchEvent(
                                new Event('input', { bubbles: true })
                            );
                        "
                        class="block w-full rounded-xl border border-border bg-paper p-3 text-left text-sm font-medium text-ink transition hover:border-primary hover:bg-primary/5"
                        x-text="title"
                    ></button>

                </template>

            </div>

        </div>
    </template>

    {{-- Generated Excerpt --}}
    <template x-if="excerpt">
        <div class="rounded-2xl border border-border bg-white p-4 sm:p-5">

            <div class="mb-3 flex items-center justify-between">

                <span class="text-xs font-bold uppercase tracking-wider text-ink">
                    Suggested Excerpt
                </span>

                <span class="rounded-full bg-primary/10 px-2 py-1 text-[9px] font-bold uppercase tracking-wider text-primary">
                    AI
                </span>

            </div>

            <button
                type="button"
                @click="
                    document.querySelector('textarea[name=excerpt]').value = excerpt;
                    document.querySelector('textarea[name=excerpt]').dispatchEvent(
                        new Event('input', { bubbles: true })
                    );
                "
                class="w-full rounded-xl border border-border bg-paper p-3 text-left text-sm leading-6 text-ink transition hover:border-primary hover:bg-primary/5"
                x-text="excerpt"
            ></button>

        </div>
    </template>

    {{-- Suggested Tags --}}
    <template x-if="suggestedTags.length">
        <div class="rounded-2xl border border-border bg-white p-4 sm:p-5">

            <div class="mb-4 flex items-center justify-between">

                <span class="text-xs font-bold uppercase tracking-wider text-ink">
                    Suggested Tags
                </span>

                <span class="rounded-full bg-primary/10 px-2 py-1 text-[9px] font-bold uppercase tracking-wider text-primary">
                    AI
                </span>

            </div>

            <div class="flex flex-wrap gap-2">

                <template
                    x-for="tag in suggestedTags"
                    :key="tag.name"
                >

                    <button
                        type="button"
                        @click="toggleTag(tag)"
                        :class="
                            selectedTags.some(
                                selected =>
                                    selected.name.toLowerCase() ===
                                    tag.name.toLowerCase()
                            )
                                ? 'border-primary bg-primary text-white'
                                : 'border-border bg-white text-ink hover:bg-paper'
                        "
                        class="inline-flex items-center gap-2 rounded-lg border px-3 py-1.5 text-xs font-semibold transition"
                    >

                        <span x-text="'#' + tag.name"></span>

                        <span
                            x-show="tag.exists"
                            class="text-[9px] uppercase opacity-70"
                        >
                            Existing
                        </span>

                        <span
                            x-show="!tag.exists"
                            class="text-[9px] uppercase opacity-70"
                        >
                            New
                        </span>

                    </button>

                </template>

            </div>

        </div>
    </template>

    {{-- Improve Article Result --}}
    <template x-if="improvedArticle">

        <div class="overflow-hidden rounded-2xl border border-border bg-white">

            <div class="flex flex-col gap-3 border-b border-border p-4 sm:flex-row sm:items-center sm:justify-between sm:p-5">

                <div>

                    <div class="flex items-center gap-2">

                        <h3 class="text-sm font-bold text-ink">
                            Article Improvement
                        </h3>

                        <span class="rounded-full bg-primary/10 px-2 py-1 text-[9px] font-bold uppercase tracking-wider text-primary">
                            AI
                        </span>

                    </div>

                    <p class="mt-1 text-xs text-muted">
                        Review each suggestion before applying it to your article.
                    </p>

                </div>

                <button
                    type="button"
                    @click="applyAllImprovements()"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-primary px-4 py-2.5 text-xs font-bold text-white transition hover:-translate-y-0.5 hover:shadow-md active:translate-y-0"
                >

                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>

                    Apply All

                </button>

            </div>

            <div class="divide-y divide-border">

                {{-- Improved Title --}}
                <div class="p-4 sm:p-5">

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">

                        <div class="min-w-0">

                            <span class="text-xs font-bold uppercase tracking-wider text-ink">
                                Improved Title
                            </span>

                            <p
                                class="mt-2 text-sm font-semibold leading-6 text-ink"
                                x-text="improvedArticle?.title"
                            ></p>

                        </div>

                        <button
                            type="button"
                            @click="useImprovedTitle()"
                            class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg border border-border bg-white px-3 py-2 text-xs font-bold text-ink transition hover:border-primary hover:text-primary active:scale-95"
                        >
                            Use Title
                        </button>

                    </div>

                </div>

                {{-- Improved Excerpt --}}
                <div class="p-4 sm:p-5">

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">

                        <div class="min-w-0">

                            <span class="text-xs font-bold uppercase tracking-wider text-ink">
                                Improved Excerpt
                            </span>

                            <p
                                class="mt-2 text-sm leading-6 text-muted"
                                x-text="improvedArticle?.excerpt"
                            ></p>

                        </div>

                        <button
                            type="button"
                            @click="useImprovedExcerpt()"
                            class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg border border-border bg-white px-3 py-2 text-xs font-bold text-ink transition hover:border-primary hover:text-primary active:scale-95"
                        >
                            Use Excerpt
                        </button>

                    </div>

                </div>

                {{-- Suggested Category --}}
                <div class="p-4 sm:p-5">

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">

                        <div class="min-w-0">

                            <div class="flex items-center gap-2">

                                <span class="text-xs font-bold uppercase tracking-wider text-ink">
                                    Suggested Category
                                </span>

                                <span class="rounded-full bg-primary/10 px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider text-primary">
                                    AI
                                </span>

                            </div>

                            <template x-if="improvedArticle?.category">

                                <div class="mt-3">

                                    <span
                                        class="inline-flex items-center gap-2 rounded-lg border border-primary/20 bg-primary/5 px-3 py-1.5 text-xs font-semibold text-primary"
                                        x-text="improvedArticle.category.name"
                                    ></span>

                                </div>

                            </template>

                            <template x-if="!improvedArticle?.category">

                                <p class="mt-2 text-xs text-muted">
                                    No suitable category was found.
                                </p>

                            </template>

                        </div>

                        <template x-if="improvedArticle?.category">

                            <button
                                type="button"
                                @click="useImprovedCategory()"
                                class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg border border-border bg-white px-3 py-2 text-xs font-bold text-ink transition hover:border-primary hover:text-primary active:scale-95"
                            >

                                <svg
                                    class="h-3.5 w-3.5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 12h14m-7-7 7 7-7 7"
                                    />
                                </svg>

                                Use Category

                            </button>

                        </template>

                    </div>

                </div>

                {{-- Improved Content --}}
                <div class="p-4 sm:p-5">

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">

                        <div class="min-w-0 flex-1">

                            <span class="text-xs font-bold uppercase tracking-wider text-ink">
                                Improved Content
                            </span>

                            <div
                                class="mt-2 max-h-72 overflow-y-auto whitespace-pre-line rounded-xl bg-paper p-4 text-sm leading-7 text-ink"
                                x-text="improvedArticle?.content"
                            ></div>

                        </div>

                        <button
                            type="button"
                            @click="useImprovedContent()"
                            class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg border border-border bg-white px-3 py-2 text-xs font-bold text-ink transition hover:border-primary hover:text-primary active:scale-95"
                        >
                            Use Content
                        </button>

                    </div>

                </div>

                {{-- Improved Tags --}}
                <div class="p-4 sm:p-5">

                    <div class="flex flex-col gap-4">

                        <div>

                            <div class="flex items-center gap-2">

                                <span class="text-xs font-bold uppercase tracking-wider text-ink">
                                    Suggested Tags
                                </span>

                                <span class="rounded-full bg-primary/10 px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider text-primary">
                                    AI
                                </span>

                            </div>

                            <p class="mt-1 text-xs text-muted">
                                Click a tag to add or remove it from the article.
                            </p>

                        </div>

                        <div class="flex flex-wrap gap-2">

                            <template
                                x-for="tag in (improvedArticle?.tags || [])"
                                :key="tag.name"
                            >

                                <button
                                    type="button"
                                    @click="toggleTag(tag)"
                                    :class="
                                        selectedTags.some(
                                            selected =>
                                                selected.name.toLowerCase() ===
                                                tag.name.toLowerCase()
                                        )
                                            ? 'border-primary bg-primary text-white'
                                            : 'border-border bg-white text-ink hover:bg-paper'
                                    "
                                    class="inline-flex items-center gap-2 rounded-lg border px-3 py-1.5 text-xs font-semibold transition"
                                >

                                    <span x-text="'#' + tag.name"></span>

                                    <span
                                        x-show="tag.exists"
                                        class="text-[9px] uppercase opacity-70"
                                    >
                                        Existing
                                    </span>

                                    <span
                                        x-show="!tag.exists"
                                        class="text-[9px] uppercase opacity-70"
                                    >
                                        New
                                    </span>

                                </button>

                            </template>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </template>

</div>
