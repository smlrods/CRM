@extends('layouts.app');

@section('content')
    @parent
    <x-table :columnHeaders="['title', 'description', 'due date', 'status', 'created at', 'project']" :$items :$resourceName>
        @foreach ($items as $item)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $item->title }}
                </td>
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $item->description}}
                </td>
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $item->due_date }}
                </td>
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $item->status }}
                </td>
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $item->created_at->diffForHumans() }}
                </td>
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <a href="/projects/{{ $item->project->id }}">
                        {{ $item->project->title }}
                    </a>
                </td>
                <td class="flex items-center px-6 py-4">
                    <a href="/{{ $resourceName }}/{{ $item->id }}"
                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
                    <a href="/{{ $resourceName }}/{{ $item->id }}/edit"
                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline ms-3">Edit</a>
                    <form class="inline mb-0" method="POST" action="/{{ $resourceName }}/{{ $item->id }}">
                        @csrf
                        @method('delete')
                        <button type="submit"
                            class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">Delete</button>
                    </form>
                </td>
                <tr />
        @endforeach
    </x-table>
@endsection
