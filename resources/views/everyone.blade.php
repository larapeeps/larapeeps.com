<x-layout>
    <main class="pt-16 pb-12">
        <div class="text-center">
            <a class="inline-block mb-4 text-gray-400 hover:underline hover:text-gray-900" href="{{ url('/') }}">Back</a>
            <h1 class="text-6xl font-extrabold">Everyone</h1>
            <p class="mt-4 text-lg">In alphabetical order</p>
        </div>

        <div class="mt-20 max-w-4xl mx-auto px-8">
            <div class="divide-y">
                @foreach($people as $person)
                    <div class="p-8 flex items-center hover:bg-gray-50">
                        <img class="self-start relative inline-block h-16 w-16 rounded-full ring-2 ring-white" src="{{ $person->x_avatar_url }}" alt="{{ $person->name }}">
                        <div class="ml-8 pr-8">
                            <h3 class="text-xl leading-none font-bold">{{ $person->name }}</h3>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
</x-layout>
