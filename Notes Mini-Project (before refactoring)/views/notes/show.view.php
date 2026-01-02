<?php require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/nav.php') ?>
<?php require base_path('views/partials/banner.php') ?>

<main>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 text-blue-500 ">
        <a href="/notes">Go back to All Notes</a>
        <br>
        <div class="mb-4 p-4 border border-gray-300 rounded-lg shadow-sm">
            <h3 class="text-xl font-semibold mb-2"><?= (htmlspecialchars($note['body'])) ?></h3>
        </div>

        <a href="/notes/edit?id=<?= $note['id'] ?>">Edit</a>

        <form method="POST" action="/notes">
            <input type="hidden" name="id" value="<?= $note['id'] ?>">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="text-red-500 text-sm mt-2">Delete</button>
        </form>
    </div>
</main>

<?php require base_path('views/partials/footer.php') ?>