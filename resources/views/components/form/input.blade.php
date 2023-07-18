@props([
  'placeholder' => "",
  'type' => 'text',
  'inputName' => null,
  'name' => null,
  'label' => null,
  'labelClass' => null,
  'inputClass' => null
])
<div>
    <label for="{{ $name }}" class="block mb-2 text-sm font-medium text-gray-800 dark:text-white {{ $labelClass }}">{{ $label }}</label>
    <input
      type="{{ $type }}"
      name="{{ $inputName }}"
      id="{{ $name }}"
      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-500 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white {{ $inputClass }}" placeholder="{{ $placeholder }}" autocomplete="off">
</div>
