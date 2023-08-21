@props(['people'])

<div {{ $attributes }}>
    @foreach($people as $person)
        <div class="px-6 group">
            <div class="py-6 border-b group-last:border-b-0">
                <div class="flex items-end justify-between">
                    <div>
                        <p class="mb-1 text-sm text-gray-400">Founder & Creator</p>
                        <h3 class="text-xl leading-none font-bold md:text-2xl">{{ $person->name }}&nbsp;&nbsp;🇺🇸</h3>
                    </div>
                    <div class="flex-shrink-0 flex items-center">
                        <img class="w-8 h-8 md:w-12 md:h-12 rounded-full" src="{{ $person->x_avatar_url }}" alt="{{ $person->name }}">
                        {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.0" stroke="currentColor" class="ml-2 w-4 h-4 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg> --}}
                    </div>
                </div>
                <div class="mt-3 whitespace-nowrap overflow-x-scroll space-x-1">
                    <a href="https://x.com/{{ $person->x_handle }}" class="h-8 bg-gray-100 rounded-full inline-flex align-top items-center px-4">
                        <img class="mr-2 h-3" src="{{ asset('img/x_logo.svg') }}">
                        <span class="font-medium text-sm">{{ $person->x_handle }}</span>
                    </a>
                    @if($person->github_handle)
                    <a href="https://github.com/{{ $person->github_handle }}" class="h-8 bg-gray-100 rounded-full inline-flex  align-top items-center px-4">
                        <img class="mr-2 h-3" src="{{ asset('img/github_logo.svg') }}">
                        <span class="font-medium text-sm">{{ $person->github_handle }}</span>
                    </a>
                    @endif
                    @if($person->website_url)
                    <a href="{{ $person->website_url }}" class="h-8 bg-gray-100 rounded-full inline-flex  align-top items-center px-4">
                        <span class="font-medium text-sm">{{ $person->website_url }}</span>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
