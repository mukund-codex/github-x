<x-app-layout>
    <x-slot name="header">
        {{ __('Roles') }}
    </x-slot>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="mt-4 flow-root">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Role List</h1>
                    <p class="mt-2 text-sm text-gray-700">Roles and permissions are manageable by Permission Seeder. Below is read only table. Super Admin role by default bypass all permissions</p>
                </div>
            </div>
            <div class="-mx-4 py-6 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                        <tr class="divide-x divide-gray-200">
                            <th scope="col"
                                class="py-3.5 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-0">Name
                            </th>
                            <th scope="col"
                                class="py-3.5 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pr-0">Can
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach($roles as $role)
                            <tr class="divide-x divide-gray-200">
                                <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-0">{{Str::ucfirst($role->name)}}</td>
                                <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-0">
                                    @forelse($role->permissions as $permission)
                                        <span
                                            class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-500 ring-1 ring-inset ring-gray-600/20">
                                            {{ $permission->name }}
                                        </span>
                                    @empty
                                        <i>not specified</i>
                                    @endforelse
                                </td>
                            </tr>
                        @endforeach


                        <!-- More people... -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
