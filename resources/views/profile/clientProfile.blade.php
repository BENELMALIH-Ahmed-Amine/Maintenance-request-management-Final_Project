<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 text-center dark:text-gray-200 leading-tight">
            Page personnelle
        </h2>
    </x-slot>

    {{-- Todo: separe client / tech --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col gap-[50px]">
                <section class="p-6 text-gray-900 dark:text-gray-100 flex justify-center">
                    @role('Client')
                        <form action="/post/store" method="POST" enctype="multipart/form-data"
                            class="h-fit px-2.5 py-3 bg-gray-300 rounded-2xl flex flex-col gap-3">
                            @csrf

                            {{-- title --}}
                            <input type="text" name="title" id="" class="focus:ring-0 rounded-lg"
                                placeholder="Title">

                            {{-- image --}}
                            <input type="file" accept="image/*" name="image" id="" class="focus:ring-0">

                            {{-- dectiption --}}
                            <textarea type="text" name="dectiption" id="" class="focus:ring-0" placeholder="Dectiption"></textarea>

                            {{-- priority --}}
                            <input type="text" name="priority" id="" class="focus:ring-0"
                                placeholder="Priority">

                            {{-- category_id --}}
                            <select name="category_id" class="focus:ring-0">
                                <option value="" selected>Catégorie de votre problème</option>
                                @foreach ($categorys as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>

                            {{-- user_id --}}
                            <input name="user_id" id="" class="hidden" value="{{ Auth::user()->id }}">

                            <button type="submit"
                                class="mt-2 py-1 px-3 bg-white rounded-lg hover:bg-gray-100">Publier</button>
                        </form>
                    @endrole

                    <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-wrap justify-center gap-x-5 gap-y-8">
                        @foreach ($clientPosts as $clientPost)
                            <article class="w-[400px] p-3 bg-slate-200 rounded-2xl">
                                <div class="mb-5 flex items-center justify-between">
                                    <h1 class="text-[22px] underline">{{ $clientPost->title }}</h1>
                                    <span
                                        class="h-fit pt-0.5 pb-1 px-3 bg-gray-400 rounded-full text-white font-semibold">{{ $clientPost->priority }}</span>
                                </div>
                                <p class="text-[18px]">{{ $clientPost->dectiption }}</p>
                                <div class="mt-3 h-[300px]"><img class="w-full h-full rounded-[20px]"
                                        src="{{ asset('storage/' . $clientPost->image) }}" alt=""></div>

                            </article>
                            <article class="w-[400px] p-3 bg-slate-200 rounded-2xl">
                                <div class="mb-5 flex items-center justify-between">
                                    <h1 class="text-[22px] underline">{{ $clientPost->title }}</h1>
                                    <span
                                        class="h-fit pt-0.5 pb-1 px-3 bg-gray-400 rounded-full text-white font-semibold">{{ $clientPost->priority }}</span>
                                </div>
                                <p class="text-[18px]">{{ $clientPost->dectiption }}</p>
                                <div class="mt-3 h-[300px]"><img class="w-full h-full rounded-[20px]"
                                        src="{{ asset('storage/' . $clientPost->image) }}" alt=""></div>

                            </article>
                        @endforeach
                    </div>
                </section>

                <section class="p-6 bg-gray-700 dark:bg-gray-200 dark:text-gray-900 flex flex-wrap gap-10">
                    <h3 class="w-full bg-gray-300 text-[28px] text-center">Problèmes résolus</h3>
                    <div class="flex flex-wrap justify-center gap-x-5 gap-y-8 text-gray-100">
                        @foreach ($clientPosts as $clientPost)
                            <article class="w-[360px] p-3 bg-slate-600 rounded-2xl">
                                <div class="mb-5 flex items-center justify-between">
                                    <h1 class="text-[22px] underline">{{ $clientPost->title }}</h1>
                                    <span
                                        class="h-fit pt-0.5 pb-1 px-3 bg-gray-400 rounded-full text-black font-semibold">{{ $clientPost->priority }}</span>
                                </div>
                                <p class="text-[18px]">{{ $clientPost->dectiption }}</p>
                                <div class="mt-3 h-[300px]"><img class="w-full h-full rounded-[20px]"
                                        src="{{ asset('storage/' . $clientPost->image) }}" alt=""></div>

                            </article>
                            <article class="w-[360px] p-3 bg-slate-600 rounded-2xl">
                                <div class="mb-5 flex items-center justify-between">
                                    <h1 class="text-[22px] underline">{{ $clientPost->title }}</h1>
                                    <span
                                        class="h-fit pt-0.5 pb-1 px-3 bg-gray-400 rounded-full text-black font-semibold">{{ $clientPost->priority }}</span>
                                </div>
                                <p class="text-[18px]">{{ $clientPost->dectiption }}</p>
                                <div class="mt-3 h-[300px]"><img class="w-full h-full rounded-[20px]"
                                        src="{{ asset('storage/' . $clientPost->image) }}" alt=""></div>

                            </article>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
