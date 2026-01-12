@props(['name'])

@error($name)
<div class="mt-2 p-3 bg-red-400 text-white rounded-lg shadow-md text-sm">
    <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
</div>
@enderror