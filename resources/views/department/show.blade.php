<x-app>

    <x-slot:title>{{ $title }}</x-slot>

    <a class="btn btn-warning mb-3" href="{{ route('department.index') }}" role="button">
        Bak To departmen
    </a>

    <ul class="list-group">

        @foreach ($department->lecturers as $lecturer)
            <li class="list-group-item">{{ $lecturer->name }}</li>
        @endforeach

    </ul>

</x-app>
