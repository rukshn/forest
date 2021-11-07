<x-app-layout title="Feed">
  <div class="py-6">
    <div class="w-full max-w-8xl mx-auto">
      <div class="lg:flex">
        <x-left-sidebar>
        </x-left-sidebar>
        <div class="min-w-0 px-4 w-full flex-auto lg:static lg:max-h-full lg:overflow-visible">
          <x-composer-component></x-composer-component>
        </div>
        <x-right-sidebar>
        </x-right-sidebar>
      </div>
    </div>
  </div>
</x-app-layout>
