<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit City') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-12">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block w-full sm:px-6 lg:px-8">
                    <div class="flex justify-start">
                        <a href="{{ route('cities.index') }}"
                            class="py-2 px-4 m-2 bg-green-500 hover:bg-green-600 text-gray-50 rounded-md">{{ __('Back')
                            }}</a>
                    </div>
                </div>
            </div>
            <div class="overflow-hidden sm:rounded-lg bg-gray-200 m-2 p-2">
                <div>
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Edit City') }}</h3>
                            </div>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <form action="{{ route('cities.update', $city->id) }}" enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="shadow sm:rounded-md sm:overflow-hidden">
                                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                        <div class="grid grid-cols-3 gap-6">
                                            <div class="col-span-3 sm:col-span-2">
                                                <label for="name"
                                                    class="block text-sm font-medium text-gray-700">
                                                    Name
                                                </label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <input type="text" name="name"
                                                        id="name"
                                                        value="{{ $city->name }}"
                                                        class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300"
                                                        placeholder="City Name">
                                                </div>
                                                @error('name')
                                                    <div class="text-red-500 text-xs">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div>
                                            <label for="state_id" class="block text-sm font-medium text-gray-700">
                                                State
                                            </label>
                                            <div class="mt-1 flex items-center">
                                                <select id="state_id" name="state_id" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300">
                                                    <option value="">Select a state</option>
                                                    @foreach ($states as $state)
                                                        <option
                                                            value="{{ $state->id }}"
                                                            @if ($state->id === $city->state_id)selected                                                      @endif
                                                        >
                                                            {{ $state->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('state_id')
                                                <div class="text-red-500 text-xs">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="px-4 py-3 bg-gray-50 sm:px-6">
                                        <button type="submit"
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <form
                            action="{{ route('cities.destroy', $city->id) }}"
                            method="POST"
                            x-data="{
                                submit() {
                                    window.confirm('Are you sure?')
                                    ? $el.submit()
                                    : false
                                }
                            }"
                            @submit.prevent="submit"
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
