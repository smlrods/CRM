@extends('layouts.app');

@section('content')
    @parent
    <x-table :columnHeaders="['company', 'vat', 'address']" :$items :$resourceName>
        @foreach ($items as $item)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $item->company }}
                </td>
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $item->vat }}
                </td>
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $item->address->street_address .
                        ', ' .
                        $item->address->city .
                        ', ' .
                        $item->address->state .
                        ' ' .
                        $item->address->zip_code }}
                </td>
                <td class="flex items-center px-6 py-4">
                    <a href="clients/{{ $item->id }}"
                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
                    <a href="clients/{{ $item->id }}/edit"
                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline ms-3">Edit</a>
                    <form class="inline mb-0" method="POST" action="clients/{{ $item->id }}">
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
