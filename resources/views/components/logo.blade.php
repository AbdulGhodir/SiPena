@props([
    'size' => 'w-5 h-5'
])

<div {{ $attributes->merge(['class' => 'bg-[#F4E8CD] p-2.5 rounded-xl flex items-center justify-center shrink-0 shadow-2xs']) }}>
    <i data-lucide="book-open" class="{{ $size }} text-[#173F35]"></i>
</div>