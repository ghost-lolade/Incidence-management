<div class="row">
    <a href="{{ route('htmltopdfview',['download'=>'pdf']) }}">Download PDF</a>
    <table>
        <tr>
            <th>Name</th>
            <th>Details</th>
        </tr>
        @foreach ($invoices as $invoice)
            <tr>
                <td>{{ $invoice->client }}</td>
                <td>{{ $invoice->id }}</td>
            </tr>
        @endforeach
    </table>
</div>