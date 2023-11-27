@extends('layouts.app');

@section('content')
    @parent
    <x-content>
        <div class="container mx-auto px-6 py-8 shadow-md">
            <h2 class="text-4xl font-bold dark:text-white mb-2">
                {{ $user->name }}
            </h2>
            <div class="mb-2 flex">
                @foreach ($user->roles as $role)
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                        {{ \App\Enums\RolesEnum::from($role->name)->label() }}
                    </span>
                @endforeach
            </div>
            <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                <div class="flex flex-col pb-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Email address</dt>
                    <dd class="text-lg font-semibold">
                        {{ $user->email }}
                    </dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Email Verified At</dt>
                    <dd class="text-lg font-semibold">
                        {{ $user->email_verified_at }}
                    </dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Created At</dt>
                    <dd class="text-lg font-semibold">
                        {{ $user->created_at }}
                    </dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Updated At</dt>
                    <dd class="text-lg font-semibold">
                        {{ $user->updated_at }}
                    </dd>
                </div>
                @if (! $user->projects->isEmpty())
                    <div class="flex flex-col py-3">
                        <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Projects</dt>
                        <dd class="text-lg font-semibold">
                            <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                                @foreach ($user->projects as $project)
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
