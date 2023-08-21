@props(['groups'])

<div {{ $attributes }}>
    @foreach($groups as $group)
    <a class="block px-6 md:hover:bg-gray-50 group" href="{{ route('group', ['group' => $group]) }}">
        <div class="py-6 border-b group-last:border-b-0 md:py-10">
            <div class="flex items-center">
                <div>
                    <div class="md:flex md:items-center md:gap-3">
                        <p class="text-sm text-gray-400 md:text-base md:-mb-1 md:order-last">{{ count($group->members) }} peeps</p>
                        <h3 class="text-xl font-bold md:text-3xl">{{ $group->name }}</h3>
                    </div>
                    <p class="hidden mt-1 pr-8 md:block md:text-lg">{{ $group->description }}</p>
                </div>

                <div class="mb-1 mr-1 ml-auto flex-shrink-0 isolate flex -space-x-2.5 md:mr-4">
                    @foreach ($group->people as $i => $person)
                        @php $zIndex = ['z-50', 'z-40', 'z-30', 'z-20', 'z-10', 'z-0'][$i]; @endphp

                        <img @class([
                            'relative inline-block h-7 w-7 rounded-full ring-2 ring-white',
                            'md:w-10 md:h-10',
                            ['z-50', 'z-40', 'z-30', 'z-20', 'z-10', 'z-0'][$i]
                        ]) src="{{ $person->x_avatar_url }}" alt="{{ $person->name }}">
                    @endforeach
                </div>

                <div class="mb-2.5 flex-shrink-0 md:mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </div>
            </div>
            <p class="mt-1 pr-8 md:hidden">{{ $group->description }}</p>
        </div>
    </a>
@endforeach
</div>
