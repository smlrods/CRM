@extends('layouts.app');

@section('content')
    @parent
    <div class="sm:ml-64 mt-14 p-4">
        <div class="grid 2xl:grid-cols-4 lg:grid-cols-2 w-fit gap-5">
            <x-dashboard.charts.bar :data="$userChartData" :resourceName="'users'" />
            <x-dashboard.charts.bar :data="$clientChartData" :resourceName="'clients'" />
            <x-dashboard.charts.donut :data="$projectChartData" :resourceName="'projects'" />
            <x-dashboard.charts.donut :data="$taskChartData" :resourceName="'tasks'" />
        </div>
    </div>
@endsection
