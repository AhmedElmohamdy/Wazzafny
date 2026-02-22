@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'block mt-1 w-full bg-white text-gray-700 border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 rounded-lg']) }}>
