<div
    x-data="{
        loading: false,
        result: '',
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
            this.error = '';
            this.result = '';

            try {
                const response = await fetch(
                    '{{ route('ai.writing.improve') }}',
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

                this.result = data.result;
            } catch (error) {
                console.error(error);
                this.error = error.message;
            } finally {
                this.loading = false;
            }
        },

        useResult() {
            const contentField = document.querySelector('textarea[name=content]');

            if (!contentField || !this.result) {
                return;
            }

            contentField.value = this.result;

            contentField.dispatchEvent(
                new Event('input', { bubbles: true })
            );

            this.result = '';
        }
    }"
    class="overflow-hidden rounded-2xl border border-border bg-white"
>
    {{-- Header --}}
    <div class="flex flex-col gap-4 border-b border-border bg-paper px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-center gap-3">
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-ink text-base text-white">
                ✦
            </div>

            <div>
                <div class="flex items-center gap-2">
                    <h3 class="text-sm font-bold text-ink">
                        Ink AI
                    </h3>

                    <span class="rounded-full border border-border bg-white px-2 py-0.5 text-[9px] font-bold uppercase tracking-widest text-muted">
                        Writing Aid
                    </span>
                </div>

                <p class="mt-0.5 text-xs text-muted">
                    Refine your writing while keeping your voice.
                </p>
            </div>
        </div>

        <button
            type="button"
            @click="improveWriting()"
            :disabled="loading"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-ink px-4 py-2.5 text-xs font-bold text-white transition hover:-translate-y-0.5 hover:shadow-md active:translate-y-0 disabled:cursor-not-allowed disabled:opacity-60"
        >
            {{-- Normal --}}
            <template x-if="!loading">
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

            {{-- Loading --}}
            <template x-if="loading">
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
    </div>

    {{-- Error --}}
    <div
        x-show="error"
        x-cloak
        class="mx-5 mt-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-xs font-medium text-rose-600"
        x-text="error"
    ></div>

    {{-- Result --}}
    <div
        x-show="result"
        x-cloak
        class="m-5 rounded-xl border border-border bg-paper"
    >
        <div class="flex items-center justify-between gap-3 border-b border-border px-4 py-3">
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