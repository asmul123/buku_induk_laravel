<h2>Data Peserta Didik</h2>
<table border="1">
    <tr>
        <th>Nama</th>
        <th>NISN</th>
        <th>Jenis Kelamin</th>
    </tr>
    @foreach($data as $siswa)
        <tr>
            <td>{{ $siswa['nama'] }}</td>
            <td>{{ $siswa['nisn'] }}</td>
            <td>{{ $siswa['jenis_kelamin'] }}</td>
        </tr>
    @endforeach
</table>
