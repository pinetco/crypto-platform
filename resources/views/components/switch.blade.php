<div
    x-data="{ value: @entangle($attributes->wire('model')) }"
    class="mt-2 flex items-center justify-start gap-x-2"
    x-id="['token-operator']"
>
    <!-- Label -->
    <label class="transition-colors font-semibold">{{ $off }}</label>

    <!-- Button -->
    <button
        x-ref="toggle"
        @click="value = value === 'or' ? 'and' : 'or'"
        type="button"
        role="switch"
        :aria-checked="value"
        :aria-labelledby="$id('token-operator')"
        :class="value === 'and' ? 'bg-black border-2 border-white' : 'bg-white border-2 border-black'"
        class="relative w-14 py-1 px-0 inline-flex rounded-full"
    >
        <span
            :class="value === 'and' ? 'bg-white translate-x-9' : 'bg-black translate-x-1'"
            class="w-3 h-3 rounded-full transition"
            aria-hidden="true"
        ></span>
    </button>

    <!-- Label -->
    <label class="transition-colors font-semibold">{{ $on }}</label>
</div>
