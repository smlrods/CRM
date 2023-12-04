@extends('layouts.app');

@section('content')
    @parent
    <x-content>
        <div class="container mx-auto px-6 py-8 shadow-md">
            <h2 class="text-4xl font-bold dark:text-white mb-2">
                {{ $task->title }}
            </h2>
            <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                <div class="flex flex-col pb-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Description</dt>
                    <dd class="text-lg font-semibold">
                        {!! nl2br(e($task->description)) !!}
                    </dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Due Date</dt>
                    <dd class="text-lg font-semibold">
                        {{ $task->due_date }}
                    </dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Status</dt>
                    <dd class="text-lg font-semibold">
                        {{ ucfirst($task->status) }}
                    </dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Created at</dt>
                    <dd class="text-lg font-semibold">
                        {{ ucfirst($task->created_at->diffForHumans() ) }}
                    </dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Project</dt>
                    <dd class="text-lg font-semibold">
                        <a href="/projects/{{ $task->project->id }}">
                            {{ $task->project->title }}
                        </a>
                    </dd>
                </div>
            </dl>
        </div>
    </x-content>
@endsection
