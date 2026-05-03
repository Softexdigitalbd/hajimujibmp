@extends('layouts.admin')

@section('title', __('Complaint status'))
@section('heading', __('Complaint status'))
@section('subheading', __('Internal name (slug), display label, and workflow state.'))

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.settings.statuses.create') }}" class="inline-flex items-center rounded-xl bg-slate-900 text-white px-5 py-2.5 text-sm font-semibold hover:bg-slate-800 shadow-lg shadow-slate-900/10 transition">{{ __('Add status') }}</a>
        
        <a href="{{ route('admin.settings.statuses.trash') }}" class="group inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-bold text-slate-500 hover:bg-rose-50 hover:border-rose-100 hover:text-rose-600 transition shadow-sm">
            <svg class="h-4 w-4 transition-colors text-slate-400 group-hover:text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
            {{ __('View Trash') }}
            @php $count = \App\Models\ComplaintStatus::onlyTrashed()->count() @endphp
            @if($count > 0)
                <span class="inline-flex items-center justify-center h-4.5 min-w-[1.125rem] rounded-full bg-rose-500 px-1 text-[10px] font-black leading-none text-white ring-2 ring-rose-50 group-hover:ring-rose-100">
                    {{ $count }}
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
        <div class="rounded-2xl bg-white border border-slate-200 overflow-hidden shadow-sm">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead>
                    <tr class="bg-slate-50/90 border-b border-slate-100 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                        <th class="px-6 py-4">{{ __('Name (system)') }}</th>
                        <th class="px-6 py-4">{{ __('Label') }}</th>
                        <th class="px-6 py-4">{{ __('State') }}</th>
                        <th class="px-6 py-4">{{ __('Active') }}</th>
                        <th class="px-6 py-4 text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($statuses as $st)
                        <tr class="hover:bg-emerald-50/20 transition text-slate-700">
                            <td class="px-6 py-4 font-mono text-xs text-slate-500 tracking-tight">{{ $st->name }}</td>
                            <td class="px-6 py-4 font-medium">
                                @php $sc = $st->colorClasses(); @endphp
                                <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-bold ring-1 ring-inset" style="{{ $sc['badge_style'] }}">
                                    <span class="h-1.5 w-1.5 rounded-full" style="{{ $sc['dot_style'] }}"></span>
                                    {{ $st->alias_name }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold bg-slate-100 text-slate-600 ring-1 ring-slate-200/50">{{ $st->state }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-500 font-medium">
                                @if($st->is_active)
                                    <span class="text-emerald-600 flex items-center gap-1.5"><span class="h-1 w-1 rounded-full bg-emerald-600"></span> {{ __('Active') }}</span>
                                @else
                                    <span class="text-slate-400 flex items-center gap-1.5"><span class="h-1 w-1 rounded-full bg-slate-400"></span> {{ __('Inactive') }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.settings.statuses.edit', $st) }}" class="inline-flex h-8 items-center rounded-lg border border-slate-200 bg-white px-3 text-xs font-bold text-slate-700 shadow-sm transition hover:bg-slate-50 hover:border-slate-300">
                                        {{ __('Edit') }}
                                    </a>
                                    <button @click="openModal('{{ route('admin.settings.statuses.destroy', $st) }}')" type="button" class="inline-flex h-8 items-center rounded-lg border border-red-100 bg-red-50 px-3 text-xs font-bold text-red-600 shadow-sm transition hover:bg-red-100 hover:border-red-200">
                                        {{ __('Delete') }}
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
                
                {{-- Decorative Danger Header --}}
                <div class="mb-6 flex flex-col items-center text-center">
                    <div class="mb-4 flex h-20 w-20 items-center justify-center rounded-2xl bg-rose-50 text-rose-500 shadow-inner ring-1 ring-rose-200/50">
                        <svg class="h-10 w-10 animate-bounce-subtle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-black tracking-tight text-slate-900 sm:text-2xl" id="modal-title">
                        {{ __('Confirm Removal') }}
                    </h3>
                    <p class="mt-2 text-sm font-bold text-slate-400 uppercase tracking-widest">
                        {{ __('Irreversible action') }}
                    </p>
                </div>

                {{-- Warning Content --}}
                <div class="mb-8 rounded-2xl bg-slate-50 p-5 border border-slate-100">
                    <p class="text-[13px] font-medium leading-relaxed text-slate-600 text-center">
                        {{ __('Warning: Deleting this status will immediately hide it from the active workflow. While complaints tied to this status will retain their history, you will not be able to assign this status to new or existing complaints.') }}
                    </p>
                </div>

                {{-- Action Buttons --}}
                <div class="grid gap-3 sm:grid-cols-2">
                    <button @click="showModal = false" type="button" class="order-2 sm:order-1 flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-6 py-4 text-sm font-extrabold text-slate-700 shadow-sm transition hover:bg-slate-50 active:scale-95">
                        {{ __('Keep it') }}
                    </button>
                    <form method="POST" :action="deleteUrl" class="order-1 sm:order-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full flex items-center justify-center rounded-2xl bg-slate-900 px-6 py-4 text-sm font-extrabold text-white shadow-xl shadow-slate-900/20 hover:bg-black transition active:scale-95">
                            {{ __('Remove Status') }}
                        </button>
                    </form>
                </div>

                {{-- Extra Hint --}}
                <p class="mt-6 text-center text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">
                    {{ __('Press ESC to cancel') }}
                </p>
            </div>
        </div>
    </div>
@endsection
