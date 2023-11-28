@extends('layouts.app');

@section('content')
    @parent
    <x-content>
        <h2 class="text-4xl font-bold dark:text-white mb-5 ml-1">Create Client</h2>
        <form class="px-2" method="POST" action="/clients">
            @csrf
            <div class="mb-6">
                <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Company</label>
                <input type="text" id="company" name="company"
                    size="255"
                    class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500
                    @error('company')
                        border-red-500
                    @else
                        border-gray-300
                    @enderror"
                    placeholder="Gerlach Inc" value="{{ old('company') }}" required>
                @error('company')
                    <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="vat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">VAT</label>
                <input type="number" id="vat" name="vat" min="1000" max="99999"
                    class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500
                    @error('vat')
                        border-red-500
                    @else
                        border-gray-300
                    @enderror"
                    placeholder="00000" value="{{ old('vat') }}" required>
                @error('vat')
                    <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="grid md:grid-cols-2 md:gap-6 mb-6">
                <div class="mb-1 relative w-full group">
                    <label for="street_address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Street
                        Address</label>
                    <input type="text" id="street_address" name="street_address"
                        class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500
                    @error('street_address')
                        border-red-500
                    @else
                        border-gray-300
                    @enderror"
                        placeholder="33369 Angus Shores Suite 622" value="{{ old('street_address') }}" required>
                    @error('street_address')
                        <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="mb-1 relative w-full group">
                    <label for="city" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">City</label>
                    <input type="text" id="city" name="city"
                        class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500
                    @error('city')
                        border-red-500
                    @else
                        border-gray-300
                    @enderror"
                        placeholder="West Elbert" value="{{ old('city') }}" required>
                    @error('city')
                        <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="mb-1 relative w-full group">
                    <label for="state" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">State</label>
                    <input type="text" id="state" name="state"
                        class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500
                    @error('state')
                        border-red-500
                    @else
                        border-gray-300
                    @enderror"
                        placeholder="California" value="{{ old('state') }}" required>
                    @error('state')
                        <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="mb-1 relative w-full group">
                    <label for="zip_code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ZIP
                        code</label>
                    <input type="text" id="zip_code" name="zip_code" min="99999" max="999999999"
                        pattern="^\d{5}(-\d{4})?$"
                        class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500
                    @error('zip_code')
                        border-red-500
                    @else
                        border-gray-300
                    @enderror"
                        placeholder="12345 or 12345-6789" value="{{ old('zip_code') }}" required>
                    @error('zip_code')
                        <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </form>
    </x-content>
@endsection
