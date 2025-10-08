<header class="bg-blue-600 text-white fixed w-full z-50 shadow-md">
  <div class="container mx-auto flex justify-between items-center p-4">
    <!-- Logo -->
    <a href="#" class="flex items-center space-x-2">
      <img src="./assets/img/logo.png" alt="Smart School Logo" class="w-10 h-10 object-contain">
      <span class="text-xl font-bold">Smart School System</span>
    </a>

    <!-- Desktop Navigation (hidden on sm and md, visible lg+) -->
    <nav class="hidden lg:flex space-x-6 items-center">
      <a href="#features" class="hover:text-gray-200 transition">Features</a>
      <a href="#about" class="hover:text-gray-200 transition">About</a>
      <a href="#contact" class="hover:text-gray-200 transition">Contact</a>
      <a href="./login.php" class="hover:text-gray-200 transition font-semibold">Login</a>
    </nav>

    <!-- Hamburger Button (visible sm and md, hidden lg+) -->
    <button id="menu-btn" class="lg:hidden flex flex-col justify-between w-8 h-8 focus:outline-none z-50">
      <span class="block h-1 w-full bg-white rounded transition-transform origin-top-left"></span>
      <span class="block h-1 w-full bg-white rounded transition-opacity"></span>
      <span class="block h-1 w-full bg-white rounded transition-transform origin-bottom-left"></span>
    </button>
  </div>

  <!-- Fullscreen Mobile Menu -->
  <div id="mobile-menu" class="fixed inset-0 bg-blue-600 text-white flex flex-col justify-center items-center space-y-10 transform -translate-y-full transition-transform duration-300">
    <a href="#features" class="text-2xl hover:text-gray-200 transition font-medium">Features</a>
    <a href="#about" class="text-2xl hover:text-gray-200 transition font-medium">About</a>
    <a href="#contact" class="text-2xl hover:text-gray-200 transition font-medium">Contact</a>
    <a href="#login" class="text-2xl hover:text-gray-200 transition font-semibold">Login</a>
  </div>
</header>

<!-- Mobile Menu Script -->
<script>
  const menuBtn = document.getElementById('menu-btn');
  const mobileMenu = document.getElementById('mobile-menu');
  const menuLinks = mobileMenu.querySelectorAll('a');
  let menuOpen = false;

  function toggleMenu() {
    menuOpen = !menuOpen;
    if (menuOpen) {
      mobileMenu.classList.remove('-translate-y-full');
      mobileMenu.classList.add('translate-y-0');
      menuBtn.children[0].classList.add('rotate-45', 'translate-y-2');
      menuBtn.children[1].classList.add('opacity-0');
      menuBtn.children[2].classList.add('-rotate-45', '-translate-y-2');
    } else {
      mobileMenu.classList.add('-translate-y-full');
      mobileMenu.classList.remove('translate-y-0');
      menuBtn.children[0].classList.remove('rotate-45', 'translate-y-2');
      menuBtn.children[1].classList.remove('opacity-0');
      menuBtn.children[2].classList.remove('-rotate-45', '-translate-y-2');
    }
  }

  menuBtn.addEventListener('click', toggleMenu);

  menuLinks.forEach(link => {
    link.addEventListener('click', () => {
      if (menuOpen) toggleMenu();
    });
  });

  window.addEventListener('resize', () => {
    if (window.innerWidth >= 1024 && menuOpen) toggleMenu(); // close menu on lg+ screens
  });
</script>
