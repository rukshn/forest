<x-app-layout title="Feed">
    <div class="py-6">
      <div class="w-full max-w-8xl mx-auto">
        <div class="lg:flex">
          <div id="sidebarLeft" class="fixed z-40 inset-0 flex-none h-full bg-black bg-opacity-25 w-full lg:bg-gray-100 lg:static lg:h-auto lg:overflow-y-visible lg:pt-0 lg:w-60 xl:w-72 lg:block hidden">
            <div class="h-full overflow-y-auto scrolling-touch lg:h-auto lg:block lg:relative lg:sticky lg:bg-transparent overflow-hidden lg:top-18 bg-white mr-24 lg:mr-0" id="sidebar-wrapper">
              <nav class="px-1 pt-6 overflow-y-auto font-medium text-base sm:px-3 xl:px-5 lg:text-sm pb-10 lg:pt-10 lg:pb-14 sticky?lg:h-(screen-18)">
                <ul>
                  <li></li>
                  <li></li>
                  <li></li>
                  <li></li>
                  <li></li>
                  <li></li>
                </ul>
              </nav>
            </div>
          </div>
          <div class="min-w-0 px-4 w-full flex-auto lg:static lg:max-h-full lg:overflow-visible">
            <x-composer-component></x-composer-component>
          </div>
          <div id="sidebarRight" class="fixed z-40 inset-0 flex-none h-full bg-black bg-opacity-25 w-full lg:bg-gray-100 lg:static lg:h-auto lg:overflow-y-visible lg:pt-0 lg:w-60 xl:w-72 lg:block hidden">
            <div class="h-full overflow-y-auto scrolling-touch lg:h-auto lg:block lg:relative lg:sticky lg:bg-transparent overflow-hidden lg:top-18 bg-white mr-24 lg:mr-0" id="sidebar-wrapper">
              <nav class="px-1 pt-6 overflow-y-auto font-medium text-base sm:px-3 xl:px-5 lg:text-sm pb-10 lg:pt-10 lg:pb-14 sticky?lg:h-(screen-18)">
                <ul>
                  <li></li>
                  <li></li>
                  <li></li>
                  <li></li>
                  <li></li>
                  <li></li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
</x-app-layout>