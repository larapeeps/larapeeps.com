<x-layout>
    <main class="pt-16 pb-12">
        <div class="text-center">
            <a class="inline-block mb-4 text-gray-400 hover:underline hover:text-gray-900" href="{{ url('/') }}">Back</a>
            <h1 class="text-6xl font-extrabold">{{ $group->name }}</h1>
            <p class="mt-4 text-lg">{{ $group->description }}</p>
        </div>

        <div class="mt-20 max-w-4xl mx-auto px-8">
            <div class="divide-y">
                @foreach($group->people as $person)
                    <a class="p-8 flex items-center hover:bg-gray-50" href="https://x.com/{{ $person->x_handle }}">
                        <img class="relative inline-block h-16 w-16 rounded-full ring-2 ring-white" src="{{ $person->x_avatar_url }}" alt="{{ $person->name }}">
                        <div class="ml-6">
                            <h3 class="text-xl leading-none font-bold">{{ $person->name }}</h3>
                            <p class="mt-2">{{ Str::limit($person->bio, 80) }}</p>
                        </div>
                        <img class="ml-auto" src="{{ asset('img/x_logo.svg') }}" alt="X">
                        <svg class="ml-2 w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                @endforeach
            </div>
        </div>
    </main>
</x-layout>
