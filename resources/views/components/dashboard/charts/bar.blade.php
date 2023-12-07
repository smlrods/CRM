<div class="max-w-md w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
  <div class="grid grid-cols-2 py-3">
    <dl>
      <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Total {{ $resourceName }}</dt>
      <dd class="leading-none text-xl font-bold text-blue-700 dark:text-blue-400">{{ end($data)['totalDay'] }}</dd>
    </dl>
    <dl>
      <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">New {{ $resourceName }}</dt>
      <dd class="leading-none text-xl font-bold text-green-500 dark:text-green-500">{{ collect($data)->pluck('totalNew')->sum() }}</dd>
    </dl>
  </div>

  <div id="bar-chart-{{ $resourceName }}"></div>

</div>

@push('scripts')
    <script>
        let data{{ ucfirst($resourceName) }} = @json($data);
    </script>
    @vite(['resources/js/dashboard/charts/bar_' . $resourceName . '.js'])
@endpush
