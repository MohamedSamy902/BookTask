<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.4.0/css/rowGroup.dataTables.min.css">

    <style>
        .load_screen {
            background-color: #bcbdc557;
            opacity: 1;
            position: fixed;
            z-index: 10;
            top: 0px;
            left: 0px;
            width: 100%;
            height: 100%;
            display: none
        }

        #load_screen>#loading {
            color: #fff;
            width: 120px;
            height: 24px;
            margin: 300px auto
        }

        .loader-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            margin-top: -80px;
            z-index: 1000
        }

        .loader {
            display: block;
            position: relative;
            left: 50%;
            top: 50%;
            width: 150px;
            height: 150px;
            margin: -75px 0 0 -75px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #fff;
            -webkit-animation: spin 2s linear infinite;
            -khtml-animation: spin 2s linear infinite;
            -moz-animation: spin 2s linear infinite;
            -ms-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
            z-index: 1001
        }

        .loader:before {
            content: "";
            position: absolute;
            top: 5px;
            left: 5px;
            right: 5px;
            bottom: 5px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #fff;
            -webkit-animation: spin 3s linear infinite;
            -khtml-animation: spin 3s linear infinite;
            -moz-animation: spin 3s linear infinite;
            -ms-animation: spin 3s linear infinite;
            animation: spin 3s linear infinite
        }

        .loader:after {
            content: "";
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            bottom: 15px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #fff;
            -webkit-animation: spin 1.5s linear infinite;
            -khtml-animation: spin 1.5s linear infinite;
            -moz-animation: spin 1.5s linear infinite;
            -ms-animation: spin 1.5s linear infinite;
            animation: spin 1.5s linear infinite
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
                -khtml-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                transform: rotate(0deg)
            }

            100% {
                -webkit-transform: rotate(360deg);
                -khtml-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                transform: rotate(360deg)
            }
        }

        @-ms-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
                -khtml-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                transform: rotate(0deg)
            }

            100% {
                -webkit-transform: rotate(360deg);
                -khtml-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                transform: rotate(360deg)
            }
        }

        @keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
                -khtml-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                transform: rotate(0deg)
            }

            100% {
                -webkit-transform: rotate(360deg);
                -khtml-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                transform: rotate(360deg)
            }
        }
    </style>



    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.3.2/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap.min.js"></script>
</head>

<body>
    {{-- Start Load Screen --}}
    <div class="load_screen" id="loade">
        <div class="loading">
            <div class="loader-wrapper">
                <div class="loader"></div>
                <div class="loader-section.section-left"></div>
                <div class="loader-section.section-right"></div>
            </div>
        </div>
    </div>
    {{-- End Load Screen --}}


    <div class="container">
        <div class="reloadSingle"></div>
        <div class="row">
            <div class="col-sm-12">
                {{-- <button type="button" class="btn btn-primary reload float-right mb-3">Reload</button> --}}
                <button type="supmit"class="btn btn-primary float-right" id="scrape-books"
                    style="margin-top: 10px;">Search Books</button>
                <h1 class="text-center">Books</h1>
                <table id="example" class="display nowrap" cellspacing="1" style="width:100%">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Pages</th>
                            <th>Language</th>
                            <th>Size</th>
                            <th>download</th>
                            <th>reviews</th>
                            <th>reviewsMove</th>
                            <th>pdf_url</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

    </div>




    <script>
        $(document).ready(function() {

            var table = $('#example').DataTable({
                responsive: true,
                stateSave: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('index') }}",
                columns: [{
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'author',
                        name: 'author'
                    },
                    {
                        data: 'pages',
                        name: 'pages'
                    },
                    {
                        data: 'lang',
                        name: 'lang'
                    },
                    {
                        className: 'size',
                        data: 'size',
                        render: function(data, type) {
                            if (type === 'display') {

                                return data + ' MB';
                            }
                            return data;
                        }
                    },

                    {
                        data: 'download',
                        name: 'download'
                    },
                    {
                        data: 'reviews',
                        name: 'reviews'
                    },
                    {
                        data: 'reviewsMove',
                        name: 'reviewsMove'
                    },
                    {
                        className: 'pdf_url',
                        data: 'pdf_url',
                        render: function(data, type) {
                            if (type === 'display') {
                                if (data == 'https://www.googletagmanager.com/ns.html?id=GTM-NSTJN67') {
                                    return 'Not Found';
                                }else {
                                    return '<a target="_blank" href="' + data + '">Show Pdf Book</a> ';

                                }
                            }
                            return data;
                        }
                    },

                ]
            });

            new $.fn.dataTable.FixedHeader(table);
            $(".reload").click(function() {
                // table.ajax.reload(null, true);
                table.ajax.url('{{ route('index') }}').load();
            });

            $('#scrape-books').click(function() {
                $("#loade").css("display", 'block');
                $.ajax({
                    url: '{{ route('scrape-books') }}',
                    type: 'GET',
                    xhrFields: {
                        withCredentials: true
                    },
                    success: function(response) {
                        table.ajax.reload(null, false);
                        $("#loade").css("display", 'none');
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>



</body>

</html>
