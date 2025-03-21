<!-- Include Flowbite CSS & JS in your <head> and before closing </body> -->

<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<div class="fixed top-16 w-full bg-[#FBFFE4] shadow border-b border-blue-300 z-30 px-2 py-2">
    <div class="flex items-center gap-10">

        <!-- All Books Dropdown -->
        <div class="relative">
            <button id="dropdownButton" data-dropdown-toggle="dropdownMenu"
                class="text-black w-[24vh] font-semibold px-6 py-2 flex items-center gap-2 hover:text-green-700 transition">
                All Books
                <svg class="w-4 h-4 transform transition-transform" id="dropdownIcon" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <div id="dropdownMenu"
                class="z-50 hidden absolute left-0 m-4 w-[40vh] h-[75vh] overflow-y-auto no-scrollbar rounded-lg bg-white border border-gray-200 shadow-lg">
                <ul class="py-2 text-base text-gray-700 divide-y divide-gray-100">
                    <?php
                    $catcalling = $connect->query("SELECT * FROM category");
                    while ($cat = $catcalling->fetch_array()):
                    ?>
                        <a href="filter.php?filter=<?= $cat['cat_title']; ?>" class="block px-4 py-2 hover:bg-gray-100 transition-all">
                            <?= $cat['cat_title']; ?>
                        </a>
                    <?php endwhile; ?>
                </ul>
            </div>
        </div>

        <!-- Horizontal Scroll Categories -->
        <div class="relative max-w-full">
            <div class="overflow-x-auto whitespace-nowrap no-scrollbar max-w-full" id="categoryScroll">
                <div class="flex space-x-4">
                    <?php
                    $names = ['49 store', '99 store', '149 store', 'Pre Booking', 'Text Book','English Book', 'Harry Potter Store', 'Childreen', 'Manga Store', 'Hindi Book'];
                    foreach ($names as $name):
                    ?>
                        <a href="filter2.php?name=<?=$name;?>"
                            class="border-l border-[#105242] pl-4 pr-2 font-semibold text-gray-700 hover:text-green-800 hover:underline transition">
                            <?= $name; ?>
                        </a>
                    <?php endforeach; ?>
                        
                </div>
            </div>
        </div>

    </div>
</div>