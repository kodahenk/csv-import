<!doctype html>
<html lang="tr">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <title>Mivento Assessment</title>

    <style>
        .container {
            margin-top: 2rem !important;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div id="danger" class="alert alert-danger" style="display: none;">
                    <ul></ul>
                </div>
                <div id="success" class="alert alert-success" style="display: none;">
                    <ul></ul>
                </div>

                <div id="info" class="alert alert-info" style="display: none;">
                    <h4>Yükleme sırasında hata ile karşılaşılan satırlar</h4>
                    <ul></ul>
                </div>

                <form id="uploadForm" class="needs-validation" novalidate method="POST" action="file_upload.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="campaign-name" class="form-label">Kampanya Adı</label>
                        <input type="text" class="form-control" name="companyName" id="campaign-name" required />
                    </div>
                    <div class="mb-3">
                        <select id="campaign-date" class="form-select" required name="date">
                            <option selected disabled value="">Tarih Seçin</option>
                            <option value="2022-07">Temmuz 2022</option>
                            <option value="2022-08">Ağustos 2022</option>
                            <option value="2022-09">Eylül 2022</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="campaign-file" class="form-label">Dosya Yükleyin</label>
                        <input class="form-control" type="file" name="file" id="campaign-file" required />
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary btn-block">Yükle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>

    <!-- Example starter JavaScript for disabling form submissions if there are invalid fields -->
    <script>
        (function() {
            'use strict';

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation');

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }

                        form.classList.add('was-validated');
                    }, false);
                });
        })();


        $(document).ready(function() {

            $('#uploadForm').on('submit', function(event) {
                $('#danger').hide('slide');
                $('#success').hide('slide');
                $('#info').hide('slide');

                event.preventDefault();
                $.ajax({
                    url: "file_upload.php",
                    method: "POST",
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {

                        // formda eksik alan geldi
                        if (data.errors.length > 0) {
                            $('#danger').show('slide');
                            $('#danger ul').html('');

                            $.each(data.errors, function(index, value) {
                                $('#danger ul').prepend("<li>" + value + "</li>");
                            });

                            $('#danger ul').prepend("<li>Dosya Yükleme başarısız</li>");
                        }

                        // show success messages
                        if (data.message.length > 0) {
                            $('#success').show('slide');
                            $('#success ul').html('');
                            $('#success').text(data.message);
                        }

                        // show success messages
                        if (Object.keys(data.csvLineError).length > 0) {
                            $('#info').show('slide');
                            $('#info ul').html('');

                            $.each(data.csvLineError, function(index, value) {
                                $('#info ul').append("<li>" + index + "<br><strong>" + JSON.stringify(value) + "</strong></li>");
                            });
                        }

                        // form temizleme
                        $('#campaign-name').val('');
                        $('#campaign-select').prop('checked', true);
                        $('#campaign-file').val('');
                    }
                });

            });

        });
    </script>
</body>

</html>