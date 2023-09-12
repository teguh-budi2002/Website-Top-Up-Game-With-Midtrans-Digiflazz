@props([
  'placeholder' => "",
  'type' => 'text',
  'inputName' => null,
  'name' => null,
  'label' => null,
  'labelClass' => null,
  'inputClass' => null,
  'value' => null,
  'modelBinding' => null,
  'inputBinding' => null,
  'initAlpine'  => null
])
<div>
    <label for="{{ $name }}" class="block mb-2 text-sm font-medium text-gray-800 dark:text-primary-darker {{ $labelClass }}">{{ $label }}</label>
    <input
      @if ($inputBinding)
        @input="{{ $inputBinding }}"  
      @endif
      type="{{ $type }}"
      name="{{ $inputName }}"
      id="{{ $name }}"
      value="{{ $value }}"
      @if ($modelBinding)
        x-model="{{ $modelBinding }}"
      @endif
      @if ($initAlpine)
          x-init="{{ $initAlpine }}"
      @endif
      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white dark:border-gray-500 dark:placeholder-gray-400 dark:text-primary {{ $inputClass }}" placeholder="{{ $placeholder }}" autocomplete="off">
</div>
