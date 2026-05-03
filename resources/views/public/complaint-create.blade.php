@extends('layouts.public')

@section('title', __('Complaint Form').' (অভিযোগ জানান) — '.config('app.name'))

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Page header --}}
    <div class="mb-4 text-center sm:text-left">

        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
            {{ __('Complaint Form') }}
            <span class="block sm:inline sm:ml-2 text-2xl sm:text-3xl font-semibold text-[#1b4d3e] noto-bn"
                lang="bn">(অভিযোগ জানান)</span>
        </h1>
        <p class="mt-3 text-slate-500 text-sm leading-relaxed max-w-xl">
            {{ __('Same information as the public reference form: your contact details, location, and complaint text.')
            }}
        </p>
    </div>

    @error('form')
    <div class="mb-6 flex items-center gap-3 rounded-xl border border-amber-200/60 bg-amber-50 px-5 py-4 text-sm font-medium text-amber-900"
        role="alert">
        <svg class="h-5 w-5 text-amber-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
        </svg>
        {{ $message }}
    </div>
    @enderror

    @if($questions->isEmpty() || ! $settingsConfigured)
    <div
        class="rounded-xl border border-slate-200/60 bg-white shadow-lg shadow-slate-200/40 p-8 sm:p-10 text-center space-y-5">
        <span class="flex h-14 w-14 items-center justify-center rounded-xl bg-slate-100 text-slate-400 mx-auto">
            <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
            </svg>
        </span>
        @if($questions->isEmpty())
        <p class="text-slate-700 font-semibold">{{ __('The complaint form is not available yet.') }}</p>
        <p class="text-sm text-slate-500">{{ __('Please check back later or contact the site administrator.') }}</p>
        @else
        <p class="text-slate-700 font-semibold">{{ __('Complaints cannot be submitted at the moment.') }}</p>
        <p class="text-sm text-slate-500">{{ __('The service is being configured. Please try again later.') }}</p>
        @endif
        <a href="{{ route('home') }}"
            class="inline-flex justify-center rounded-lg bg-slate-900 text-white px-6 py-3 text-sm font-semibold hover:bg-slate-800 transition shadow-sm">{{
            __('Back to home') }}</a>
    </div>
    @else
    <div class="rounded-xl border border-slate-200/60 bg-white shadow-xl shadow-slate-200/40 overflow-hidden">


        <form method="POST" action="{{ route('complaint.store') }}" enctype="multipart/form-data"
            class="pt-2 px-6 pb-6 sm:pt-4 sm:px-8 sm:pb-8 space-y-6">
            @csrf

                {{-- সচেতনতা বার্তা --}}
                <div class="rounded-xl border border-amber-200/80 bg-amber-50/70 px-5 py-4" role="alert">
                    <div class="flex items-start gap-3">
                        <svg class="h-5 w-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                        <div class="noto-bn text-[13px] leading-relaxed text-amber-900" lang="bn">
                            <p class="font-semibold mb-1">সচেতনতা বার্তা:</p>
                            <p>মিথ্যা তথ্য ছড়ানো, কাউকে ফাঁসানোর উদ্দেশ্যে বা বিভ্রান্তকর তথ্য দেওয়া থেকে বিরত থাকুন। এর ফলে মূল্যবান সময় নষ্ট হয় এবং সমাজে অযথা বিভ্রান্তি সৃষ্টি হয়। <strong>মিথ্যা তথ্য প্রমাণিত হলে, তথ্য প্রদানকারীর বিরুদ্ধে আইনানুগ ব্যবস্থা গ্রহণ করা হবে।</strong></p>
                        </div>
                    </div>
                </div>



            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 sm:gap-6">
                @foreach($questions as $question)
                @php
                $wide = in_array($question->type, [
                \App\Models\ComplaintQuestion::TYPE_TEXTAREA,
                \App\Models\ComplaintQuestion::TYPE_FILE,
                \App\Models\ComplaintQuestion::TYPE_BOOLEAN,
                ], true);
                @endphp
                <div class="space-y-2 {{ $wide ? 'sm:col-span-2' : '' }}">
                    @if($question->type !== \App\Models\ComplaintQuestion::TYPE_BOOLEAN)
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700" for="q-{{ $question->id }}">{{
                            $question->prompt }}</label>
                        @if(filled($question->prompt_bn))
                        <p class="text-sm text-[#1b4d3e]/80 mt-0.5 font-medium noto-bn" lang="bn">{{ $question->prompt_bn
                            }}</p>
                        @endif
                    </div>
                    @endif

                    @if($question->type === \App\Models\ComplaintQuestion::TYPE_TEXT || $question->type ===
                    \App\Models\ComplaintQuestion::TYPE_EMAIL || $question->type ===
                    \App\Models\ComplaintQuestion::TYPE_PHONE)
                    <input id="q-{{ $question->id }}"
                        type="{{ $question->type === \App\Models\ComplaintQuestion::TYPE_EMAIL ? 'email' : 'text' }}"
                        name="answers[{{ $question->id }}]" value="{{ old('answers.'.$question->id) }}"
                        placeholder="{{ $question->prompt }}"
                        class="w-full h-11 rounded-lg border border-slate-200 bg-white px-4 text-[13px] text-slate-900 shadow-sm focus:border-[#1b4d3e] focus:ring-2 focus:ring-[#1b4d3e]/20 transition placeholder:text-[13px] placeholder:text-slate-400/80">
                    @elseif($question->type === \App\Models\ComplaintQuestion::TYPE_TEXTAREA)
                    <textarea id="q-{{ $question->id }}" name="answers[{{ $question->id }}]" rows="6"
                        placeholder="{{ $question->prompt }}"
                        class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2 text-[13px] text-slate-900 shadow-sm focus:border-[#1b4d3e] focus:ring-2 focus:ring-[#1b4d3e]/20 transition resize-y placeholder:text-[13px] placeholder:text-slate-400/80">{{ old('answers.'.$question->id) }}</textarea>
                    @elseif($question->type === \App\Models\ComplaintQuestion::TYPE_SELECTION)
                    @if($question->allow_multiple)
                    <div class="space-y-3 rounded-lg border border-slate-100 bg-slate-50/30 p-4">
                        @foreach($question->options as $opt)
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" name="answers[{{ $question->id }}][]" value="{{ $opt->id }}"
                                class="mt-1 rounded border-slate-300 text-[#1b4d3e] focus:ring-[#1b4d3e] transition" {{
                                in_array($opt->id, (array) old('answers.'.$question->id, []), true) ? 'checked' : '' }}>
                            <span class="text-sm text-slate-700 group-hover:text-slate-900 transition">{{ $opt->label
                                }}</span>
                        </label>
                        @endforeach
                    </div>
                    @else
                    <div class="relative">
                        <select id="q-{{ $question->id }}" name="answers[{{ $question->id }}]"
                            class="w-full h-11 appearance-none rounded-lg border border-slate-200 bg-white px-4 pr-10 text-[13px] text-slate-900 shadow-sm focus:border-[#1b4d3e] focus:ring-2 focus:ring-[#1b4d3e]/20 transition cursor-pointer">
                            <option value="" disabled {{ old('answers.'.$question->id) === null ? 'selected' : '' }}>{{
                                __('Select an option...') }}</option>
                            @foreach($question->options as $opt)
                            <option value="{{ $opt->id }}" {{ (string) old('answers.'.$question->id) === (string)
                                $opt->id ? 'selected' : '' }}>
                                {{ $opt->label }}
                            </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4">
                            <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                            </svg>
                        </div>
                    </div>
                    @endif
                    @elseif($question->type === \App\Models\ComplaintQuestion::TYPE_BOOLEAN)
                    <input type="hidden" name="answers[{{ $question->id }}]" value="0">
                    <label class="flex items-start gap-4 cursor-pointer py-1 transition group">
                        <input type="checkbox" name="answers[{{ $question->id }}]" value="1"
                            class="mt-1 h-5 w-5 rounded border-slate-300 text-[#1b4d3e] focus:ring-[#1b4d3e] shadow-sm transition-all"
                            {{ old('answers.'.$question->id) === '1' || old('answers.'.$question->id) === 1 ? 'checked'
                        : '' }}>
                        <div class="flex-1 text-left">
                            <span
                                class="text-[13px] font-semibold text-slate-700 group-hover:text-[#1b4d3e] transition-colors">{{
                                $question->prompt }}</span>
                            @if(filled($question->prompt_bn))
                            <p class="text-sm text-[#1b4d3e]/80 mt-1 font-medium noto-bn" lang="bn">{{
                                $question->prompt_bn }}</p>
                            @endif
                        </div>
                    </label>
                    @elseif($question->type === \App\Models\ComplaintQuestion::TYPE_FILE)
                    <div class="relative group/file">
                        <label for="q-{{ $question->id }}"
                            id="label-{{ $question->id }}"
                            class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-200 border-dashed rounded-lg cursor-pointer bg-slate-50/50 hover:bg-[#1b4d3e]/5 hover:border-[#1b4d3e]/30 transition-all duration-300">

                            {{-- Default state --}}
                            <div id="placeholder-{{ $question->id }}" class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-3 text-slate-400 group-hover/file:text-[#1b4d3e] transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="mb-1 text-sm text-slate-600 font-medium">{{ __('Click to upload') }}
                                    <span class="text-slate-400 font-normal">or drag and drop</span></p>
                                <p class="text-xs text-slate-400">{{ __('PDF, JPG, PNG, WEBP, DOC — Max 10MB') }}</p>
                            </div>

                            {{-- Selected state (hidden by default) --}}
                            <div id="preview-{{ $question->id }}" class="hidden flex-col items-center justify-center gap-2 py-4 px-4 w-full">
                                <svg class="w-7 h-7 text-[#1b4d3e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <p id="filenames-{{ $question->id }}" class="text-sm font-semibold text-[#1b4d3e] text-center break-all"></p>
                                <p class="text-xs text-slate-400">{{ __('Click to change') }}</p>
                            </div>

                            <input id="q-{{ $question->id }}"
                                type="file"
                                name="answers[{{ $question->id }}][]"
                                multiple
                                class="hidden"
                                accept=".pdf,.jpg,.jpeg,.png,.webp,.doc,.docx,application/pdf,image/*"
                                onchange="handleFileChange('{{ $question->id }}', this)" />
                        </label>
                    </div>
                    @endif

                    @error('answers.'.$question->id)
                    <p class="flex items-center gap-1.5 text-[12px] text-red-600 font-medium">
                        <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                    @if($errors->has('answers.'.$question->id.'.*'))
                    <p class="flex items-center gap-1.5 text-[12px] text-red-600 font-medium">
                        <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        {{ $errors->first('answers.'.$question->id.'.*') }}
                    </p>
                    @endif
                </div>
                @endforeach
            </div>

                {{-- অভিযোগ পর্যবেক্ষণ বার্তা --}}
                <div class="rounded-xl border border-sky-200/80 bg-sky-50/70 px-5 py-4">
                    <div class="flex items-start gap-3">
                        <svg class="h-5 w-5 text-sky-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                        <p class="noto-bn text-[13px] leading-relaxed text-sky-900" lang="bn">
                            আপনার অভিযোগ ক্রমান্বয়ে পর্যবেক্ষণ করা হবে। এর জন্য কিছু সময় প্রয়োজন। অভিযোগ হাতে নেওয়ার সঙ্গে সঙ্গে আপনাকে ফোনের মাধ্যমে জানানো হবে। অতি জরুরি বিষয়ে ফোনে অথবা সরাসরি এমপি মহোদয়ের সঙ্গে যোগাযোগ করুন।
                        </p>
                    </div>
                </div>

            <div
                class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-4 pt-8 border-t border-slate-100">
                <a href="{{ route('home') }}"
                    class="inline-flex justify-center items-center rounded-lg border border-slate-200 bg-white px-6 py-3.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-all shadow-sm">
                    {{ __('Discard') }}
                </a>
                <button type="submit"
                    class="group relative inline-flex justify-center items-center gap-2.5 rounded-lg bg-[#2d6a4f] px-10 py-4 text-base font-bold text-white shadow-lg shadow-[#2d6a4f]/20 hover:bg-[#1b4d3e] hover:shadow-xl hover:shadow-[#1b4d3e]/30 hover:-translate-y-0.5 transition-all duration-300">
                    <span>{{ __('Submit complaint') }}</span>
                    <span class="text-white/30">|</span>
                    <span class="noto-bn" lang="bn">জমা দিন</span>
                    <svg class="h-5 w-5 transition-transform duration-300 group-hover:translate-x-1" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
    @endif
</div>

@push('head')
<script>
function handleFileChange(questionId, input) {
    const placeholder = document.getElementById('placeholder-' + questionId);
    const preview     = document.getElementById('preview-' + questionId);
    const filenames   = document.getElementById('filenames-' + questionId);
    const label       = document.getElementById('label-' + questionId);

    if (input.files && input.files.length > 0) {
        const names = Array.from(input.files).map(f => f.name).join(', ');
        filenames.textContent = names;
        placeholder.classList.add('hidden');
        preview.classList.remove('hidden');
        preview.classList.add('flex');
        label.classList.add('border-[#1b4d3e]', 'bg-[#1b4d3e]/5');
        label.classList.remove('border-slate-200', 'bg-slate-50/50');
    } else {
        placeholder.classList.remove('hidden');
        preview.classList.add('hidden');
        preview.classList.remove('flex');
        label.classList.remove('border-[#1b4d3e]', 'bg-[#1b4d3e]/5');
        label.classList.add('border-slate-200', 'bg-slate-50/50');
    }
}
</script>
@endpush
@endsection