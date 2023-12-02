@extends('layouts.app');

@section('content')
    @parent
    <x-content>
        <div class="container mx-auto px-6 py-8 shadow-md">
            <h2 class="text-4xl font-bold dark:text-white mb-2">
                {{ $project->title }}
            </h2>
            <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                <div class="flex flex-col pb-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Description</dt>
                    <dd class="text-lg font-semibold">
                        {{ $project->description}}
                    </dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Deadline</dt>
                    <dd class="text-lg font-semibold">
                        {{ $project->deadline }}
                    </dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">User</dt>
                    <dd class="text-lg font-semibold">
                        <a href="/users/{{ $project->user->id }}">
                            {{ $project->user->name }}
                        </a>
                    </dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Client</dt>
                    <dd class="text-lg font-semibold">
                        <a href="/clients/{{ $project->client->id }}">
                            {{ $project->client->company }}
                        </a>
                    </dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Status</dt>
                    <dd class="text-lg font-semibold">
                        {{ ucfirst($project->status) }}
                    </dd>
                </div>
                @if (! $project->tasks->isEmpty())
                    <div class="flex flex-col py-3">
                        <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Tasks</dt>
                        <dd class="text-lg font-semibold">
                            <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                                @foreach ($project->tasks as $task)
                                    <li>
                                        <a href="/tasks/{{ $task->id }}">
                                            {{ $task->title }}
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
