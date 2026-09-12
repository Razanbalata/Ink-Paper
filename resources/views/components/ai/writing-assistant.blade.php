
<div
    x-data="{
        loading: false,
        action: null,

        result: '',
        titles: [],
        excerpt: '',

        suggestedTags: [],
        selectedTags: [],

        error: '',

        async improveWriting() {
            const contentField = document.querySelector('textarea[name=content]');

            if (!contentField || !contentField.value.trim()) {
                this.error = 'Write some content first.';
                this.result = '';
                return;
            }

            if (contentField.value.trim().length < 10) {
                this.error = 'Write at least 10 characters first.';
                this.result = '';
                return;
            }

            this.loading = true;
            this.action = 'improve';
            this.error = '';
            this.result = '';
            this.titles = [];
            this.excerpt = '';
            this.suggestedTags = [];

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
                            content: contentField.value,
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
            const contentField = document.querySelector('textarea[name=content]');

            if (!contentField || !contentField.value.trim()) {
                this.error = 'Write some content first.';
                this.titles = [];
                return;
            }

            if (contentField.value.trim().length < 10) {
                this.error = 'Write at least 10 characters first.';
                this.titles = [];
                return;
            }

            this.loading = true;
            this.action = 'title';
            this.error = '';
            this.titles = [];
            this.result = '';
            this.excerpt = '';
            this.suggestedTags = [];

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
                            content: contentField.value,
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
            const contentField = document.querySelector('textarea[name=content]');

            if (!contentField || !contentField.value.trim()) {
                this.error = 'Write some content first.';
                this.excerpt = '';
                return;
            }

            if (contentField.value.trim().length < 10) {
                this.error = 'Write at least 10 characters first.';
                this.excerpt = '';
                return;
            }

            this.loading = true;
            this.action = 'excerpt';
            this.error = '';
            this.excerpt = '';
            this.result = '';
            this.titles = [];
            this.suggestedTags = [];

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
                            content: contentField.value,
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
            const contentField = document.querySelector('textarea[name=content]');

            if (!contentField || !contentField.value.trim()) {
                this.error = 'Write some content first.';
                this.suggestedTags = [];
                return;
            }

            if (contentField.value.trim().length < 10) {
                this.error = 'Write at least 10 characters first.';
                this.suggestedTags = [];
                return;
            }

            this.loading = true;
            this.action = 'tags';
            this.error = '';
            this.suggestedTags = [];
            this.selectedTags = [];
            this.result = '';
            this.titles = [];
            this.excerpt = '';

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
                            content: contentField.value,
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

        async toggleTag(tag) {
            const index = this.selectedTags.findIndex(
                selected => selected.name === tag.name
            );

            if (index !== -1) {
                this.selectedTags.splice(index, 1);
                this.removeTagFromForm(tag);
                return;
            }

            this.selectedTags.push(tag);

            await this.addTagToForm(tag);
        },

        async addTagToForm(tag) {
            const form = document.querySelector('form');

            if (!form) return;

            /*
             * Existing tag
             */
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
                        new Event('change', { bubbles: true })
                    );
                }

                return;
            }

            /*
             * New tag
             */
            try {
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

                if (!response.ok) {
                    throw new Error(
                        data.message || 'Failed to create tag.'
                    );
                }

                const createdTag = data.tag;

                /*
                 * Update the local AI suggestion.
                 *
                 * It is now a real database tag.
                 */
                tag.id = createdTag.id;
                tag.exists = true;

                const tagsContainer = document.querySelector(
                    '#post-tags-container'
                );

                if (!tagsContainer) return;

               // Remove No tags available message.
                    
                const emptyMessage = document.querySelector(
                    '#no-tags-message'
                );

                if (emptyMessage) {
                    emptyMessage.remove();
                }

                /*
                 * Check whether the tag is already displayed.
                 */
                const existingCheckboxes = tagsContainer.querySelectorAll(
                    `input[name='tags[]']`
                );

                const alreadyExists = Array.from(existingCheckboxes).find(
                    input => input.value === String(createdTag.id)
                );

                if (alreadyExists) {
                    alreadyExists.checked = true;
                    return;
                }

                /*
                 * Create the label.
                 */
                const label = document.createElement('label');

                label.className =
                    'inline-flex cursor-pointer items-center gap-2 rounded-lg border border-primary bg-primary/5 px-3 py-1.5 text-xs font-medium text-primary transition';

                label.setAttribute(
                    'data-ai-tag',
                    createdTag.name
                );

                /*
                 * Create checkbox.
                 */
                const checkbox = document.createElement('input');

                checkbox.type = 'checkbox';
                checkbox.name = 'tags[]';
                checkbox.value = createdTag.id;
                checkbox.checked = true;

                checkbox.className =
                    'rounded border-border text-primary focus:ring-primary';

                /*
                 * Create tag text.
                 */
                const text = document.createElement('span');

                text.textContent = '#' + createdTag.name;

                /*
                 * Build label.
                 */
                label.appendChild(checkbox);
                label.appendChild(text);

                tagsContainer.appendChild(label);

            } catch (error) {
                console.error(error);

                const index = this.selectedTags.findIndex(
                    selected => selected.name === tag.name
                );

                if (index !== -1) {
                    this.selectedTags.splice(index, 1);
                }

                this.error = error.message;
            }
        },

        removeTagFromForm(tag) {
            const form = document.querySelector('form');

            if (!form) return;

            /*
             * If the tag has an ID, simply uncheck it.
             */
            if (tag.id) {
                const checkboxes = form.querySelectorAll(
                    `input[name='tags[]']`
                );

                const checkbox = Array.from(checkboxes).find(
                    input => input.value === String(tag.id)
                );

                if (checkbox) {
                    checkbox.checked = false;
                }

                return;
            }

            /*
             * Fallback for a tag that has not received an ID yet.
             */
            const labels = form.querySelectorAll(
                'label[data-ai-tag]'
            );

            const label = Array.from(labels).find(
                element => element.dataset.aiTag === tag.name
            );

            if (label) {
                label.remove();
            }
        },

        useTitle(title) {
            const titleField = document.querySelector(
                `input[name='title']`
            );

            if (!titleField || !title) return;

            titleField.value = title;

            titleField.dispatchEvent(
                new Event('input', {
                    bubbles: true
                })
            );

            this.titles = [];
        },

        useExcerpt() {
            const excerptField = document.querySelector(
                `textarea[name='excerpt']`
            );

            if (!excerptField || !this.excerpt) return;

            excerptField.value = this.excerpt;

            excerptField.dispatchEvent(
                new Event('input', {
                    bubbles: true
                })
            );

            this.excerpt = '';
        },

        useResult() {
            const contentField = document.querySelector(
                `textarea[name='content']`
            );

            if (!contentField || !this.result) return;

            contentField.value = this.result;

            contentField.dispatchEvent(
                new Event('input', {
                    bubbles: true
                })
            );

            this.result = '';
        }
    }"
    class="overflow-hidden rounded-2xl border border-border bg-white"
