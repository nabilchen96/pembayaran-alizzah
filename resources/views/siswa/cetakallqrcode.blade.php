<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="mx-4 mt-4">
        <div class="row mt-4">
            @foreach ($siswa as $item)
            <div class="col-lg-3 mt-4">
                <div class="card">
                    <div class="card-header">

                    </div>
                    <div class="card-body">
                        <p class="text-center">{{ $item->nama_siswa }} <br>
                            NIS: {{ $item->nis }} <br><br>
                            {!! QrCode::size(100)->generate($item->nis); !!}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <script>
        window.print();
    </script>
</body>

</html>