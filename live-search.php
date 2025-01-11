<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <script src="https://kit.fontawesome.com/4d31e6f82d.js" crossorigin="anonymous"></script>
</head>

<body>
    <input type="text" id="searchInput" placeholder="Find me here...">
    <div id="searchResult"></div>

    <script src="js/jquery/jquery-3.7.1.js"></script>
    <script>
        var typingTimer;
        var doneTypingInterval = 500; // Time in milliseconds

        document.addEventListener('keyup', function (ev) {
            let el = ev.target;

            if (el.id === 'searchInput') {
                let searchTerm = el.value.trim();

                // Clear timeout to prevent unnecessary API calls
                clearTimeout(typingTimer);

                // Set timeout for debouncing
                typingTimer = setTimeout(function () {
                    searchDb(searchTerm);
                }, doneTypingInterval);
            }
        });

        function searchDb(searchTerm) {
            let searchResult = document.getElementById('searchResult');

            if (searchTerm.length) {
                searchResult.style.display = 'block';

                $.ajax({
                    type: 'GET',
                    data: { search_term: searchTerm },
                    url: 'database/live-search.php',
                    success: function (response) {
                        try {
                            // Parse response if necessary
                            let result = typeof response === 'string' ? JSON.parse(response) : response;

                            if (!result.length || Object.keys(result.data).length === 0) {
                                searchResult.innerHTML = 'Data not found!';
                            } else {
                                let html = '';

                                // Loop through the response data
                                for (const [tbl, tblRows] of Object.entries(result.data)) {
                                    tblRows.forEach((row) => {
                                        let text = '';
                                        let url = '';

                                        if (tbl === 'users') {
                                            text = row.first_name + ' ' + row.last_name;
                                            url = 'users-view.php';
                                        }
                                        if (tbl === 'suppliers') {
                                            text = row.supplier_name;
                                            url = 'supplier-view.php';
                                        }
                                        if (tbl === 'products') {
                                            text = row.product_name;
                                            url = 'product-view.php';
                                        }

                                        html += `<a href="${url}">${text}</a><br/>`;
                                    });
                                }
                                searchResult.innerHTML = html;
                            }
                        } catch (error) {
                            console.error('Error processing response:', error);
                            searchResult.innerHTML = 'Error fetching data!';
                        }
                    },
                    error: function () {
                        searchResult.innerHTML = 'Error fetching data!';
                    },
                    dataType: 'json'
                });
            } else {
                searchResult.style.display = 'none';
                searchResult.innerHTML = '';
            }
        }
    </script>
</body>

</html>
