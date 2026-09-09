@props(['name', 'label' => null, 'type' => 'text', 'placeholder' => '', 'value' => ''])

<div>
    @if($label)
        <label class="block text-sm font-medium text-slate-700 mb-1.5">{{ $label }}</label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'w-full rounded-xl border border-slate-200 bg-white px-3 py-2.75 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900/20 focus:border-slate-900 transition-all duration-150']) }}
    >

    @error($name)
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
