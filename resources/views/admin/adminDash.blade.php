<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 text-center dark:text-gray-200 leading-tight">
            Management usres
        </h2>
    </x-slot>

    {{-- Todo: separe client / tech --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 border border-black text-sm text-gray-700 uppercase tracking-wider">
                                    Name
                                </th>
                                <th class="px-6 py-3 border border-black text-sm text-gray-700 uppercase tracking-wider">
                                    Address
                                </th>
                                <th
                                    class="px-6 py-3 border border-black text-sm text-gray-700 uppercase tracking-wider">
                                    Role
                                </th>
                                <th
                                    class="px-6 py-3 border border-black text-sm text-gray-700 uppercase tracking-wider">
                                    delete
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="px-6 py-4 border-b border-l border-black">
                                        <div class="flex items-center">
                                            <div class="w-[50px] h-[50px]">
                                                <img class="w-full h-full border border-black rounded-full"
                                                    src={{ asset('storage/' . $user->profil) }} alt="broken">
                                            </div>
                                            <div class="w-full ml-4">
                                                <div class="font-medium text-gray-900 flex justify-between">
                                                    {{ $user->name }}
                                                    <span class="px-2 bg-gray-300 rounded-full">{{ $user->posts->count() }}</span>
                                                </div>
                                                <div class="text-gray-500">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 border-b border-black">
                                        <div class="ml-8 text-gray-900">{{ $user->address }}</div>
                                    </td>

                                    <td class="px-6 py-4 border-b border-black">
                                        <span
                                            class="ml-8 px-2 inline-flex leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $user->category?->name ?? 'Client' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-gray-500 border-b border-r border-black">
                                        <form action="/adminDash/destroy/{{ $user->id }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                class="ml-8 px-4 py-2 font-medium text-white bg-red-600 rounded-md hover:bg-red-500 focus:outline-none focus:shadow-outline-red active:bg-red-600 transition duration-150 ease-in-out">
                                                DELETE
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
