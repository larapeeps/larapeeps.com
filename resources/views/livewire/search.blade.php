<?php

use Livewire\Volt\Component;
use App\Models\Person;
use Illuminate\Support\Str;

new class extends Component {
    public $query = '';

    public function with()
    {
        return [
            'results' => $this->query 
                ? Person::where('name', 'like', '%' . $this->query . '%')->get()
                : collect([]),
        ];
    }
} ?>

<div
    x-data="{ open: false }"
    x-on:open-search.window="open = true; $nextTick(() => $refs.search.focus())"
    x-on:keydown.slash.window.prevent="open = true; $nextTick(() => $refs.search.focus())"
    x-on:keydown.escape.window.prevent="open = false"
>
    <template x-if="open">
        <div class="absolute top-4 bottom-0 inset-x-0 bg-white md:top-10">
            <div class="max-w-4xl mx-auto">
                <div class="relative py-4 px-6 md:px-12">
                    <button
                        class="absolute h-10 w-10 flex items-center justify-center md:h-12 md:w-12"
                        x-on:click="open = false"
                    >
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.0" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </button>
                    <input
                        type="search"
                        x-ref="search"
                        placeholder="Search"
                        wire:model.live="query"
                        class="w-full pl-12 bg-gray-950/5 border-none h-10 rounded-lg focus:ring-2 focus:ring-gray-300 md:h-12"
                    >
                </div>

                <x-peoplelist :people="$results" />
            </div>
        </div>
    </template>
</div>
