<x-admin-layout>
    <div class="mb-6">
        <h1 class="text-3xl font-semibold text-gray-800 dark:text-white">Crear Noticia</h1>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-6 border border-gray-200 dark:border-slate-700">
        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Título</label>
                    <input type="text" name="title" id="title" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-slate-600 rounded-md dark:bg-slate-900 dark:text-white" value="{{ old('title') }}" required>
                </div>

                <div class="col-span-2">
                    <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Slug</label>
                    <input type="text" name="slug" id="slug" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-slate-600 rounded-md dark:bg-slate-900 dark:text-white" value="{{ old('slug') }}" required>
                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Se generará automáticamente si se deja vacío (necesita JS o backend logic, por ahora requerido).</p>
                </div>

                <div class="col-span-2">
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Extracto</label>
                    <textarea name="excerpt" id="excerpt" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-slate-600 rounded-md dark:bg-slate-900 dark:text-white">{{ old('excerpt') }}</textarea>
                </div>

                <div class="col-span-2">
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Contenido</label>
                    <textarea name="content" id="editor">{{ old('content') }}</textarea>
                </div>

                <div class="col-span-2">
                    <label for="iframe_embed" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Código de Incrustación (Iframe/Embed)</label>
                    <textarea name="iframe_embed" id="iframe_embed" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-slate-600 rounded-md dark:bg-slate-900 dark:text-white" placeholder='<iframe src="..."></iframe>'>{{ old('iframe_embed') }}</textarea>
                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Pega aquí el código de incrustación (iframe) de YouTube, Scribd, Google Drive, etc.</p>
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Categoría</label>
                    <div class="flex gap-2">
                        <select name="category_id" id="category_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:text-white">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" onclick="document.getElementById('newCategoryModal').classList.remove('hidden')" class="mt-1 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            +
                        </button>
                    </div>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Estado</label>
                    <select name="status" id="status" class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:text-white">
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Borrador</option>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publicado</option>
                        <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>Programado</option>
                    </select>
                </div>

                <div>
                    <label for="published_at" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Fecha de Publicación</label>
                    <input type="datetime-local" name="published_at" id="published_at" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-slate-600 rounded-md dark:bg-slate-900 dark:text-white" value="{{ old('published_at') }}">
                </div>

                <div>
                    <label for="featured_image" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Imagen Destacada</label>
                    <input type="file" name="featured_image" id="featured_image" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-slate-600 rounded-md dark:bg-slate-900 dark:text-white">
                </div>
                
                <div class="col-span-2">
                     <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Tags</label>
                     <div class="flex gap-2">
                        <select name="tags[]" id="tags" multiple class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm h-32 dark:text-white">
                           @foreach($tags as $tag)
                               <option value="{{ $tag->id }}" {{ (collect(old('tags'))->contains($tag->id)) ? 'selected' : '' }}>{{ $tag->name }}</option>
                           @endforeach
                        </select>
                        <div class="flex flex-col justify-start mt-1">
                            <button type="button" onclick="document.getElementById('newTagModal').classList.remove('hidden')" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                +
                            </button>
                        </div>
                     </div>
                     <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Mantén presionado Ctrl (Windows) o Command (Mac) para seleccionar múltiples.</p>
                </div>

                <div class="col-span-2 border-t border-gray-200 dark:border-slate-700 pt-4 mt-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">SEO</h3>
                </div>

                <div>
                    <label for="meta_title" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Meta Título</label>
                    <input type="text" name="meta_title" id="meta_title" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-slate-600 rounded-md dark:bg-slate-900 dark:text-white" value="{{ old('meta_title') }}">
                </div>

                <div>
                    <label for="meta_description" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Meta Descripción</label>
                    <textarea name="meta_description" id="meta_description" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-slate-600 rounded-md dark:bg-slate-900 dark:text-white">{{ old('meta_description') }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('admin.posts.index') }}" class="bg-gray-200 dark:bg-slate-700 hover:bg-gray-300 dark:hover:bg-slate-600 text-gray-800 dark:text-white font-bold py-2 px-4 rounded mr-2">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Guardar
                </button>
            </div>
        </form>
    </div>

    <!-- Modals -->
    <!-- New Category Modal -->
    <div id="newCategoryModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('newCategoryModal').classList.add('hidden')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-slate-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-200 dark:border-slate-700">
                <div class="bg-white dark:bg-slate-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">Nueva Categoría</h3>
                            <div class="mt-2">
                                <input type="text" id="newCategoryName" placeholder="Nombre de la categoría" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-slate-600 rounded-md dark:bg-slate-900 dark:text-white">
                                <p id="newCategoryError" class="text-red-500 dark:text-red-400 text-xs mt-1 hidden"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-slate-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="createCategory()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Crear
                    </button>
                    <button type="button" onclick="document.getElementById('newCategoryModal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-slate-600 shadow-sm px-4 py-2 bg-white dark:bg-slate-800 text-base font-medium text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- New Tag Modal -->
    <div id="newTagModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('newTagModal').classList.add('hidden')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-slate-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-200 dark:border-slate-700">
                <div class="bg-white dark:bg-slate-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">Nuevo Tag</h3>
                            <div class="mt-2">
                                <input type="text" id="newTagName" placeholder="Nombre del tag" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-slate-600 rounded-md dark:bg-slate-900 dark:text-white">
                                <p id="newTagError" class="text-red-500 dark:text-red-400 text-xs mt-1 hidden"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-slate-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="createTag()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Crear
                    </button>
                    <button type="button" onclick="document.getElementById('newTagModal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-slate-600 shadow-sm px-4 py-2 bg-white dark:bg-slate-800 text-base font-medium text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Slug generation helper
        function generateSlug(text) {
            return text.toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/^-+|-+$/g, '');
        }

        async function createCategory() {
            const name = document.getElementById('newCategoryName').value;
            const errorEl = document.getElementById('newCategoryError');
            
            if (!name) {
                errorEl.textContent = 'El nombre es obligatorio';
                errorEl.classList.remove('hidden');
                return;
            }

            try {
                const response = await fetch('{{ route("admin.categories.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        name: name,
                        slug: generateSlug(name)
                    })
                });

                const data = await response.json();

                if (data.success) {
                    const select = document.getElementById('category_id');
                    const option = new Option(data.category.name, data.category.id);
                    option.selected = true;
                    select.add(option);
                    document.getElementById('newCategoryModal').classList.add('hidden');
                    document.getElementById('newCategoryName').value = '';
                    errorEl.classList.add('hidden');
                } else {
                    errorEl.textContent = data.message || 'Error al crear la categoría';
                    errorEl.classList.remove('hidden');
                }
            } catch (error) {
                console.error(error);
                errorEl.textContent = 'Error de conexión';
                errorEl.classList.remove('hidden');
            }
        }

        async function createTag() {
            const name = document.getElementById('newTagName').value;
            const errorEl = document.getElementById('newTagError');
            
            if (!name) {
                errorEl.textContent = 'El nombre es obligatorio';
                errorEl.classList.remove('hidden');
                return;
            }

            try {
                const response = await fetch('{{ route("admin.tags.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        name: name,
                        slug: generateSlug(name)
                    })
                });

                const data = await response.json();

                if (data.success) {
                    const select = document.getElementById('tags');
                    const option = new Option(data.tag.name, data.tag.id);
                    option.selected = true;
                    select.add(option);
                    document.getElementById('newTagModal').classList.add('hidden');
                    document.getElementById('newTagName').value = '';
                    errorEl.classList.add('hidden');
                } else {
                    errorEl.textContent = data.message || 'Error al crear el tag';
                    errorEl.classList.remove('hidden');
                }
            } catch (error) {
                console.error(error);
                errorEl.textContent = 'Error de conexión';
                errorEl.classList.remove('hidden');
            }
        }

        class MyUploadAdapter {
            constructor(loader) {
                this.loader = loader;
            }

            upload() {
                return this.loader.file
                    .then(file => new Promise((resolve, reject) => {
                        this._initRequest();
                        this._initListeners(resolve, reject, file);
                        this._sendRequest(file);
                    }));
            }

            abort() {
                if (this.xhr) {
                    this.xhr.abort();
                }
            }

            _initRequest() {
                const xhr = this.xhr = new XMLHttpRequest();
                xhr.open('POST', "{{ route('admin.posts.upload_image') }}", true);
                xhr.responseType = 'json';
                xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            }

            _initListeners(resolve, reject, file) {
                const xhr = this.xhr;
                const loader = this.loader;
                const genericErrorText = `Couldn't upload file: ${ file.name }.`;

                xhr.addEventListener('error', () => reject(genericErrorText));
                xhr.addEventListener('abort', () => reject());
                xhr.addEventListener('load', () => {
                    const response = xhr.response;

                    if (!response || response.error) {
                        return reject(response && response.error ? response.error.message : genericErrorText);
                    }

                    resolve({
                        default: response.url
                    });
                });

                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', evt => {
                        if (evt.lengthComputable) {
                            loader.uploadTotal = evt.total;
                            loader.uploaded = evt.loaded;
                        }
                    });
                }
            }

            _sendRequest(file) {
                const data = new FormData();
                data.append('upload', file);
                this.xhr.send(data);
            }
        }

        function MyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new MyUploadAdapter(loader);
            };
        }

        ClassicEditor
            .create(document.querySelector('#editor'), {
                extraPlugins: [MyCustomUploadAdapterPlugin],
            })
            .catch(error => {
                console.error(error);
            });

        document.getElementById('title').addEventListener('input', function() {
            let slug = this.value.toLowerCase()
                .replace(/[^\w\s-]/g, '') // Remove non-word chars (except spaces/dashes)
                .replace(/\s+/g, '-')     // Replace spaces with -
                .replace(/^-+|-+$/g, ''); // Trim - from start/end
            document.getElementById('slug').value = slug;
        });
    </script>
</x-admin-layout>