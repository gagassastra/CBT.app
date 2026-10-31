@props(['title', 'subtitle' => null, 'back' => null, 'action', 'method' => 'POST', 'submit' => 'Simpan Data', 'files' => false])

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    @if($back)
        <div class="mb-4">
            <a href="{{ $back }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-blue-600 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar
            </a>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        <div class="px-6 sm:px-8 py-6 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white flex items-center justify-between">
            <div>
                <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">{{ $title }}</h1>
                @if($subtitle)
                    <p class="text-sm text-slate-500 mt-1">{{ $subtitle }}</p>
                @endif
            </div>
            <div class="hidden sm:flex w-11 h-11 rounded-xl bg-blue-50 text-blue-600 items-center justify-center border border-blue-100 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </div>
        </div>

        <form action="{{ $action }}" method="POST" @if($files) enctype="multipart/form-data" @endif class="px-6 sm:px-8 py-7">
            @csrf
            @if(strtoupper($method) !== 'POST')
                @method($method)
            @endif

            @if($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50/80 px-4 py-3.5 text-sm text-red-700">
                    <div class="flex items-center gap-2 font-bold mb-1">
                        <svg class="w-4 h-4 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Periksa kembali isian formulir Anda:
                    </div>
                    <ul class="list-disc pl-5 space-y-0.5 text-xs">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5">
                {{ $slot }}
            </div>

            <div class="mt-8 pt-5 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                @if($back)
                    <a href="{{ $back }}" class="ui-btn-ghost">Batal</a>
                @endif
                <button type="submit" class="ui-btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    {{ $submit }}
                </button>
            </div>
        </form>
    </div>
</div>
