<div class="fixed h-full w-full overflow-y-auto bg-gray-600 bg-opacity-50 md:inset-0">
  <div class="bg-primary relative top-28 mx-auto w-4/12 cursor-pointer rounded-t-md p-5">
    <div class="mt-3 text-center">
      {{ $slot }}
    </div>
    {{-- Modal Footer --}}
    <div
      class="border-primary-ligh absolute left-0 mt-5 w-full rounded-b-md border-0 border-t border-solid bg-black/90 p-2">
      <div class="text-primary flex items-center space-x-1 text-xs">
        <div class="esc_kbod flex h-6 w-8 items-center justify-center rounded bg-white p-1.5 leading-relaxed">
          <span class="esc">esc</span>
        </div>
        <span class="transition-colors hover:text-cyan-300">to close</span>
      </div>
    </div>
  </div>
</div>
