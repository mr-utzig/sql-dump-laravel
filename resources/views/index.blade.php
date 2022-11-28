<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ env("APP_NAME") }}</title>
        <link rel="stylesheet" href="css/app.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    </head>
    <body>
        <section class="mx-5 my-2">
            <h1>Gerador de dump de arquivo CSV para SQL</h1>
            <hr>
            <div>
                <h4>Gerador de dump de arquivo</h4>
                <form method="POST" enctype="multipart/form-data" action="#">
                    @csrf
                    <div class="mb-3">
                        <label for="csvFile" class="form-label">Arquivo CSV</label>
                        <input type="file" name="csv_file" id="csvFile" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="tabelName" class="form-label">Tabela SQL</label>
                        <input type="text" name="tabel_name" id="tabelName" class="form-control" required>
                    </div>
                    <div class="mb-3 form-check">
                    <!-- <label for="separator">Separador</label>
                    <input type="text" name="separator" id="separator" class="form-control" required> -->
                        <input type="checkbox" name="dump_header" id="dumpHeader" value="1" class="form-check-input">
                        <label for="dumpHeader" class="form-check-label">1ª Linha = Cols</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
            <hr>
            @if (isset($status) && $status)
            <div>
                <ul class="list-group">
                @foreach ($data as $dump)
                    <li class="list-group-item">{{ $dump }}</li>
                @endforeach
                </ul>
            </div>
            @elseif (isset($status) && !$status)
            <div>
                <div class="alert alert-danger" role="alert">
                    {{ $message }}
                </div>
            </div>
            @endif
        </section>
    </body>
</html>
