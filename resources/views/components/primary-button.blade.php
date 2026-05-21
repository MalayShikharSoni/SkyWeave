<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center w-full px-5 py-3 bg-accent-500 text-white font-semibold text-sm rounded-xl shadow-lg shadow-accent-500/25 hover:bg-accent-400 hover:shadow-accent-400/30 hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-2 focus:ring-accent/30 focus:ring-offset-2 focus:ring-offset-sky-900 transition-all duration-200']) }}>
    {{ $slot }}
</button>
