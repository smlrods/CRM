@extends('layouts.app');

@section('content')
    @parent
    <x-table :columnHeaders="['name', 'email', 'email verified at', 'created at', 'updated at']" :$items :$resourceName>
        @foreach ($items as $item)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $item->name }}
                </td>
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $item->email }}
                </td>
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $item->email_verified_at }}
                </td>
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $item->created_at }}
                </td>
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $item->updated_at }}
                </td>
                <td class="flex items-center justify-center px-6 py-4">
                    <a href="users/{{ $item->id }}"
                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
                    @can('update', $item)
                        <a href="users/{{ $item->id }}/edit"
                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline ms-3">Edit</a>
                    @endcan
                    @can('delete', $item)
                        <form class="inline mb-0" method="POST" action="users/{{ $item->id }}">
                            @csrf
                            @method('delete')
                            <button type="submit"
                                class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">Delete</button>
                        </form>
                    @endcan
                </td>
                <tr />
        @endforeach
    </x-table>
@endsection
