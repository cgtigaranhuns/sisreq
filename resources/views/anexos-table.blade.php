@props(['anexos' => []])

@php
use Illuminate\Support\Facades\Storage;

// Fallback para compatibilidade com formulário Livewire, se necessário
$anexos = $anexos ?: ($this->form->getRawState()['_anexos'] ?? []);

// Função para verificar se é imagem
function isImage($filename) {
$imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'];
$extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
return in_array($extension, $imageExtensions);
}
@endphp

<div x-data="{
    open: false,
    fileUrl: '',
    fileName: '',
    isImage: false,
    zoom: 1,
    minZoom: 0.5,
    maxZoom: 3,
    zoomStep: 0.25,
    position: { x: 0, y: 0 },
    isDragging: false,
    dragStart: { x: 0, y: 0 },
    
    init() {
        // Reset zoom e posição quando modal abre
        this.$watch('open', (value) => {
            if (value) {
                this.zoom = 1;
                this.position = { x: 0, y: 0 };
            }
        });
    },
    
    openModal(url, name) {
        this.fileUrl = url;
        this.fileName = name;
        this.isImage = this.checkIsImage(name);
        this.zoom = 1;
        this.position = { x: 0, y: 0 };
        this.open = true;
    },
    
    checkIsImage(filename) {
        const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'];
        const extension = filename.split('.').pop().toLowerCase();
        return imageExtensions.includes(extension);
    },
    
    zoomIn() {
        if (this.zoom < this.maxZoom) {
            this.zoom += this.zoomStep;
        }
    },
    
    zoomOut() {
        if (this.zoom > this.minZoom) {
            this.zoom -= this.zoomStep;
        }
    },
    
    resetZoom() {
        this.zoom = 1;
        this.position = { x: 0, y: 0 };
    },
    
    startDrag(event) {
        if (!this.isImage) return;
        
        this.isDragging = true;
        this.dragStart = {
            x: event.clientX - this.position.x,
            y: event.clientY - this.position.y
        };
    },
    
    doDrag(event) {
        if (!this.isDragging || !this.isImage) return;
        
        this.position = {
            x: event.clientX - this.dragStart.x,
            y: event.clientY - this.dragStart.y
        };
    },
    
    stopDrag() {
        this.isDragging = false;
    },
    
    getImageStyle() {
        return {
            transform: `scale(${this.zoom}) translate(${this.position.x}px, ${this.position.y}px)`,
            transformOrigin: 'center center',
            transition: this.isDragging ? 'none' : 'transform 0.2s ease',
            cursor: this.isDragging ? 'grabbing' : (this.zoom > 1 ? 'grab' : 'default'),
            maxWidth: '100%',
            maxHeight: '100%'
        };
    }
}">
    <style>
    .fi-ta {
        width: 100%;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
        margin-bottom: 1.5rem;
        padding: 1rem;
        background-color: white;
    }

    .fi-ta table {
        width: 100%;
        border-collapse: collapse;
    }

    .fi-ta th,
    .fi-ta td {
        text-align: left;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .fi-ta th {
        background-color: #f9fafb;
        font-weight: 500;
        color: #374151;
    }

    .fi-ta tr:hover {
        background-color: #f3f4f6;
    }

    .fi-ta a {
        text-decoration: none;
        font-weight: 400;
        padding: 0.25rem;
        border-radius: 0.25rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .fi-ta a:hover {
        background-color: #e0e7ff;
    }

    /* Estilos para o modal de imagem */
    .image-container {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        overflow: hidden;
        background-color: #f8f9fa;
    }

    .image-wrapper {
        position: relative;
        display: inline-block;
        max-width: 90%;
        max-height: 90%;
    }

    .zoom-controls {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: white;
        border-radius: 0.5rem;
        padding: 0.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        display: flex;
        gap: 0.5rem;
        z-index: 10;
    }

    .zoom-btn {
        width: 2.5rem;
        height: 2.5rem;
        border: none;
        border-radius: 0.25rem;
        background: #f1f5f9;
        color: #475569;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .zoom-btn:hover {
        background: #e2e8f0;
        color: #334155;
    }

    .zoom-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .zoom-display {
        min-width: 3rem;
        text-align: center;
        font-weight: 600;
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .drag-indicator {
        position: absolute;
        bottom: 1rem;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .image-wrapper:hover .drag-indicator {
        opacity: 1;
    }
    </style>

    @if (!empty($anexos))
    <div class="fi-ta">
        <div class="overflow-x-auto w-full">
            <table class="w-full">
                <thead>
                    <tr>
                        <th>Anexo(s)</th>
                        <th>Tamanho</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($anexos as $anexo)
                    @php
                    $caminho = $anexo['caminho'];
                    $nomeOriginal = $anexo['nome_original'];
                    $fullPath = storage_path("app/public/{$caminho}");
                    $fileExists = file_exists($fullPath);
                    $url = Storage::url($caminho);
                    $sizeKb = $fileExists ? round(filesize($fullPath) / 1024, 2) : null;
                    $isImageFile = isImage($nomeOriginal);
                    @endphp
                    <tr>
                        <td>
                            <div class="flex items-center">
                                @if ($isImageFile)
                                <x-heroicon-s-photo class="w-4 h-4 mr-2 text-blue-500" />
                                @else
                                <x-heroicon-s-document class="w-4 h-4 mr-2 text-gray-500" />
                                @endif
                                {{ $nomeOriginal }}
                            </div>
                        </td>
                        <td>
                            {{ $fileExists ? "{$sizeKb} KB" : 'Arquivo não encontrado' }}
                        </td>
                        <td class="text-center">
                            <div class="flex justify-center space-x-2">
                                @if ($fileExists)
                                <!-- Visualizar -->
                                <button type="button"
                                    @click="openModal({{ json_encode(asset($url)) }}, {{ json_encode($nomeOriginal) }})"
                                    class="text-primary-600 hover:text-primary-700" title="Visualizar anexo">
                                    <x-heroicon-s-eye class="w-6 h-6" />
                                </button>

                                <!-- Download -->
                                <a href="{{ asset($url) }}" download class="text-green-600 hover:text-green-700"
                                    title="Download">
                                    <x-heroicon-s-arrow-down-tray class="w-6 h-6" />
                                </a>
                                @else
                                <span class="text-red-500 text-sm">Arquivo indisponível</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div x-show="open" style="display: none;"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[999] p-4" x-transition
        @click.self="open = false">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl max-w-4xl w-full flex flex-col" style="height: 85vh;">
            <!-- Cabeçalho -->
            <div class="flex justify-between items-center p-4 border-b">
                <h2 class="text-lg font-semibold text-gray-800">
                    Visualizar Anexo: <span x-text="fileName" class="font-medium"></span>
                </h2>
                <button @click="open = false" class="text-gray-500 hover:text-gray-700 transition-colors">
                    <x-heroicon-s-x-mark class="w-6 h-6" />
                </button>
            </div>

            <!-- Conteúdo -->
            <div class="flex-1 overflow-hidden bg-gray-50 relative">
                <template x-if="!isImage">
                    <iframe :src="fileUrl" class="w-full h-full border-0"
                        style="min-height: calc(85vh - 64px);"></iframe>
                </template>

                <template x-if="isImage">
                    <div class="image-container">
                        <div class="image-wrapper" @mousedown="startDrag($event)" @mousemove="doDrag($event)"
                            @mouseup="stopDrag()" @mouseleave="stopDrag()">

                            <!-- Controles de zoom -->
                            <div class="zoom-controls">
                                <button @click="zoomOut()" :disabled="zoom <= minZoom" class="zoom-btn"
                                    title="Zoom Out">
                                    <x-heroicon-s-minus class="w-4 h-4" />
                                </button>

                                <span class="zoom-display" x-text="Math.round(zoom * 100) + '%'"></span>

                                <button @click="zoomIn()" :disabled="zoom >= maxZoom" class="zoom-btn" title="Zoom In">
                                    <x-heroicon-s-plus class="w-4 h-4" />
                                </button>

                                <button @click="resetZoom()" class="zoom-btn" title="Reset Zoom"
                                    :disabled="zoom === 1 && position.x === 0 && position.y === 0">
                                    <x-heroicon-s-arrows-pointing-out class="w-4 h-4" />
                                </button>
                            </div>

                            <!-- Imagem -->
                            <img :src="fileUrl" :alt="fileName" :style="getImageStyle()" class="block mx-auto">

                            <!-- Indicador de arraste -->
                            <div class="drag-indicator" x-show="zoom > 1">
                                Clique e arraste para mover a imagem
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Rodapé -->
            <div class="flex justify-between items-center p-3 border-t bg-white">
                <div x-show="isImage" class="text-sm text-gray-600">
                    Use os controles para zoom e arraste para mover a imagem
                </div>
                <div class="flex gap-2 ml-auto">
                    <a :href="fileUrl" download
                        class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        <x-heroicon-s-arrow-down-tray class="w-5 h-5 mr-2" />
                        Download
                    </a>
                    <button @click="open = false"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="fi-ta">
        <p class="text-gray-500 text-sm py-2">Nenhum anexo encontrado.</p>
    </div>
    @endif
</div>