<x-layout>
    <main class="pt-24">
        <div class="max-w-4xl mx-auto px-8">
            <h1 class="text-center text-6xl font-extrabold">
                Discover <span class="text-red-500">amazing</span> people in the Laravel community
            </h1>
            <div class="mt-24 divide-y">
                @foreach($groups as $group)
                    <a class="p-8 flex items-center hover:bg-gray-50" href="{{ route('group', $group) }}">
                        <div>
                            <div class="flex items-center gap-3">
                                <h3 class="-mt-1 text-3xl font-bold">{{ $group->name }}</h3>
                                <div class="w-1.5 h-1.5 bg-gray-300 rounded-full"></div>
                                <div>9 peeps</div>
                            </div>
                            <p class="mt-2">Members of the official Laravel team</p>
                        </div>
                        <div class="ml-auto flex-shrink-0 isolate flex -space-x-2 overflow-hidden">
                            <img class="relative z-30 inline-block h-10 w-10 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                            <img class="relative z-20 inline-block h-10 w-10 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                            <img class="relative z-10 inline-block h-10 w-10 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.25&w=256&h=256&q=80" alt="">
                            <img class="relative z-0 inline-block h-10 w-10 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>                              
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </main>
</x-layout>
