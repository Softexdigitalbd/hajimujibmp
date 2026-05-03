@extends('layouts.admin')

@section('title', __('Edit Role'))
@section('heading', __('Edit Role: ').$role->label)
@section('subheading', __('Update role name, description, and permission assignments.'))

@section('content')
<div class="max-w-3xl space-y-6">

    <form method="POST" action="{{ route('admin.roles.update', $role) }}" class="space-y-6">
        @csrf @method('PUT')

        {{-- Basic Info --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white px-6 py-4 flex items-center justify-between">
                <h2 class="text-sm font-bold text-slate-800">{{ __('Role Information') }}</h2>
                <code class="rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-mono text-slate-500">{{ $role->name }}</code>
            </div>
            <div class="p-6 space-y-5">
                <div>
                    <label for="label" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">{{ __('Display Name') }}</label>
                    <input type="text" id="label" name="label" value="{{ old('label', $role->label) }}" required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-400 focus:bg-white focus:ring-2 focus:ring-indigo-100 @error('label') border-red-300 bg-red-50 @enderror">
                    @error('label')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">{{ __('Description') }}</label>
                    <textarea id="description" name="description" rows="2"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-400 focus:bg-white focus:ring-2 focus:ring-indigo-100 resize-none">{{ old('description', $role->description) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Permissions Matrix --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white px-6 py-4 flex items-center justify-between">
                <h2 class="text-sm font-bold text-slate-800">{{ __('Permissions') }}</h2>
                <button type="button" id="selectAll"
                    class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition">
                    {{ __('Select All') }}
                </button>
            </div>
            <div class="p-6 space-y-6">
                @foreach($permissions as $group => $groupPerms)
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">{{ $group }}</span>
                        <div class="flex-1 h-px bg-slate-100"></div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($groupPerms as $perm)
                        <label for="perm_{{ $perm->id }}"
                            class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 px-4 py-3 transition hover:border-indigo-300 hover:bg-indigo-50/40 has-[:checked]:border-indigo-400 has-[:checked]:bg-indigo-50">
                            <input type="checkbox" id="perm_{{ $perm->id }}" name="permissions[]" value="{{ $perm->id }}"
                                class="perm-cb h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                                {{ in_array($perm->id, old('permissions', $rolePermIds)) ? 'checked' : '' }}>
                            <div>
                                <p class="text-sm font-medium text-slate-700">{{ $perm->label }}</p>
                                <code class="text-[10px] text-slate-400 font-mono">{{ $perm->name }}</code>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-3">
            <button type="submit"
                class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/25 transition hover:shadow-xl hover:-translate-y-0.5">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                {{ __('Save Changes') }}
            </button>
            <a href="{{ route('admin.roles.index') }}"
                class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                {{ __('Cancel') }}
            </a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const btn = document.getElementById('selectAll');
    const cbs = document.querySelectorAll('.perm-cb');
    let allChecked = cbs.length > 0 && [...cbs].every(cb => cb.checked);
    btn.textContent = allChecked ? '{{ __("Deselect All") }}' : '{{ __("Select All") }}';
    btn.addEventListener('click', () => {
        allChecked = !allChecked;
        cbs.forEach(cb => cb.checked = allChecked);
        btn.textContent = allChecked ? '{{ __("Deselect All") }}' : '{{ __("Select All") }}';
    });
</script>
@endpush
