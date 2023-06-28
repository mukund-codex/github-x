<x-app-layout>
    <x-slot name="header">
        {{ __('Users') }}
    </x-slot>

    @if (session('status') === 'user-updated')
    <x-slot name="notification">
        <x-notification-simple>
            Successfully updated!
            <x-slot name="description">User data has been changed</x-slot>
        </x-notification-simple>
    </x-slot>
    @endif

    @if (session('status') === 'user-deleted')
        <x-slot name="notification">
            <x-notification-simple>
                Successfully deleted!
                <x-slot name="description">User has been deleted</x-slot>
            </x-notification-simple>
        </x-slot>
    @endif

    @if (session('status') === 'user-created')
        <x-slot name="notification">
            <x-notification-simple>
                Successfully created!
                <x-slot name="description">User has been created</x-slot>
            </x-notification-simple>
        </x-slot>
    @endif

    <div class="py-4">
        <div class="px-4 sm:px-6 lg:px-8">
{{--            <div class="sm:flex sm:items-center">--}}
{{--                <div class="sm:flex-auto">--}}
{{--                    <h1 class="text-base font-semibold leading-6 text-gray-900">List</h1>--}}
{{--                    <p class="mt-2 text-sm text-gray-700">A list of all the users.</p>--}}
{{--                </div>--}}
{{--                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">--}}
{{--                    <button type="button"--}}
{{--                            class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">--}}
{{--                        Add user--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                        {{ __('First name') }}
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        {{ __('Last name') }}
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        {{ __('Email') }}
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        {{ __('Roles') }}
                                    </th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($users as $user)
                                    <tr class="even:bg-gray-50">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                            {{ $user->first_name }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            {{ $user->last_name }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            {{ $user->email }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            @forelse ($user->roles as $role)
                                                {{ $role->name }}
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @empty
                                                <i>no roles</i>
                                            @endforelse
                                        </td>
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            @can('update user')
                                                <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900 px-2">Edit<span
                                                        class="sr-only">, {{ $user->first_name }} {{ $user->last_name }}</span></a>
                                            @endcan
                                            @can('remove user')
                                                <a href="{{ route('admin.users.delete', $user) }}" class="text-red-600 hover:text-red-900 px-2">Delete<span
                                                        class="sr-only">, {{ $user->first_name }} {{ $user->last_name }}</span></a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-app-layout>
