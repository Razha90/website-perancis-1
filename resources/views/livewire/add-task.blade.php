<div>
    @vite(['resources/js/editor.js'])
    @if (session()->has(key: 'FAILED'))
        <div x-data="{ alert: true }" x-init="setTimeout(() => alert = false, 5000)" x-show="alert" x-transition
            class="flex items-start z-40 left-5 bottom-5 flex-row p-4 mb-4 text-sm rounded-lg bg-gray-800 animate-fade-up text-red-400 fixed"
            role="alert">
            <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">{{ session('FAILED') }}</span>
            </div>
        </div>
    @endif
    <header class="z-30 w-full bg-secondary_blue py-3 min-h-[70px]  px-[10%] fixed">
        <nav class="flex flex-row justify-between max-w-[1500px] w-full h-full items-center">
            <div>
                <button class="flex flex-row text-primary_white text-2xl font-bold items-center gap-x-2"
                    @click="if (document.referrer.startsWith(window.location.origin)) {
                                history.back();
                            } else {
                                window.location.href = '{{ route('classroom-learn', ['id' => $id]) }}';
                            }
                        ">
                    <svg class="w-9 h-9" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#F7F7F7">
                        <polyline fill="none" points="7.6 7 2.5 12 7.6 17" stroke="#F7F7F7" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2"></polyline>
                        <line fill="none" stroke="#F7F7F7" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" x1="21.5" x2="4.8" y1="12" y2="12"></line>
                    </svg>
                    <p>{{ __('add-class.back') }}</p>
                </button>
            </div>
            <div class="flex flex-row gap-x-4 items-center">

                <a href="{{ route('profile.edit') }}"
                    class="w-[45px] h-[45px] overflow-hidden rounded-full border border-secondary_blue p-1  hover:opacity-50 transition-opacity"
                    x-data="{ isClicked: false }"
                    @click.prevent="if (!isClicked) { isClicked = true; window.location.href = '{{ route('profile.edit') }}'; }"
                    :class="{ 'pointer-events-none opacity-50': isClicked }">
                    <img src="{{ asset('/img/profile/' . auth()->user()->profile_photo_path) }}" alt="Profile Photo">
                </a>

            </div>
        </nav>
    </header>

    <main x-data="cmsContent()" x-init="init()" class="min-h-[500px] w-full min-w-[500px] h-[92vh]">
        <template x-if="isLoading && content.length > 0">
            <div class="w-1/4 bg-gray-100 p-4 rounded-lg h-full shadow-xl fixed mt-[70px]">
                <div class="w-full flex justify-end">
                    <button x-bind:disabled="saveNew" @click="clickSave"
                        :class="{
                            'opacity-50 cursor-not-allowed border-gray-400 bg-gray-300 text-gray-500': (saveNew || !
                                saved),
                            'border-white outline outline-secondary_blue bg-secondary_blue text-white': !(saveNew || !
                                saved)
                        }"
                        class="border px-4 py-1 text-xl transition-all"
                        x-text="saved ? '{{ __('add-task.saved') }}' : '{{ __('add-task.saving') }}....' ">
                    </button>
                </div>
                <h2 class="text-lg font-bold mb-2">Pilih Tipe Konten</h2>
                <select x-model="type" class="w-full p-2 border rounded" x-init="initType"
                    x-on:input="saveNew =false">
                    <option value="task">{{ __('add-class.task') }}</option>
                    <option value="notification">{{ __('add-class.notification') }}</option>
                </select>
            </div>
        </template>
        <div class="w-3/4 flex flex-col items-center px-[5%] ml-[25%] pt-[80px]">

            <template x-if="isLoading && content.length == 0">
                <div class="w-full h-full flex justify-center items-center flex-col gap-y-3 ">
                    <p class="text-4xl font-koho text-gray-700 font-bold">
                        {{ __('add-task.not_found') }}
                    </p>
                    <p class="underline text-secondary_blue"
                        @click="if (document.referrer.startsWith(window.location.origin)) {
                                history.back();
                            } else {
                                window.location.href = '{{ route('classroom-learn', ['id' => $id]) }}';
                            }
                        ">
                        {{ __('add-task.back') }}</p>
                </div>
            </template>

            <div class="w-full mt-5" x-show="isLoading && content.length > 0">
                <input type="text" x-init="initTitle" x-model="title" x-on:input="saveNew = false"
                    class="w-full border-none rounded-xl text-2xl p-4">
            </div>
            <div x-show="isLoading && content.length > 0"
                class="w-full h-auto px-4 pt-3 pb-3 bg-primary_white rounded-xl mt-5">
                <h2 class="text-2xl font-bold my-2">{{ __('add-class.content') }}</h2>
                <div id="editorjs"></div>
            </div>
            <div x-show="(type == 'task') && isLoading && content.length > 0" class="w-full p-3 bg-primary_white mt-4">
                <div
                    class="rounded-xl border border-dashed border-secondary_blue w-full flex flex-row items-center p-3">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-[40px]">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M12.75 9C12.75 8.58579 12.4142 8.25 12 8.25C11.5858 8.25 11.25 8.58579 11.25 9L11.25 11.25H9C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75H11.25V15C11.25 15.4142 11.5858 15.75 12 15.75C12.4142 15.75 12.75 15.4142 12.75 15L12.75 12.75H15C15.4142 12.75 15.75 12.4142 15.75 12C15.75 11.5858 15.4142 11.25 15 11.25H12.75V9Z"
                                nCar fill="#2867A4"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M12 1.25C6.06294 1.25 1.25 6.06294 1.25 12C1.25 17.9371 6.06294 22.75 12 22.75C17.9371 22.75 22.75 17.9371 22.75 12C22.75 6.06294 17.9371 1.25 12 1.25ZM2.75 12C2.75 6.89137 6.89137 2.75 12 2.75C17.1086 2.75 21.25 6.89137 21.25 12C21.25 17.1086 17.1086 21.25 12 21.25C6.89137 21.25 2.75 17.1086 2.75 12Z"
                                fill="#2867A4"></path>
                        </g>
                    </svg>
                    <svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"
                        class="w-[40px]">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M864 512a32 32 0 0 0-32 32v96a32 32 0 0 0 64 0v-96a32 32 0 0 0-32-32zM881.92 389.44a23.68 23.68 0 0 0-5.76-2.88 19.84 19.84 0 0 0-6.08-1.92 32 32 0 0 0-28.8 8.64A32 32 0 0 0 832 416a32 32 0 1 0 64 0 33.6 33.6 0 0 0-9.28-22.72z"
                                fill="#2867A4"></path>
                            <path
                                d="M800 128h-32a96 96 0 0 0-96-96H352a96 96 0 0 0-96 96H224a96 96 0 0 0-96 93.44v677.12A96 96 0 0 0 224 992h576a96 96 0 0 0 96-93.44V736a32 32 0 0 0-64 0v162.56a32 32 0 0 1-32 29.44H224a32 32 0 0 1-32-29.44V221.44A32 32 0 0 1 224 192h32a96 96 0 0 0 96 96h320a96 96 0 0 0 96-96h32a32 32 0 0 1 32 29.44V288a32 32 0 0 0 64 0V221.44A96 96 0 0 0 800 128z m-96 64a32 32 0 0 1-32 32H352a32 32 0 0 1-32-32V128a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32z"
                                fill="#2867A4"></path>
                            <path
                                d="M712.32 426.56L448 721.6l-137.28-136.32A32 32 0 0 0 265.6 630.4l160 160a32 32 0 0 0 22.4 9.6 32 32 0 0 0 23.04-10.56l288-320a32 32 0 0 0-47.68-42.88z"
                                fill="#2867A4"></path>
                        </g>
                    </svg>
                    <p class="text-2xl ml-2 text-secondary_blue font-bold">{{ __('add-class.upload') }}</p>
                </div>
            </div>

        </div>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/editorjs-style@latest"></script>
    <script>
        function cmsContent() {
            return {
                isLoading: @entangle('isLoading'),
                content: @entangle('content'),
                saved: true,
                type: 'task',
                data: "",
                title: "",
                saveNew: true,
                selectionPos: false,
                init() {
                    if (this.selectionPos) return;
                    this.selectionPos = true;

                    let token = "{{ session('sanctum_token') }}";
                    let stateAwal = false

                    const editor = new EditorJS({
                        holder: "editorjs",
                        tools: {

                            paragraph: {
                                class: Paragraph,
                                config: {
                                    inlineToolbar: true,
                                }
                            },
                            header: Header,
                            list: List,
                            image: {
                                class: ImageTool,
                                config: {
                                    types: "image/*",
                                    additionalRequestHeaders: {
                                        "Authorization": `Bearer ${token}`,
                                        "Content-Type": "application/json"
                                    },
                                    captionPlaceholder: "Tambahkan deskripsi gambar",
                                    buttonContent: "Pilih Gambar",
                                    features: {
                                        border: true,
                                        background: true,
                                        stretched: true,
                                        caption: 'optional',
                                    },
                                    uploader: {
                                        async uploadByFile(file) {
                                            const formData = new FormData();
                                            formData.append('image', file);
                                            const response = await fetch('{{ route('upload-image') }}', {
                                                method: 'POST',
                                                body: formData,
                                                headers: {
                                                    "Authorization": `Bearer ${token}`
                                                },
                                            });

                                            return response.json();
                                        }

                                    }

                                },
                            },
                            raw: RawTool,
                            code: CodeTool,
                            linkTool: {
                                class: LinkTool,
                                config: {
                                    endpoint: '{{ route('info') }}',
                                    headers: {
                                        "Authorization": `Bearer ${token}`,
                                        "Content-Type": "application/json"
                                    }
                                }
                            },
                            embed: {
                                class: Embed,
                                config: {
                                    services: {
                                        youtube: true,
                                        facebook: true,
                                        instagram: true,
                                        twitter: true,
                                        twitch: true,
                                        "twitch-channel": true,
                                        miro: true,
                                        vimeo: true,
                                        gfycat: true,
                                        imgur: true,
                                        vine: true,
                                        aparat: true,
                                        "yandex-music-track": true,
                                        "yandex-music-album": true,
                                        "yandex-music-playlist": true,
                                        coub: true,
                                        codepen: true,
                                        pinterest: true,
                                        github: true
                                    }
                                }
                            },
                            attaches: {
                                class: AttachesTool,
                                config: {
                                    uploader: {
                                        async uploadByFile(file) {
                                            const formData = new FormData();
                                            formData.append('file', file);
                                            const response = await fetch('{{ route('upload-file') }}', {
                                                method: 'POST',
                                                body: formData,
                                                headers: {
                                                    "Authorization": `Bearer ${token}`
                                                },
                                            });
                                            return response.json();
                                        },
                                    }
                                }
                            },
                            table: {
                                class: Table,
                                inlineToolbar: true,
                                config: {
                                    rows: 2,
                                    cols: 3,
                                    maxRows: 5,
                                    maxCols: 5,
                                },
                            },
                            quote: Quote,
                            underline: Underline,
                            delimiter: Delimiter,
                            inlineCode: {
                                class: InlineCode,
                                shortcut: 'CMD+SHIFT+M',
                            },
                            textVariant: TextVariantTune,
                            Marker: {
                                class: Marker,
                                shortcut: 'CMD+SHIFT+M',
                            }
                        },
                        tunes: ['textVariant'],
                        onChange: async () => {
                            this.data = await editor.save();
                            if (stateAwal) {
                                this.saveNew = false;
                            } else {
                                stateAwal = true;
                            }
                        }
                    });


                    document.addEventListener('keydown', async (event) =>  {
                        if (event.ctrlKey && (event.key === 's' || event.key === 'S')) {
                            event.preventDefault();
                            this.saved = false;
                            const content = await editor.save();
                            const data = {
                                title: this.title,
                                content: content,
                                type: this.type,
                            };

                            Livewire.dispatch('savedContent', {
                                data: data
                            });

                        }
                    });


                    Livewire.on('savedSuccess', (event) => {
                        this.saved = true;
                    });
                },
                initTitle() {
                    this.title = this.content[0].title;
                },
                initType() {
                    this.type = this.content[0].type;
                },
                clickSave() {
                    const event = new KeyboardEvent('keydown', {
                        key: 's',
                        ctrlKey: true,
                        bubbles: true,
                        cancelable: true
                    });
                    document.dispatchEvent(event);
                    this.saveNew = true;
                }

            }
        }
    </script>
</div>
