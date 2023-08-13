<x-layout>
    @foreach($group->people as $person)
        <div>{{ $person }}</div>
    @endforeach
</x-layout>
