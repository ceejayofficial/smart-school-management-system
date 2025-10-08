<!-- preloader.php -->
<div id="preloader" class="fixed inset-0 bg-blue-900 bg-opacity-90 flex items-center justify-center z-50 hidden">
    <div class="flex flex-col items-center">
        <!-- Spinner -->
        <div class="w-16 h-16 border-4 border-white border-t-transparent rounded-full animate-spin"></div>
        <p class="mt-4 text-white font-semibold text-lg">Loading, please wait...</p>
    </div>
</div>

<style>
    /* You can also move this into spinner.css if you prefer */
    #preloader.show {
        display: flex;
    }
</style>

<script>
    // Show preloader when any menu link is clicked
    document.addEventListener("DOMContentLoaded", function() {
        const menuLinks = document.querySelectorAll("aside nav a");
        const preloader = document.getElementById("preloader");

        menuLinks.forEach(link => {
            link.addEventListener("click", function(e) {
                // Show preloader
                preloader.classList.add("show");
            });
        });

        // Optional: hide preloader automatically after page load
        window.addEventListener("load", function() {
            preloader.classList.remove("show");
        });
    });
</script>
