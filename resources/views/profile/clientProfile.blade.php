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

                            {{-- description3 --}}
                            <textarea type="text" name="description" id="" class="focus:ring-0" placeholder="description"></textarea>

                            {{-- status --}}
                            <select name="status_id" class="focus:ring-0">
                                <option value="" selected>Urgent</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>

                            {{-- category --}}
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

                    <div
                        class="px-6 pb-6 text-gray-900 dark:text-gray-100 flex flex-wrap justify-center gap-x-5 gap-y-8">
                        @foreach ($clientPosts as $clientPost)
                            <article>
                                <form action="/post/update/{{ $clientPost->id }}" method="POST"3
                                    class="w-[360px] p-3 bg-slate-200 rounded-2xl edit" id="">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-5 flex items-center justify-between">
                                        <textarea id="title" readonly name="title"
                                            class="w-[250px] p-0 bg-slate-200 border-none focus:ring-0 text-[22px] underline">{{ $clientPost->title }}</textarea>
                                        <span
                                            class="h-fit pt-0.5 pb-[5px] px-3 bg-gray-400 rounded-2xl text-white font-semibold">{{ $clientPost->status->name }}</span>
                                    </div>

                                    <textarea id="description" readonly name="description"
                                        class="w-full h-fit py-0 px-[10px] bg-slate-200 border-none focus:ring-0 text-[18px]">{{ $clientPost->description }}</textarea>
                                    <div class="mt-3 h-[300px]">
                                        <img class="w-full h-full rounded-[20px]"
                                            src="{{ asset('storage/' . $clientPost->image) }}" alt="">
                                    </div>

                                    <section class="mt-5 flex justify-center gap-5">
                                        {{-- Edit --}}
                                        <button id="" type="button"
                                            class="editBtn px-4 py-2 font-medium text-white bg-green-600 rounded-md hover:bg-green-500 focus:outline-none focus:shadow-outline-red active:bg-green-600 transition duration-150 ease-in-out ">
                                            Edit
                                        </button>

                                        {{-- Delete --}}
                                        <form action="/post/destroy/{{ $clientPost->id }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                class="px-4 py-2 font-medium text-white bg-red-600 rounded-md hover:bg-red-500 focus:outline-none focus:shadow-outline-red active:bg-red-600 transition duration-150 ease-in-out">
                                                DELETE
                                            </button>
                                        </form>
                                    </section>
                                </form>
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
                                    <h1 class="h-[67px] overflow-scroll text-[22px] underline">{{ $clientPost->title }}</h1>
                                    <span
                                        class="h-fit pt-0.5 pb-1 px-3 bg-gray-400 rounded-2xl text-black font-semibold">{{ $clientPost->status->name }}</span>
                                </div>
                                <p class="h-[60px] overflow-scroll text-[18px]">{{ $clientPost->description }}</p>
                                <div class="mt-3 h-[300px]"><img class="w-full h-full rounded-[20px]"
                                        src="{{ asset('storage/' . $clientPost->image) }}" alt=""></div>
                            </article>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script>
        let posts = document.querySelectorAll('.edit');

        posts.forEach(f => {
            let title = f.querySelector('#title')
            let description = f.querySelector('#description')
            let editBtn = f.querySelector('.editBtn')

            title.readOnly = true
            description.readOnly = true
            title.classList.add('resize-none')
            description.classList.add('resize-none')

            editBtn.addEventListener('click', (event) => {
                event.preventDefault();

                if (editBtn.textContent == 'Edit') {
                    editBtn.textContent = 'Save'
                    editBtn.type = 'submit'
                    title.readOnly = false
                    description.readOnly = false
                    title.classList.remove('resize-none')
                    description.classList.remove('resize-none')
                } else {
                    editBtn.textContent = 'Edit'
                    editBtn.type = 'button';
                    title.readOnly = true
                    description.readOnly = true
                    title.classList.add('resize-none')
                    description.classList.add('resize-none')
                }
            });
        });
    </script>
</x-app-layout>
