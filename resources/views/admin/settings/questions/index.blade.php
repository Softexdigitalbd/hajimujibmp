@extends('layouts.admin')

@section('title', __('Form questions'))
@section('heading', __('Form questions'))
@section('subheading', __('These appear on the public complaint form, in order. English and Bangla labels are shown together when both are set.'))

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.settings.questions.create') }}" class="inline-flex items-center rounded-xl bg-slate-900 text-white px-5 py-2.5 text-sm font-semibold hover:bg-slate-800 shadow-lg shadow-slate-900/10 transition">{{ __('Add question') }}</a>
        
        <a href="{{ route('admin.settings.statuses.trash') }}" class="group inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-bold text-slate-500 hover:bg-rose-50 hover:border-rose-100 hover:text-rose-600 transition shadow-sm">
            <svg class="h-4 w-4 transition-colors text-slate-400 group-hover:text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
            {{ __('View Trash') }}
            @php 
                $statusTrashCount = \App\Models\ComplaintStatus::onlyTrashed()->count();
                $questionTrashCount = \App\Models\ComplaintQuestion::onlyTrashed()->count();
                $totalTrashCount = $statusTrashCount + $questionTrashCount;
            @endphp
            @if($totalTrashCount > 0)
                <span class="inline-flex items-center justify-center h-4.5 min-w-[1.125rem] rounded-full bg-rose-500 px-1 text-[10px] font-black leading-none text-white ring-2 ring-rose-50 group-hover:ring-rose-100">
                    {{ $totalTrashCount }}
                </span>
            @endif
        </a>
    </div>

    <div x-data="{ 
        showModal: false, 
        deleteUrl: '', 
        openModal(url) { 
            this.deleteUrl = url; 
            this.showModal = true; 
        } 
    }">
        <div class="space-y-4">
        @foreach($questions as $q)
            <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm flex items-center justify-between gap-6 hover:border-emerald-200/60 transition">
                <div class="min-w-0 flex-1">
                    <p class="font-semibold text-slate-900">{{ $q->prompt }}</p>
                    @if(filled($q->prompt_bn))
                        <p class="text-sm text-slate-600 mt-1 noto-bn" lang="bn">{{ $q->prompt_bn }}</p>
                    @endif
                    <p class="text-xs text-slate-500 mt-2">
                        {{ __('Type') }}:
                        @if($q->type === \App\Models\ComplaintQuestion::TYPE_BOOLEAN)
                            {{ __('Checkbox') }}
                        @elseif($q->type === \App\Models\ComplaintQuestion::TYPE_FILE)
                            {{ __('File') }}
                        @else
                            {{ $q->type }}
                        @endif
                        @if($q->type === \App\Models\ComplaintQuestion::TYPE_SELECTION && $q->allow_multiple)
                            ({{ __('multiple choice') }})
                        @endif
                        · {{ $q->is_active ? __('Active') : __('Inactive') }}
                    </p>
                    @if($q->options->isNotEmpty())
                        <ul class="text-sm text-slate-600 mt-3 space-y-1 pl-4 list-disc">
                            @foreach($q->options as $o)
                                <li>{{ $o->label }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <a href="{{ route('admin.settings.questions.edit', $q) }}" class="inline-flex h-8 items-center rounded-lg border border-slate-200 bg-white px-3 text-xs font-bold text-slate-700 shadow-sm transition hover:bg-slate-50 hover:border-slate-300">
                        {{ __('Edit') }}
                    </a>
                    <button @click="openModal('{{ route('admin.settings.questions.destroy', $q) }}')" type="button" class="inline-flex h-8 items-center rounded-lg border border-red-100 bg-red-50 px-3 text-xs font-bold text-red-600 shadow-sm transition hover:bg-red-100 hover:border-red-200">
                        {{ __('Delete') }}
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Delete Confirmation Modal --}}
    <div x-show="showModal" 
        x-cloak 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6" 
        aria-labelledby="modal-title" 
        role="dialog" 
        aria-modal="true">
        
        {{-- Overlay Backdrop --}}
        <div x-show="showModal" 
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="showModal = false" 
            class="fixed inset-0 bg-slate-900/40 backdrop-blur-md transition-opacity" 
            aria-hidden="true"></div>

        {{-- Modal Panel --}}
        <div x-show="showModal" 
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-8"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-8"
            class="relative w-full max-w-md transform overflow-hidden rounded-3xl bg-white p-8 text-left shadow-2xl transition-all border border-slate-200/50">
            
            <div class="mb-6 flex flex-col items-center text-center">
                <div class="mb-4 flex h-20 w-20 items-center justify-center rounded-2xl bg-rose-50 text-rose-500 shadow-inner ring-1 ring-rose-200/50">
                    <svg class="h-10 w-10 animate-bounce-subtle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <h3 class="text-xl font-black tracking-tight text-slate-900 sm:text-2xl">
                    {{ __('Confirm Removal') }}
                </h3>
                <p class="mt-2 text-sm font-bold text-slate-400 uppercase tracking-widest">{{ __('Irreversible action') }}</p>
            </div>

            <div class="mb-8 rounded-2xl bg-slate-50 p-5 border border-slate-100 text-center">
                <p class="text-[13px] font-medium leading-relaxed text-slate-600">
                    {{ __('Are you sure you want to remove this question? While historical data is preserved, it will be hidden from the active form.') }}
                </p>
            </div>

            <div class="grid gap-3 sm:grid-cols-2">
                <button @click="showModal = false" type="button" class="order-2 sm:order-1 flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-6 py-4 text-sm font-extrabold text-slate-700 shadow-sm transition hover:bg-slate-50 active:scale-95">
                    {{ __('Keep it') }}
                </button>
                <form method="POST" :action="deleteUrl" class="order-1 sm:order-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full flex items-center justify-center rounded-2xl bg-slate-900 px-6 py-4 text-sm font-extrabold text-white shadow-xl shadow-slate-900/20 hover:bg-black transition active:scale-95">
                        {{ __('Remove Question') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
