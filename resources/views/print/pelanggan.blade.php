<body>
    <style>
        .d-flex {
            display: flex;
            flex-wrap: wrap;
        }

        .table {
            border-collapse: collapse;
        }

        .table th, .table td {
            border: 1px solid black;
            padding: 5px;
        }

        hr {
            border-color: black;
        }
    </style>
    <div style="padding: 20px 30px; ">
        <div class="d-flex" style="align-items: center">
            <div style="width: 20%;">
                <img src="{{ asset('/logo.png') }}" alt="" style="width: 100%;">
            </div>
            <div style="width: 50%;">
                <br><br>
                {{ env('APP_NAME') }} <br><br>
                {{ env('APP_ADDRESS') }} <br><br>
                Telp : {{ env('APP_PHONE') }}
            </div>
            <div style="width: 30%;">
                <br><br>
                <div style="border: 1px solid black; padding: 30px 0;" align="center">
                    DATA PELANGGAN
                </div>
            </div>
        </div>
        
        <hr>

        <div>
            <br><br>
            <table class="table" style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kontak</th>
                        <th>Tanggal Lahir</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pelanggan as $item)
                        <tr>
                            <td align="center">{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td align="center">{{ $item->whatsapp }}</td>
                            <td align="center">{{ $item->tanggal_lahir }}</td>
                            <td>{{ $item->alamat }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div align="right">
            <br><br>
            {{ date('Y-m-d') }}
        </div>
    </div>
    
	<script>
		window.print();
		setTimeout(() => {
			window.close();
		}, 4000);
	</script>
</body>