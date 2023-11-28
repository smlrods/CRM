@extends('layouts.app');

@section('content')
    @parent
    <x-content>
        <div class="container mx-auto px-6 py-8 shadow-md">
            <h2 class="text-4xl font-bold dark:text-white mb-2">
                {{ $client->company }}
            </h2>
            <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                <div class="flex flex-col pb-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">VAT</dt>
                    <dd class="text-lg font-semibold">
                        {{ $client->vat }}
                    </dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Address</dt>
                    <dd class="text-lg font-semibold">
                        {{ $client->toArray()['address'] }}
                    </dd>
                </div>
                @if (! $client->projects->isEmpty())
                    <div class="flex flex-col py-3">
                        <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Projects</dt>
                        <dd class="text-lg font-semibold">
                            <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                                @foreach ($client->projects as $project)
                                    <li>
                                        <a href="/projects/{{ $project->id }}">
                                            {{ $project->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </dd>
                    </div>
                @endif
            </dl>
        </div>
    </x-content>
@endsection
