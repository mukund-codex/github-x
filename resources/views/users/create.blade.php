<x-app-layout>
    <x-slot name="header">
        {{ __('User') }}
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 text-gray-100">
                                {{ __('Create User') }}
                            </h2>
                        </header>

                        <form method="post" action="{{ route('admin.users.store') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('post')

                            <div>
                                <x-input-label for="first_name" :value="__('First Name')"/>
                                <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full"
                                              required autofocus autocomplete="first_name"/>
                                <x-input-error class="mt-2" :messages="$errors->get('first_name')"/>
                            </div>

                            <div>
                                <x-input-label for="last_name" :value="__('Last Name')"/>
                                <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full"
                                              required autocomplete="last_name"/>
                                <x-input-error class="mt-2" :messages="$errors->get('last_name')"/>
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Email')"/>
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                              required autocomplete="username"/>
                                <x-input-error class="mt-2" :messages="$errors->get('email')"/>
                            </div>

                            <div>
                                <x-input-label for="password" :value="__('Password')" />

                                <x-text-input id="password" class="block mt-1 w-full"
                                              type="password"
                                              name="password"
                                              required autocomplete="new-password" />

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                              type="password"
                                              name="password_confirmation" required autocomplete="new-password" />

                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            <div>
                                <fieldset>
                                    <legend class="text-base font-semibold leading-6 text-gray-900">Roles</legend>
                                    <div class="mt-4 divide-y divide-gray-200 border-b border-t border-gray-200">
                                        @foreach($roles as $i => $role)
                                            <div class="relative flex items-start py-2">
                                                <div class="min-w-0 flex-1 text-sm leading-6">
                                                    <label for="role-{{$i}}"
                                                           class="select-none font-medium text-gray-900">{{$role}}</label>
                                                </div>
                                                <div class="ml-3 flex h-6 items-center">
                                                    <input id="role-{{$i}}" name="role[]" type="checkbox" value="{{$role}}"
                                                           class="h-4 w-4 rounded border-gray-300 text-orange-600 focus:ring-orange-600">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('role.*')
                                    <x-input-error class="mt-2" :messages="$message"/>
                                    @enderror
                                </fieldset>
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                            </div>
                        </form>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
