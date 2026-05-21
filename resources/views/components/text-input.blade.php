@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full bg-sky-800/60 border border-sky-700/50 rounded-xl px-4 py-3 text-sky-100 placeholder-sky-500 focus:border-accent/50 focus:ring-2 focus:ring-accent/20 transition-all duration-200']) }}>
