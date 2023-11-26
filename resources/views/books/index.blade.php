<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
<div class="container mt-4">
    <h1 class="mb-4">Books</h1>
    <div id="books-list" class="list-group">
    </div>
    <nav aria-label="Page navigation">
        <ul class="pagination" id="pagination">
        </ul>
    </nav>
</div>

<script>
    $(document).ready(function () {
        loadBooks(1);

        function loadBooks(page) {
            $.ajax({
                url: '/api/v1/client/books?page=' + page,
                type: 'GET',
                success: function (response) {
                    $('#books-list').html('');
                    response.books.forEach(function(book) {
                        $('#books-list').append(renderBookItem(book));
                    });
                    generatePaginationLinks(response.currentPage, response.totalPages);
                }
            });
        }

        function renderBookItem(book) {
            return `
                <a href="#" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">${book.title}</h5>
                        <small class="text-muted">Published by: ${book.publisher}</small>
                    </div>
                    <p class="mb-1">${book.description}</p>
                    <small class="text-muted">Author(s): ${book.authors}</small>
                </a>
            `;
        }

        function generatePaginationLinks(currentPage, totalPages) {
            $('#pagination').html('');
            for (let i = 1; i <= totalPages; i++) {
                let activeClass = i === currentPage ? 'active' : '';
                $('#pagination').append(`
                    <li class="page-item ${activeClass}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `);
            }
        }

        $(document).on('click', '#pagination a', function (e) {
            e.preventDefault();
            var page = $(this).data('page');
            loadBooks(page);
        });
    });
</script>
</body>
</html>
