<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>

{{--    <div class="py-12 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">--}}
{{--        {{ __("You're logged in!") }}--}}
{{--    </div>--}}
    <div class="bg-white py-12 sm:py-12">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:mx-0">
                <h2 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Welcome!</h2>
                <p class="mt-6 text-lg leading-8 text-gray-600">This is your main dashboard view. Feel free to adjust it for your needs!</p>
            </div>
        </div>
    </div>

</x-app-layout>
