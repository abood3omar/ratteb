@props(['label', 'name', 'type' => 'text', 'placeholder' => '', 'value' => null, 'required' => false, 'dir' => 'rtl'])

<div class="space-y-2 {{ $attributes->get('class') }}">
    <label class="block text-slate-400 text-xs font-bold uppercase tracking-wider">
        {{ $label }} @if($required) <span class="text-red-500">*</span> @endif
    </label>
    
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        value="{{ old($name, $value) }}" 
        placeholder="{{ $placeholder }}"
        dir="{{ $dir }}"
        {{ $required ? 'required' : '' }}
        class="block w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all placeholder-slate-600"
    >

    @error($name)
        <p class="text-red-400 text-xs mt-1 font-bold">{{ $message }}</p>
    @enderror
</div>