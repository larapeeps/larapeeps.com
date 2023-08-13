<x-layout>
    @foreach($groups as $group)
        <a href="{{ route('group', $group) }}">{{ $group->name }}</a>
    @endforeach
</x-layout>
