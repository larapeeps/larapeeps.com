@props(['groups'])

<div class="mt-24 divide-y">
    @foreach($groups as $group)
    <a class="p-8 flex items-center hover:bg-gray-50" href="/groups/{{ $group->slug }}">
        <div>
            <div class="flex items-center gap-3">
                <h3 class="-mt-1 text-3xl font-bold">{{ $group->name }}</h3>
                <div class="w-1.5 h-1.5 bg-gray-300 rounded-full"></div>
                <div>{{ count($group->members) }} peeps</div>
            </div>
            <p class="mt-2">{{ $group->description }}</p>
        </div>

        <div class="ml-auto flex-shrink-0 isolate flex -space-x-2 overflow-hidden">
            @foreach ($group->people as $i => $person)
                @php $zIndex = ['z-30', 'z-20', 'z-10', 'z-0'][$i]; @endphp

                <img class="relative {{ $zIndex }} inline-block h-12 w-12 rounded-full ring-2 ring-white" src="{{ $person->x_avatar_url }}" alt="{{ $person->name }}">
            @endforeach
        </div>

        <div class="ml-4 flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
        </div>
    </a>
@endforeach
</div>
