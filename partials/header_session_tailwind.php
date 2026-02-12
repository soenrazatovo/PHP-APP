<header class="bg-gray-900">
  <nav aria-label="Global" class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8">
    <div class="flex lg:flex-1">
      <a href="index.php" class="-m-1.5 p-1.5">
        <img src="assets\MystR-Logo-White-NoSmoke.webp" alt="Logo" class="h-8 w-auto" />
      </a>
    </div>
    <div class="flex lg:hidden">
      <button type="button" command="show-modal" commandfor="mobile-menu" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-400">
        <span class="sr-only">Open main menu</span>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
          <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </button>
    </div>
    <el-popover-group class="hidden lg:flex lg:gap-x-12">
      <a href="profile.php" class="text-sm/6 font-semibold text-white">Your profile</a>
      <a href="shop.php" class="text-sm/6 font-semibold text-white">E-Shop</a>
      <a href="contact.php" class="text-sm/6 font-semibold text-white">Contact</a>
      <a href="todo.php" class="text-sm/6 font-semibold text-white">Todo</a>
    </el-popover-group>
    <div class="hidden lg:flex lg:flex-1 lg:justify-end items-center">
      <!-- <div class=""> -->
        <a href="cart.php" class="relative flex mr-10 items-end text-sm/6 font-semibold text-white">
          <img class="max-w-10 max-h-10" src="assets/icons8-cart-100.png" alt="">
          <?php if (!empty($_SESSION["cart"]["content"])): ?>
            <h2 class="absolute top-0 -right-2 text-sm/6 font-semibold text-white bg-red-500 rounded-full w-5 h-5 flex items-center justify-center"><?=count($_SESSION["cart"]["content"])?></h2>
          <?php endif ?>
        </a>
      <!-- </div> -->
      <a href="logout.php" class="text-sm/6 font-semibold text-white">Log out <span aria-hidden="true">&rarr;</span></a>
    </div>
  </nav>
  <el-dialog>
    <dialog id="mobile-menu" class="backdrop:bg-transparent lg:hidden">
      <div tabindex="0" class="fixed inset-0 focus:outline-none">
        <el-dialog-panel class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-gray-900 p-6 sm:max-w-sm sm:ring-1 sm:ring-gray-100/10">
          <div class="flex items-center justify-between">
            <a href="#" class="-m-1.5 p-1.5">
              <img src="assets\MystR-Logo-White-NoSmoke.webp" alt="Logo company" class="h-8 w-auto" />
            </a>
            <button type="button" command="close" commandfor="mobile-menu" class="-m-2.5 rounded-md p-2.5 text-gray-400">
              <span class="sr-only">Close menu</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
                <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </button>
          </div>
          <div class="mt-6 flow-root">
            <div class="-my-6 divide-y divide-white/10">
              <div class="space-y-2 py-6">
                <div class="-mx-3">
                  <a href="profile.php" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-white/5">Your profile</a>
                  <a href="shop.php" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-white/5">E-shop</a>
                  <a href="contact.php" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-white/5">Contact</a>
                  <a href="todo.php" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-white/5">Todo</a>
                  <a href="cart.php" class="flex gap-5 items-center -mx-3 rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-white/5"><img class="max-w-10 max-h-10" src="assets/icons8-cart-100.png" alt="">Your cart</a>
              </div>
              <div class="py-6">
                <div class="flex flex-row gap-5">
                    <a href="logout.php" class="block -mx-3 rounded-lg px-3 py-2.5 text-base/7 font-semibold text-white hover:bg-white/5">Log out <span aria-hidden="true">&rarr;</span></a>
                </div>
              </div>
            </div>
          </div>
        </el-dialog-panel>
      </div>
    </dialog>
  </el-dialog>
</header>