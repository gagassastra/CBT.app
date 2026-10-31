@props(['label', 'name' => null, 'hint' => null, 'full' => false, 'required' => false])

<div {{ $attributes->class(['sm:col-span-2' => $full]) }}>
    <label @if($name) for="{{ $name }}" @endif class="ui-label">
        {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
    </label>
    {{ $slot }}
    @if($hint)
        <p class="mt-1.5 text-xs text-slate-500">{{ $hint }}</p>
    @endif
    @if($name)
        @error($name)
            <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    @endif
</div>
