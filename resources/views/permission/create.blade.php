<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permissions') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Breadcrumb -->
        <x-breadcrumb :contents="json_encode(['Permissions' => route('permissions.index'), 'Create' => '#'])" />

        <form method="post" action="{{ route('permissions.store') }}">
            @csrf
            <div class="px-5 py-3 mb-4 text-gray-700 border border-gray-200 rounded-lg bg-white shadow space-y-6">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Create Permission') }}
                    </h2>
                </header>


                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')"
                        required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <x-input-label class="pb-0" for="name" :value="__('Roles')" />
                <div class="overflow-y-auto max-h-64 columns-5 p-1">
                    @forelse ($roles as $key => $role)
                        @if ($role->name != \App\Models\User::SUPER_ADMIN)
                            <div class="flex items-center mb-4">
                                <x-checkbox-input 
                                    id="role_id-{{ $key }}" 
                                    name="role_id[]" 
                                    class="block w-full" 
                                    value="{{ $role->id }}"
                                />
                                <x-input-label class="ml-1" for="role_id-{{ $key }}" :value="$role->name" />
                            </div>
                        @endif
                    @endforelse
                </div>
                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>