>
    {{-- Header --}}
    <div class="border-b border-border bg-paper px-5 py-4">
        <div class="flex flex-col gap-4">

            <div>
                <div class="flex items-center gap-2">
                    <span class="text-sm font-bold text-ink">
                        Ink AI
                    </span>

                    <span
                        class="rounded-full bg-primary/10 px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider text-primary"
                    >
                        Writing Aid
                    </span>
                </div>

                <p class="mt-1 text-xs text-muted">
                    Use AI to improve and shape your article.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">

                {{-- Improve Writing --}}
                <button
                    type="button"
                    @click="improveWriting()"
                    :disabled="loading"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-ink px-4 py-2.5 text-xs font-bold text-white transition hover:-translate-y-0.5 hover:shadow-md active:translate-y-0 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <template x-if="!(loading && action === 'improve')">
                        <span class="flex items-center gap-2">
                            <svg
                                class="h-3.5 w-3.5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 3l1.45 5.55L19 10l-5.55 1.45L12 17l-1.45-5.55L5 10l5.55-1.45L12 3Z"
                                />

                                <path
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    d="M19 16v5M16.5 18.5h5"
                                />
                            </svg>

                            Improve Writing
                        </span>
                    </template>

                    <template x-if="loading && action === 'improve'">
                        <span class="flex items-center gap-2">
                            <svg
                                class="h-3.5 w-3.5 animate-spin"
                                viewBox="0 0 24 24"
                                fill="none"
                            >
                                <circle
                                    class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="3"
                                />

                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                                />
                            </svg>

                            Improving...
                        </span>
                    </template>
                </button>

                {{-- Generate Title --}}
                <button
                    type="button"
                    @click="generateTitle()"
                    :disabled="loading"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-border bg-white px-4 py-2.5 text-xs font-bold text-ink transition hover:-translate-y-0.5 hover:bg-paper hover:shadow-sm active:translate-y-0 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <template x-if="!(loading && action === 'title')">
                        <span class="flex items-center gap-2">
                            <svg
                                class="h-3.5 w-3.5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M4 6h16M4 12h10M4 18h7"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                />
                            </svg>

                            Generate Title
                        </span>
                    </template>

                    <template x-if="loading && action === 'title'">
                        <span class="flex items-center gap-2">
                            <svg
                                class="h-3.5 w-3.5 animate-spin"
                                viewBox="0 0 24 24"
                                fill="none"
                            >
                                <circle
                                    class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="3"
                                />

                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                                />
                            </svg>

                            Generating...
                        </span>
                    </template>
                </button>

                {{-- Generate Excerpt --}}
                <button
                    type="button"
                    @click="generateExcerpt()"
                    :disabled="loading"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-border bg-white px-4 py-2.5 text-xs font-bold text-ink transition hover:-translate-y-0.5 hover:bg-paper hover:shadow-sm active:translate-y-0 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <template x-if="!(loading && action === 'excerpt')">
                        <span class="flex items-center gap-2">
                            <svg
                                class="h-3.5 w-3.5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M4 6h16M4 12h12M4 18h8"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                />
                            </svg>

                            Generate Excerpt
                        </span>
                    </template>

                    <template x-if="loading && action === 'excerpt'">
                        <span class="flex items-center gap-2">
                            <svg
                                class="h-3.5 w-3.5 animate-spin"
                                viewBox="0 0 24 24"
                                fill="none"
                            >
                                <circle
                                    class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="3"
                                />

                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                                />
                            </svg>

                            Generating...
                        </span>
                    </template>
                </button>

                {{-- Suggest Tags --}}
                <button
                    type="button"
                    @click="suggestTags()"
                    :disabled="loading"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-border bg-white px-4 py-2.5 text-xs font-bold text-ink transition hover:-translate-y-0.5 hover:bg-paper hover:shadow-sm active:translate-y-0 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <template x-if="!(loading && action === 'tags')">
                        <span class="flex items-center gap-2">
                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M7 7h10M7 12h6M7 17h10"
                                />
                            </svg>

                            Suggest Tags
                        </span>
                    </template>

                    <template x-if="loading && action === 'tags'">
                        <span class="flex items-center gap-2">
                            <svg
                                class="h-4 w-4 animate-spin"
                                viewBox="0 0 24 24"
                                fill="none"
                            >
                                <circle
                                    class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="9"
                                    stroke="currentColor"
                                    stroke-width="3"
                                />

                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M21 12a9 9 0 0 0-9-9v3a6 6 0 0 1 6 6h3z"
                                />
                            </svg>

                            Suggesting...
                        </span>
                    </template>
                </button>
            </div>
        </div>
    </div>

    {{-- Error --}}
    <div
        x-show="error"
        x-cloak
        class="mx-5 mt-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-xs font-medium text-rose-600"
        x-text="error"
    ></div>

    {{-- Suggested Tags --}}
    <div
        x-show="suggestedTags.length"
        x-cloak
        class="m-5 rounded-xl border border-border bg-paper p-4"
    >
        <div class="mb-3">
            <p class="text-xs font-bold uppercase tracking-wider text-ink">
                Suggested Tags
            </p>

            <p class="mt-0.5 text-[11px] text-muted">
                Click a tag to add it to your article.
            </p>
        </div>

        <div class="flex flex-wrap gap-2">
            <template
                x-for="tag in suggestedTags"
                :key="tag.name"
            >
                <button
                    type="button"
                    @click="toggleTag(tag)"
                    :class="selectedTags.some(selected => selected.name === tag.name)
                        ? 'border-primary bg-primary text-white'
                        : 'border-border bg-white text-ink hover:bg-paper'"
                    class="inline-flex items-center gap-1.5 rounded-lg border px-3 py-1.5 text-xs font-medium shadow-sm transition"
                >
                    <span x-text="'#' + tag.name"></span>

                    <span
                        x-show="tag.exists"
                        class="text-[9px] opacity-70"
                        x-text="'Existing'"
                    ></span>

                    <span
                        x-show="!tag.exists"
                        class="text-[9px] opacity-70"
                        x-text="'New'"
                    ></span>
                </button>
            </template>
        </div>
    </div>

    {{-- Excerpt Result --}}
    <div
        x-show="excerpt"
        x-cloak
        class="m-5 rounded-xl border border-border bg-paper"
    >
        <div
            class="flex items-center justify-between gap-3 border-b border-border px-4 py-3"
        >
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-ink">
                    Generated Excerpt
                </p>

                <p class="mt-0.5 text-[11px] text-muted">
                    Review the excerpt before applying it.
                </p>
            </div>

            <button
                type="button"
                @click="useExcerpt()"
                class="rounded-lg bg-primary px-3 py-1.5 text-xs font-bold text-white transition hover:opacity-90 active:scale-95"
            >
                Use Result
            </button>
        </div>

        <div
            class="px-4 py-4 text-sm leading-7 text-ink"
            x-text="excerpt"
        ></div>
    </div>

    {{-- Title Suggestions --}}
    <div
        x-show="titles.length"
        x-cloak
        class="m-5 overflow-hidden rounded-2xl border border-border bg-white"
    >
        <div class="border-b border-border bg-paper px-4 py-3">
            <p class="text-xs font-bold uppercase tracking-wider text-ink">
                Title Suggestions
            </p>

            <p class="mt-0.5 text-[11px] text-muted">
                Choose the one that fits your article best.
            </p>
        </div>

        <div class="space-y-2 p-4">
            <template
                x-for="(title, index) in titles"
                :key="index"
            >
                <button
                    type="button"
                    @click="useTitle(title)"
                    class="group flex w-full items-center justify-between gap-4 rounded-xl border border-border bg-white px-4 py-3 text-left transition hover:-translate-y-0.5 hover:border-primary hover:shadow-sm active:translate-y-0"
                >
                    <span
                        class="text-sm font-medium leading-6 text-ink"
                        x-text="title"
                    ></span>

                    <span
                        class="shrink-0 text-xs font-bold text-muted transition group-hover:text-primary"
                    >
                        Use
                    </span>
                </button>
            </template>
        </div>
    </div>

    {{-- Improved Result --}}
    <div
        x-show="result"
        x-cloak
        class="m-5 overflow-hidden rounded-2xl border border-border bg-white"
    >
        <div
            class="flex items-center justify-between gap-3 border-b border-border bg-paper px-4 py-3"
        >
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-ink">
                    Improved Version
                </p>

                <p class="mt-0.5 text-[11px] text-muted">
                    Review the result before applying it.
                </p>
            </div>

            <button
                type="button"
                @click="useResult()"
                class="rounded-lg bg-primary px-3 py-1.5 text-xs font-bold text-white transition hover:opacity-90 active:scale-95"
            >
                Use Result
            </button>
        </div>

        <div
            class="max-h-80 overflow-y-auto whitespace-pre-wrap px-4 py-4 text-sm leading-7 text-ink"
            x-text="result"
        ></div>
    </div>
</div>

