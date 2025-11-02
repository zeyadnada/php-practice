<?php require('partials/head.php')  ?>
<?php require('partials/nav.php')  ?>
<?php require('partials/banner.php')  ?>

<main>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 text-blue-500 ">
        <?php foreach ($notes as $note) : ?>
            <div class="mb-4 p-4 border border-gray-300 rounded-lg shadow-sm">
                <a href="/note?id=<?= $note['id'] ?>"
                    class="text-xl font-semibold mb-2"><?= (htmlspecialchars($note['body'])) ?></a>
            </div>
        <?php endforeach; ?>

    </div>
    <div>
        <p>
            <a href="/notes/create" class="text-blue-500 hover:underline">Create Note</a>
        </p>
        <ul>
            <!-- list of notes -->
        </ul>
    </div>
</main>

<?php require('partials/footer.php')  ?>