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
  'initAlpine'  => null,
  'maxInput' => null,
  'isReadonly' => false
])
<div>
    <label for="{{ $name }}" class="block mb-2 text-sm font-medium text-gray-800 dark:text-primary-darker {{ $labelClass }}">{{ $label }}</label>
    <input
      @if ($maxInput)
        maxLength="{{ $maxInput }}"  
      @endif
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
      @if ($isReadonly)
          readonly
      @endif
      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 placeholder-violet-700 dark:placeholder-gray-400 read-only:bg-gray-400 read-only:cursor-not-allowed read-only:text-white {{ $inputClass }}" placeholder="{{ $placeholder }}" autocomplete="off">
</div>
